<?php

namespace App\Http\Controllers;

use App\Models\FoodPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FoodPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $userNeighborhood = $user->profile?->neighborhood;

        $query = FoodPost::where('neighborhood', $userNeighborhood)
            ->where('status', 'available')
            ->where('expires_at', '>', now())
            ->with('user');

        if ($search = $request->input('q')) {
            $query->where(function ($w) use ($search) {
                $w->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($type = $request->input('type')) {
            $query->where('food_type', $type);
        }

        $sort = $request->input('sort', 'latest');
        if ($sort === 'expiring') {
            $query->orderBy('expires_at', 'asc');
        } else {
            $query->latest();
        }

        $foodPosts = $query->paginate(12)->withQueryString();

        return view('food.index', compact('foodPosts'));
    }

    public function create()
    {
        return view('food.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'food_type' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'expires_at' => 'required|date|after:now',
        ]);

        $user = Auth::user();
        $profile = $user->profile;

        $data = $request->all();
        $data['user_id'] = $user->id;
        $data['neighborhood'] = $profile?->neighborhood ?? 'Unknown';
        $data['latitude'] = $profile?->latitude ?? 0;
        $data['longitude'] = $profile?->longitude ?? 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('food', 'public');
        }

        FoodPost::create($data);

        return redirect()->route('food.index')->with('success', 'Food post created successfully!');
    }

    public function show(FoodPost $foodPost)
    {
        if ($foodPost->user_id !== Auth::id()) {
            $foodPost->increment('views');
        }
        return view('food.show', compact('foodPost'));
    }

    public function edit(FoodPost $foodPost)
    {
        if ($foodPost->user_id !== Auth::id()) {
            abort(403);
        }

        return view('food.edit', compact('foodPost'));
    }

    public function update(Request $request, FoodPost $foodPost)
    {
        if ($foodPost->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'food_type' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:available,claimed,expired',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($foodPost->image) {
                Storage::disk('public')->delete($foodPost->image);
            }
            $data['image'] = $request->file('image')->store('food', 'public');
        }

        $foodPost->update($data);

        return redirect()->route('food.show', $foodPost)->with('success', 'Food post updated!');
    }

    public function destroy(FoodPost $foodPost)
    {
        if ($foodPost->user_id !== Auth::id()) {
            abort(403);
        }

        if ($foodPost->image) {
            Storage::disk('public')->delete($foodPost->image);
        }

        $foodPost->delete();

        return redirect()->route('food.index')->with('success', 'Food post deleted!');
    }
}
