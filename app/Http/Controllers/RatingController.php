<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rated_user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
            'post_type' => 'nullable|in:food,skill',
            'post_id' => 'nullable|integer',
        ]);

        $ratedUser = User::findOrFail($request->rated_user_id);

        $data = [
            'rater_id' => Auth::id(),
            'rated_user_id' => $request->rated_user_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ];

        if ($request->post_type === 'food') {
            $data['food_post_id'] = $request->post_id;
        } elseif ($request->post_type === 'skill') {
            $data['skill_post_id'] = $request->post_id;
        }

        Rating::create($data);

        // Update user's average rating
        $ratings = Rating::where('rated_user_id', $ratedUser->id)->pluck('rating');
        $ratedUser->update([
            'rating' => $ratings->avg(),
            'total_ratings' => $ratings->count(),
        ]);

        \App\Models\Notification::notify(
            (int) $ratedUser->id,
            'rating',
            Auth::user()->name . ' rated you ' . $request->rating . '★',
            $request->comment ?: 'You received a new rating.',
            route('profile.show', $ratedUser),
            'fa-star'
        );

        return back()->with('success', 'Rating submitted successfully!');
    }
}
