<?php

namespace App\Http\Controllers;

use App\Models\FoodPost;
use App\Models\SkillPost;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));

        $food = collect();
        $skills = collect();
        $people = collect();

        if ($q !== '') {
            $food = FoodPost::where('status', 'available')
                ->where('expires_at', '>', now())
                ->where(function ($w) use ($q) {
                    $w->where('title', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%")
                      ->orWhere('food_type', 'like', "%{$q}%");
                })
                ->with('user')->latest()->limit(24)->get();

            $skills = SkillPost::where('status', 'active')
                ->where(function ($w) use ($q) {
                    $w->where('title', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%")
                      ->orWhere('category', 'like', "%{$q}%");
                })
                ->with('user')->latest()->limit(24)->get();

            $people = User::where('name', 'like', "%{$q}%")
                ->with('profile')->limit(24)->get();
        }

        $total = $food->count() + $skills->count() + $people->count();

        return view('search.index', compact('q', 'food', 'skills', 'people', 'total'));
    }
}
