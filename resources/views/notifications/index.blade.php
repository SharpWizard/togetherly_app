@extends('layouts.app')

@section('title', __('app.notifications.title'))

@section('extra_css')
<style>
    .tg-note { background:#fff; border-radius:14px; padding:16px 18px; margin-bottom:10px; display:flex; gap:14px;
        align-items:flex-start; box-shadow:0 3px 12px rgba(0,0,0,.04); }
    .tg-note .ic { width:44px;height:44px;border-radius:12px; flex:0 0 44px; display:flex;align-items:center;justify-content:center;
        font-size:1.1rem; color:#fff; background:linear-gradient(135deg,var(--tg-green),var(--tg-light)); }
    .tg-empty { background:#fff; border-radius:18px; padding:56px; text-align:center; box-shadow:0 6px 20px rgba(0,0,0,.05); }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5" style="max-width:760px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0"><i class="fas fa-bell me-2"></i>{{ __('app.notifications.title') }}</h2>
        <form action="{{ route('notifications.read-all') }}" method="POST">@csrf
            <button class="btn btn-outline-primary btn-sm">{{ __('app.notifications.mark_all_read') }}</button>
        </form>
    </div>

    @forelse ($notifications as $note)
        <div class="tg-note">
            <div class="ic"><i class="fas {{ $note->icon }}"></i></div>
            <div class="flex-grow-1">
                <div class="fw-semibold">{{ $note->title }}</div>
                @if ($note->body)<div class="text-muted small">{{ $note->body }}</div>@endif
                <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
            </div>
            @if ($note->link)
                <a href="{{ $note->link }}" class="btn btn-light btn-sm align-self-center">{{ __('app.notifications.open') }}</a>
            @endif
        </div>
    @empty
        <div class="tg-empty">
            <i class="fas fa-bell-slash fa-2x text-muted mb-3"></i>
            <h5>{{ __('app.notifications.none_title') }}</h5>
            <p class="text-muted mb-0">{{ __('app.notifications.none_sub') }}</p>
        </div>
    @endforelse

    <div class="mt-4 d-flex justify-content-center">{{ $notifications->links() }}</div>
</div>
@endsection
