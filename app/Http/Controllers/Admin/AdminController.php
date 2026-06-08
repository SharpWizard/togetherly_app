<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\FoodPost;
use App\Models\SkillPost;
use App\Models\Claim;
use App\Models\Booking;
use App\Models\Message;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users'    => User::count(),
            'food'     => FoodPost::count(),
            'skills'   => SkillPost::count(),
            'claims'   => Claim::count(),
            'bookings' => Booking::count(),
            'messages' => Message::count(),
            'verified' => UserProfile::where('is_verified', true)->count(),
            'reports'  => Report::where('status', 'open')->count(),
        ];

        $recentFood   = FoodPost::with('user')->latest()->limit(5)->get();
        $recentSkills = SkillPost::with('user')->latest()->limit(5)->get();

        return view('admin.index', compact('stats', 'recentFood', 'recentSkills'));
    }

    public function users(Request $request)
    {
        $query = User::with('profile');

        if ($search = $request->input('q')) {
            $query->where(function ($w) use ($search) {
                $w->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function toggleVerify(User $user)
    {
        $profile = UserProfile::firstOrCreate(['user_id' => $user->id], ['neighborhood' => 'Unknown']);
        $profile->update(['is_verified' => ! $profile->is_verified]);

        return back()->with('success', $user->name . ' verification ' . ($profile->is_verified ? 'granted' : 'removed') . '.');
    }

    public function toggleAdmin(User $user)
    {
        $user->update(['is_admin' => ! $user->is_admin]);

        return back()->with('success', $user->name . ' is ' . ($user->is_admin ? 'now an admin' : 'no longer an admin') . '.');
    }

    public function deleteFood(FoodPost $foodPost)
    {
        $foodPost->delete();
        return back()->with('success', 'Food post removed.');
    }

    public function deleteSkill(SkillPost $skillPost)
    {
        $skillPost->delete();
        return back()->with('success', 'Skill post removed.');
    }

    public function reports()
    {
        $reports = Report::with('reporter', 'foodPost.user', 'skillPost.user')
            ->orderByRaw("FIELD(status,'open','actioned','dismissed')")
            ->latest()
            ->paginate(20);

        return view('admin.reports', compact('reports'));
    }

    public function dismissReport(Report $report)
    {
        $report->update(['status' => 'dismissed']);
        return back()->with('success', 'Report dismissed.');
    }

    public function actionReport(Report $report)
    {
        // Remove the reported post, then mark the report actioned.
        if ($report->foodPost) {
            $report->foodPost->delete();
        }
        if ($report->skillPost) {
            $report->skillPost->delete();
        }
        $report->update(['status' => 'actioned']);

        return back()->with('success', 'Post removed and report resolved.');
    }

    public function posts(Request $request)
    {
        $type = $request->input('type', 'all');
        $search = $request->input('q');

        if ($type === 'food' || $type === 'all') {
            $foodQuery = FoodPost::with('user');
            if ($search) {
                $foodQuery->where(function ($w) use ($search) {
                    $w->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }
            $foodPosts = $foodQuery->latest()->paginate(15, ['*'], 'food_page');
        } else {
            $foodPosts = null;
        }

        if ($type === 'skill' || $type === 'all') {
            $skillQuery = SkillPost::with('user');
            if ($search) {
                $skillQuery->where(function ($w) use ($search) {
                    $w->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }
            $skillPosts = $skillQuery->latest()->paginate(15, ['*'], 'skill_page');
        } else {
            $skillPosts = null;
        }

        return view('admin.posts', compact('foodPosts', 'skillPosts', 'type', 'search'));
    }

    public function suspendUser(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'Cannot suspend admin users.');
        }

        $user->update(['is_suspended' => true]);
        return back()->with('success', $user->name . ' has been suspended.');
    }

    public function unsuspendUser(User $user)
    {
        $user->update(['is_suspended' => false]);
        return back()->with('success', $user->name . ' has been unsuspended.');
    }

    public function deleteUser(User $user)
    {
        if ($user->is_admin && User::where('is_admin', true)->count() === 1) {
            return back()->with('error', 'Cannot delete the last admin user.');
        }

        $name = $user->name;
        FoodPost::where('user_id', $user->id)->delete();
        SkillPost::where('user_id', $user->id)->delete();
        $user->delete();

        return back()->with('success', $name . ' and all their posts have been deleted.');
    }

    public function foodPosts(Request $request)
    {
        $search = $request->input('q');
        $status = $request->input('status');

        $query = FoodPost::with('user');

        if ($search) {
            $query->where(function ($w) use ($search) {
                $w->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $foodPosts = $query->latest()->paginate(20)->withQueryString();

        return view('admin.food-posts', compact('foodPosts', 'search', 'status'));
    }

    public function skillPosts(Request $request)
    {
        $search = $request->input('q');
        $status = $request->input('status');

        $query = SkillPost::with('user');

        if ($search) {
            $query->where(function ($w) use ($search) {
                $w->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $skillPosts = $query->latest()->paginate(20)->withQueryString();

        return view('admin.skill-posts', compact('skillPosts', 'search', 'status'));
    }
}
