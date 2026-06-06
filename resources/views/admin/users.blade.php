@extends('layouts.app')

@section('title', __('app.admin.users_title'))

@section('extra_css')
<style>
    .tg-panel { background:#fff; border-radius:16px; box-shadow:0 4px 16px rgba(0,0,0,.05); overflow:hidden; }
    .tg-user-row { display:flex; align-items:center; gap:14px; padding:14px 20px; border-bottom:1px solid #f0f3f0; }
    .tg-user-row:last-child { border-bottom:none; }
    .tg-ua { width:42px;height:42px;border-radius:50%; background:linear-gradient(135deg,var(--tg-orange),var(--tg-coral));
        color:#fff; display:flex;align-items:center;justify-content:center; font-weight:700; flex:0 0 42px; }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <h2 class="section-title mb-0"><i class="fas fa-users me-2"></i>{{ __('app.admin.users_title') }}</h2>
        <a href="{{ route('admin.index') }}" class="btn btn-light btn-sm"><i class="fas fa-arrow-left me-1"></i>{{ __('app.admin.back_to_dashboard') }}</a>
    </div>

    <form method="GET" class="card border-0 p-3 mb-4">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0" placeholder="{{ __('app.admin.search_users') }}">
            <button class="btn btn-primary">{{ __('app.admin.search') }}</button>
        </div>
    </form>

    <div class="tg-panel">
        @foreach ($users as $u)
            <div class="tg-user-row">
                @if ($u->avatar)
                    <img src="{{ asset('storage/'.$u->avatar) }}" class="tg-ua" style="object-fit:cover;" alt="">
                @else
                    <div class="tg-ua">{{ strtoupper(substr($u->name,0,1)) }}</div>
                @endif
                <div class="flex-grow-1">
                    <div class="fw-bold">
                        {{ $u->name }}
                        @if ($u->profile?->is_verified)<i class="fas fa-circle-check text-success ms-1" title="{{ __('app.admin.verified') }}"></i>@endif
                        @if ($u->is_admin)<span class="badge bg-primary ms-1">{{ __('app.admin.admin_badge') }}</span>@endif
                        @if ($u->profile && $u->profile->account_type !== 'individual')<span class="badge bg-info ms-1">{{ __('app.profile.'.$u->profile->account_type) }}</span>@endif
                    </div>
                    <div class="small text-muted">{{ $u->email }} · {{ $u->profile?->neighborhood ?? '—' }} · ⭐ {{ number_format($u->rating,1) }}</div>
                </div>
                <div class="d-flex gap-2">
                    <form action="{{ route('admin.users.verify', $u) }}" method="POST">@csrf
                        <button class="btn btn-sm {{ $u->profile?->is_verified ? 'btn-secondary' : 'btn-outline-primary' }}">
                            <i class="fas fa-circle-check me-1"></i>{{ $u->profile?->is_verified ? __('app.admin.unverify') : __('app.admin.verify') }}
                        </button>
                    </form>
                    <form action="{{ route('admin.users.admin', $u) }}" method="POST">@csrf
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-shield-halved me-1"></i>{{ $u->is_admin ? __('app.admin.revoke') : __('app.admin.make_admin') }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">{{ $users->links() }}</div>
</div>
@endsection
