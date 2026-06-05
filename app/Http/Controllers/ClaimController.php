<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\FoodPost;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** A user requests to claim a food post. */
    public function store(Request $request, FoodPost $foodPost)
    {
        $request->validate(['message' => 'nullable|string|max:500']);

        if ($foodPost->user_id === Auth::id()) {
            return back()->with('success', 'You cannot claim your own food post.');
        }
        if ($foodPost->status !== 'available') {
            return back()->with('success', 'This food is no longer available.');
        }

        $existing = Claim::where('food_post_id', $foodPost->id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'accepted'])
            ->first();
        if ($existing) {
            return back()->with('success', 'You already have a pending claim on this item.');
        }

        Claim::create([
            'food_post_id' => $foodPost->id,
            'user_id'      => Auth::id(),
            'owner_id'     => $foodPost->user_id,
            'status'       => 'pending',
            'message'      => $request->message,
        ]);

        Notification::notify(
            $foodPost->user_id,
            'claim',
            Auth::user()->name . ' wants your "' . $foodPost->title . '"',
            $request->message ?: 'Tap to review the claim request.',
            route('food.show', $foodPost),
            'fa-hand-holding-heart'
        );

        return back()->with('success', 'Claim request sent! The owner will review it.');
    }

    /** Owner accepts a claim. */
    public function accept(Claim $claim)
    {
        $this->authorizeOwner($claim);

        $claim->update(['status' => 'accepted']);
        $claim->foodPost->update(['status' => 'claimed']);

        // Decline other pending claims on the same post
        Claim::where('food_post_id', $claim->food_post_id)
            ->where('id', '!=', $claim->id)
            ->where('status', 'pending')
            ->update(['status' => 'declined']);

        Notification::notify(
            $claim->user_id,
            'claim_update',
            'Your claim was accepted! 🎉',
            'You can pick up "' . $claim->foodPost->title . '". Message to arrange details.',
            route('food.show', $claim->foodPost),
            'fa-circle-check'
        );

        return back()->with('success', 'Claim accepted! The claimer has been notified.');
    }

    /** Owner declines a claim. */
    public function decline(Claim $claim)
    {
        $this->authorizeOwner($claim);

        $claim->update(['status' => 'declined']);

        Notification::notify(
            $claim->user_id,
            'claim_update',
            'Your claim was declined',
            'The owner declined your claim for "' . $claim->foodPost->title . '".',
            route('food.show', $claim->foodPost),
            'fa-circle-xmark'
        );

        return back()->with('success', 'Claim declined.');
    }

    /** Owner marks the exchange complete. */
    public function complete(Claim $claim)
    {
        $this->authorizeOwner($claim);

        $claim->update(['status' => 'completed']);

        Notification::notify(
            $claim->user_id,
            'claim_update',
            'Exchange completed ✅',
            'Thanks for using Togetherly! Leave a rating for ' . $claim->owner->name . '.',
            route('food.show', $claim->foodPost),
            'fa-star'
        );

        return back()->with('success', 'Marked as completed. Less food wasted!');
    }

    /** Claimer cancels their own claim. */
    public function cancel(Claim $claim)
    {
        if ($claim->user_id !== Auth::id()) {
            abort(403);
        }
        $claim->update(['status' => 'cancelled']);

        // Free the food back up if it was reserved for this claim
        if ($claim->foodPost->status === 'claimed') {
            $claim->foodPost->update(['status' => 'available']);
        }

        return back()->with('success', 'Claim cancelled.');
    }

    /** "My claims" list. */
    public function myClaims()
    {
        $claims = Claim::where('user_id', Auth::id())
            ->with('foodPost', 'owner')
            ->latest()
            ->paginate(15);

        return view('claims.index', compact('claims'));
    }

    private function authorizeOwner(Claim $claim): void
    {
        if ($claim->owner_id !== Auth::id()) {
            abort(403);
        }
    }
}
