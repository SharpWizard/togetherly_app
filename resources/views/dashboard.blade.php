@extends('layouts.app')

@section('title', 'Dashboard')

@section('extra_css')
<style>
    .tg-dash-hero {
        background: linear-gradient(135deg, #16302d, #2d8f7f); color:#fff;
        border-radius: 22px; padding: 34px 38px; position: relative; overflow: hidden;
    }
    .tg-dash-hero::after { content:""; position:absolute; width:220px;height:220px;border-radius:50%;
        background:rgba(127,224,205,.18); top:-70px; right:-40px; }
    .tg-dash-hero .inner { position:relative; z-index:1; }
    .tg-stat-card { background:#fff; border-radius:18px; padding:22px; box-shadow:0 6px 20px rgba(0,0,0,.05);
        display:flex; align-items:center; gap:16px; height:100%; transition:transform .25s; }
    .tg-stat-card:hover { transform:translateY(-5px); }
    .tg-stat-ic { width:54px;height:54px;border-radius:14px; display:flex;align-items:center;justify-content:center;
        font-size:1.4rem; color:#fff; flex:0 0 54px; }
    .tg-stat-card .v { font-size:1.6rem; font-weight:800; line-height:1; color:var(--tg-dark); }
    .tg-stat-card .l { font-size:.82rem; color:#7a8884; }
    .tg-card-post { background:#fff; border-radius:18px; overflow:hidden; height:100%; box-shadow:0 6px 20px rgba(0,0,0,.06);
        transition:transform .25s, box-shadow .25s; }
    .tg-card-post:hover { transform:translateY(-6px); box-shadow:0 16px 36px rgba(0,0,0,.12); }
    .tg-card-img { height:170px; object-fit:cover; width:100%; }
    .tg-card-img-ph { height:170px; display:flex;align-items:center;justify-content:center; font-size:2.4rem; color:#fff; }
    .tg-mini-avatar { width:30px;height:30px;border-radius:50%; background:linear-gradient(135deg,var(--tg-orange),var(--tg-coral));
        color:#fff; display:inline-flex;align-items:center;justify-content:center; font-size:.8rem; font-weight:700; }
    .tg-empty { background:#fff; border-radius:18px; padding:48px; text-align:center; box-shadow:0 6px 20px rgba(0,0,0,.05); }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5">

    {{-- Hero --}}
    <div class="tg-dash-hero mb-4">
        <div class="inner d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h1 class="fw-bold mb-1">Hello, {{ Auth::user()->name }} 👋</h1>
                <p class="mb-0" style="opacity:.85;">
                    <i class="fas fa-location-dot me-1"></i>{{ Auth::user()->profile?->neighborhood ?? 'Set your neighborhood' }}
                    &nbsp;·&nbsp; ⭐ {{ number_format(Auth::user()->rating, 1) }} ({{ Auth::user()->total_ratings }} ratings)
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('food.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i> Share Food</a>
                <a href="{{ route('skills.create') }}" class="btn btn-light fw-semibold" style="border-radius:12px;"><i class="fas fa-plus me-1"></i> Share Skill</a>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-5">
        <div class="col-6 col-lg-3">
            <div class="tg-stat-card">
                <div class="tg-stat-ic" style="background:linear-gradient(135deg,#ffb347,#ff8c42)"><i class="fas fa-star"></i></div>
                <div><div class="v">{{ number_format(Auth::user()->rating, 1) }}</div><div class="l">Your Rating</div></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="tg-stat-card">
                <div class="tg-stat-ic" style="background:linear-gradient(135deg,#ff8c42,#ff6f5e)"><i class="fas fa-utensils"></i></div>
                <div><div class="v">{{ $myFoodPosts->count() }}</div><div class="l">Food Posts</div></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="tg-stat-card">
                <div class="tg-stat-ic" style="background:linear-gradient(135deg,#2d8f7f,#45b4a1)"><i class="fas fa-lightbulb"></i></div>
                <div><div class="v">{{ $mySkillPosts->count() }}</div><div class="l">Skills Shared</div></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <a href="{{ route('messages.inbox') }}" class="text-decoration-none">
                <div class="tg-stat-card">
                    <div class="tg-stat-ic" style="background:linear-gradient(135deg,#45b4a1,#7fe0cd)"><i class="fas fa-envelope"></i></div>
                    <div><div class="v">{{ \App\Models\Message::where('recipient_id', Auth::id())->where('is_read', false)->count() }}</div><div class="l">Unread Messages</div></div>
                </div>
            </a>
        </div>
    </div>

    {{-- My Posts --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title mb-0">Your Posts</h4>
    </div>
    <div class="row g-4 mb-5">
        @if ($myFoodPosts->isEmpty() && $mySkillPosts->isEmpty())
            <div class="col-12">
                <div class="tg-empty">
                    <i class="fas fa-seedling fa-2x text-success mb-3"></i>
                    <h5>Start sharing with your community!</h5>
                    <p class="text-muted">Post surplus food or offer a skill to connect with neighbors.</p>
                    <a href="{{ route('food.create') }}" class="btn btn-secondary me-2">Share Food</a>
                    <a href="{{ route('skills.create') }}" class="btn btn-primary">Share Skill</a>
                </div>
            </div>
        @else
            @foreach ($myFoodPosts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="tg-card-post">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="tg-card-img" alt="{{ $post->title }}">
                        @else
                            <div class="tg-card-img-ph" style="background:linear-gradient(135deg,#ff8c42,#ff6f5e)"><i class="fas fa-utensils"></i></div>
                        @endif
                        <div class="p-3">
                            <span class="badge bg-warning mb-2">Food · {{ $post->status }}</span>
                            <h6 class="fw-bold">{{ $post->title }}</h6>
                            <p class="text-muted small mb-3">{{ Str::limit($post->description, 70) }}</p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('food.show', $post) }}" class="btn btn-outline-primary btn-sm flex-fill">View</a>
                                <a href="{{ route('food.edit', $post) }}" class="btn btn-light btn-sm">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @foreach ($mySkillPosts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="tg-card-post">
                        <div class="tg-card-img-ph" style="background:linear-gradient(135deg,#2d8f7f,#45b4a1)"><i class="fas fa-lightbulb"></i></div>
                        <div class="p-3">
                            <span class="badge bg-success mb-2">Skill · {{ $post->category }}</span>
                            <h6 class="fw-bold">{{ $post->title }}</h6>
                            <p class="text-muted small mb-3">{{ Str::limit($post->description, 70) }}</p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('skills.show', $post) }}" class="btn btn-outline-primary btn-sm flex-fill">View</a>
                                <a href="{{ route('skills.edit', $post) }}" class="btn btn-light btn-sm">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Community --}}
    @if (!$recentFoodPosts->isEmpty() || !$recentSkillPosts->isEmpty())
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="section-title mb-0">Available in {{ Auth::user()->profile?->neighborhood }}</h4>
            <a href="{{ route('food.index') }}" class="text-decoration-none fw-semibold" style="color:var(--tg-green)">See all <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-4">
            @foreach ($recentFoodPosts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="tg-card-post">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="tg-card-img" alt="{{ $post->title }}">
                        @else
                            <div class="tg-card-img-ph" style="background:linear-gradient(135deg,#ff8c42,#ff6f5e)"><i class="fas fa-utensils"></i></div>
                        @endif
                        <div class="p-3">
                            <span class="badge bg-warning mb-2">Food</span>
                            <h6 class="fw-bold">{{ $post->title }}</h6>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="tg-mini-avatar">{{ strtoupper(substr($post->user->name,0,1)) }}</span>
                                <small class="text-muted">{{ $post->user->name }} · ⭐ {{ number_format($post->user->rating,1) }}</small>
                            </div>
                            <a href="{{ route('food.show', $post) }}" class="btn btn-primary btn-sm w-100">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
            @foreach ($recentSkillPosts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="tg-card-post">
                        <div class="tg-card-img-ph" style="background:linear-gradient(135deg,#2d8f7f,#45b4a1)"><i class="fas fa-lightbulb"></i></div>
                        <div class="p-3">
                            <span class="badge bg-success mb-2">{{ $post->category }}</span>
                            <h6 class="fw-bold">{{ $post->title }}</h6>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="tg-mini-avatar">{{ strtoupper(substr($post->user->name,0,1)) }}</span>
                                <small class="text-muted">{{ $post->user->name }} · ⭐ {{ number_format($post->user->rating,1) }}</small>
                            </div>
                            <a href="{{ route('skills.show', $post) }}" class="btn btn-primary btn-sm w-100">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
