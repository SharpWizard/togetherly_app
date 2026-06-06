@extends('layouts.app')

@section('title', $skillPost->title)

@section('extra_css')
<style>
    .tg-show-banner { height:200px; border-radius:18px; display:flex;align-items:center;justify-content:center;
        font-size:4rem; color:#fff; background:linear-gradient(135deg,#2d8f7f,#45b4a1); position:relative; overflow:hidden; }
    .tg-show-banner .cat { position:absolute; bottom:16px; left:16px; }
    .tg-poster { width:54px;height:54px;border-radius:50%; background:linear-gradient(135deg,var(--tg-green),var(--tg-light));
        color:#fff; display:flex;align-items:center;justify-content:center; font-size:1.4rem; font-weight:700; }
    .tg-book-row { background:#f7faf8; border:1px solid #e6efe9; border-radius:12px; padding:12px 14px; margin-bottom:8px; }
    .tg-status { font-size:.72rem; font-weight:700; padding:3px 10px; border-radius:20px; text-transform:capitalize; }
    .s-pending { background:#fff3cd; color:#b8860b; } .s-accepted { background:#d8f0e9; color:#1c6b5b; }
    .s-declined,.s-cancelled { background:#fde2e0; color:#a33; } .s-completed { background:#e3f3ee; color:#2d8f7f; }
</style>
@endsection

@section('content')
@php
    $isOwner = Auth::id() === $skillPost->user_id;
    $myBooking = \App\Models\Booking::where('skill_post_id',$skillPost->id)->where('user_id',Auth::id())->latest()->first();
    $bookings = $isOwner ? \App\Models\Booking::where('skill_post_id',$skillPost->id)->with('requester')->latest()->get() : collect();
@endphp
<div class="container my-4 my-lg-5">
    <a href="{{ route('skills.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="fas fa-arrow-left me-1"></i> {{ __('app.skills.back_to_skills') }}</a>
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
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <a href="{{ route('profile.show', $skillPost->user) }}" class="d-flex align-items-center gap-3 text-decoration-none">
                            <div class="tg-poster">{{ strtoupper(substr($skillPost->user->name,0,1)) }}</div>
                            <div>
                                <div class="fw-bold text-dark">{{ $skillPost->user->name }}</div>
                                <small class="text-muted">⭐ {{ number_format($skillPost->user->rating,1) }} ({{ $skillPost->user->total_ratings }} {{ __('app.dashboard.ratings') }})</small>
                            </div>
                        </a>
                        @if (!$isOwner)
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('messages.conversation', $skillPost->user_id) }}" class="btn btn-outline-primary"><i class="fas fa-envelope me-1"></i>{{ __('app.skills.message') }}</a>
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ratingModal"><i class="fas fa-star me-1"></i>{{ __('app.rate.rate') }}</button>
                                <button class="btn btn-link text-muted text-decoration-none btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal"><i class="fas fa-flag me-1"></i>{{ __('app.report.report') }}</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Owner: manage bookings --}}
            @if ($isOwner && $bookings->count())
                <div class="card mt-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-calendar-check me-2 text-success"></i>{{ __('app.skills.session_requests') }} ({{ $bookings->where('status','pending')->count() }} {{ __('app.skills.pending_count') }})</h6>
                        @foreach ($bookings as $booking)
                            <div class="tg-book-row d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div>
                                    <strong>{{ $booking->requester->name }}</strong>
                                    <span class="tg-status s-{{ $booking->status }} ms-1">{{ __('app.statuses.'.$booking->status) }}</span>
                                    @if ($booking->preferred_time)<div class="small text-muted"><i class="fas fa-clock me-1"></i>{{ $booking->preferred_time }}</div>@endif
                                    @if ($booking->message)<div class="small text-muted">{{ $booking->message }}</div>@endif
                                </div>
                                <div class="d-flex gap-2">
                                    @if ($booking->status === 'pending')
                                        <form action="{{ route('bookings.accept', $booking) }}" method="POST">@csrf<button class="btn btn-primary btn-sm">{{ __('app.skills.accept') }}</button></form>
                                        <form action="{{ route('bookings.decline', $booking) }}" method="POST">@csrf<button class="btn btn-light btn-sm">{{ __('app.skills.decline') }}</button></form>
                                    @elseif ($booking->status === 'accepted')
                                        <form action="{{ route('bookings.complete', $booking) }}" method="POST">@csrf<button class="btn btn-secondary btn-sm">{{ __('app.skills.mark_completed') }}</button></form>
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
                        <h6 class="fw-bold mb-3">{{ __('app.skills.manage_skill') }}</h6>
                        <a href="{{ route('skills.edit', $skillPost) }}" class="btn btn-secondary w-100 mb-2"><i class="fas fa-edit me-1"></i>{{ __('app.skills.edit_skill') }}</a>
                        <form action="{{ route('skills.destroy', $skillPost) }}" method="POST" onsubmit="return confirm('{{ __('app.skills.delete_confirm') }}')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-primary w-100"><i class="fas fa-trash me-1"></i>{{ __('app.common.delete') }}</button>
                        </form>
                    @else
                        @php $saved = \App\Models\Favorite::hasSkill($skillPost->id); @endphp
                        <form action="{{ route('favorites.skill', $skillPost) }}" method="POST" class="mb-3">@csrf
                            <button class="btn {{ $saved ? 'btn-secondary' : 'btn-outline-primary' }} w-100">
                                <i class="fas fa-heart me-1"></i>{{ $saved ? __('app.skills.saved') : __('app.skills.save_for_later') }}
                            </button>
                        </form>
                        <h6 class="fw-bold mb-2"><i class="fas fa-calendar-check text-success me-1"></i>{{ __('app.skills.book_session') }}</h6>
                        @if ($myBooking && in_array($myBooking->status, ['pending','accepted']))
                            <div class="alert alert-success small mb-2">
                                {{ __('app.skills.your_request_is') }} <strong>{{ __('app.statuses.'.$myBooking->status) }}</strong>.
                                @if ($myBooking->status==='accepted') {{ __('app.skills.finalize') }} @endif
                            </div>
                            <form action="{{ route('bookings.cancel', $myBooking) }}" method="POST">@csrf
                                <button class="btn btn-outline-primary w-100">{{ __('app.skills.cancel_request') }}</button>
                            </form>
                        @else
                            <p class="text-muted small">{{ __('app.skills.send_request_hint') }}</p>
                            <form action="{{ route('bookings.store', $skillPost) }}" method="POST">
                                @csrf
                                <input type="text" name="preferred_time" class="form-control mb-2" placeholder="{{ __('app.skills.preferred_time_placeholder') }}">
                                <textarea name="message" class="form-control mb-2" rows="2" placeholder="{{ __('app.skills.optional_message') }}"></textarea>
                                <button class="btn btn-primary w-100"><i class="fas fa-paper-plane me-1"></i>{{ __('app.skills.request_session') }}</button>
                            </form>
                        @endif
                    @endif

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

{{-- Rating modal --}}
@if (!$isOwner)
<div class="modal fade" id="ratingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:18px;">
            <form action="{{ route('ratings.store') }}" method="POST">@csrf
                <div class="modal-header border-0"><h5 class="modal-title">{{ __('app.rate.rate_user', ['name' => $skillPost->user->name]) }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <input type="hidden" name="rated_user_id" value="{{ $skillPost->user_id }}">
                    <input type="hidden" name="post_type" value="skill">
                    <input type="hidden" name="post_id" value="{{ $skillPost->id }}">
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
            <form action="{{ route('reports.skill', $skillPost) }}" method="POST">@csrf
                <div class="modal-header border-0"><h5 class="modal-title"><i class="fas fa-flag text-danger me-2"></i>{{ __('app.skills.report_skill') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <label class="form-label">{{ __('app.report.reason') }}</label>
                    <select class="form-select mb-3" name="reason" required>
                        <option value="">{{ __('app.report.select_reason') }}</option>
                        <option value="Spam or scam">{{ __('app.report.spam') }}</option>
                        <option value="Inappropriate content">{{ __('app.report.inappropriate') }}</option>
                        <option value="Misleading">{{ __('app.report.misleading') }}</option>
                        <option value="Not a real skill offer">{{ __('app.report.not_real') }}</option>
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
