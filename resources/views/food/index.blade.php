@extends('layouts.app')

@section('title', 'Food Posts')

@section('extra_css')
<style>
    .tg-page-head { background: linear-gradient(135deg,#ff8c42,#ff6f5e); color:#fff; border-radius:22px;
        padding:32px 36px; position:relative; overflow:hidden; }
    .tg-page-head::after { content:""; position:absolute; width:200px;height:200px;border-radius:50%;
        background:rgba(255,255,255,.15); top:-60px; right:-30px; }
    .tg-page-head .inner { position:relative; z-index:1; }
    .tg-card-post { background:#fff; border-radius:18px; overflow:hidden; height:100%; box-shadow:0 6px 20px rgba(0,0,0,.06);
        transition:transform .25s, box-shadow .25s; }
    .tg-card-post:hover { transform:translateY(-6px); box-shadow:0 16px 36px rgba(0,0,0,.12); }
    .tg-card-img { height:200px; object-fit:cover; width:100%; }
    .tg-card-img-ph { height:200px; display:flex;align-items:center;justify-content:center; font-size:3rem; color:#fff;
        background:linear-gradient(135deg,#ff8c42,#ff6f5e); }
    .tg-mini-avatar { width:32px;height:32px;border-radius:50%; background:linear-gradient(135deg,var(--tg-orange),var(--tg-coral));
        color:#fff; display:inline-flex;align-items:center;justify-content:center; font-size:.85rem; font-weight:700; }
    .tg-empty { background:#fff; border-radius:18px; padding:56px; text-align:center; box-shadow:0 6px 20px rgba(0,0,0,.05); }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5">
    <div class="tg-page-head mb-4">
        <div class="inner d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h1 class="fw-bold mb-1"><i class="fas fa-utensils me-2"></i>Food Near You</h1>
                <p class="mb-0" style="opacity:.9;"><i class="fas fa-location-dot me-1"></i>{{ Auth::user()->profile?->neighborhood ?? 'Not set' }} · {{ $foodPosts->total() }} available</p>
            </div>
            <a href="{{ route('food.create') }}" class="btn btn-light fw-semibold" style="border-radius:12px;"><i class="fas fa-plus me-1"></i> Share Food</a>
        </div>
    </div>

    {{-- Search & filters --}}
    <form method="GET" action="{{ route('food.index') }}" class="card border-0 p-3 mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0" placeholder="Search food…">
                </div>
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select">
                    <option value="">All types</option>
                    @foreach (['cooked'=>'Cooked Meal','raw'=>'Raw Ingredients','bakery'=>'Bakery','drinks'=>'Drinks','desserts'=>'Desserts','leftovers'=>'Leftovers','other'=>'Other'] as $val=>$lbl)
                        <option value="{{ $val }}" {{ request('type')===$val?'selected':'' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="sort" class="form-select">
                    <option value="latest" {{ request('sort')!=='expiring'?'selected':'' }}>Newest</option>
                    <option value="expiring" {{ request('sort')==='expiring'?'selected':'' }}>Expiring soon</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-primary"><i class="fas fa-filter me-1"></i>Filter</button>
            </div>
        </div>
        @if (request('q') || request('type') || request('sort'))
            <div class="mt-2"><a href="{{ route('food.index') }}" class="small text-decoration-none text-muted"><i class="fas fa-xmark me-1"></i>Clear filters</a></div>
        @endif
    </form>

    @if ($foodPosts->isEmpty())
        <div class="tg-empty">
            <i class="fas fa-utensils fa-2x text-warning mb-3"></i>
            <h5>No food posts found</h5>
            <p class="text-muted">Be the first to share surplus food with your neighborhood!</p>
            <a href="{{ route('food.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i> Share Food</a>
        </div>
    @else
        <div class="row g-4">
            @foreach ($foodPosts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="tg-card-post">
                        <div class="position-relative">
                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" class="tg-card-img" alt="{{ $post->title }}">
                            @else
                                <div class="tg-card-img-ph"><i class="fas fa-utensils"></i></div>
                            @endif
                            <span class="badge bg-warning position-absolute" style="top:14px;left:14px;">{{ $post->food_type }}</span>
                        </div>
                        <div class="p-3">
                            <h6 class="fw-bold mb-2">{{ $post->title }}</h6>
                            <p class="text-muted small mb-3">{{ Str::limit($post->description, 75) }}</p>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="tg-mini-avatar">{{ strtoupper(substr($post->user->name,0,1)) }}</span>
                                <small class="text-muted">{{ $post->user->name }} · ⭐ {{ number_format($post->user->rating,1) }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 small text-muted">
                                <span><i class="fas fa-box me-1"></i>Qty: {{ $post->quantity }}</span>
                                <span><i class="fas fa-clock me-1"></i>{{ $post->expires_at->diffForHumans() }}</span>
                            </div>
                            <a href="{{ route('food.show', $post) }}" class="btn btn-primary w-100"><i class="fas fa-circle-info me-1"></i> View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">{{ $foodPosts->links() }}</div>
    @endif
</div>
@endsection
