@extends('layouts.app')

@section('title', $foodPost->title)

@section('extra_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css" />
<style>
    .gallery-main { position: relative; height: 400px; border-radius: 16px; overflow: hidden; background: #f0f3f0; }
    .gallery-main img { width: 100%; height: 100%; object-fit: cover; }
    .gallery-thumbs { display: flex; gap: 10px; margin-top: 12px; overflow-x: auto; padding-bottom: 8px; }
    .gallery-thumb { width: 80px; height: 80px; border-radius: 10px; overflow: hidden; cursor: pointer; border: 2px solid #e2e8e4; transition: all .2s; }
    .gallery-thumb.active { border-color: var(--tg-green); box-shadow: 0 0 0 2px rgba(45,143,127,.2); }
    .gallery-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .map-container { height: 300px; border-radius: 16px; overflow: hidden; margin: 20px 0; }
    .share-buttons { display: flex; gap: 10px; }
    .share-btn { padding: 10px 16px; border-radius: 8px; border: 1px solid #e2e8e4; background: #fff; cursor: pointer; transition: all .2s; display: inline-flex; align-items: center; gap: 6px; font-size: .9rem; font-weight: 600; }
    .share-btn:hover { background: #f0f3f0; border-color: var(--tg-green); color: var(--tg-green); }
    .user-card { background: linear-gradient(135deg,#ff8c42,#ff6f5e); color: #fff; border-radius: 16px; padding: 24px; margin-bottom: 20px; }
    .user-avatar { width: 60px; height: 60px; border-radius: 50%; background: rgba(255,255,255,.3); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 700; margin-bottom: 16px; }
    .user-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 16px; }
    .stat-item { background: rgba(255,255,255,.15); padding: 12px; border-radius: 10px; }
    .stat-label { font-size: .85rem; opacity: .9; }
    .stat-value { font-size: 1.3rem; font-weight: 700; }
    .recommendations { margin-top: 40px; padding-top: 40px; border-top: 2px solid #f0f3f0; }
    .rec-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-top: 20px; }
    .rec-card { background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04); transition: all .2s; cursor: pointer; }
    .rec-card:hover { transform: translateY(-4px); box-shadow: 0 8px 16px rgba(0,0,0,.1); }
    .rec-img { height: 140px; background: linear-gradient(135deg,#ff8c42,#ff6f5e); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 2rem; }
    .rec-img img { width: 100%; height: 100%; object-fit: cover; }
    .rec-body { padding: 12px; }
    .rec-title { font-weight: 700; font-size: .9rem; color: #16302d; margin-bottom: 6px; }
    .rec-meta { font-size: .8rem; color: #9aa6a0; }
</style>
@endsection

@section('content')
@php
    $isOwner = Auth::id() === $foodPost->user_id;
    $myClaim = \App\Models\Claim::where('food_post_id',$foodPost->id)->where('user_id',Auth::id())->latest()->first();
    $claims = $isOwner ? \App\Models\Claim::where('food_post_id',$foodPost->id)->with('claimer')->latest()->get() : collect();
@endphp

<div class="container my-4 my-lg-5">
    <a href="{{ route('food.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="fas fa-arrow-left me-1"></i>Back to Food</a>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Gallery -->
            <div class="gallery-main" id="mainImage">
                @if ($foodPost->image)
                    <img src="{{ asset('storage/'.$foodPost->image) }}" alt="{{ $foodPost->title }}" id="galleryImage">
                @else
                    <div style="display:flex;align-items:center;justify-content:center;height:100%;color:#fff;font-size:3rem;">
                        <i class="fas fa-utensils"></i>
                    </div>
                @endif
            </div>

            <!-- Thumbnails (if multiple images) -->
            @if ($foodPost->image)
            <div class="gallery-thumbs">
                <div class="gallery-thumb active" onclick="changeImage('{{ asset('storage/'.$foodPost->image) }}')">
                    <img src="{{ asset('storage/'.$foodPost->image) }}" alt="{{ $foodPost->title }}">
                </div>
            </div>
            @endif

            <!-- Share Buttons -->
            <div class="share-buttons mt-4 mb-4">
                <button class="share-btn" onclick="shareVia('whatsapp')"><i class="fab fa-whatsapp"></i>Share</button>
                <button class="share-btn" onclick="shareVia('email')"><i class="fas fa-envelope"></i>Email</button>
                <button class="share-btn" onclick="copyLink()"><i class="fas fa-link"></i>Copy Link</button>
            </div>

            <!-- Post Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h1 class="fw-bold mb-1">{{ $foodPost->title }}</h1>
                            <small class="text-muted"><i class="fas fa-clock me-1"></i>Posted {{ $foodPost->created_at->diffForHumans() }}</small>
                        </div>
                        <span class="badge bg-warning text-dark fs-6">{{ ucfirst($foodPost->status) }}</span>
                    </div>

                    <p class="text-muted">{{ $foodPost->description }}</p>

                    <div class="row g-3 my-4">
                        <div class="col-md-3">
                            <div class="card border-0 bg-light p-3 text-center">
                                <small class="text-muted">Type</small>
                                <div class="fw-bold">{{ ucfirst($foodPost->food_type) }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 bg-light p-3 text-center">
                                <small class="text-muted">Quantity</small>
                                <div class="fw-bold">{{ $foodPost->quantity }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 bg-light p-3 text-center">
                                <small class="text-muted">Expires</small>
                                <div class="fw-bold">{{ $foodPost->expires_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 bg-light p-3 text-center">
                                <small class="text-muted">Views</small>
                                <div class="fw-bold">{{ $foodPost->views }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Map -->
                    @if ($foodPost->latitude && $foodPost->longitude)
                    <h6 class="fw-bold mt-4 mb-3"><i class="fas fa-map-location-dot me-2"></i>Pickup Location</h6>
                    <div class="map-container" id="map"></div>
                    @endif
                </div>
            </div>

            <!-- Claims/Actions -->
            @if ($isOwner && $claims->count())
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-hand-holding-heart me-2"></i>Claim Requests</h6>
                        @foreach ($claims as $claim)
                            <div style="background:#f7faf8;border:1px solid #e6efe9;border-radius:10px;padding:12px;margin-bottom:10px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $claim->claimer->name }}</strong>
                                        <span class="badge ms-2" style="background:{{ $claim->status === 'pending' ? '#fff3cd' : '#d8f0e9' }};color:{{ $claim->status === 'pending' ? '#b8860b' : '#1c6b5b' }};">{{ ucfirst($claim->status) }}</span>
                                        @if ($claim->message)<div class="small text-muted mt-2">{{ $claim->message }}</div>@endif
                                    </div>
                                    <div class="d-flex gap-2">
                                        @if ($claim->status === 'pending')
                                            <form action="{{ route('claims.accept', $claim) }}" method="POST" style="display:inline;">@csrf<button class="btn btn-sm btn-success">Accept</button></form>
                                            <form action="{{ route('claims.decline', $claim) }}" method="POST" style="display:inline;">@csrf<button class="btn btn-sm btn-light">Decline</button></form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Recommendations -->
            <div class="recommendations">
                <h5 class="fw-bold mb-1"><i class="fas fa-sparkles me-2"></i>Similar Posts</h5>
                <p class="text-muted small">You might also like...</p>
                <div class="rec-grid">
                    @forelse ($recommendations ?? [] as $rec)
                        <a href="{{ route('food.show', $rec) }}" class="rec-card text-decoration-none">
                            <div class="rec-img">
                                @if ($rec->image)
                                    <img src="{{ asset('storage/'.$rec->image) }}" alt="{{ $rec->title }}">
                                @else
                                    <i class="fas fa-utensils"></i>
                                @endif
                            </div>
                            <div class="rec-body">
                                <div class="rec-title">{{ Str::limit($rec->title, 20) }}</div>
                                <div class="rec-meta">⭐ {{ number_format($rec->user->rating, 1) }} · {{ Str::limit($rec->neighborhood, 15) }}</div>
                            </div>
                        </a>
                    @empty
                        <p class="text-muted">No similar posts available</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- User Card -->
            <div class="user-card">
                <div class="user-avatar">{{ strtoupper(substr($foodPost->user->name, 0, 1)) }}</div>
                <h5 class="fw-bold mb-1">{{ $foodPost->user->name }}</h5>
                <small style="opacity:.9;">{{ $foodPost->user->profile?->neighborhood ?? 'Community Member' }}</small>

                <div class="user-stats">
                    <div class="stat-item">
                        <div class="stat-label">Rating</div>
                        <div class="stat-value">⭐ {{ number_format($foodPost->user->rating, 1) }}</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Reviews</div>
                        <div class="stat-value">{{ $foodPost->user->total_ratings }}</div>
                    </div>
                </div>
            </div>

            <!-- Action Card -->
            @auth
                @if (!$isOwner)
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            @if ($myClaim && in_array($myClaim->status, ['pending','accepted']))
                                <div class="alert alert-success small mb-3">
                                    ✓ Your claim is <strong>{{ ucfirst($myClaim->status) }}</strong>
                                </div>
                                <form action="{{ route('claims.cancel', $myClaim) }}" method="POST">@csrf
                                    <button class="btn btn-outline-primary w-100">Cancel Claim</button>
                                </form>
                            @else
                                <h6 class="fw-bold mb-3">Interested in this food?</h6>
                                <form action="{{ route('claims.store', $foodPost) }}" method="POST">
                                    @csrf
                                    <textarea name="message" class="form-control mb-3" rows="3" placeholder="Add a note (optional)"></textarea>
                                    <button class="btn btn-primary w-100"><i class="fas fa-hand-holding-heart me-2"></i>Request This Food</button>
                                </form>
                            @endif

                            <hr>

                            <form action="{{ route('favorites.food', $foodPost) }}" method="POST">@csrf
                                <button class="btn btn-outline-primary w-100"><i class="fas fa-heart me-2"></i>Save for Later</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">Manage Post</h6>
                            <a href="{{ route('food.edit', $foodPost) }}" class="btn btn-secondary w-100 mb-2"><i class="fas fa-edit me-2"></i>Edit</a>
                            <form action="{{ route('food.destroy', $foodPost) }}" method="POST" onsubmit="return confirm('Delete this post?');">@csrf @method('DELETE')
                                <button class="btn btn-outline-danger w-100"><i class="fas fa-trash me-2"></i>Delete</button>
                            </form>
                        </div>
                    </div>
                @endif
            @else
                <a href="{{ route('register') }}" class="btn btn-primary w-100 mb-2">Sign Up to Claim</a>
            @endauth
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.js"></script>
<script>
    function changeImage(src) {
        document.getElementById('galleryImage').src = src;
    }

    function shareVia(platform) {
        const url = window.location.href;
        const title = '{{ $foodPost->title }}';

        if (platform === 'whatsapp') {
            window.open(`https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`);
        } else if (platform === 'email') {
            window.open(`mailto:?subject=${encodeURIComponent(title)}&body=${encodeURIComponent(url)}`);
        }
    }

    function copyLink() {
        navigator.clipboard.writeText(window.location.href);
        alert('Link copied!');
    }

    @if ($foodPost->latitude && $foodPost->longitude)
    const map = L.map('map').setView([{{ $foodPost->latitude }}, {{ $foodPost->longitude }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    L.marker([{{ $foodPost->latitude }}, {{ $foodPost->longitude }}]).addTo(map).bindPopup('{{ $foodPost->title }}');
    @endif
</script>
@endsection
