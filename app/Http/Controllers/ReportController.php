<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\FoodPost;
use App\Models\SkillPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function storeFood(Request $request, FoodPost $foodPost)
    {
        return $this->store($request, ['food_post_id' => $foodPost->id], $foodPost->user_id);
    }

    public function storeSkill(Request $request, SkillPost $skillPost)
    {
        return $this->store($request, ['skill_post_id' => $skillPost->id], $skillPost->user_id);
    }

    private function store(Request $request, array $target, int $ownerId)
    {
        $request->validate([
            'reason'  => 'required|string|max:100',
            'details' => 'nullable|string|max:500',
        ]);

        if ($ownerId === Auth::id()) {
            return back()->with('success', "You can't report your own post.");
        }

        Report::create(array_merge($target, [
            'reporter_id' => Auth::id(),
            'reason'      => $request->reason,
            'details'     => $request->details,
            'status'      => 'open',
        ]));

        return back()->with('success', 'Thanks — your report has been sent to the moderators.');
    }
}
