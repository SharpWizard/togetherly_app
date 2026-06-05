<?php

namespace App\Http\Controllers;

use App\Models\FoodPost;
use App\Models\SkillPost;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $userNeighborhood = $user->profile?->neighborhood;

        $recentFoodPosts = FoodPost::where('neighborhood', $userNeighborhood)
            ->where('status', 'available')
            ->where('expires_at', '>', now())
            ->with('user')
            ->latest()
            ->limit(6)
            ->get();

        $recentSkillPosts = SkillPost::where('neighborhood', $userNeighborhood)
            ->where('status', 'active')
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
}
