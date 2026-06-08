@extends('layouts.app')

@section('title', $foodPost->title)

@section('extra_css')
<style>
    .tg-show-img { height:360px; object-fit:cover; width:100%; border-radius:18px; }
    .tg-show-ph { height:360px; border-radius:18px; display:flex;align-items:center;justify-content:center;
        font-size:4rem; color:#fff; background:linear-gradient(135deg,#ff8c42,#ff6f5e); }
    .tg-meta { background:#fff; border-radius:14px; padding:16px; text-align:center; box-shadow:0 3px 12px rgba(0,0,0,.04); }
    .tg-meta .v { font-weight:800; color:var(--tg-dark); }
    .tg-poster { width:54px;height:54px;border-radius:50%; background:linear-gradient(135deg,var(--tg-orange),var(--tg-coral));
        color:#fff; display:flex;align-items:center;justify-content:center; font-size:1.4rem; font-weight:700; }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5">
    <a href="{{ route('welcome') }}" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="fas fa-arrow-left me-1"></i> Back to Home</a>
    <div class="row g-4">
        <div class="col-lg-8">
            @if ($foodPost->image)
                <img src="{{ asset('storage/'.$foodPost->image) }}" class="tg-show-img mb-4" alt="{{ $foodPost->title }}">
            @else
                <div class="tg-show-ph mb-4"><i class="fas fa-utensils"></i></div>
            @endif

            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h1 class="fw-bold mb-0">{{ $foodPost->title }}</h1>
                        <span class="badge bg-info fs-6">{{ __('app.statuses.'.$foodPost->status) }}</span>
                    </div>
                    <p class="text-muted">{{ $foodPost->description }}</p>

                    <div class="row g-3 my-3">
                        <div class="col-4"><div class="tg-meta"><div class="text-muted small">{{ __('app.food.type') }}</div><div class="v">{{ __('app.food_types.'.$foodPost->food_type) }}</div></div></div>
                        <div class="col-4"><div class="tg-meta"><div class="text-muted small">{{ __('app.food.quantity') }}</div><div class="v">{{ $foodPost->quantity }}</div></div></div>
                        <div class="col-4"><div class="tg-meta"><div class="text-muted small">{{ __('app.food.expires') }}</div><div class="v">{{ $foodPost->expires_at->diffForHumans() }}</div></div></div>
                    </div>

                    <hr>
                    <h6 class="fw-bold mb-3">{{ __('app.food.shared_by') }}</h6>
                    <a href="{{ route('profile.show', $foodPost->user) }}" class="d-flex align-items-center gap-3 text-decoration-none">
                        <div class="tg-poster">{{ strtoupper(substr($foodPost->user->name,0,1)) }}</div>
                        <div>
                            <div class="fw-bold text-dark">{{ $foodPost->user->name }}</div>
                            <small class="text-muted">⭐ {{ number_format($foodPost->user->rating,1) }} ({{ $foodPost->user->total_ratings }} {{ __('app.dashboard.ratings') }})</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="card sticky-top" style="top:90px;">
                <div class="card-body p-4">
                    @auth
                        <p class="text-muted small">{{ __('app.food.request_pickup') }}</p>
                        <form action="{{ route('claims.store', $foodPost) }}" method="POST">
                            @csrf
                            <textarea name="message" class="form-control mb-2" rows="2" placeholder="{{ __('app.food.claim_note_placeholder') }}"></textarea>
                            <button class="btn btn-primary w-100"><i class="fas fa-hand-holding-heart me-1"></i>{{ __('app.food.claim_food') }}</button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary w-100 mb-2">{{ __('app.welcome.cta_get_started') }}</a>
                        <p class="text-center text-muted small">Sign up to claim this food</p>
                    @endauth

                    <hr>
                    <div class="small text-muted">
                        <div class="mb-1"><i class="fas fa-location-dot me-2"></i>{{ $foodPost->neighborhood }}</div>
                        <div class="mb-1"><i class="fas fa-eye me-2"></i>{{ $foodPost->views }} {{ __('app.food.views') }}</div>
                        <div class="mb-1"><i class="fas fa-clock me-2"></i>{{ __('app.food.posted') }} {{ $foodPost->created_at->diffForHumans() }}</div>
                        <div><i class="fas fa-hourglass-half me-2"></i>{{ __('app.food.expires_at') }} {{ $foodPost->expires_at->format('M d, H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
