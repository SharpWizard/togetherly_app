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
    .tg-claim-row { background:#f7faf8; border:1px solid #e6efe9; border-radius:12px; padding:12px 14px; margin-bottom:8px; }
    .tg-status { font-size:.72rem; font-weight:700; padding:3px 10px; border-radius:20px; text-transform:capitalize; }
    .s-pending { background:#fff3cd; color:#b8860b; } .s-accepted { background:#d8f0e9; color:#1c6b5b; }
    .s-declined,.s-cancelled { background:#fde2e0; color:#a33; } .s-completed { background:#e3f3ee; color:#2d8f7f; }
</style>
@endsection

@section('content')
@php
    $isOwner = Auth::id() === $foodPost->user_id;
    $myClaim = \App\Models\Claim::where('food_post_id',$foodPost->id)->where('user_id',Auth::id())->latest()->first();
    $claims = $isOwner ? \App\Models\Claim::where('food_post_id',$foodPost->id)->with('claimer')->latest()->get() : collect();
@endphp
<div class="container my-4 my-lg-5">
    <a href="{{ route('food.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="fas fa-arrow-left me-1"></i> {{ __('app.food.back_to_food') }}</a>
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
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <a href="{{ route('profile.show', $foodPost->user) }}" class="d-flex align-items-center gap-3 text-decoration-none">
                            <div class="tg-poster">{{ strtoupper(substr($foodPost->user->name,0,1)) }}</div>
                            <div>
                                <div class="fw-bold text-dark">{{ $foodPost->user->name }}</div>
                                <small class="text-muted">⭐ {{ number_format($foodPost->user->rating,1) }} ({{ $foodPost->user->total_ratings }} {{ __('app.dashboard.ratings') }})</small>
                            </div>
                        </a>
                        @if (!$isOwner)
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('messages.conversation', $foodPost->user_id) }}" class="btn btn-outline-primary"><i class="fas fa-envelope me-1"></i>{{ __('app.food.message') }}</a>
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ratingModal"><i class="fas fa-star me-1"></i>{{ __('app.rate.rate') }}</button>
                                <button class="btn btn-link text-muted text-decoration-none btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal"><i class="fas fa-flag me-1"></i>{{ __('app.report.report') }}</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Owner: manage claims --}}
            @if ($isOwner && $claims->count())
                <div class="card mt-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-hand-holding-heart me-2 text-warning"></i>{{ __('app.food.claim_requests') }} ({{ $claims->where('status','pending')->count() }} {{ __('app.food.pending_count') }})</h6>
                        @foreach ($claims as $claim)
                            <div class="tg-claim-row d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div>
                                    <strong>{{ $claim->claimer->name }}</strong>
                                    <span class="tg-status s-{{ $claim->status }} ms-1">{{ __('app.statuses.'.$claim->status) }}</span>
                                    @if ($claim->message)<div class="small text-muted">{{ $claim->message }}</div>@endif
                                </div>
                                <div class="d-flex gap-2">
                                    @if ($claim->status === 'pending')
                                        <form action="{{ route('claims.accept', $claim) }}" method="POST">@csrf<button class="btn btn-primary btn-sm">{{ __('app.food.accept') }}</button></form>
                                        <form action="{{ route('claims.decline', $claim) }}" method="POST">@csrf<button class="btn btn-light btn-sm">{{ __('app.food.decline') }}</button></form>
                                    @elseif ($claim->status === 'accepted')
                                        <form action="{{ route('claims.complete', $claim) }}" method="POST">@csrf<button class="btn btn-secondary btn-sm">{{ __('app.food.mark_completed') }}</button></form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="card sticky-top" style="top:90px;">
                <div class="card-body p-4">
                    @if ($isOwner)
                        <h6 class="fw-bold mb-3">{{ __('app.food.manage_post') }}</h6>
                        <a href="{{ route('food.edit', $foodPost) }}" class="btn btn-secondary w-100 mb-2"><i class="fas fa-edit me-1"></i>{{ __('app.food.edit_post') }}</a>
                        <form action="{{ route('food.destroy', $foodPost) }}" method="POST" onsubmit="return confirm('{{ __('app.food.delete_confirm') }}')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-primary w-100"><i class="fas fa-trash me-1"></i>{{ __('app.common.delete') }}</button>
                        </form>
                    @else
                        @php $saved = \App\Models\Favorite::hasFood($foodPost->id); @endphp
                        <form action="{{ route('favorites.food', $foodPost) }}" method="POST" class="mb-3">@csrf
                            <button class="btn {{ $saved ? 'btn-secondary' : 'btn-outline-primary' }} w-100">
                                <i class="fas fa-heart me-1"></i>{{ $saved ? __('app.food.saved') : __('app.food.save_for_later') }}
                            </button>
                        </form>
                        <h6 class="fw-bold mb-2"><i class="fas fa-hand-holding-heart text-warning me-1"></i>{{ __('app.food.claim_this') }}</h6>
                        @if ($myClaim && in_array($myClaim->status, ['pending','accepted']))
                            <div class="alert alert-success small mb-2">
                                {{ __('app.food.your_claim_is') }} <strong>{{ __('app.statuses.'.$myClaim->status) }}</strong>.
                                @if ($myClaim->status==='accepted') {{ __('app.food.arrange_pickup') }} @endif
                            </div>
                            <form action="{{ route('claims.cancel', $myClaim) }}" method="POST">@csrf
                                <button class="btn btn-outline-primary w-100">{{ __('app.food.cancel_claim') }}</button>
                            </form>
                        @elseif ($foodPost->status !== 'available')
                            <div class="alert alert-info small mb-0">{{ __('app.food.no_longer_available') }}</div>
                        @else
                            <p class="text-muted small">{{ __('app.food.request_pickup') }}</p>
                            <form action="{{ route('claims.store', $foodPost) }}" method="POST">
                                @csrf
                                <textarea name="message" class="form-control mb-2" rows="2" placeholder="{{ __('app.food.claim_note_placeholder') }}"></textarea>
                                <button class="btn btn-primary w-100"><i class="fas fa-hand-holding-heart me-1"></i>{{ __('app.food.claim_food') }}</button>
                            </form>
                        @endif
                    @endif

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

{{-- Rating modal --}}
@if (!$isOwner)
<div class="modal fade" id="ratingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:18px;">
            <form action="{{ route('ratings.store') }}" method="POST">@csrf
                <div class="modal-header border-0"><h5 class="modal-title">{{ __('app.rate.rate_user', ['name' => $foodPost->user->name]) }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <input type="hidden" name="rated_user_id" value="{{ $foodPost->user_id }}">
                    <input type="hidden" name="post_type" value="food">
                    <input type="hidden" name="post_id" value="{{ $foodPost->id }}">
                    <label class="form-label">{{ __('app.rate.rating') }}</label>
                    <select class="form-select mb-3" name="rating" required>
                        <option value="5">★★★★★ {{ __('app.rate.excellent') }}</option>
                        <option value="4">★★★★ {{ __('app.rate.good') }}</option>
                        <option value="3">★★★ {{ __('app.rate.average') }}</option>
                        <option value="2">★★ {{ __('app.rate.poor') }}</option>
                        <option value="1">★ {{ __('app.rate.very_poor') }}</option>
                    </select>
                    <label class="form-label">{{ __('app.rate.comment_optional') }}</label>
                    <textarea class="form-control" name="comment" rows="3"></textarea>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('app.common.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('app.rate.submit_rating') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Report modal --}}
<div class="modal fade" id="reportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:18px;">
            <form action="{{ route('reports.food', $foodPost) }}" method="POST">@csrf
                <div class="modal-header border-0"><h5 class="modal-title"><i class="fas fa-flag text-danger me-2"></i>{{ __('app.report.report_post') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <label class="form-label">{{ __('app.report.reason') }}</label>
                    <select class="form-select mb-3" name="reason" required>
                        <option value="">{{ __('app.report.select_reason') }}</option>
                        <option value="Spam or scam">{{ __('app.report.spam') }}</option>
                        <option value="Inappropriate content">{{ __('app.report.inappropriate') }}</option>
                        <option value="Unsafe / spoiled food">{{ __('app.report.unsafe') }}</option>
                        <option value="Misleading">{{ __('app.report.misleading') }}</option>
                        <option value="Other">{{ __('app.report.other') }}</option>
                    </select>
                    <label class="form-label">{{ __('app.report.details_optional') }}</label>
                    <textarea class="form-control" name="details" rows="3" placeholder="{{ __('app.report.details_placeholder') }}"></textarea>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('app.common.cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('app.report.submit_report') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
