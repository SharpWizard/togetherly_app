@extends('layouts.app')

@section('title', __('app.auth.login_title'))

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
    .tg-auth-feature { display:flex; gap:12px; align-items:center; margin-top:18px; }
    .tg-auth-feature i { width:36px;height:36px;border-radius:10px; background:rgba(255,255,255,.15);
        display:flex;align-items:center;justify-content:center; }
    .tg-auth-body { padding: 50px 44px; background: #fff; }
    .tg-demo-box { background:#eaf5f1; border:1px dashed var(--tg-light); border-radius:14px; padding:14px 16px; }
    .tg-divider { display:flex; align-items:center; gap:14px; color:#9aa6a0; font-size:.85rem; margin:22px 0; }
    .tg-divider::before, .tg-divider::after { content:""; flex:1; height:1px; background:#e2e8e4; }
</style>
@endsection

@section('content')
<div class="tg-auth">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card tg-auth-card border-0">
                    <div class="row g-0">
                        {{-- Visual side --}}
                        <div class="col-md-5 d-none d-md-block">
                            <div class="tg-auth-visual h-100">
                                <div class="inner">
                                    <div class="tg-auth-logo">T</div>
                                    <h2>{{ __('app.auth.login_welcome') }}</h2>
                                    <p class="mt-3" style="opacity:.85;">{{ __('app.auth.login_visual_sub') }}</p>
                                    <div class="tg-auth-feature"><i class="fas fa-utensils"></i><span>{{ __('app.auth.login_feat1') }}</span></div>
                                    <div class="tg-auth-feature"><i class="fas fa-lightbulb"></i><span>{{ __('app.auth.login_feat2') }}</span></div>
                                    <div class="tg-auth-feature"><i class="fas fa-heart"></i><span>{{ __('app.auth.login_feat3') }}</span></div>
                                </div>
                            </div>
                        </div>

                        {{-- Form side --}}
                        <div class="col-md-7">
                            <div class="tg-auth-body">
                                <h3 class="fw-bold mb-1">{{ __('app.auth.login_heading') }}</h3>
                                <p class="text-muted mb-4">{{ __('app.auth.login_subtitle') }}</p>

                                {{-- Demo quick login --}}
                                <div class="tg-demo-box mb-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <div>
                                            <strong><i class="fas fa-wand-magic-sparkles me-1 text-success"></i> {{ __('app.auth.try_demo') }}</strong>
                                            <div class="small text-muted">{{ __('app.auth.demo_no_signup') }}</div>
                                        </div>
                                        <form action="{{ route('demo.login') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-bolt me-1"></i> {{ __('app.auth.demo_login') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="tg-divider">{{ __('app.auth.or_login_email') }}</div>

                                <form action="{{ route('store.login') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{ __('app.auth.email') }}</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" value="{{ old('email', 'demo@togetherly.app') }}" required autofocus>
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">{{ __('app.auth.password') }}</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password" value="password" required>
                                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-4 form-check">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">{{ __('app.auth.remember_me') }}</label>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 mb-3">
                                        <i class="fas fa-right-to-bracket me-1"></i> {{ __('app.auth.login_heading') }}
                                    </button>

                                    <p class="text-center mb-0 text-muted">
                                        {{ __('app.auth.no_account') }} <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">{{ __('app.auth.register_here') }}</a>
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
