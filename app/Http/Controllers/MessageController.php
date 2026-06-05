<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inbox()
    {
        $threads = $this->buildThreads('recipient_id');
        return view('messages.inbox', ['threads' => $threads, 'box' => 'inbox']);
    }

    public function sent()
    {
        $threads = $this->buildThreads('sender_id');
        return view('messages.sent', ['threads' => $threads, 'box' => 'sent']);
    }

    /**
     * Build a list of conversation threads (one row per other-user, latest message + unread count).
     */
    private function buildThreads(string $box)
    {
        $me = Auth::id();

        // All messages involving me, newest first
        $messages = Message::where('sender_id', $me)
            ->orWhere('recipient_id', $me)
            ->with('sender', 'recipient')
            ->latest()
            ->get();

        $threads = [];
        foreach ($messages as $m) {
            $otherId = $m->sender_id === $me ? $m->recipient_id : $m->sender_id;
            if (! isset($threads[$otherId])) {
                $other = $m->sender_id === $me ? $m->recipient : $m->sender;
                if (! $other) {
                    continue;
                }
                $threads[$otherId] = [
                    'user'    => $other,
                    'last'    => $m,
                    'unread'  => 0,
                ];
            }
            if (! $m->is_read && $m->recipient_id === $me) {
                $threads[$otherId]['unread']++;
            }
        }

        return collect(array_values($threads));
    }

    public function conversation($userId)
    {
        $otherUser = User::findOrFail($userId);
        $me = Auth::id();

        $messages = $this->conversationQuery($me, $otherUser->id)
            ->with('sender', 'recipient', 'foodPost', 'skillPost')
            ->orderBy('created_at')
            ->get();

        // Mark incoming as read
        Message::where('recipient_id', $me)
            ->where('sender_id', $otherUser->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('messages.conversation', compact('messages', 'otherUser'));
    }

    /**
     * JSON endpoint for live polling — returns messages after a given id.
     */
    public function fetch(Request $request, $userId)
    {
        $me = Auth::id();
        $other = User::findOrFail($userId);
        $afterId = (int) $request->input('after', 0);

        $messages = $this->conversationQuery($me, $other->id)
            ->where('id', '>', $afterId)
            ->orderBy('created_at')
            ->get();

        // Mark newly fetched incoming messages as read
        Message::where('recipient_id', $me)
            ->where('sender_id', $other->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json([
            'messages' => $messages->map(fn ($m) => [
                'id'    => $m->id,
                'mine'  => $m->sender_id === $me,
                'text'  => $m->message,
                'time'  => $m->created_at->format('M d, H:i'),
            ]),
        ]);
    }

    private function conversationQuery($me, $otherId)
    {
        return Message::where(function ($q) use ($me, $otherId) {
            $q->where('sender_id', $me)->where('recipient_id', $otherId);
        })->orWhere(function ($q) use ($me, $otherId) {
            $q->where('sender_id', $otherId)->where('recipient_id', $me);
        });
    }

    public function sendMessage(Request $request, $userId)
    {
        $request->validate([
            'message'   => 'required|string|max:2000',
            'post_type' => 'nullable|in:food,skill',
            'post_id'   => 'nullable|integer',
        ]);

        $recipient = User::findOrFail($userId);

        $data = [
            'sender_id'    => Auth::id(),
            'recipient_id' => $recipient->id,
            'message'      => $request->message,
        ];

        if ($request->post_type === 'food') {
            $data['food_post_id'] = $request->post_id;
        } elseif ($request->post_type === 'skill') {
            $data['skill_post_id'] = $request->post_id;
        }

        $message = Message::create($data);

        Notification::notify(
            $recipient->id,
            'message',
            Auth::user()->name . ' sent you a message',
            Str::limit($request->message, 80),
            route('messages.conversation', Auth::id()),
            'fa-envelope'
        );

        // AJAX request → return JSON for instant UI
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'ok'      => true,
                'message' => [
                    'id'   => $message->id,
                    'mine' => true,
                    'text' => $message->message,
                    'time' => $message->created_at->format('M d, H:i'),
                ],
            ]);
        }

        return back()->with('success', 'Message sent!');
    }

    public function markAsRead(Message $message)
    {
        if ($message->recipient_id !== Auth::id()) {
            abort(403);
        }

        $message->update(['is_read' => true, 'read_at' => now()]);

        return back();
    }
}
