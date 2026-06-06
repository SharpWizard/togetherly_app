@extends('layouts.app')

@section('title', __('app.claims.title'))

@section('extra_css')
<style>
    .tg-row { background:#fff; border-radius:14px; padding:18px; margin-bottom:12px; box-shadow:0 3px 12px rgba(0,0,0,.04); }
    .tg-status { font-size:.72rem; font-weight:700; padding:4px 12px; border-radius:20px; text-transform:capitalize; }
    .s-pending { background:#fff3cd; color:#b8860b; } .s-accepted { background:#d8f0e9; color:#1c6b5b; }
    .s-declined,.s-cancelled { background:#fde2e0; color:#a33; } .s-completed { background:#e3f3ee; color:#2d8f7f; }
    .tg-empty { background:#fff; border-radius:18px; padding:56px; text-align:center; box-shadow:0 6px 20px rgba(0,0,0,.05); }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5" style="max-width:820px;">
    <h2 class="section-title mb-4"><i class="fas fa-hand-holding-heart me-2"></i>{{ __('app.claims.heading') }}</h2>

    @forelse ($claims as $claim)
        <div class="tg-row d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h6 class="mb-0 fw-bold">{{ $claim->foodPost->title ?? __('app.claims.removed_post') }}</h6>
                    <span class="tg-status s-{{ $claim->status }}">{{ __('app.statuses.'.$claim->status) }}</span>
                </div>
                <small class="text-muted">{{ __('app.claims.from') }} {{ $claim->owner->name }} · {{ $claim->created_at->diffForHumans() }}</small>
                @if ($claim->message)<div class="small text-muted mt-1"><i class="fas fa-quote-left me-1"></i>{{ $claim->message }}</div>@endif
            </div>
            <div class="d-flex gap-2">
                @if ($claim->foodPost)
                    <a href="{{ route('food.show', $claim->foodPost) }}" class="btn btn-light btn-sm">{{ __('app.common.view') }}</a>
                @endif
                @if (in_array($claim->status, ['pending','accepted']))
                    <form action="{{ route('claims.cancel', $claim) }}" method="POST">@csrf
                        <button class="btn btn-outline-primary btn-sm">{{ __('app.common.cancel') }}</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="tg-empty">
            <i class="fas fa-hand-holding-heart fa-2x text-muted mb-3"></i>
            <h5>{{ __('app.claims.none_title') }}</h5>
            <p class="text-muted mb-3">{{ __('app.claims.none_sub') }}</p>
            <a href="{{ route('food.index') }}" class="btn btn-primary">{{ __('app.claims.browse_food') }}</a>
        </div>
    @endforelse

    <div class="mt-4 d-flex justify-content-center">{{ $claims->links() }}</div>
</div>
@endsection
