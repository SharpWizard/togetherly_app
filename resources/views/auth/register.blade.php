@extends('layouts.app')

@section('title', 'Register')

@section('extra_css')
<style>
    .tg-auth { min-height: calc(100vh - 76px); display: flex; align-items: center; padding: 40px 0; }
    .tg-auth-card { border-radius: 24px; overflow: hidden; box-shadow: 0 24px 60px rgba(0,0,0,.12); }
    .tg-auth-visual {
        background: linear-gradient(135deg, #16302d, #2d8f7f 70%, #45b4a1);
        color: #fff; padding: 50px 44px; position: relative; overflow: hidden;
    }
    .tg-auth-visual::before { content:""; position:absolute; width:280px;height:280px;border-radius:50%;
        background:rgba(127,224,205,.2); top:-80px; right:-60px; }
    .tg-auth-visual::after { content:""; position:absolute; width:180px;height:180px;border-radius:50%;
        background:rgba(255,140,66,.18); bottom:-50px; left:-30px; }
    .tg-auth-visual .inner { position: relative; z-index: 1; }
    .tg-auth-logo { width:56px;height:56px;border-radius:16px; background:rgba(255,255,255,.15);
        display:flex;align-items:center;justify-content:center; font-weight:800; font-size:1.6rem; margin-bottom:26px; }
    .tg-auth-visual h2 { font-weight:800; font-size:2rem; line-height:1.2; }
    .tg-auth-stat { display:flex; gap:14px; align-items:center; margin-top:22px; }
    .tg-auth-stat .v { font-size:1.8rem; font-weight:800; color: var(--tg-mint); }
    .tg-auth-body { padding: 44px; background: #fff; }
    .tg-demo-box { background:#eaf5f1; border:1px dashed var(--tg-light); border-radius:14px; padding:12px 16px; }
</style>
@endsection

@section('content')
<div class="tg-auth">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card tg-auth-card border-0">
                    <div class="row g-0">
                        {{-- Visual side --}}
                        <div class="col-md-5 d-none d-md-block">
                            <div class="tg-auth-visual h-100">
                                <div class="inner">
                                    <div class="tg-auth-logo">T</div>
                                    <h2>Join Togetherly today.</h2>
                                    <p class="mt-3" style="opacity:.85;">Free for everyone. Set your neighborhood and start sharing in 60 seconds.</p>
                                    <div class="tg-auth-stat"><span class="v">130kg</span><span>food saved per person / year</span></div>
                                    <div class="tg-auth-stat"><span class="v">68%</span><span>have skills worth sharing</span></div>
                                    <div class="tg-auth-stat"><span class="v">100%</span><span>free, no paywalls</span></div>
                                </div>
                            </div>
                        </div>

                        {{-- Form side --}}
                        <div class="col-md-7">
                            <div class="tg-auth-body">
                                <h3 class="fw-bold mb-1">Create your account</h3>
                                <p class="text-muted mb-3">Share food. Share skills. Build community.</p>

                                <div class="tg-demo-box mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <span class="small"><i class="fas fa-wand-magic-sparkles text-success me-1"></i> Just want to look around?</span>
                                    <form action="{{ route('demo.login') }}" method="POST">@csrf
                                        <button class="btn btn-secondary btn-sm"><i class="fas fa-bolt me-1"></i>Demo Login</button>
                                    </form>
                                </div>

                                <form action="{{ route('store.register') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                                   id="phone" name="phone" value="{{ old('phone') }}" placeholder="010-1234-5678" required>
                                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="neighborhood" class="form-label">Neighborhood / District</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="fas fa-location-dot text-success"></i></span>
                                            <input type="text" class="form-control @error('neighborhood') is-invalid @enderror"
                                                   id="neighborhood" name="neighborhood" value="{{ old('neighborhood') }}"
                                                   placeholder="e.g., Haeundae-gu, Busan" required>
                                            @error('neighborhood')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                   id="password" name="password" required>
                                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 mb-3">
                                        <i class="fas fa-user-plus me-1"></i> Create Account
                                    </button>

                                    <p class="text-center mb-0 text-muted">
                                        Already have an account? <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Login here</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
