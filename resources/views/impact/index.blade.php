@extends('layouts.app')

@section('title', 'Community Impact')

@section('extra_css')
<style>
    .tg-impact-hero { background:linear-gradient(135deg,#16302d,#2d8f7f); color:#fff; border-radius:22px;
        padding:44px; text-align:center; position:relative; overflow:hidden; }
    .tg-impact-hero::after { content:""; position:absolute; width:240px;height:240px;border-radius:50%;
        background:rgba(127,224,205,.15); top:-80px; right:-50px; }
    .tg-impact-hero .inner { position:relative; z-index:1; }
    .tg-big { background:#fff; border-radius:18px; padding:28px; text-align:center; box-shadow:0 6px 20px rgba(0,0,0,.06); height:100%; }
    .tg-big .ic { width:56px;height:56px;border-radius:16px; margin:0 auto 14px; display:flex;align-items:center;justify-content:center;
        font-size:1.5rem; color:#fff; }
    .tg-big .v { font-size:2rem; font-weight:800; color:var(--tg-dark); line-height:1; }
    .tg-big .l { color:#7a8884; font-size:.88rem; margin-top:6px; }
    .tg-lead { background:#fff; border-radius:18px; box-shadow:0 6px 20px rgba(0,0,0,.06); overflow:hidden; }
    .tg-lead .row-item { display:flex; align-items:center; gap:14px; padding:14px 20px; border-bottom:1px solid #f0f3f0; }
    .tg-lead .row-item:last-child { border-bottom:none; }
    .tg-rank { width:34px;height:34px;border-radius:50%; display:flex;align-items:center;justify-content:center; font-weight:800; flex:0 0 34px; }
    .tg-rank.r1 { background:linear-gradient(135deg,#ffd700,#ffb300); color:#fff; }
    .tg-rank.r2 { background:linear-gradient(135deg,#c0c0c0,#9e9e9e); color:#fff; }
    .tg-rank.r3 { background:linear-gradient(135deg,#cd7f32,#b06a28); color:#fff; }
    .tg-rank.rn { background:#eef1ec; color:#7a8884; }
    .tg-lead-avatar { width:42px;height:42px;border-radius:50%; background:linear-gradient(135deg,var(--tg-green),var(--tg-light));
        color:#fff; display:flex;align-items:center;justify-content:center; font-weight:700; }
</style>
@endsection

@section('content')
<div class="container my-4 my-lg-5">
    <div class="tg-impact-hero mb-4">
        <div class="inner">
            <span class="badge bg-light text-success mb-2">Why It Matters</span>
            <h1 class="fw-bold">Our Community Impact</h1>
            <p class="mb-0" style="opacity:.9;">Together we're cutting waste, sharing knowledge, and building a warmer community.</p>
        </div>
    </div>

    {{-- Headline impact --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="tg-big">
                <div class="ic" style="background:linear-gradient(135deg,#2d8f7f,#45b4a1)"><i class="fas fa-bowl-food"></i></div>
                <div class="v">{{ number_format($stats['mealsSaved']) }}</div>
                <div class="l">Meals rescued from waste</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tg-big">
                <div class="ic" style="background:linear-gradient(135deg,#56ab7b,#7fe0cd)"><i class="fas fa-leaf"></i></div>
                <div class="v">{{ number_format($stats['co2Saved'], 1) }} kg</div>
                <div class="l">Estimated CO₂e avoided</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tg-big">
                <div class="ic" style="background:linear-gradient(135deg,#ff8c42,#ff6f5e)"><i class="fas fa-won-sign"></i></div>
                <div class="v">₩{{ number_format($stats['moneySaved']) }}</div>
                <div class="l">Value of free skills shared</div>
            </div>
        </div>
    </div>

    {{-- Activity stats --}}
    <div class="row g-3 mb-5">
        <div class="col-6 col-lg-3">
            <div class="tg-big"><div class="v text-warning">{{ $stats['foodShared'] }}</div><div class="l">Food posts shared</div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="tg-big"><div class="v" style="color:var(--tg-green)">{{ $stats['skillsShared'] }}</div><div class="l">Skills offered</div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="tg-big"><div class="v text-warning">{{ $stats['foodClaimed'] }}</div><div class="l">Food exchanges</div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="tg-big"><div class="v" style="color:var(--tg-green)">{{ $stats['sessionsBooked'] }}</div><div class="l">Sessions booked</div></div>
        </div>
    </div>

    {{-- Leaderboard --}}
    <h4 class="section-title mb-3"><i class="fas fa-trophy text-warning me-2"></i>Top Community Contributors</h4>
    <div class="tg-lead">
        @forelse ($leaderboard as $i => $member)
            <div class="row-item">
                <div class="tg-rank {{ $i===0?'r1':($i===1?'r2':($i===2?'r3':'rn')) }}">{{ $i+1 }}</div>
                @if ($member->avatar)
                    <img src="{{ asset('storage/'.$member->avatar) }}" class="tg-lead-avatar" style="object-fit:cover;" alt="">
                @else
                    <div class="tg-lead-avatar">{{ strtoupper(substr($member->name,0,1)) }}</div>
                @endif
                <div class="flex-grow-1">
                    <a href="{{ route('profile.show', $member) }}" class="fw-bold text-decoration-none text-dark">{{ $member->name }}</a>
                    @if ($member->profile?->is_verified)<i class="fas fa-circle-check text-success ms-1" title="Verified"></i>@endif
                    <div class="small text-muted">⭐ {{ number_format($member->rating,1) }} · {{ $member->profile?->neighborhood }}</div>
                </div>
                <div class="text-end">
                    <div class="fw-bold" style="color:var(--tg-green)">{{ $member->contribution }}</div>
                    <small class="text-muted">contributions</small>
                </div>
            </div>
        @empty
            <div class="p-4 text-center text-muted">No contributors yet.</div>
        @endforelse
    </div>
</div>
@endsection
