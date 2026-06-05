<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\FoodPost;
use App\Models\SkillPost;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(User $user)
    {
        $foodPosts = FoodPost::where('user_id', $user->id)
            ->where('status', 'available')
            ->latest()->limit(6)->get();

        $skillPosts = SkillPost::where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()->limit(6)->get();

        $reviews = Rating::where('rated_user_id', $user->id)
            ->whereNotNull('comment')
            ->with('rater')
            ->latest()->limit(10)->get();

        $stats = [
            'food'   => FoodPost::where('user_id', $user->id)->count(),
            'skills' => SkillPost::where('user_id', $user->id)->count(),
        ];

        return view('profile.show', compact('user', 'foodPosts', 'skillPosts', 'reviews', 'stats'));
    }

    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'         => 'required|string|max:255',
            'phone'        => 'nullable|string|max:30',
            'bio'          => 'nullable|string|max:500',
            'neighborhood' => 'required|string|max:255',
            'account_type' => 'required|in:individual,business,restaurant',
            'avatar'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->name  = $request->name;
        $user->phone = $request->phone;
        $user->bio   = $request->bio;
        $user->save();

        UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            ['neighborhood' => $request->neighborhood, 'account_type' => $request->account_type]
        );

        return redirect()->route('profile.show', $user)->with('success', 'Profile updated!');
    }
}
