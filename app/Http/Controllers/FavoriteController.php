<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\FoodPost;
use App\Models\SkillPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggleFood(FoodPost $foodPost)
    {
        $fav = Favorite::where('user_id', Auth::id())->where('food_post_id', $foodPost->id)->first();

        if ($fav) {
            $fav->delete();
            $msg = 'Removed from saved.';
        } else {
            Favorite::create(['user_id' => Auth::id(), 'food_post_id' => $foodPost->id]);
            $msg = 'Saved! Find it under Saved.';
        }

        return back()->with('success', $msg);
    }

    public function toggleSkill(SkillPost $skillPost)
    {
        $fav = Favorite::where('user_id', Auth::id())->where('skill_post_id', $skillPost->id)->first();

        if ($fav) {
            $fav->delete();
            $msg = 'Removed from saved.';
        } else {
            Favorite::create(['user_id' => Auth::id(), 'skill_post_id' => $skillPost->id]);
            $msg = 'Saved! Find it under Saved.';
        }

        return back()->with('success', $msg);
    }

    public function index()
    {
        $savedFood = Favorite::where('user_id', Auth::id())
            ->whereNotNull('food_post_id')
            ->with('foodPost.user')
            ->latest()->get()
            ->pluck('foodPost')->filter();

        $savedSkills = Favorite::where('user_id', Auth::id())
            ->whereNotNull('skill_post_id')
            ->with('skillPost.user')
            ->latest()->get()
            ->pluck('skillPost')->filter();

        return view('favorites.index', compact('savedFood', 'savedSkills'));
    }
}
