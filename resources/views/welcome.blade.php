@extends('layouts.app')

@section('title', __('app.welcome.page_title'))

@section('extra_css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --tg-dark: #16302d;
        --tg-green: #2d8f7f;
        --tg-light: #45b4a1;
        --tg-mint: #7fe0cd;
        --tg-orange: #ff8c42;
        --tg-coral: #ff6f5e;
        --tg-cream: #f4f8f4;
    }

    body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; }

    /* ===== ANIMATIONS ===== */
    @keyframes tgGradient { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }
    @keyframes tgFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-18px)} }
    @keyframes tgFloatSlow { 0%,100%{transform:translateY(0) rotate(-3deg)} 50%{transform:translateY(-22px) rotate(-3deg)} }
    @keyframes tgPulse { 0%,100%{transform:scale(1);opacity:.5} 50%{transform:scale(1.15);opacity:.8} }
    @keyframes tgFadeUp { from{opacity:0;transform:translateY(40px)} to{opacity:1;transform:translateY(0)} }
    @keyframes tgSpinSlow { from{transform:rotate(0)} to{transform:rotate(360deg)} }

    .reveal { opacity: 0; }
    .reveal.in { animation: tgFadeUp .8s cubic-bezier(.2,.7,.2,1) forwards; }
    .reveal.d1.in { animation-delay:.1s } .reveal.d2.in { animation-delay:.2s }
    .reveal.d3.in { animation-delay:.3s } .reveal.d4.in { animation-delay:.4s }
    .reveal.d5.in { animation-delay:.5s }

    /* ===== HERO ===== */
    .tg-hero {
        position: relative; overflow: hidden; color: #fff;
        padding: 120px 0 130px;
        background: linear-gradient(120deg, #0f2421, #16302d, #1f4f47, #2d8f7f, #16302d);
        background-size: 300% 300%;
        animation: tgGradient 16s ease infinite;
    }
    .tg-blob { position:absolute; border-radius:50%; filter: blur(6px); z-index:0; }
    .tg-blob.b1 { width:420px;height:420px; top:-130px; right:-60px; background:radial-gradient(circle,#45b4a1 0%,transparent 70%); animation:tgPulse 9s ease-in-out infinite; }
    .tg-blob.b2 { width:300px;height:300px; bottom:-120px; left:-80px; background:radial-gradient(circle,#ff8c42 0%,transparent 70%); opacity:.5; animation:tgPulse 11s ease-in-out infinite; }
    .tg-blob.b3 { width:200px;height:200px; top:40%; left:42%; background:radial-gradient(circle,#7fe0cd 0%,transparent 70%); opacity:.35; animation:tgPulse 7s ease-in-out infinite; }
    .tg-hero .container { position: relative; z-index: 2; }

    .tg-chip {
        display:inline-flex; align-items:center; gap:8px;
        background: rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2);
        backdrop-filter: blur(8px); padding:7px 16px; border-radius:30px;
        font-size:.85rem; font-weight:600; margin-bottom:24px;
    }
    .tg-chip .dot { width:8px;height:8px;border-radius:50%; background:var(--tg-mint); box-shadow:0 0 10px var(--tg-mint); }

    .tg-hero h1 {
        font-size: 4.6rem; font-weight: 800; letter-spacing:-2px; line-height:1.02; margin-bottom:18px;
    }
    .tg-grad-text {
        background: linear-gradient(90deg,#7fe0cd,#ffd6a5,#ff8c42);
        -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;
    }
    .tg-hero .tagline { font-size:1.45rem; font-weight:600; opacity:.95; margin-bottom:14px; }
    .tg-hero .subtag { font-size:1.05rem; opacity:.72; max-width:520px; line-height:1.7; }

    .tg-btn-glow {
        background:#fff; color:var(--tg-dark); font-weight:700; border:none;
        padding:14px 32px; border-radius:40px; transition:all .3s;
        box-shadow:0 10px 30px rgba(127,224,205,.35);
    }
    .tg-btn-glow:hover { transform:translateY(-3px); box-shadow:0 16px 40px rgba(127,224,205,.55); color:var(--tg-green); }
    .tg-btn-ghost {
        background:rgba(255,255,255,.08); color:#fff; font-weight:600; border:1px solid rgba(255,255,255,.35);
        padding:14px 32px; border-radius:40px; transition:all .3s; backdrop-filter:blur(6px);
    }
    .tg-btn-ghost:hover { background:rgba(255,255,255,.18); color:#fff; transform:translateY(-3px); }

    /* hero floating preview cards */
    .tg-hero-visual { position: relative; height: 460px; }
    .tg-float-card {
        position:absolute; background:#fff; color:#2b3a36; border-radius:18px; padding:18px;
        box-shadow:0 20px 50px rgba(0,0,0,.3); width:250px;
    }
    .tg-float-card .fc-top { display:flex; align-items:center; gap:10px; margin-bottom:10px; }
    .tg-float-card .fc-ic { width:40px;height:40px;border-radius:12px; display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem; }
    .tg-float-card h6 { margin:0; font-weight:700; font-size:.95rem; }
    .tg-float-card small { color:#9aa6a0; }
    .tg-float-card .fc-tag { display:inline-block; font-size:.7rem; font-weight:700; padding:3px 10px; border-radius:20px; margin-top:6px; }
    .fc1 { top:20px; right:30px; animation: tgFloat 6s ease-in-out infinite; }
    .fc2 { top:180px; right:140px; animation: tgFloatSlow 7s ease-in-out infinite; z-index:3; }
    .fc3 { top:300px; right:10px; animation: tgFloat 8s ease-in-out infinite; }
    .tg-ring { position:absolute; border:2px dashed rgba(255,255,255,.25); border-radius:50%; }
    .tg-ring.r1 { width:340px;height:340px; top:60px; right:60px; animation:tgSpinSlow 40s linear infinite; }

    /* ===== STAT STRIP ===== */
    .tg-statstrip { background: var(--tg-dark); color:#fff; padding:0; }
    .tg-statstrip .inner {
        background: linear-gradient(135deg,#2d8f7f,#1f4f47);
        border-radius:24px; margin-top:-60px; position:relative; z-index:5;
        padding:40px 20px; box-shadow:0 30px 60px rgba(0,0,0,.25);
    }
    .tg-stat-item { text-align:center; padding:10px; }
    .tg-stat-item .num { font-size:2.6rem; font-weight:800; line-height:1; }
    .tg-stat-item .num .suf { color:var(--tg-mint); }
    .tg-stat-item .lbl { font-size:.85rem; opacity:.8; margin-top:8px; }
    .tg-stat-divider { border-right:1px solid rgba(255,255,255,.15); }

    /* ===== SECTIONS ===== */
    .tg-section { padding: 90px 0; }
    .tg-eyebrow {
        display:inline-block; text-transform:uppercase; letter-spacing:2px; font-size:.78rem;
        font-weight:800; color:var(--tg-green); margin-bottom:12px;
        background:#e3f3ee; padding:5px 14px; border-radius:20px;
    }
    .tg-heading { font-size:2.6rem; font-weight:800; color:var(--tg-dark); margin-bottom:14px; letter-spacing:-1px; }
    .tg-sub { color:#6b7770; font-size:1.05rem; max-width:640px; margin:0 auto; }

    /* PROBLEM */
    .tg-problem-card {
        background:#fff; border-radius:20px; padding:38px; height:100%;
        box-shadow:0 10px 40px rgba(0,0,0,.06); position:relative; overflow:hidden;
        transition:transform .3s, box-shadow .3s;
    }
    .tg-problem-card:hover { transform:translateY(-8px); box-shadow:0 20px 50px rgba(0,0,0,.12); }
    .tg-problem-card::after { content:""; position:absolute; top:0;left:0; width:100%; height:6px;
        background:linear-gradient(90deg,var(--tg-orange),var(--tg-coral)); }
    .tg-problem-card.green::after { background:linear-gradient(90deg,var(--tg-green),var(--tg-mint)); }
    .tg-problem-card .stat { font-size:4rem; font-weight:800; line-height:1;
        background:linear-gradient(135deg,var(--tg-orange),var(--tg-coral)); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .tg-problem-card.green .stat { background:linear-gradient(135deg,var(--tg-green),var(--tg-light)); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .tg-problem-card .stat-label { font-size:1.05rem; color:#3c4a45; margin:14px 0 16px; font-weight:600; }
    .tg-problem-card .stat-desc { color:#6b7770; line-height:1.7; }
    .tg-problem-card .src { font-size:.78rem; color:#aab2ac; margin-top:18px; font-style:italic; }
    .tg-pill { display:inline-block; background:#ffe9d9; color:#d9651f; font-size:.72rem; font-weight:800; letter-spacing:1px; padding:5px 14px; border-radius:20px; margin-bottom:18px; }
    .tg-problem-card.green .tg-pill { background:#d8f0e9; color:var(--tg-green); }

    /* SOLUTION */
    .tg-solution { background: var(--tg-cream); }
    .tg-feature-block { background:#fff; border-radius:22px; overflow:hidden; height:100%;
        box-shadow:0 10px 40px rgba(0,0,0,.07); transition:transform .3s; }
    .tg-feature-block:hover { transform:translateY(-8px); }
    .tg-feature-block .head { padding:30px 34px; color:#fff; position:relative; }
    .tg-feature-block .head.food  { background:linear-gradient(135deg,#ff8c42,#ff6f5e); }
    .tg-feature-block .head.skill { background:linear-gradient(135deg,#2d8f7f,#45b4a1); }
    .tg-feature-block .head h3 { font-weight:800; margin:0; font-size:1.6rem; }
    .tg-feature-block .head i.big { position:absolute; right:24px; top:22px; font-size:3.4rem; opacity:.22; }
    .tg-feature-block .body { padding:28px 34px; }
    .tg-step { display:flex; align-items:center; gap:14px; padding:13px 0; border-bottom:1px dashed #e6e9e4; }
    .tg-step:last-child { border-bottom:none; }
    .tg-step .n { flex:0 0 30px; width:30px;height:30px; border-radius:50%;
        background:var(--tg-cream); color:var(--tg-dark); font-weight:800;
        display:flex; align-items:center; justify-content:center; font-size:.85rem; }
    .tg-feature-block:hover .tg-step .n { background:var(--tg-mint); }

    /* HOW */
    .tg-how-step { text-align:center; padding:0 14px; }
    .tg-how-circle { width:84px;height:84px; border-radius:24px; margin:0 auto 22px;
        display:flex; align-items:center; justify-content:center; font-size:1.7rem; font-weight:800; color:#fff;
        box-shadow:0 14px 30px rgba(0,0,0,.15); transition:transform .3s; }
    .tg-how-step:hover .tg-how-circle { transform:translateY(-6px) rotate(-6deg); }
    .tg-how-step:nth-child(1) .tg-how-circle { background:linear-gradient(135deg,#ff8c42,#ff6f5e); }
    .tg-how-step:nth-child(3) .tg-how-circle { background:linear-gradient(135deg,#2d8f7f,#45b4a1); }
    .tg-how-step:nth-child(5) .tg-how-circle { background:linear-gradient(135deg,#e0a800,#ffc63d); }
    .tg-how-step h5 { font-weight:700; color:var(--tg-dark); }
    .tg-how-arrow { display:flex; align-items:center; justify-content:center; color:#c5cdc7; font-size:1.6rem; }
    .tg-result-banner { background:linear-gradient(135deg,#16302d,#2d8f7f); color:#fff; border-radius:18px;
        padding:26px 30px; text-align:center; font-size:1.18rem; font-weight:600; margin-top:54px;
        box-shadow:0 16px 40px rgba(45,143,127,.3); }

    /* FEATURES */
    .tg-feat-card { background:#fff; border-radius:18px; padding:30px; height:100%;
        box-shadow:0 6px 24px rgba(0,0,0,.05); transition:transform .3s, box-shadow .3s;
        border:1px solid #eef1ec; position:relative; overflow:hidden; }
    .tg-feat-card::before { content:""; position:absolute; right:-40px; top:-40px; width:120px; height:120px;
        border-radius:50%; background:linear-gradient(135deg,#e3f3ee,transparent); transition:transform .4s; }
    .tg-feat-card:hover { transform:translateY(-8px); box-shadow:0 18px 40px rgba(0,0,0,.1); }
    .tg-feat-card:hover::before { transform:scale(1.6); }
    .tg-feat-icon { width:58px;height:58px; border-radius:16px; margin-bottom:20px; position:relative; z-index:1;
        display:flex; align-items:center; justify-content:center; font-size:1.5rem; color:#fff;
        background:linear-gradient(135deg,var(--tg-green),var(--tg-light)); box-shadow:0 8px 20px rgba(45,143,127,.35); }
    .tg-feat-card:nth-child(even) .tg-feat-icon { background:linear-gradient(135deg,var(--tg-orange),var(--tg-coral)); box-shadow:0 8px 20px rgba(255,140,66,.35); }
    .tg-feat-card h5 { font-weight:700; color:var(--tg-dark); position:relative; z-index:1; }
    .tg-feat-card p { color:#6b7770; margin:0; font-size:.95rem; position:relative; z-index:1; }

    /* USERS */
    .tg-users { background:var(--tg-cream); }
    .tg-user-card { background:#fff; border-radius:16px; padding:24px; height:100%;
        box-shadow:0 6px 24px rgba(0,0,0,.05); display:flex; gap:16px; align-items:flex-start;
        transition:transform .3s; border:1px solid #eef1ec; }
    .tg-user-card:hover { transform:translateY(-6px); }
    .tg-user-ic { flex:0 0 50px; width:50px;height:50px; border-radius:14px;
        display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.15rem;
        background:linear-gradient(135deg,var(--tg-green),var(--tg-light)); }
    .tg-user-card h6 { font-weight:700; margin-bottom:4px; color:var(--tg-dark); }
    .tg-user-card p { margin:0; font-size:.88rem; color:#6b7770; }

    /* IMPACT */
    .tg-impact { position:relative; overflow:hidden;
        background:linear-gradient(135deg,#0f2421,#16302d); color:#fff; }
    .tg-impact .tg-eyebrow { color:var(--tg-mint); background:rgba(127,224,205,.12); }
    .tg-impact .tg-heading { color:#fff; }
    .tg-impact .tg-sub { color:rgba(255,255,255,.7); }
    .tg-impact-card { background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1);
        border-radius:18px; padding:28px; height:100%; transition:transform .3s, background .3s; }
    .tg-impact-card:hover { transform:translateY(-8px); background:rgba(255,255,255,.1); }
    .tg-impact-card .sdg { color:var(--tg-mint); font-weight:700; font-size:.82rem; margin-bottom:10px; }
    .tg-impact-card h5 { font-weight:700; }
    .tg-impact-card p { color:rgba(255,255,255,.72); margin:0; font-size:.92rem; line-height:1.7; }
    .tg-impact-ic { width:56px;height:56px;border-radius:16px; display:flex;align-items:center;justify-content:center;
        font-size:1.5rem; color:#fff; margin-bottom:16px;
        background:linear-gradient(135deg,var(--tg-orange),var(--tg-coral)); }

    /* VISION */
    .tg-vision { position:relative; overflow:hidden; color:#fff; text-align:center; padding:100px 0;
        background:linear-gradient(120deg,#2d8f7f,#45b4a1,#7fe0cd,#2d8f7f); background-size:300% 300%;
        animation:tgGradient 14s ease infinite; }
    .tg-vision h2 { font-size:2.9rem; font-weight:800; max-width:840px; margin:0 auto 22px; line-height:1.18; letter-spacing:-1px; }
    .tg-vision p { font-size:1.12rem; opacity:.92; max-width:640px; margin:0 auto 32px; }

    @media (max-width: 991px) { .tg-hero-visual { display:none; } .tg-hero { padding:90px 0 100px; } }
    @media (max-width: 768px) {
        .tg-hero h1 { font-size:2.8rem; }
        .tg-heading { font-size:2rem; }
        .tg-how-arrow { display:none; }
        .tg-stat-divider { border-right:none; }
    }
</style>
@endsection

@section('content')

{{-- ============ HERO ============ --}}
<section class="tg-hero">
    <span class="tg-blob b1"></span>
    <span class="tg-blob b2"></span>
    <span class="tg-blob b3"></span>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="tg-chip"><span class="dot"></span> {{ __('app.welcome.hero_chip') }}</span>
                <h1>{{ __('app.welcome.hero_l1') }}<br>{{ __('app.welcome.hero_l2') }}<br><span class="tg-grad-text">{{ __('app.welcome.hero_l3') }}</span></h1>
                <p class="subtag">{{ __('app.welcome.hero_subtag') }}</p>

                <div class="mt-4 d-flex flex-wrap gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="tg-btn-glow">
                            <i class="fas fa-gauge-high me-2"></i>{{ __('app.welcome.cta_dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="tg-btn-glow">
                            {{ __('app.welcome.cta_get_started') }} <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="{{ route('login') }}" class="tg-btn-ghost">{{ __('app.nav.login') }}</a>
                    @endauth
                </div>
            </div>

            <div class="col-lg-6">
                <div class="tg-hero-visual">
                    <span class="tg-ring r1"></span>

                    <div class="tg-float-card fc1">
                        <div class="fc-top">
                            <div class="fc-ic" style="background:linear-gradient(135deg,#ff8c42,#ff6f5e)"><i class="fas fa-utensils"></i></div>
                            <div><h6>{{ __('app.welcome.fc1_title') }}</h6><small>{{ __('app.welcome.fc1_meta') }}</small></div>
                        </div>
                        <span class="fc-tag" style="background:#ffe9d9;color:#d9651f">{{ __('app.welcome.fc1_tag') }}</span>
                    </div>

                    <div class="tg-float-card fc2">
                        <div class="fc-top">
                            <div class="fc-ic" style="background:linear-gradient(135deg,#2d8f7f,#45b4a1)"><i class="fas fa-lightbulb"></i></div>
                            <div><h6>{{ __('app.welcome.fc2_title') }}</h6><small>{{ __('app.welcome.fc2_meta') }}</small></div>
                        </div>
                        <span class="fc-tag" style="background:#d8f0e9;color:#2d8f7f">{{ __('app.welcome.fc2_tag') }}</span>
                    </div>

                    <div class="tg-float-card fc3">
                        <div class="fc-top">
                            <div class="fc-ic" style="background:linear-gradient(135deg,#e0a800,#ffc63d)"><i class="fas fa-language"></i></div>
                            <div><h6>{{ __('app.welcome.fc3_title') }}</h6><small>{{ __('app.welcome.fc3_meta') }}</small></div>
                        </div>
                        <span class="fc-tag" style="background:#fff3cd;color:#b8860b">{{ __('app.welcome.fc3_tag') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ STAT STRIP ============ --}}
<section class="tg-statstrip">
    <div class="container">
        <div class="inner">
            <div class="row text-white align-items-center">
                <div class="col-6 col-md-3 tg-stat-divider">
                    <div class="tg-stat-item"><div class="num" data-count="130"><span class="suf">kg</span></div>
                        <div class="lbl">{{ __('app.welcome.stat1') }}</div></div>
                </div>
                <div class="col-6 col-md-3 tg-stat-divider">
                    <div class="tg-stat-item"><div class="num" data-count="68"><span class="suf">%</span></div>
                        <div class="lbl">{{ __('app.welcome.stat2') }}</div></div>
                </div>
                <div class="col-6 col-md-3 tg-stat-divider">
                    <div class="tg-stat-item"><div class="num" data-count="100"><span class="suf">%</span></div>
                        <div class="lbl">{{ __('app.welcome.stat3') }}</div></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="tg-stat-item"><div class="num" data-count="2"><span class="suf">{{ __('app.welcome.stat4_suffix') }}</span></div>
                        <div class="lbl">{{ __('app.welcome.stat4') }}</div></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ THE PROBLEM ============ --}}
<section class="tg-section">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="tg-eyebrow">{{ __('app.welcome.problem_eyebrow') }}</span>
            <h2 class="tg-heading">{{ __('app.welcome.problem_title') }}</h2>
            <p class="tg-sub">{{ __('app.welcome.problem_sub') }}</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 reveal d1">
                <div class="tg-problem-card">
                    <span class="tg-pill">{{ __('app.welcome.problem1_pill') }}</span>
                    <div class="stat">130 kg</div>
                    <div class="stat-label">{{ __('app.welcome.problem1_label') }}</div>
                    <p class="stat-desc">{{ __('app.welcome.problem1_desc') }}</p>
                    <div class="src">{{ __('app.welcome.problem1_src') }}</div>
                </div>
            </div>
            <div class="col-md-6 reveal d2">
                <div class="tg-problem-card green">
                    <span class="tg-pill">{{ __('app.welcome.problem2_pill') }}</span>
                    <div class="stat">68%</div>
                    <div class="stat-label">{{ __('app.welcome.problem2_label') }}</div>
                    <p class="stat-desc">{{ __('app.welcome.problem2_desc') }}</p>
                    <div class="src">{{ __('app.welcome.problem2_src') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ THE SOLUTION ============ --}}
<section class="tg-section tg-solution">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="tg-eyebrow">{{ __('app.welcome.solution_eyebrow') }}</span>
            <h2 class="tg-heading">{{ __('app.welcome.solution_title') }}</h2>
            <p class="tg-sub">{{ __('app.welcome.solution_sub') }}</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-6 reveal d1">
                <div class="tg-feature-block">
                    <div class="head food">
                        <i class="fas fa-utensils big"></i>
                        <h3><i class="fas fa-utensils me-2"></i>{{ __('app.welcome.sol_food_title') }}</h3>
                    </div>
                    <div class="body">
                        <p class="text-muted">{{ __('app.welcome.sol_food_desc') }}</p>
                        <div class="tg-step"><span class="n">1</span><span>{{ __('app.welcome.sol_food_s1') }}</span></div>
                        <div class="tg-step"><span class="n">2</span><span>{{ __('app.welcome.sol_food_s2') }}</span></div>
                        <div class="tg-step"><span class="n">3</span><span>{{ __('app.welcome.sol_food_s3') }}</span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reveal d2">
                <div class="tg-feature-block">
                    <div class="head skill">
                        <i class="fas fa-lightbulb big"></i>
                        <h3><i class="fas fa-lightbulb me-2"></i>{{ __('app.welcome.sol_skill_title') }}</h3>
                    </div>
                    <div class="body">
                        <p class="text-muted">{{ __('app.welcome.sol_skill_desc') }}</p>
                        <div class="tg-step"><span class="n">1</span><span>{{ __('app.welcome.sol_skill_s1') }}</span></div>
                        <div class="tg-step"><span class="n">2</span><span>{{ __('app.welcome.sol_skill_s2') }}</span></div>
                        <div class="tg-step"><span class="n">3</span><span>{{ __('app.welcome.sol_skill_s3') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ HOW IT WORKS ============ --}}
<section class="tg-section">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="tg-eyebrow">{{ __('app.welcome.how_eyebrow') }}</span>
            <h2 class="tg-heading">{{ __('app.welcome.how_title') }}</h2>
            <p class="tg-sub">{{ __('app.welcome.how_sub') }}</p>
        </div>
        <div class="row align-items-start">
            <div class="col-md tg-how-step reveal d1">
                <div class="tg-how-circle">01</div>
                <h5>{{ __('app.welcome.how1_title') }}</h5>
                <p class="text-muted">{{ __('app.welcome.how1_desc') }}</p>
            </div>
            <div class="col-md-auto tg-how-arrow reveal d2"><i class="fas fa-arrow-right"></i></div>
            <div class="col-md tg-how-step reveal d2">
                <div class="tg-how-circle">02</div>
                <h5>{{ __('app.welcome.how2_title') }}</h5>
                <p class="text-muted">{{ __('app.welcome.how2_desc') }}</p>
            </div>
            <div class="col-md-auto tg-how-arrow reveal d3"><i class="fas fa-arrow-right"></i></div>
            <div class="col-md tg-how-step reveal d3">
                <div class="tg-how-circle">03</div>
                <h5>{{ __('app.welcome.how3_title') }}</h5>
                <p class="text-muted">{{ __('app.welcome.how3_desc') }}</p>
            </div>
        </div>
        <div class="tg-result-banner reveal d4">
            <i class="fas fa-seedling me-2"></i>
            {{ __('app.welcome.how_result') }}
        </div>
    </div>
</section>

{{-- ============ KEY FEATURES ============ --}}
<section class="tg-section tg-solution">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="tg-eyebrow">{{ __('app.welcome.features_eyebrow') }}</span>
            <h2 class="tg-heading">{{ __('app.welcome.features_title') }}</h2>
            <p class="tg-sub">{{ __('app.welcome.features_sub') }}</p>
        </div>
        <div class="row g-4">
            @php
                $features = [
                    ['fa-location-dot', __('app.welcome.feat1_title'), __('app.welcome.feat1_desc')],
                    ['fa-bolt', __('app.welcome.feat2_title'), __('app.welcome.feat2_desc')],
                    ['fa-comments', __('app.welcome.feat3_title'), __('app.welcome.feat3_desc')],
                    ['fa-star', __('app.welcome.feat4_title'), __('app.welcome.feat4_desc')],
                    ['fa-bell', __('app.welcome.feat5_title'), __('app.welcome.feat5_desc')],
                    ['fa-heart', __('app.welcome.feat6_title'), __('app.welcome.feat6_desc')],
                ];
            @endphp
            @foreach ($features as $i => $f)
                <div class="col-md-6 col-lg-4 reveal d{{ ($i % 3) + 1 }}">
                    <div class="tg-feat-card">
                        <div class="tg-feat-icon"><i class="fas {{ $f[0] }}"></i></div>
                        <h5>{{ $f[1] }}</h5>
                        <p>{{ $f[2] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ WHO WE SERVE ============ --}}
<section class="tg-section tg-users">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="tg-eyebrow">{{ __('app.welcome.users_eyebrow') }}</span>
            <h2 class="tg-heading">{{ __('app.welcome.users_title') }}</h2>
            <p class="tg-sub">{{ __('app.welcome.users_sub') }}</p>
        </div>
        <div class="row g-4">
            @php
                $users = [
                    ['fa-house', __('app.welcome.user1_title'), __('app.welcome.user1_desc')],
                    ['fa-store', __('app.welcome.user2_title'), __('app.welcome.user2_desc')],
                    ['fa-graduation-cap', __('app.welcome.user3_title'), __('app.welcome.user3_desc')],
                    ['fa-earth-asia', __('app.welcome.user4_title'), __('app.welcome.user4_desc')],
                    ['fa-people-roof', __('app.welcome.user5_title'), __('app.welcome.user5_desc')],
                    ['fa-briefcase', __('app.welcome.user6_title'), __('app.welcome.user6_desc')],
                ];
            @endphp
            @foreach ($users as $i => $u)
                <div class="col-md-6 col-lg-4 reveal d{{ ($i % 3) + 1 }}">
                    <div class="tg-user-card">
                        <div class="tg-user-ic"><i class="fas {{ $u[0] }}"></i></div>
                        <div>
                            <h6>{{ $u[1] }}</h6>
                            <p>{{ $u[2] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ SOCIAL IMPACT ============ --}}
<section class="tg-section tg-impact">
    <span class="tg-blob b2" style="opacity:.25"></span>
    <div class="container" style="position:relative;z-index:2">
        <div class="text-center mb-5 reveal">
            <span class="tg-eyebrow">{{ __('app.welcome.impact_eyebrow') }}</span>
            <h2 class="tg-heading">{{ __('app.welcome.impact_title') }}</h2>
            <p class="tg-sub">{{ __('app.welcome.impact_sub') }}</p>
        </div>
        <div class="row g-4">
            @php
                $impacts = [
                    ['fa-recycle', __('app.welcome.impact1_sdg'), __('app.welcome.impact1_title'), __('app.welcome.impact1_desc')],
                    ['fa-handshake-angle', __('app.welcome.impact2_sdg'), __('app.welcome.impact2_title'), __('app.welcome.impact2_desc')],
                    ['fa-book-open', __('app.welcome.impact3_sdg'), __('app.welcome.impact3_title'), __('app.welcome.impact3_desc')],
                    ['fa-hand-holding-heart', __('app.welcome.impact4_sdg'), __('app.welcome.impact4_title'), __('app.welcome.impact4_desc')],
                ];
            @endphp
            @foreach ($impacts as $i => $im)
                <div class="col-md-6 col-lg-3 reveal d{{ $i + 1 }}">
                    <div class="tg-impact-card">
                        <div class="tg-impact-ic"><i class="fas {{ $im[0] }}"></i></div>
                        <div class="sdg">{{ $im[1] }}</div>
                        <h5>{{ $im[2] }}</h5>
                        <p>{{ $im[3] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ VISION / CTA ============ --}}
<section class="tg-vision">
    <div class="container reveal">
        <span class="tg-chip"><span class="dot"></span> {{ __('app.welcome.vision_chip') }}</span>
        <h2>{{ __('app.welcome.vision_title') }}</h2>
        <p>{{ __('app.welcome.vision_desc') }}</p>
        @auth
            <a href="{{ route('dashboard') }}" class="tg-btn-glow">{{ __('app.welcome.vision_cta_dashboard') }}</a>
        @else
            <a href="{{ route('register') }}" class="tg-btn-glow">{{ __('app.welcome.vision_cta_join') }} <i class="fas fa-arrow-right ms-2"></i></a>
            <a href="{{ route('login') }}" class="tg-btn-ghost ms-2">{{ __('app.nav.login') }}</a>
        @endauth
    </div>
</section>

@endsection

@section('extra_js')
<script>
    // Scroll reveal
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
    }, { threshold: 0.15 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));

    // Animated number counters
    function animateCount(el) {
        const target = parseInt(el.getAttribute('data-count'), 10);
        const suffix = el.querySelector('.suf') ? el.querySelector('.suf').outerHTML : '';
        let cur = 0;
        const dur = 1400, start = performance.now();
        function tick(now) {
            const p = Math.min((now - start) / dur, 1);
            const val = Math.floor(p * target);
            el.innerHTML = val + suffix;
            if (p < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }
    const counterIO = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { animateCount(e.target); counterIO.unobserve(e.target); } });
    }, { threshold: 0.5 });
    document.querySelectorAll('.num[data-count]').forEach(el => counterIO.observe(el));
</script>
@endsection
