@extends('layouts.app')

@section('title', $user->name)

@section('extra_css')
<style>
    .tg-profile-head { background:linear-gradient(135deg,#16302d,#2d8f7f); color:#fff; border-radius:22px;
        padding:40px; position:relative; overflow:hidden; }
    .tg-profile-head::after { content:""; position:absolute; width:220px;height:220px;border-radius:50%;
        background:rgba(127,224,205,.15); top:-70px; right:-40px; }
    .tg-profile-head .inner { position:relative; z-index:1; }
    .tg-profile-avatar { width:90px;height:90px;border-radius:50%; background:linear-gradient(135deg,var(--tg-orange),var(--tg-coral));
        display:flex;align-items:center;justify-content:center; font-size:2.4rem; font-weight:800; color:#fff;
        border:4px solid rgba(255,255,255,.25); }
    .tg-card-post { background:#fff; border-radius:16px; overflow:hidden; height:100%; box-shadow:0 6px 20px rgba(0,0,0,.06);
        transition:transform .25s; }
    .tg-card-post:hover { transform:translateY(-5px); }
    .tg-card-img-ph { height:120px; display:flex;align-items:center;justify-content:center; font-size:2rem; color:#fff; }
    .tg-review { background:#fff; border-radius:14px; padding:18px; margin-bottom:12px; box-shadow:0 3px 12px rgba(0,0,0,.04); }
    .tg-review-avatar { width:38px;height:38px;border-radius:50%; background:linear-gradient(135deg,var(--tg-green),var(--tg-light));
        color:#fff; display:flex;align-items:center;justify-content:center; font-weight:700; flex:0 0 38px; }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5">
    {{-- Header --}}
    <div class="tg-profile-head mb-4">
        <div class="inner d-flex flex-wrap align-items-center gap-4">
            @if ($user->avatar)
                <img src="{{ asset('storage/'.$user->avatar) }}" alt="" class="tg-profile-avatar" style="object-fit:cover;">
            @else
                <div class="tg-profile-avatar">{{ strtoupper(substr($user->name,0,1)) }}</div>
            @endif
            <div class="flex-grow-1">
                <h1 class="fw-bold mb-1">{{ $user->name }}</h1>
                <p class="mb-2" style="opacity:.9;">
                    <i class="fas fa-location-dot me-1"></i>{{ $user->profile?->neighborhood ?? 'Busan' }}
                    @if ($user->profile?->is_verified)<span class="badge bg-light text-success ms-2"><i class="fas fa-circle-check me-1"></i>Verified</span>@endif
                </p>
                @if ($user->bio)<p class="mb-0" style="opacity:.85;">{{ $user->bio }}</p>@endif
            </div>
            <div class="text-center">
                <div class="display-6 fw-bold">⭐ {{ number_format($user->rating, 1) }}</div>
                <small style="opacity:.85;">{{ $user->total_ratings }} ratings</small>
                @if (Auth::id() !== $user->id)
                    <div class="mt-2"><a href="{{ route('messages.conversation', $user->id) }}" class="btn btn-light btn-sm fw-semibold"><i class="fas fa-envelope me-1"></i>Message</a></div>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            {{-- Food --}}
            <h5 class="section-title mb-3"><i class="fas fa-utensils text-warning me-2"></i>Food Posts ({{ $stats['food'] }})</h5>
            @if ($foodPosts->isEmpty())
                <p class="text-muted">No active food posts.</p>
            @else
                <div class="row g-3 mb-4">
                    @foreach ($foodPosts as $post)
                        <div class="col-sm-6">
                            <a href="{{ route('food.show', $post) }}" class="text-decoration-none">
                                <div class="tg-card-post">
                                    @if ($post->image)
                                        <img src="{{ asset('storage/'.$post->image) }}" class="tg-card-img-ph" style="object-fit:cover;width:100%;" alt="">
                                    @else
                                        <div class="tg-card-img-ph" style="background:linear-gradient(135deg,#ff8c42,#ff6f5e)"><i class="fas fa-utensils"></i></div>
                                    @endif
                                    <div class="p-3"><h6 class="fw-bold mb-0 text-dark">{{ $post->title }}</h6>
                                        <small class="text-muted">{{ $post->food_type }}</small></div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Skills --}}
            <h5 class="section-title mb-3"><i class="fas fa-lightbulb text-success me-2"></i>Skills ({{ $stats['skills'] }})</h5>
            @if ($skillPosts->isEmpty())
                <p class="text-muted">No active skills.</p>
            @else
                <div class="row g-3">
                    @foreach ($skillPosts as $post)
                        <div class="col-sm-6">
                            <a href="{{ route('skills.show', $post) }}" class="text-decoration-none">
                                <div class="tg-card-post">
                                    <div class="tg-card-img-ph" style="background:linear-gradient(135deg,#2d8f7f,#45b4a1)"><i class="fas fa-lightbulb"></i></div>
                                    <div class="p-3"><h6 class="fw-bold mb-0 text-dark">{{ $post->title }}</h6>
                                        <small class="text-muted">{{ $post->category }} · {{ $post->skill_level }}</small></div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Reviews --}}
        <div class="col-lg-5">
            <h5 class="section-title mb-3"><i class="fas fa-star text-warning me-2"></i>Reviews</h5>
            @forelse ($reviews as $review)
                <div class="tg-review">
                    <div class="d-flex gap-3">
                        <div class="tg-review-avatar">{{ strtoupper(substr($review->rater->name ?? '?',0,1)) }}</div>
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <strong>{{ $review->rater->name ?? 'User' }}</strong>
                                <span class="text-warning">{{ str_repeat('★', $review->rating) }}<span class="text-muted">{{ str_repeat('★', 5 - $review->rating) }}</span></span>
                            </div>
                            <p class="mb-1 text-muted small">{{ $review->comment }}</p>
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">No written reviews yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
