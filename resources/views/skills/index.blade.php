@extends('layouts.app')

@section('title', __('app.skills.index_title'))

@section('extra_css')
<style>
    .tg-page-head { background: linear-gradient(135deg,#2d8f7f,#45b4a1); color:#fff; border-radius:22px;
        padding:32px 36px; position:relative; overflow:hidden; }
    .tg-page-head::after { content:""; position:absolute; width:200px;height:200px;border-radius:50%;
        background:rgba(255,255,255,.15); top:-60px; right:-30px; }
    .tg-page-head .inner { position:relative; z-index:1; }
    .tg-card-post { background:#fff; border-radius:18px; overflow:hidden; height:100%; box-shadow:0 6px 20px rgba(0,0,0,.06);
        transition:transform .25s, box-shadow .25s; }
    .tg-card-post:hover { transform:translateY(-6px); box-shadow:0 16px 36px rgba(0,0,0,.12); }
    .tg-card-img-ph { height:160px; display:flex;align-items:center;justify-content:center; font-size:3rem; color:#fff;
        background:linear-gradient(135deg,#2d8f7f,#45b4a1); position:relative; }
    .tg-card-img-ph .cat { position:absolute; bottom:14px; left:14px; }
    .tg-mini-avatar { width:32px;height:32px;border-radius:50%; background:linear-gradient(135deg,var(--tg-green),var(--tg-light));
        color:#fff; display:inline-flex;align-items:center;justify-content:center; font-size:.85rem; font-weight:700; }
    .tg-empty { background:#fff; border-radius:18px; padding:56px; text-align:center; box-shadow:0 6px 20px rgba(0,0,0,.05); }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5">
    <div class="tg-page-head mb-4">
        <div class="inner d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h1 class="fw-bold mb-1"><i class="fas fa-lightbulb me-2"></i>{{ __('app.skills.near_you') }}</h1>
                <p class="mb-0" style="opacity:.9;"><i class="fas fa-location-dot me-1"></i>{{ Auth::user()->profile?->neighborhood ?? __('app.food.not_set') }} · {{ $skillPosts->total() }} {{ __('app.skills.available_count') }}</p>
            </div>
            <a href="{{ route('skills.create') }}" class="btn btn-light fw-semibold" style="border-radius:12px;"><i class="fas fa-plus me-1"></i> {{ __('app.skills.share_skill') }}</a>
        </div>
    </div>

    {{-- Search & filters --}}
    <form method="GET" action="{{ route('skills.index') }}" class="card border-0 p-3 mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0" placeholder="{{ __('app.skills.search_placeholder') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">{{ __('app.skill_categories.all') }}</option>
                    @foreach (['languages','cooking','music','coding','fitness','art','business','other'] as $val)
                        <option value="{{ $val }}" {{ request('category')===$val?'selected':'' }}>{{ __('app.skill_categories.'.$val) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="level" class="form-select">
                    <option value="">{{ __('app.skill_levels.any') }}</option>
                    @foreach (['beginner','intermediate','advanced'] as $val)
                        <option value="{{ $val }}" {{ request('level')===$val?'selected':'' }}>{{ __('app.skill_levels.'.$val) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-primary"><i class="fas fa-filter me-1"></i>{{ __('app.skills.filter') }}</button>
            </div>
        </div>
        @if (request('q') || request('category') || request('level'))
            <div class="mt-2"><a href="{{ route('skills.index') }}" class="small text-decoration-none text-muted"><i class="fas fa-xmark me-1"></i>{{ __('app.skills.clear_filters') }}</a></div>
        @endif
    </form>

    @if ($skillPosts->isEmpty())
        <div class="tg-empty">
            <i class="fas fa-lightbulb fa-2x text-success mb-3"></i>
            <h5>{{ __('app.skills.none_found') }}</h5>
            <p class="text-muted">{{ __('app.skills.share_knowledge') }}</p>
            <a href="{{ route('skills.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> {{ __('app.skills.share_skill') }}</a>
        </div>
    @else
        <div class="row g-4">
            @foreach ($skillPosts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="tg-card-post">
                        @if ($post->image)
                            <div class="position-relative">
                                <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" style="height:160px;width:100%;object-fit:cover;">
                                <span class="badge bg-success position-absolute" style="bottom:14px;left:14px;">{{ __('app.skill_categories.'.$post->category) }}</span>
                            </div>
                        @else
                            <div class="tg-card-img-ph">
                                <i class="fas fa-lightbulb"></i>
                                <span class="badge bg-light text-dark cat">{{ __('app.skill_categories.'.$post->category) }}</span>
                            </div>
                        @endif
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold mb-0">{{ $post->title }}</h6>
                                <span class="badge bg-info">{{ __('app.skill_levels.'.$post->skill_level) }}</span>
                            </div>
                            <p class="text-muted small mb-3">{{ Str::limit($post->description, 75) }}</p>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="tg-mini-avatar">{{ strtoupper(substr($post->user->name,0,1)) }}</span>
                                <small class="text-muted">{{ $post->user->name }} · ⭐ {{ number_format($post->user->rating,1) }}</small>
                            </div>
                            <a href="{{ route('skills.show', $post) }}" class="btn btn-primary w-100"><i class="fas fa-circle-info me-1"></i> {{ __('app.common.view_details') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">{{ $skillPosts->links() }}</div>
    @endif
</div>
@endsection
