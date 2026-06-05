@extends('layouts.app')

@section('title', 'Welcome')

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
                <span class="tg-chip"><span class="dot"></span> Now live in your neighborhood</span>
                <h1>Share Food.<br>Share Skills.<br><span class="tg-grad-text">Build Community.</span></h1>
                <p class="subtag">A neighborhood platform that turns surplus food and unused skills into
                    real connections — starting in Busan, built for everyone.</p>

                <div class="mt-4 d-flex flex-wrap gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="tg-btn-glow">
                            <i class="fas fa-gauge-high me-2"></i>Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="tg-btn-glow">
                            Get Started — Free <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="{{ route('login') }}" class="tg-btn-ghost">Login</a>
                    @endauth
                </div>
            </div>

            <div class="col-lg-6">
                <div class="tg-hero-visual">
                    <span class="tg-ring r1"></span>

                    <div class="tg-float-card fc1">
                        <div class="fc-top">
                            <div class="fc-ic" style="background:linear-gradient(135deg,#ff8c42,#ff6f5e)"><i class="fas fa-utensils"></i></div>
                            <div><h6>Homemade Kimchi</h6><small>0.4 km away</small></div>
                        </div>
                        <span class="fc-tag" style="background:#ffe9d9;color:#d9651f">FREE · 3 portions</span>
                    </div>

                    <div class="tg-float-card fc2">
                        <div class="fc-top">
                            <div class="fc-ic" style="background:linear-gradient(135deg,#2d8f7f,#45b4a1)"><i class="fas fa-lightbulb"></i></div>
                            <div><h6>Guitar Lessons</h6><small>⭐ 4.9 · Min-jun</small></div>
                        </div>
                        <span class="fc-tag" style="background:#d8f0e9;color:#2d8f7f">Beginner welcome</span>
                    </div>

                    <div class="tg-float-card fc3">
                        <div class="fc-top">
                            <div class="fc-ic" style="background:linear-gradient(135deg,#e0a800,#ffc63d)"><i class="fas fa-language"></i></div>
                            <div><h6>Korean ↔ English</h6><small>Language swap</small></div>
                        </div>
                        <span class="fc-tag" style="background:#fff3cd;color:#b8860b">Weekends</span>
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
                        <div class="lbl">Food wasted / person / year</div></div>
                </div>
                <div class="col-6 col-md-3 tg-stat-divider">
                    <div class="tg-stat-item"><div class="num" data-count="68"><span class="suf">%</span></div>
                        <div class="lbl">Never share their skills</div></div>
                </div>
                <div class="col-6 col-md-3 tg-stat-divider">
                    <div class="tg-stat-item"><div class="num" data-count="100"><span class="suf">%</span></div>
                        <div class="lbl">Free for everyone</div></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="tg-stat-item"><div class="num" data-count="2"><span class="suf">in 1</span></div>
                        <div class="lbl">Food + Skills, one app</div></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ THE PROBLEM ============ --}}
<section class="tg-section">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="tg-eyebrow">Why Togetherly</span>
            <h2 class="tg-heading">The Problem</h2>
            <p class="tg-sub">Two major issues silently affect communities every single day.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 reveal d1">
                <div class="tg-problem-card">
                    <span class="tg-pill">Food Waste Crisis</span>
                    <div class="stat">130 kg</div>
                    <div class="stat-label">of food wasted per person every year in South Korea</div>
                    <p class="stat-desc">Restaurants &amp; households discard surplus food daily with no easy
                        way to share it locally before it goes to waste.</p>
                    <div class="src">Source: Korea Environment Corp., 2023</div>
                </div>
            </div>
            <div class="col-md-6 reveal d2">
                <div class="tg-problem-card green">
                    <span class="tg-pill">Skills Go Unshared</span>
                    <div class="stat">68%</div>
                    <div class="stat-label">of people have skills they never teach or share</div>
                    <p class="stat-desc">Knowledge stays locked inside individuals while others nearby
                        pay to learn the very same things.</p>
                    <div class="src">Source: Global Skills Report, 2023</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ THE SOLUTION ============ --}}
<section class="tg-section tg-solution">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="tg-eyebrow">The Solution</span>
            <h2 class="tg-heading">Introducing Togetherly</h2>
            <p class="tg-sub">One simple app — two powerful features — infinite community impact.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-6 reveal d1">
                <div class="tg-feature-block">
                    <div class="head food">
                        <i class="fas fa-utensils big"></i>
                        <h3><i class="fas fa-utensils me-2"></i>Food Sharing</h3>
                    </div>
                    <div class="body">
                        <p class="text-muted">Post surplus food in 30 seconds. Nearby neighbors claim it before
                            it goes to waste. Simple pickup — no delivery needed.</p>
                        <div class="tg-step"><span class="n">1</span><span>Post food with a photo &amp; location</span></div>
                        <div class="tg-step"><span class="n">2</span><span>Neighbors get an instant notification</span></div>
                        <div class="tg-step"><span class="n">3</span><span>Meet &amp; hand over locally</span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reveal d2">
                <div class="tg-feature-block">
                    <div class="head skill">
                        <i class="fas fa-lightbulb big"></i>
                        <h3><i class="fas fa-lightbulb me-2"></i>Skill Sharing</h3>
                    </div>
                    <div class="body">
                        <p class="text-muted">Offer what you know — languages, cooking, music, coding. Locals
                            book a free session. Skills flow freely through the community.</p>
                        <div class="tg-step"><span class="n">1</span><span>List your skill &amp; availability</span></div>
                        <div class="tg-step"><span class="n">2</span><span>Interested people send a request</span></div>
                        <div class="tg-step"><span class="n">3</span><span>Meet, teach &amp; connect locally</span></div>
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
            <span class="tg-eyebrow">User Journey</span>
            <h2 class="tg-heading">How It Works</h2>
            <p class="tg-sub">Three simple steps — from surplus to smiles.</p>
        </div>
        <div class="row align-items-start">
            <div class="col-md tg-how-step reveal d1">
                <div class="tg-how-circle">01</div>
                <h5>Download &amp; Sign Up</h5>
                <p class="text-muted">Join with your phone or email. Set your neighborhood. Done in 60 seconds.</p>
            </div>
            <div class="col-md-auto tg-how-arrow reveal d2"><i class="fas fa-arrow-right"></i></div>
            <div class="col-md tg-how-step reveal d2">
                <div class="tg-how-circle">02</div>
                <h5>Browse or Post</h5>
                <p class="text-muted">See what's available nearby — food or skills. Or share your own in 30 seconds.</p>
            </div>
            <div class="col-md-auto tg-how-arrow reveal d3"><i class="fas fa-arrow-right"></i></div>
            <div class="col-md tg-how-step reveal d3">
                <div class="tg-how-circle">03</div>
                <h5>Connect &amp; Meet</h5>
                <p class="text-muted">Message directly in-app. Arrange pickup or a meeting. Build real community bonds.</p>
            </div>
        </div>
        <div class="tg-result-banner reveal d4">
            <i class="fas fa-seedling me-2"></i>
            Result: Less food wasted. More skills shared. A stronger, warmer community.
        </div>
    </div>
</section>

{{-- ============ KEY FEATURES ============ --}}
<section class="tg-section tg-solution">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="tg-eyebrow">Product Features</span>
            <h2 class="tg-heading">Key Features</h2>
            <p class="tg-sub">Simple, focused, and ready to use.</p>
        </div>
        <div class="row g-4">
            @php
                $features = [
                    ['fa-location-dot', 'Location-Based Feed', "See posts only from your neighborhood. Relevant, timely, local."],
                    ['fa-bolt', 'Quick Post', "Share food or a skill in under 30 seconds — title, photo, location."],
                    ['fa-comments', 'In-App Messaging', "Contact the poster directly. No phone number needed. Safe & private."],
                    ['fa-star', 'Community Ratings', "Rate exchanges after completion. Build trust across the network."],
                    ['fa-bell', 'Notifications', "Get alerted when food or a skill you want is posted nearby."],
                    ['fa-heart', 'Free for Everyone', "No paywalls for regular users. Inclusive by design."],
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
            <span class="tg-eyebrow">Who We Serve</span>
            <h2 class="tg-heading">Built for Everyone</h2>
            <p class="tg-sub">No barriers to entry — Togetherly works for every kind of neighbor.</p>
        </div>
        <div class="row g-4">
            @php
                $users = [
                    ['fa-house', 'Home Cooks', 'Cook more than they eat and want to reduce food waste.'],
                    ['fa-store', 'Restaurants', 'Have daily surplus food and want a verified green badge.'],
                    ['fa-graduation-cap', 'Skill Holders', 'Have knowledge to share and want to give back locally.'],
                    ['fa-earth-asia', 'Expats & Students', 'New to the city, needing community and learning.'],
                    ['fa-people-roof', 'Elderly & Families', 'Need affordable food and help, open to local support.'],
                    ['fa-briefcase', 'Local Businesses', 'CSR goals & brand building with community visibility.'],
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
            <span class="tg-eyebrow">Why It Matters</span>
            <h2 class="tg-heading">Social Impact</h2>
            <p class="tg-sub">Togetherly creates measurable good — for people and the planet.</p>
        </div>
        <div class="row g-4">
            @php
                $impacts = [
                    ['fa-recycle','SDG 12 · Responsible Consumption','Environmental','Reduces food waste sent to landfill, lowering methane emissions and carbon footprint city-wide.'],
                    ['fa-handshake-angle','SDG 11 · Sustainable Communities','Social Cohesion','Fights loneliness and isolation by creating real-world connections between neighbors.'],
                    ['fa-book-open','SDG 4 · Quality Education','Education Access','Democratizes learning by allowing anyone to teach or learn skills — regardless of income.'],
                    ['fa-hand-holding-heart','SDG 1 · No Poverty','Economic Relief','Reduces food and education costs for low-income families and students.'],
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
        <span class="tg-chip"><span class="dot"></span> Our Vision</span>
        <h2>A world where nothing goes to waste — not food, not knowledge, not kindness.</h2>
        <p>Every city has surplus food. Every person has a skill to share. We give communities the tool to help themselves.</p>
        @auth
            <a href="{{ route('dashboard') }}" class="tg-btn-glow">Go to Your Dashboard</a>
        @else
            <a href="{{ route('register') }}" class="tg-btn-glow">Join Togetherly — Free <i class="fas fa-arrow-right ms-2"></i></a>
            <a href="{{ route('login') }}" class="tg-btn-ghost ms-2">Login</a>
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
