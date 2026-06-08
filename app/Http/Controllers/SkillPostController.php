<?php

namespace App\Http\Controllers;

use App\Models\SkillPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('publicShow');
    }

    public function index(Request $request)
    {
        // Community-wide: every member sees every active skill post.
        // Neighborhood is an optional filter, not a hard restriction.
        $query = SkillPost::where('status', 'active')
            ->with('user');

        if ($neighborhood = $request->input('neighborhood')) {
            $query->where('neighborhood', $neighborhood);
        }

        // Search
        if ($search = $request->input('q')) {
            $query->where(function ($w) use ($search) {
                $w->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        // Filter by skill level
        if ($level = $request->input('level')) {
            $query->where('skill_level', $level);
        }

        // Filter by user rating
        if ($minRating = $request->input('rating')) {
            $query->whereHas('user', function ($q) use ($minRating) {
                $q->where('rating', '>=', $minRating);
            });
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        match($sort) {
            'popular' => $query->orderBy('views', 'desc'),
            'oldest' => $query->oldest(),
            default => $query->latest(),
        };

        $skillPosts = $query->paginate(12)->withQueryString();

        return view('skills.index', compact('skillPosts'));
    }

    public function create()
    {
        return view('skills.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'skill_level' => 'required|in:beginner,intermediate,advanced',
            'available_times' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $profile = $user->profile;

        $data = $request->only(['title', 'description', 'category', 'skill_level', 'available_times']);
        $data['user_id'] = $user->id;
        $data['neighborhood'] = $profile?->neighborhood ?? 'Unknown';
        $data['latitude'] = $profile?->latitude ?? 0;
        $data['longitude'] = $profile?->longitude ?? 0;
        $data['status'] = 'active';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('skills', 'public');
        }

        SkillPost::create($data);

        return redirect()->route('skills.index')->with('success', 'Skill post created successfully!');
    }

    public function show(SkillPost $skillPost)
    {
        if ($skillPost->user_id !== Auth::id()) {
            $skillPost->increment('views');
        }
        $recommendations = $this->getRecommendations($skillPost);
        return view('skills.show', compact('skillPost', 'recommendations'));
    }

    public function edit(SkillPost $skillPost)
    {
        if ($skillPost->user_id !== Auth::id()) {
            abort(403);
        }

        return view('skills.edit', compact('skillPost'));
    }

    public function update(Request $request, SkillPost $skillPost)
    {
        if ($skillPost->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'skill_level' => 'required|in:beginner,intermediate,advanced',
            'available_times' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'category', 'skill_level', 'available_times', 'status']);

        if ($request->hasFile('image')) {
            if ($skillPost->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($skillPost->image);
            }
            $data['image'] = $request->file('image')->store('skills', 'public');
        }

        $skillPost->update($data);

        return redirect()->route('skills.show', $skillPost)->with('success', 'Skill post updated!');
    }

    public function destroy(SkillPost $skillPost)
    {
        if ($skillPost->user_id !== Auth::id()) {
            abort(403);
        }

        $skillPost->delete();

        return redirect()->route('skills.index')->with('success', 'Skill post deleted!');
    }

    public function publicShow(SkillPost $skillPost)
    {
        $skillPost->increment('views');
        return view('skills.public-show', compact('skillPost'));
    }

    private function getRecommendations(SkillPost $skillPost, $limit = 4)
    {
        return SkillPost::where('category', $skillPost->category)
            ->where('id', '!=', $skillPost->id)
            ->where('status', 'active')
            ->with('user')
            ->latest()
            ->limit($limit)
            ->get();
    }
}
