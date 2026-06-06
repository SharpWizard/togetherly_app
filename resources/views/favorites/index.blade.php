@extends('layouts.app')

@section('title', __('app.favorites.title'))

@section('extra_css')
<style>
    .tg-card-post { background:#fff; border-radius:18px; overflow:hidden; height:100%; box-shadow:0 6px 20px rgba(0,0,0,.06);
        transition:transform .25s; }
    .tg-card-post:hover { transform:translateY(-6px); }
    .tg-card-img { height:160px; object-fit:cover; width:100%; }
    .tg-card-img-ph { height:160px; display:flex;align-items:center;justify-content:center; font-size:2.6rem; color:#fff; }
    .tg-mini-avatar { width:30px;height:30px;border-radius:50%; color:#fff; display:inline-flex;align-items:center;justify-content:center; font-size:.8rem; font-weight:700; }
    .tg-empty { background:#fff; border-radius:18px; padding:56px; text-align:center; box-shadow:0 6px 20px rgba(0,0,0,.05); }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5">
    <h2 class="section-title mb-4"><i class="fas fa-bookmark me-2"></i>{{ __('app.favorites.heading') }}</h2>

    @if ($savedFood->isEmpty() && $savedSkills->isEmpty())
        <div class="tg-empty">
            <i class="fas fa-bookmark fa-2x text-muted mb-3"></i>
            <h5>{{ __('app.favorites.nothing_saved') }}</h5>
            <p class="text-muted mb-3">{{ __('app.favorites.tap_heart') }}</p>
            <a href="{{ route('food.index') }}" class="btn btn-secondary me-2">{{ __('app.favorites.browse_food') }}</a>
            <a href="{{ route('skills.index') }}" class="btn btn-primary">{{ __('app.favorites.browse_skills') }}</a>
        </div>
    @endif

    @if ($savedFood->isNotEmpty())
        <h5 class="fw-bold mb-3"><i class="fas fa-utensils text-warning me-2"></i>{{ __('app.favorites.saved_food') }}</h5>
        <div class="row g-4 mb-5">
            @foreach ($savedFood as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="tg-card-post">
                        @if ($post->image)
                            <img src="{{ asset('storage/'.$post->image) }}" class="tg-card-img" alt="">
                        @else
                            <div class="tg-card-img-ph" style="background:linear-gradient(135deg,#ff8c42,#ff6f5e)"><i class="fas fa-utensils"></i></div>
                        @endif
                        <div class="p-3">
                            <span class="badge bg-warning mb-2">{{ __('app.food_types.'.$post->food_type) }}</span>
                            <h6 class="fw-bold">{{ $post->title }}</h6>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="tg-mini-avatar" style="background:linear-gradient(135deg,var(--tg-orange),var(--tg-coral))">{{ strtoupper(substr($post->user->name,0,1)) }}</span>
                                <small class="text-muted">{{ $post->user->name }}</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('food.show', $post) }}" class="btn btn-primary btn-sm flex-fill">{{ __('app.common.view') }}</a>
                                <form action="{{ route('favorites.food', $post) }}" method="POST">@csrf
                                    <button class="btn btn-outline-primary btn-sm"><i class="fas fa-heart-circle-minus"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if ($savedSkills->isNotEmpty())
        <h5 class="fw-bold mb-3"><i class="fas fa-lightbulb text-success me-2"></i>{{ __('app.favorites.saved_skills') }}</h5>
        <div class="row g-4">
            @foreach ($savedSkills as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="tg-card-post">
                        <div class="tg-card-img-ph" style="background:linear-gradient(135deg,#2d8f7f,#45b4a1)"><i class="fas fa-lightbulb"></i></div>
                        <div class="p-3">
                            <span class="badge bg-success mb-2">{{ __('app.skill_categories.'.$post->category) }}</span>
                            <h6 class="fw-bold">{{ $post->title }}</h6>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="tg-mini-avatar" style="background:linear-gradient(135deg,var(--tg-green),var(--tg-light))">{{ strtoupper(substr($post->user->name,0,1)) }}</span>
                                <small class="text-muted">{{ $post->user->name }}</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('skills.show', $post) }}" class="btn btn-primary btn-sm flex-fill">{{ __('app.common.view') }}</a>
                                <form action="{{ route('favorites.skill', $post) }}" method="POST">@csrf
                                    <button class="btn btn-outline-primary btn-sm"><i class="fas fa-heart-circle-minus"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
