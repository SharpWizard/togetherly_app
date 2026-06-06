@extends('layouts.app')

@section('title', __('app.admin.reports_title'))

@section('extra_css')
<style>
    .tg-report { background:#fff; border-radius:14px; padding:18px; margin-bottom:12px; box-shadow:0 3px 12px rgba(0,0,0,.04); }
    .tg-status { font-size:.72rem; font-weight:700; padding:3px 10px; border-radius:20px; text-transform:capitalize; }
    .s-open { background:#fde2e0; color:#a33; } .s-dismissed { background:#eef1ec; color:#7a8884; } .s-actioned { background:#d8f0e9; color:#1c6b5b; }
    .tg-empty { background:#fff; border-radius:18px; padding:56px; text-align:center; box-shadow:0 6px 20px rgba(0,0,0,.05); }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5" style="max-width:900px;">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <h2 class="section-title mb-0"><i class="fas fa-flag me-2"></i>{{ __('app.admin.reports_title') }}</h2>
        <a href="{{ route('admin.index') }}" class="btn btn-light btn-sm"><i class="fas fa-arrow-left me-1"></i>{{ __('app.admin.back_to_dashboard') }}</a>
    </div>

    @forelse ($reports as $report)
        @php $post = $report->foodPost ?? $report->skillPost; $isFood = (bool) $report->foodPost; @endphp
        <div class="tg-report">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge {{ $isFood ? 'bg-warning' : 'bg-success' }}">{{ $isFood ? __('app.admin.badge_food') : __('app.admin.badge_skill') }}</span>
                        <strong>{{ $report->reason }}</strong>
                        <span class="tg-status s-{{ $report->status }}">{{ __('app.admin.status_'.$report->status) }}</span>
                    </div>
                    @if ($post)
                        <div class="mb-1">
                            {{ __('app.admin.post') }} <a href="{{ $isFood ? route('food.show', $post) : route('skills.show', $post) }}" target="_blank" class="fw-semibold text-decoration-none">{{ $post->title }}</a>
                            <span class="text-muted">{{ __('app.admin.by') }} {{ $post->user->name ?? '—' }}</span>
                        </div>
                    @else
                        <div class="text-muted mb-1"><em>{{ __('app.admin.post_removed') }}</em></div>
                    @endif
                    @if ($report->details)<div class="small text-muted"><i class="fas fa-quote-left me-1"></i>{{ $report->details }}</div>@endif
                    <small class="text-muted">{{ __('app.admin.reported_by') }} {{ $report->reporter->name ?? '—' }} · {{ $report->created_at->diffForHumans() }}</small>
                </div>
                @if ($report->status === 'open')
                    <div class="d-flex gap-2">
                        @if ($post)
                            <form action="{{ route('admin.reports.action', $report) }}" method="POST" onsubmit="return confirm('{{ __('app.admin.remove_post_confirm') }}')">@csrf
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash me-1"></i>{{ __('app.admin.remove_post') }}</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.reports.dismiss', $report) }}" method="POST">@csrf
                            <button class="btn btn-light btn-sm">{{ __('app.admin.dismiss') }}</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="tg-empty">
            <i class="fas fa-flag fa-2x text-muted mb-3"></i>
            <h5>{{ __('app.admin.no_reports') }}</h5>
            <p class="text-muted mb-0">{{ __('app.admin.no_reports_sub') }}</p>
        </div>
    @endforelse

    <div class="mt-4 d-flex justify-content-center">{{ $reports->links() }}</div>
</div>
@endsection
