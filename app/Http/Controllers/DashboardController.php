<?php

namespace App\Http\Controllers;

use App\Models\FoodPost;
use App\Models\SkillPost;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('welcome');
    }

    public function index()
    {
        $user = Auth::user();

        // Community-wide recent posts so every member sees the whole community.
        $recentFoodPosts = FoodPost::where('status', 'available')
            ->where('expires_at', '>', now())
            ->with('user')
            ->latest()
            ->limit(6)
            ->get();

        $recentSkillPosts = SkillPost::where('status', 'active')
            ->with('user')
            ->latest()
            ->limit(6)
            ->get();

        $myFoodPosts = FoodPost::where('user_id', $user->id)
            ->with('user')
            ->latest()
            ->limit(3)
            ->get();

        $mySkillPosts = SkillPost::where('user_id', $user->id)
            ->with('user')
            ->latest()
            ->limit(3)
            ->get();

        return view('dashboard', compact('recentFoodPosts', 'recentSkillPosts', 'myFoodPosts', 'mySkillPosts'));
    }

    public function welcome()
    {
        $recentFoodPosts = FoodPost::where('status', 'available')
            ->where('expires_at', '>', now())
            ->with('user')
            ->latest()
            ->limit(6)
            ->get();

        $recentSkillPosts = SkillPost::where('status', 'active')
            ->with('user')
            ->latest()
            ->limit(6)
            ->get();

        return view('welcome', compact('recentFoodPosts', 'recentSkillPosts'));
    }
}
