@extends('layouts.app')

@section('title', __('app.search.title'))

@section('extra_css')
<style>
    .tg-card-post { background:#fff; border-radius:16px; overflow:hidden; height:100%; box-shadow:0 6px 20px rgba(0,0,0,.06); transition:transform .25s; }
    .tg-card-post:hover { transform:translateY(-5px); }
    .tg-card-img { height:150px; object-fit:cover; width:100%; }
    .tg-card-img-ph { height:150px; display:flex;align-items:center;justify-content:center; font-size:2.2rem; color:#fff; }
    .tg-mini-avatar { width:30px;height:30px;border-radius:50%; color:#fff; display:inline-flex;align-items:center;justify-content:center; font-size:.8rem; font-weight:700; }
    .tg-person { background:#fff; border-radius:14px; padding:18px; box-shadow:0 4px 16px rgba(0,0,0,.05); display:flex; gap:14px; align-items:center; height:100%; }
    .tg-person-av { width:52px;height:52px;border-radius:50%; background:linear-gradient(135deg,var(--tg-green),var(--tg-light)); color:#fff; display:flex;align-items:center;justify-content:center; font-weight:700; flex:0 0 52px; overflow:hidden; }
    .tg-person-av img { width:100%;height:100%;object-fit:cover; }
    .tg-empty { background:#fff; border-radius:18px; padding:56px; text-align:center; box-shadow:0 6px 20px rgba(0,0,0,.05); }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5">
    <h2 class="section-title mb-1"><i class="fas fa-magnifying-glass me-2"></i>{{ __('app.search.title') }}</h2>
    @if ($q !== '')
        <p class="text-muted mb-4">{!! __('app.search.results_for', ['count' => $total, 'q' => '<strong>'.e($q).'</strong>']) !!}</p>
    @else
        <p class="text-muted mb-4">{{ __('app.search.prompt') }}</p>
    @endif

    @if ($q !== '' && $total === 0)
        <div class="tg-empty">
            <i class="fas fa-magnifying-glass fa-2x text-muted mb-3"></i>
            <h5>{{ __('app.search.none_found') }}</h5>
            <p class="text-muted mb-0">{!! __('app.search.try_other', ['food' => '<a href="'.route('food.index').'">'.__('app.search.food_link').'</a>', 'skills' => '<a href="'.route('skills.index').'">'.__('app.search.skills_link').'</a>']) !!}</p>
        </div>
    @endif

    {{-- People --}}
    @if ($people->isNotEmpty())
        <h5 class="fw-bold mb-3"><i class="fas fa-user-group text-success me-2"></i>{{ __('app.search.people') }}</h5>
        <div class="row g-3 mb-5">
            @foreach ($people as $person)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('profile.show', $person) }}" class="text-decoration-none text-dark">
                        <div class="tg-person">
                            <div class="tg-person-av">
                                @if ($person->avatar)<img src="{{ asset('storage/'.$person->avatar) }}" alt="">@else{{ strtoupper(substr($person->name,0,1)) }}@endif
                            </div>
                            <div>
                                <div class="fw-bold">{{ $person->name }}
                                    @if ($person->profile?->is_verified)<i class="fas fa-circle-check text-success ms-1"></i>@endif
                                </div>
                                <small class="text-muted">⭐ {{ number_format($person->rating,1) }} · {{ $person->profile?->neighborhood ?? 'Busan' }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Food --}}
    @if ($food->isNotEmpty())
        <h5 class="fw-bold mb-3"><i class="fas fa-utensils text-warning me-2"></i>{{ __('app.search.food') }}</h5>
        <div class="row g-3 mb-5">
            @foreach ($food as $post)
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('food.show', $post) }}" class="text-decoration-none text-dark">
                        <div class="tg-card-post">
                            @if ($post->image)
                                <img src="{{ asset('storage/'.$post->image) }}" class="tg-card-img" alt="">
                            @else
                                <div class="tg-card-img-ph" style="background:linear-gradient(135deg,#ff8c42,#ff6f5e)"><i class="fas fa-utensils"></i></div>
                            @endif
                            <div class="p-3">
                                <span class="badge bg-warning mb-1">{{ __('app.food_types.'.$post->food_type) }}</span>
                                <h6 class="fw-bold mb-1">{{ $post->title }}</h6>
                                <small class="text-muted">{{ $post->user->name }} · {{ $post->neighborhood }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Skills --}}
    @if ($skills->isNotEmpty())
        <h5 class="fw-bold mb-3"><i class="fas fa-lightbulb text-success me-2"></i>{{ __('app.search.skills') }}</h5>
        <div class="row g-3">
            @foreach ($skills as $post)
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('skills.show', $post) }}" class="text-decoration-none text-dark">
                        <div class="tg-card-post">
                            @if ($post->image)
                                <img src="{{ asset('storage/'.$post->image) }}" class="tg-card-img" alt="">
                            @else
                                <div class="tg-card-img-ph" style="background:linear-gradient(135deg,#2d8f7f,#45b4a1)"><i class="fas fa-lightbulb"></i></div>
                            @endif
                            <div class="p-3">
                                <span class="badge bg-success mb-1">{{ __('app.skill_categories.'.$post->category) }}</span>
                                <h6 class="fw-bold mb-1">{{ $post->title }}</h6>
                                <small class="text-muted">{{ $post->user->name }} · {{ __('app.skill_levels.'.$post->skill_level) }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
