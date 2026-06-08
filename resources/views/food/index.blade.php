@extends('layouts.app')

@section('title', 'Food Posts')

@section('extra_css')
<style>
    .food-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; margin-top: 30px; }
    .food-card { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06); transition: all .3s; border: 1px solid #f0f3f0; }
    .food-card:hover { transform: translateY(-6px); box-shadow: 0 12px 24px rgba(0,0,0,0.12); }
    .food-card-img { position: relative; height: 180px; overflow: hidden; background: linear-gradient(135deg,#ff8c42,#ff6f5e); }
    .food-card-img img { width: 100%; height: 100%; object-fit: cover; }
    .food-card-badge { position: absolute; top: 8px; right: 8px; background: #fff; padding: 4px 12px; border-radius: 20px; font-size: .75rem; font-weight: 700; color: #ff8c42; }
    .food-card-body { padding: 14px; }
    .food-card-header { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
    .food-card-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg,#ff8c42,#ff6f5e); display: flex; align-items: center; justify-content: center; color: #fff; font-size: .85rem; font-weight: 700; }
    .food-card-user { flex: 1; }
    .food-card-name { font-size: .85rem; font-weight: 600; color: #2b3a36; }
    .food-card-rating { font-size: .75rem; color: #9aa6a0; }
    .food-card-title { font-weight: 700; color: #16302d; margin-bottom: 4px; font-size: .95rem; }
    .food-card-desc { font-size: .8rem; color: #6b7770; margin-bottom: 10px; line-height: 1.4; }
    .food-card-stats { display: flex; justify-content: space-between; font-size: .75rem; color: #9aa6a0; margin-bottom: 10px; }
    .food-card-footer { display: flex; gap: 6px; }
    .food-card-btn { flex: 1; padding: 6px 10px; border: none; border-radius: 8px; font-size: .8rem; font-weight: 600; cursor: pointer; transition: all .2s; text-align: center; }
    .food-card-save { background: #f0f3f0; color: #ff8c42; }
    .food-card-save:hover { background: #ff8c42; color: #fff; }
    .food-card-claim { background: linear-gradient(135deg,#ff8c42,#ff6f5e); color: #fff; }
    .food-card-claim:hover { opacity: .9; }
    .filter-section { background: #fff; border-radius: 16px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
    .filter-row { display: flex; gap: 12px; flex-wrap: wrap; }
    .filter-group { flex: 1; min-width: 150px; }
    .filter-label { font-size: .85rem; font-weight: 600; color: #3c4a45; margin-bottom: 6px; display: block; }
    .filter-input { width: 100%; padding: 8px 12px; border: 1px solid #e2e8e4; border-radius: 8px; font-size: .9rem; }
    .filter-input:focus { border-color: var(--tg-green); outline: none; box-shadow: 0 0 0 3px rgba(45,143,127,.1); }
    .btn-search { background: linear-gradient(135deg,var(--tg-green),var(--tg-light)); color: #fff; padding: 8px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all .2s; }
    .btn-search:hover { opacity: .9; }
    .expiry-warning { position: absolute; top: 8px; left: 8px; background: #ff6f5e; color: #fff; padding: 4px 10px; border-radius: 6px; font-size: .7rem; font-weight: 700; }
</style>
@endsection

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-1"><i class="fas fa-utensils me-2"></i>Food Posts</h2>
            <p class="text-muted">{{ $foodPosts->total() }} available in {{ Auth::user()->profile?->neighborhood ?? 'your area' }}</p>
        </div>
        <a href="{{ route('food.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Share Food</a>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <form method="GET" class="filter-row">
            <div class="filter-group flex-grow-1">
                <label class="filter-label">Search</label>
                <input type="text" name="q" class="filter-input" placeholder="Search by title..." value="{{ request('q') }}">
            </div>
            <div class="filter-group" style="min-width: 140px;">
                <label class="filter-label">Food Type</label>
                <select name="type" class="filter-input">
                    <option value="">All Types</option>
                    <option value="cooked" {{ request('type') === 'cooked' ? 'selected' : '' }}>Cooked</option>
                    <option value="raw" {{ request('type') === 'raw' ? 'selected' : '' }}>Vegetables</option>
                    <option value="bakery" {{ request('type') === 'bakery' ? 'selected' : '' }}>Bakery</option>
                    <option value="drinks" {{ request('type') === 'drinks' ? 'selected' : '' }}>Drinks</option>
                    <option value="other" {{ request('type') === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="filter-group" style="min-width: 140px;">
                <label class="filter-label">Sort By</label>
                <select name="sort" class="filter-input">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="expiring" {{ request('sort') === 'expiring' ? 'selected' : '' }}>Expiring Soon</option>
                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                </select>
            </div>
            <div class="filter-group" style="min-width: 140px;">
                <label class="filter-label">Rating</label>
                <select name="rating" class="filter-input">
                    <option value="">All Users</option>
                    <option value="4.5" {{ request('rating') === '4.5' ? 'selected' : '' }}>⭐ 4.5+</option>
                    <option value="4.0" {{ request('rating') === '4.0' ? 'selected' : '' }}>⭐ 4.0+</option>
                </select>
            </div>
            <div class="filter-group d-flex align-items-flex-end">
                <button type="submit" class="btn-search w-100">Search</button>
            </div>
        </form>
    </div>

    <!-- Posts Grid -->
    <div class="food-grid">
        @forelse ($foodPosts as $post)
        <div class="food-card">
            <!-- Image -->
            <div class="food-card-img">
                @if ($post->image)
                    <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}">
                @else
                    <div style="display:flex;align-items:center;justify-content:center;height:100%;color:#fff;font-size:3rem;">
                        <i class="fas fa-utensils"></i>
                    </div>
                @endif
                <span class="food-card-badge">{{ ucfirst($post->food_type) }}</span>
                @if ($post->expires_at->diffInHours(now()) < 24)
                    <span class="expiry-warning">⏰ Expiring soon!</span>
                @endif
            </div>

            <!-- Body -->
            <div class="food-card-body">
                <!-- User Info -->
                <div class="food-card-header">
                    <div class="food-card-avatar">{{ strtoupper(substr($post->user->name, 0, 1)) }}</div>
                    <div class="food-card-user">
                        <div class="food-card-name">{{ Str::limit($post->user->name, 15) }}</div>
                        <div class="food-card-rating">⭐ {{ number_format($post->user->rating, 1) }}</div>
                    </div>
                </div>

                <!-- Post Info -->
                <div class="food-card-title">{{ Str::limit($post->title, 25) }}</div>
                <div class="food-card-desc">{{ Str::limit($post->description, 60) }}</div>

                <!-- Stats -->
                <div class="food-card-stats">
                    <span><i class="fas fa-eye me-1"></i>{{ $post->views }}</span>
                    <span><i class="fas fa-hourglass-end me-1"></i>{{ $post->expires_at->diffForHumans() }}</span>
                </div>

                <!-- Actions -->
                <div class="food-card-footer">
                    <form action="{{ route('favorites.food', $post) }}" method="POST" style="flex:1;">
                        @csrf
                        <button type="submit" class="food-card-btn food-card-save w-100">
                            <i class="fas fa-heart"></i>
                        </button>
                    </form>
                    <a href="{{ route('food.show', $post) }}" class="food-card-btn food-card-claim" style="text-decoration:none;">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
            <i class="fas fa-inbox" style="font-size: 3rem; opacity: .2;"></i>
            <p class="text-muted mt-3">No food posts available</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-5 d-flex justify-content-center">{{ $foodPosts->links() }}</div>
</div>
@endsection
