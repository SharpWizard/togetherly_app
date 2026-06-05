<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FoodPost;
use App\Models\SkillPost;
use App\Models\Claim;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class ImpactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $foodShared      = FoodPost::count();
        $skillsShared    = SkillPost::count();
        $foodClaimed     = Claim::whereIn('status', ['accepted', 'completed'])->count();
        $sessionsBooked  = Booking::whereIn('status', ['accepted', 'completed'])->count();
        $members         = User::count();

        // Simple, transparent impact estimates
        $mealsSaved = $foodClaimed > 0 ? $foodClaimed : $foodShared;          // exchanges (or posts) as meals
        $co2Saved   = round($mealsSaved * 2.5, 1);                            // ~2.5 kg CO2e per meal saved
        $moneySaved = $sessionsBooked * 30000;                               // ~₩30,000 value per free lesson

        $stats = [
            'foodShared'     => $foodShared,
            'skillsShared'   => $skillsShared,
            'foodClaimed'    => $foodClaimed,
            'sessionsBooked' => $sessionsBooked,
            'members'        => $members,
            'mealsSaved'     => $mealsSaved,
            'co2Saved'       => $co2Saved,
            'moneySaved'     => $moneySaved,
        ];

        // Leaderboard: contribution score = food posts + skills + completed exchanges
        $leaderboard = User::select('users.*')
            ->selectSub(FoodPost::selectRaw('COUNT(*)')->whereColumn('food_posts.user_id', 'users.id'), 'food_count')
            ->selectSub(SkillPost::selectRaw('COUNT(*)')->whereColumn('skill_posts.user_id', 'users.id'), 'skill_count')
            ->withCount(['receivedRatings'])
            ->get()
            ->map(function ($u) {
                $u->contribution = ($u->food_count ?? 0) + ($u->skill_count ?? 0);
                return $u;
            })
            ->sortByDesc('contribution')
            ->take(10)
            ->values();

        return view('impact.index', compact('stats', 'leaderboard'));
    }
}
