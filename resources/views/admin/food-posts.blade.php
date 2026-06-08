@extends('layouts.app')

@section('title', 'Food Posts Management')

@section('extra_css')
<style>
    .tg-panel { background:#fff; border-radius:16px; box-shadow:0 4px 16px rgba(0,0,0,.05); overflow:hidden; }
    .tg-post-row { display:flex; gap:14px; padding:16px 20px; border-bottom:1px solid #f0f3f0; align-items:flex-start; }
    .tg-post-row:last-child { border-bottom:none; }
    .tg-post-img { width:60px;height:60px;border-radius:12px;object-fit:cover;background:linear-gradient(135deg,#ff8c42,#ff6f5e);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;flex:0 0 60px; }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <h2 class="section-title mb-0"><i class="fas fa-utensils me-2"></i>Food Posts Management</h2>
        <a href="{{ route('admin.index') }}" class="btn btn-light btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
    </div>

    <div class="card border-0 p-3 mb-4">
        <form method="GET" class="row g-2">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0" placeholder="Search by title or description">
                </div>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="claimed" {{ request('status') === 'claimed' ? 'selected' : '' }}>Claimed</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Search</button>
            </div>
        </form>
    </div>

    <div class="tg-panel">
        @forelse ($foodPosts as $post)
            <div class="tg-post-row">
                @if ($post->image)
                    <img src="{{ asset('storage/'.$post->image) }}" class="tg-post-img" alt="{{ $post->title }}">
                @else
                    <div class="tg-post-img"><i class="fas fa-utensils"></i></div>
                @endif
                <div class="flex-grow-1">
                    <div class="fw-bold">{{ $post->title }}</div>
                    <div class="small text-muted mb-2">
                        by <strong>{{ $post->user->name }}</strong> · {{ $post->neighborhood }} ·
                        <span class="badge bg-warning text-dark">{{ $post->status }}</span>
                    </div>
                    <div class="text-muted small" style="max-height:40px;overflow:hidden;">{{ $post->description }}</div>
                    <div class="mt-2 small text-muted">
                        <i class="fas fa-eye me-1"></i>{{ $post->views }} views ·
                        <i class="fas fa-clock me-1"></i>{{ $post->created_at->diffForHumans() }}
                    </div>
                </div>
                <div class="d-flex gap-1 flex-column">
                    <a href="{{ route('food.public-show', $post) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="fas fa-eye"></i>
                    </a>
                    <form action="{{ route('admin.food.delete', $post) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this post?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger w-100">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <i class="fas fa-inbox" style="font-size:3rem;opacity:.3;"></i>
                <p class="mt-3">No food posts found</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">{{ $foodPosts->links() }}</div>
</div>
@endsection
