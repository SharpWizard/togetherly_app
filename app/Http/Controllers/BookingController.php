<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\SkillPost;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Request a session for a skill. */
    public function store(Request $request, SkillPost $skillPost)
    {
        $request->validate([
            'preferred_time' => 'nullable|string|max:255',
            'message'        => 'nullable|string|max:500',
        ]);

        if ($skillPost->user_id === Auth::id()) {
            return back()->with('success', 'You cannot book your own skill.');
        }

        $existing = Booking::where('skill_post_id', $skillPost->id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'accepted'])
            ->first();
        if ($existing) {
            return back()->with('success', 'You already have a pending request for this skill.');
        }

        Booking::create([
            'skill_post_id'  => $skillPost->id,
            'user_id'        => Auth::id(),
            'teacher_id'     => $skillPost->user_id,
            'status'         => 'pending',
            'preferred_time' => $request->preferred_time,
            'message'        => $request->message,
        ]);

        Notification::notify(
            $skillPost->user_id,
            'booking',
            Auth::user()->name . ' wants to learn "' . $skillPost->title . '"',
            ($request->preferred_time ? 'Preferred: ' . $request->preferred_time . '. ' : '') . ($request->message ?: ''),
            route('skills.show', $skillPost),
            'fa-calendar-check'
        );

        return back()->with('success', 'Session request sent! The teacher will respond soon.');
    }

    public function accept(Booking $booking)
    {
        $this->authorizeTeacher($booking);

        $booking->update(['status' => 'accepted']);

        Notification::notify(
            $booking->user_id,
            'booking_update',
            'Your session was confirmed! 🎉',
            $booking->teacher->name . ' accepted your request for "' . $booking->skillPost->title . '".',
            route('skills.show', $booking->skillPost),
            'fa-circle-check'
        );

        return back()->with('success', 'Session confirmed! The learner has been notified.');
    }

    public function decline(Booking $booking)
    {
        $this->authorizeTeacher($booking);

        $booking->update(['status' => 'declined']);

        Notification::notify(
            $booking->user_id,
            'booking_update',
            'Your session request was declined',
            'Unfortunately the teacher declined your request for "' . $booking->skillPost->title . '".',
            route('skills.show', $booking->skillPost),
            'fa-circle-xmark'
        );

        return back()->with('success', 'Request declined.');
    }

    public function complete(Booking $booking)
    {
        $this->authorizeTeacher($booking);

        $booking->update(['status' => 'completed']);

        Notification::notify(
            $booking->user_id,
            'booking_update',
            'Session completed ✅',
            'Hope you learned something new! Leave a rating for ' . $booking->teacher->name . '.',
            route('skills.show', $booking->skillPost),
            'fa-star'
        );

        return back()->with('success', 'Session marked as completed!');
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Request cancelled.');
    }

    public function myBookings()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('skillPost', 'teacher')
            ->latest()
            ->paginate(15);

        return view('bookings.index', compact('bookings'));
    }

    private function authorizeTeacher(Booking $booking): void
    {
        if ($booking->teacher_id !== Auth::id()) {
            abort(403);
        }
    }
}
