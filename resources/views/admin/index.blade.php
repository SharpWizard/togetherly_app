@extends('layouts.app')

@section('title', __('app.admin.dashboard_title'))

@section('extra_css')
<style>
    .tg-admin-hero { background:linear-gradient(135deg,#16302d,#3a4f4a); color:#fff; border-radius:22px; padding:32px 36px; }
    .tg-stat { background:#fff; border-radius:16px; padding:22px; text-align:center; box-shadow:0 4px 16px rgba(0,0,0,.05); height:100%; }
    .tg-stat .v { font-size:1.8rem; font-weight:800; color:var(--tg-dark); }
    .tg-stat .l { font-size:.82rem; color:#7a8884; }
    .tg-panel { background:#fff; border-radius:16px; padding:22px; box-shadow:0 4px 16px rgba(0,0,0,.05); }
    .tg-li { display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f0f3f0; }
    .tg-li:last-child { border-bottom:none; }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5">
    <div class="tg-admin-hero mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h1 class="fw-bold mb-1"><i class="fas fa-shield-halved me-2"></i>{{ __('app.admin.dashboard_title') }}</h1>
            <p class="mb-0" style="opacity:.85;">{{ __('app.admin.dashboard_subtitle') }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reports') }}" class="btn btn-light fw-semibold position-relative">
                <i class="fas fa-flag me-1"></i>{{ __('app.admin.reports') }}
                @if ($stats['reports'] > 0)<span class="badge bg-danger rounded-pill ms-1">{{ $stats['reports'] }}</span>@endif
            </a>
            <a href="{{ route('admin.users') }}" class="btn btn-light fw-semibold"><i class="fas fa-users me-1"></i>{{ __('app.admin.manage_users') }}</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3"><div class="tg-stat"><div class="v">{{ $stats['users'] }}</div><div class="l">{{ __('app.admin.members') }}</div></div></div>
        <div class="col-6 col-lg-3"><div class="tg-stat"><div class="v text-warning">{{ $stats['food'] }}</div><div class="l">{{ __('app.admin.food_posts') }}</div></div></div>
        <div class="col-6 col-lg-3"><div class="tg-stat"><div class="v" style="color:var(--tg-green)">{{ $stats['skills'] }}</div><div class="l">{{ __('app.admin.skills') }}</div></div></div>
        <div class="col-6 col-lg-3"><div class="tg-stat"><div class="v">{{ $stats['verified'] }}</div><div class="l">{{ __('app.admin.verified') }}</div></div></div>
        <div class="col-6 col-lg-3"><div class="tg-stat"><div class="v">{{ $stats['claims'] }}</div><div class="l">{{ __('app.admin.claims') }}</div></div></div>
        <div class="col-6 col-lg-3"><div class="tg-stat"><div class="v">{{ $stats['bookings'] }}</div><div class="l">{{ __('app.admin.bookings') }}</div></div></div>
        <div class="col-6 col-lg-3"><div class="tg-stat"><div class="v">{{ $stats['messages'] }}</div><div class="l">{{ __('app.admin.messages') }}</div></div></div>
        <div class="col-6 col-lg-3"><a href="{{ route('admin.reports') }}" class="text-decoration-none"><div class="tg-stat"><div class="v text-danger">{{ $stats['reports'] }}</div><div class="l">{{ __('app.admin.open_reports') }}</div></div></a></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="tg-panel">
                <h6 class="fw-bold mb-3"><i class="fas fa-utensils text-warning me-2"></i>{{ __('app.admin.recent_food') }}</h6>
                @forelse ($recentFood as $post)
                    <div class="tg-li">
                        <div>
                            <a href="{{ route('food.show', $post) }}" class="text-decoration-none fw-semibold text-dark">{{ $post->title }}</a>
                            <div class="small text-muted">{{ __('app.admin.by') }} {{ $post->user->name }} · {{ $post->created_at->diffForHumans() }}</div>
                        </div>
                        <form action="{{ route('admin.food.delete', $post) }}" method="POST" onsubmit="return confirm('{{ __('app.admin.delete_post_confirm') }}')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-primary"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                @empty
                    <p class="text-muted mb-0">{{ __('app.admin.no_food') }}</p>
                @endforelse
            </div>
        </div>
        <div class="col-lg-6">
            <div class="tg-panel">
                <h6 class="fw-bold mb-3"><i class="fas fa-lightbulb text-success me-2"></i>{{ __('app.admin.recent_skills') }}</h6>
                @forelse ($recentSkills as $post)
                    <div class="tg-li">
                        <div>
                            <a href="{{ route('skills.show', $post) }}" class="text-decoration-none fw-semibold text-dark">{{ $post->title }}</a>
                            <div class="small text-muted">{{ __('app.admin.by') }} {{ $post->user->name }} · {{ $post->created_at->diffForHumans() }}</div>
                        </div>
                        <form action="{{ route('admin.skills.delete', $post) }}" method="POST" onsubmit="return confirm('{{ __('app.admin.delete_skill_confirm') }}')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-primary"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                @empty
                    <p class="text-muted mb-0">{{ __('app.admin.no_skills') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
