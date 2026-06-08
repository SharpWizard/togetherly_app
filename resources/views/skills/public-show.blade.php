@extends('layouts.app')

@section('title', $skillPost->title)

@section('extra_css')
<style>
    .tg-show-banner { height:200px; border-radius:18px; display:flex;align-items:center;justify-content:center;
        font-size:4rem; color:#fff; background:linear-gradient(135deg,#2d8f7f,#45b4a1); position:relative; overflow:hidden; }
    .tg-show-banner .cat { position:absolute; bottom:16px; left:16px; }
    .tg-poster { width:54px;height:54px;border-radius:50%; background:linear-gradient(135deg,var(--tg-green),var(--tg-light));
        color:#fff; display:flex;align-items:center;justify-content:center; font-size:1.4rem; font-weight:700; }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5">
    <a href="{{ route('welcome') }}" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="fas fa-arrow-left me-1"></i> Back to Home</a>
    <div class="row g-4">
        <div class="col-lg-8">
            @if ($skillPost->image)
                <div class="position-relative mb-4">
                    <img src="{{ asset('storage/'.$skillPost->image) }}" alt="{{ $skillPost->title }}" style="width:100%;height:320px;object-fit:cover;border-radius:18px;">
                    <span class="badge bg-success position-absolute" style="bottom:16px;left:16px;font-size:.9rem;">{{ __('app.skill_categories.'.$skillPost->category) }}</span>
                </div>
            @else
                <div class="tg-show-banner mb-4">
                    <i class="fas fa-lightbulb"></i>
                    <span class="badge bg-light text-dark cat">{{ __('app.skill_categories.'.$skillPost->category) }}</span>
                </div>
            @endif

            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h1 class="fw-bold mb-0">{{ $skillPost->title }}</h1>
                        <span class="badge bg-info fs-6">{{ __('app.skill_levels.'.$skillPost->skill_level) }}</span>
                    </div>
                    <p class="text-muted">{{ $skillPost->description }}</p>
                    @if ($skillPost->available_times)
                        <p class="mb-0"><i class="fas fa-clock text-success me-2"></i><strong>{{ __('app.skills.available_label') }}</strong> {{ $skillPost->available_times }}</p>
                    @endif

                    <hr>
                    <h6 class="fw-bold mb-3">{{ __('app.skills.taught_by') }}</h6>
                    <a href="{{ route('profile.show', $skillPost->user) }}" class="d-flex align-items-center gap-3 text-decoration-none">
                        <div class="tg-poster">{{ strtoupper(substr($skillPost->user->name,0,1)) }}</div>
                        <div>
                            <div class="fw-bold text-dark">{{ $skillPost->user->name }}</div>
                            <small class="text-muted">⭐ {{ number_format($skillPost->user->rating,1) }} ({{ $skillPost->user->total_ratings }} {{ __('app.dashboard.ratings') }})</small>
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
                        <h6 class="fw-bold mb-2"><i class="fas fa-calendar-check text-success me-1"></i>{{ __('app.skills.book_session') }}</h6>
                        <p class="text-muted small">{{ __('app.skills.send_request_hint') }}</p>
                        <form action="{{ route('bookings.store', $skillPost) }}" method="POST">
                            @csrf
                            <input type="text" name="preferred_time" class="form-control mb-2" placeholder="{{ __('app.skills.preferred_time_placeholder') }}">
                            <textarea name="message" class="form-control mb-2" rows="2" placeholder="{{ __('app.skills.optional_message') }}"></textarea>
                            <button class="btn btn-primary w-100"><i class="fas fa-paper-plane me-1"></i>{{ __('app.skills.request_session') }}</button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary w-100 mb-2">{{ __('app.welcome.cta_get_started') }}</a>
                        <p class="text-center text-muted small">Sign up to book this skill session</p>
                    @endauth

                    <hr>
                    <div class="small text-muted">
                        <div class="mb-1"><i class="fas fa-location-dot me-2"></i>{{ $skillPost->neighborhood }}</div>
                        <div class="mb-1"><i class="fas fa-layer-group me-2"></i>{{ __('app.skill_categories.'.$skillPost->category) }}</div>
                        <div class="mb-1"><i class="fas fa-eye me-2"></i>{{ $skillPost->views }} {{ __('app.skills.views') }}</div>
                        <div><i class="fas fa-clock me-2"></i>{{ __('app.skills.posted') }} {{ $skillPost->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
