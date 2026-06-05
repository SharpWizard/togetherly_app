<?php

namespace App\Http\Controllers;

use App\Models\SkillPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $userNeighborhood = $user->profile?->neighborhood;

        $query = SkillPost::where('neighborhood', $userNeighborhood)
            ->where('status', 'active')
            ->with('user');

        if ($search = $request->input('q')) {
            $query->where(function ($w) use ($search) {
                $w->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        if ($level = $request->input('level')) {
            $query->where('skill_level', $level);
        }

        $skillPosts = $query->latest()->paginate(12)->withQueryString();

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
            'available_times' => 'nullable|json',
        ]);

        $user = Auth::user();
        $profile = $user->profile;

        $data = $request->all();
        $data['user_id'] = $user->id;
        $data['neighborhood'] = $profile?->neighborhood ?? 'Unknown';
        $data['latitude'] = $profile?->latitude ?? 0;
        $data['longitude'] = $profile?->longitude ?? 0;
        $data['status'] = 'active';

        SkillPost::create($data);

        return redirect()->route('skills.index')->with('success', 'Skill post created successfully!');
    }

    public function show(SkillPost $skillPost)
    {
        return view('skills.show', compact('skillPost'));
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
            'available_times' => 'nullable|json',
            'status' => 'required|in:active,inactive',
        ]);

        $skillPost->update($request->all());

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
}
