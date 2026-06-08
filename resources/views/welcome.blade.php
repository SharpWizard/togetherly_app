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

    body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; overflow-x: hidden; }

    /* ===== SCROLL PROGRESS BAR ===== */
    .tg-progress {
        position: fixed; top: 0; left: 0; height: 3px; width: 0;
        background: linear-gradient(90deg, var(--tg-green), var(--tg-mint), var(--tg-orange));
        z-index: 2000; transition: width .1s linear; box-shadow: 0 0 12px rgba(127,224,205,.6);
    }

    /* ===== KEYFRAMES ===== */
    @keyframes tgGradient { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }
    @keyframes tgFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-18px)} }
    @keyframes tgFloatSlow { 0%,100%{transform:translateY(0) rotate(-3deg)} 50%{transform:translateY(-22px) rotate(-3deg)} }
    @keyframes tgPulse { 0%,100%{transform:scale(1);opacity:.5} 50%{transform:scale(1.18);opacity:.8} }
    @keyframes tgSpinSlow { from{transform:rotate(0)} to{transform:rotate(360deg)} }
    @keyframes tgShimmer { to { background-position: 200% center; } }
    @keyframes tgBob { 0%,100%{transform:translate(-50%,0)} 50%{transform:translate(-50%,10px)} }
    @keyframes tgParticle { 0%{transform:translateY(10px) scale(.6);opacity:0} 12%{opacity:.7} 88%{opacity:.7} 100%{transform:translateY(-160px) scale(1);opacity:0} }
    @keyframes tgMarquee { to { transform: translateX(-50%); } }
    @keyframes tgWiggle { 0%,100%{transform:rotate(0)} 25%{transform:rotate(-7deg)} 75%{transform:rotate(7deg)} }

    /* ===== SCROLL REVEAL ===== */
    .reveal { opacity: 0; transition: opacity .8s cubic-bezier(.2,.7,.2,1), transform .8s cubic-bezier(.2,.7,.2,1), filter .8s ease; will-change: opacity, transform; }
    .reveal.r-up    { transform: translateY(46px); }
    .reveal.r-down  { transform: translateY(-46px); }
    .reveal.r-left  { transform: translateX(-54px); }
    .reveal.r-right { transform: translateX(54px); }
    .reveal.r-zoom  { transform: scale(.9); }
    .reveal.r-blur  { filter: blur(14px); transform: translateY(20px); }
    .reveal.in { opacity: 1; transform: none; filter: none; }
    .d1{transition-delay:.08s}.d2{transition-delay:.18s}.d3{transition-delay:.28s}
    .d4{transition-delay:.38s}.d5{transition-delay:.48s}.d6{transition-delay:.58s}

    /* ===== HERO ===== */
    .tg-hero {
        position: relative; overflow: hidden; color: #fff; padding: 130px 0 150px;
        background: linear-gradient(120deg, #0f2421, #16302d, #1f4f47, #2d8f7f, #16302d);
        background-size: 300% 300%; animation: tgGradient 16s ease infinite;
    }
    .tg-hero::before { /* fine grid overlay */
        content:""; position:absolute; inset:0; z-index:0; opacity:.4;
        background-image: linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
        background-size: 46px 46px;
        mask-image: radial-gradient(ellipse 80% 60% at 50% 40%, #000 40%, transparent 80%);
        -webkit-mask-image: radial-gradient(ellipse 80% 60% at 50% 40%, #000 40%, transparent 80%);
    }
    .tg-blob { position:absolute; border-radius:50%; filter: blur(8px); z-index:0; }
    .tg-blob.b1 { width:440px;height:440px; top:-140px; right:-70px; background:radial-gradient(circle,#45b4a1 0%,transparent 70%); animation:tgPulse 9s ease-in-out infinite; }
    .tg-blob.b2 { width:320px;height:320px; bottom:-130px; left:-90px; background:radial-gradient(circle,#ff8c42 0%,transparent 70%); opacity:.5; animation:tgPulse 11s ease-in-out infinite; }
    .tg-blob.b3 { width:220px;height:220px; top:38%; left:40%; background:radial-gradient(circle,#7fe0cd 0%,transparent 70%); opacity:.35; animation:tgPulse 7s ease-in-out infinite; }
    .tg-particles { position:absolute; inset:0; z-index:1; pointer-events:none; overflow:hidden; }
    .tg-particle { position:absolute; bottom:-10px; border-radius:50%; background:rgba(255,255,255,.55); animation: tgParticle linear infinite; }
    .tg-hero .container { position: relative; z-index: 2; }

    .tg-chip {
        display:inline-flex; align-items:center; gap:8px;
        background: rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.22);
        backdrop-filter: blur(8px); padding:8px 18px; border-radius:30px;
        font-size:.85rem; font-weight:600; margin-bottom:24px;
    }
    .tg-chip .dot { width:8px;height:8px;border-radius:50%; background:var(--tg-mint); box-shadow:0 0 0 0 rgba(127,224,205,.7); animation: tgPing 2s ease-out infinite; }
    @keyframes tgPing { 0%{box-shadow:0 0 0 0 rgba(127,224,205,.6)} 70%{box-shadow:0 0 0 10px rgba(127,224,205,0)} 100%{box-shadow:0 0 0 0 rgba(127,224,205,0)} }

    .tg-hero h1 { font-size: 4.7rem; font-weight: 800; letter-spacing:-2px; line-height:1.02; margin-bottom:18px; }
    .tg-grad-text {
        background: linear-gradient(90deg,#7fe0cd,#ffd6a5,#ff8c42,#7fe0cd);
        background-size: 200% auto; -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;
        animation: tgShimmer 4.5s linear infinite;
    }
    .tg-hero .subtag { font-size:1.08rem; opacity:.78; max-width:520px; line-height:1.7; }

    .tg-btn-glow {
        position:relative; overflow:hidden; background:#fff; color:var(--tg-dark); font-weight:700; border:none;
        padding:15px 34px; border-radius:40px; transition:all .3s; box-shadow:0 10px 30px rgba(127,224,205,.35);
    }
    .tg-btn-glow::after { content:""; position:absolute; top:0; left:-130%; width:55%; height:100%;
        background:linear-gradient(120deg, transparent, rgba(255,255,255,.7), transparent); transform:skewX(-22deg); transition:left .6s ease; }
    .tg-btn-glow:hover { transform:translateY(-3px); box-shadow:0 18px 44px rgba(127,224,205,.55); color:var(--tg-green); }
    .tg-btn-glow:hover::after { left:150%; }
    .tg-btn-ghost {
        background:rgba(255,255,255,.07); color:#fff; font-weight:600; border:1px solid rgba(255,255,255,.35);
        padding:15px 34px; border-radius:40px; transition:all .3s; backdrop-filter:blur(6px);
    }
    .tg-btn-ghost:hover { background:rgba(255,255,255,.18); color:#fff; transform:translateY(-3px); }

    /* hero floating preview cards */
    .tg-hero-visual { position: relative; height: 470px; perspective: 1000px; }
    .tg-float-card {
        position:absolute; background:#fff; color:#2b3a36; border-radius:18px; padding:18px;
        box-shadow:0 20px 50px rgba(0,0,0,.32); width:255px; transform-style:preserve-3d; transition:box-shadow .3s;
    }
    .tg-float-card .fc-top { display:flex; align-items:center; gap:10px; margin-bottom:10px; }
    .tg-float-card .fc-ic { width:40px;height:40px;border-radius:12px; display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem; }
    .tg-float-card h6 { margin:0; font-weight:700; font-size:.95rem; }
    .tg-float-card small { color:#9aa6a0; }
    .tg-float-card .fc-tag { display:inline-block; font-size:.7rem; font-weight:700; padding:3px 10px; border-radius:20px; margin-top:6px; }
    .fc1 { top:18px; right:30px; animation: tgFloat 6s ease-in-out infinite; }
    .fc2 { top:185px; right:140px; animation: tgFloatSlow 7s ease-in-out infinite; z-index:3; }
    .fc3 { top:312px; right:10px; animation: tgFloat 8s ease-in-out infinite; }
    .tg-ring { position:absolute; border:2px dashed rgba(255,255,255,.22); border-radius:50%; }
    .tg-ring.r1 { width:360px;height:360px; top:55px; right:55px; animation:tgSpinSlow 40s linear infinite; }
    .tg-ring.r2 { width:240px;height:240px; top:115px; right:115px; animation:tgSpinSlow 28s linear infinite reverse; }

    .tg-scroll-cue { position:absolute; bottom:26px; left:50%; transform:translateX(-50%); z-index:2;
        color:rgba(255,255,255,.7); font-size:.72rem; font-weight:600; text-align:center; animation:tgBob 1.9s ease-in-out infinite; }
    .tg-scroll-cue .mouse { width:24px;height:38px;border:2px solid rgba(255,255,255,.5); border-radius:14px; margin:0 auto 6px; position:relative; }
    .tg-scroll-cue .mouse::after { content:""; position:absolute; top:7px; left:50%; transform:translateX(-50%); width:4px;height:7px;border-radius:3px; background:#fff; animation:tgWheel 1.6s ease-in-out infinite; }
    @keyframes tgWheel { 0%{opacity:0;top:7px} 40%{opacity:1} 80%{opacity:0;top:16px} 100%{opacity:0} }

    /* ===== MARQUEE RIBBON ===== */
    .tg-marquee { background: var(--tg-dark); padding:14px 0; overflow:hidden; position:relative; }
    .tg-marquee::before, .tg-marquee::after { content:""; position:absolute; top:0; width:90px; height:100%; z-index:2; }
    .tg-marquee::before { left:0; background:linear-gradient(90deg, var(--tg-dark), transparent); }
    .tg-marquee::after { right:0; background:linear-gradient(270deg, var(--tg-dark), transparent); }
    .tg-marquee-track { display:flex; gap:18px; width:max-content; animation: tgMarquee 24s linear infinite; }
    .tg-marquee:hover .tg-marquee-track { animation-play-state: paused; }
    .tg-marquee-item { color:rgba(255,255,255,.78); font-weight:700; font-size:.95rem; display:inline-flex; align-items:center; gap:18px; white-space:nowrap; }
    .tg-marquee-item i { color:var(--tg-mint); font-size:.6rem; }

    /* ===== STAT STRIP ===== */
    .tg-statstrip { background: var(--tg-dark); }
    .tg-statstrip .inner {
        background: linear-gradient(135deg,#2d8f7f,#1f4f47); border-radius:24px; margin-top:-66px; position:relative; z-index:5;
        padding:40px 20px; box-shadow:0 30px 60px rgba(0,0,0,.25); overflow:hidden;
    }
    .tg-statstrip .inner::after { content:""; position:absolute; width:300px;height:300px;border-radius:50%; top:-150px; right:-80px; background:radial-gradient(circle, rgba(127,224,205,.25), transparent 70%); }
    .tg-stat-item { text-align:center; padding:10px; position:relative; z-index:1; transition: transform .3s; }
    .tg-stat-item:hover { transform: translateY(-6px); }
    .tg-stat-item .num { font-size:2.7rem; font-weight:800; line-height:1; }
    .tg-stat-item .num .suf { color:var(--tg-mint); }
    .tg-stat-item .lbl { font-size:.85rem; opacity:.82; margin-top:8px; }
    .tg-stat-divider { border-right:1px solid rgba(255,255,255,.15); }

    /* ===== SECTIONS ===== */
    .tg-section { padding: 96px 0; position:relative; overflow:hidden; }
    .tg-orb { position:absolute; border-radius:50%; filter:blur(70px); z-index:0; pointer-events:none; }
    .tg-section .container { position:relative; z-index:1; }
    .tg-eyebrow {
        display:inline-block; text-transform:uppercase; letter-spacing:2px; font-size:.78rem;
        font-weight:800; color:var(--tg-green); margin-bottom:12px; background:#e3f3ee; padding:6px 16px; border-radius:20px;
    }
    .tg-heading { font-size:2.7rem; font-weight:800; color:var(--tg-dark); margin-bottom:14px; letter-spacing:-1px; }
    .tg-sub { color:#6b7770; font-size:1.05rem; max-width:640px; margin:0 auto; }

    /* PROBLEM */
    .tg-problem-card {
        background:#fff; border-radius:22px; padding:40px; height:100%; box-shadow:0 10px 40px rgba(0,0,0,.06);
        position:relative; overflow:hidden; transition:transform .3s, box-shadow .3s;
    }
    .tg-problem-card:hover { transform:translateY(-10px); box-shadow:0 26px 60px rgba(0,0,0,.13); }
    .tg-problem-card::after { content:""; position:absolute; top:0;left:0; width:100%; height:6px; background:linear-gradient(90deg,var(--tg-orange),var(--tg-coral)); }
    .tg-problem-card.green::after { background:linear-gradient(90deg,var(--tg-green),var(--tg-mint)); }
    .tg-problem-card .stat { font-size:4.2rem; font-weight:800; line-height:1;
        background:linear-gradient(135deg,var(--tg-orange),var(--tg-coral)); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .tg-problem-card.green .stat { background:linear-gradient(135deg,var(--tg-green),var(--tg-light)); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .tg-problem-card .stat-label { font-size:1.05rem; color:#3c4a45; margin:14px 0 16px; font-weight:600; }
    .tg-problem-card .stat-desc { color:#6b7770; line-height:1.7; }
    .tg-problem-card .src { font-size:.78rem; color:#aab2ac; margin-top:18px; font-style:italic; }
    .tg-pill { display:inline-block; background:#ffe9d9; color:#d9651f; font-size:.72rem; font-weight:800; letter-spacing:1px; padding:6px 14px; border-radius:20px; margin-bottom:18px; }
    .tg-problem-card.green .tg-pill { background:#d8f0e9; color:var(--tg-green); }

    /* SOLUTION */
    .tg-solution { background: var(--tg-cream); }
    .tg-feature-block { background:#fff; border-radius:24px; overflow:hidden; height:100%; box-shadow:0 10px 40px rgba(0,0,0,.07); transition:transform .35s, box-shadow .35s; }
    .tg-feature-block:hover { transform:translateY(-10px); box-shadow:0 28px 64px rgba(0,0,0,.14); }
    .tg-feature-block .head { padding:32px 36px; color:#fff; position:relative; overflow:hidden; }
    .tg-feature-block .head.food  { background:linear-gradient(135deg,#ff8c42,#ff6f5e); }
    .tg-feature-block .head.skill { background:linear-gradient(135deg,#2d8f7f,#45b4a1); }
    .tg-feature-block .head h3 { font-weight:800; margin:0; font-size:1.65rem; position:relative; z-index:1; }
    .tg-feature-block .head i.big { position:absolute; right:24px; top:50%; transform:translateY(-50%); font-size:4.6rem; opacity:.18; transition:transform .4s; }
    .tg-feature-block:hover .head i.big { transform:translateY(-50%) rotate(-10deg) scale(1.1); }
    .tg-feature-block .body { padding:30px 36px; }
    .tg-step { display:flex; align-items:center; gap:14px; padding:14px 0; border-bottom:1px dashed #e6e9e4; }
    .tg-step:last-child { border-bottom:none; }
    .tg-step .n { flex:0 0 30px; width:30px;height:30px; border-radius:50%; background:var(--tg-cream); color:var(--tg-dark); font-weight:800;
        display:flex; align-items:center; justify-content:center; font-size:.85rem; transition:all .3s; }
    .tg-feature-block:hover .tg-step .n { background:var(--tg-mint); transform:scale(1.1); }

    /* HOW */
    .tg-how-step { text-align:center; padding:0 14px; }
    .tg-how-circle { width:88px;height:88px; border-radius:26px; margin:0 auto 22px; display:flex; align-items:center; justify-content:center;
        font-size:1.8rem; font-weight:800; color:#fff; box-shadow:0 14px 30px rgba(0,0,0,.15); transition:transform .35s; }
    .tg-how-step:hover .tg-how-circle { transform:translateY(-8px) rotate(-8deg) scale(1.06); }
    .tg-how-step:nth-child(1) .tg-how-circle { background:linear-gradient(135deg,#ff8c42,#ff6f5e); }
    .tg-how-step:nth-child(3) .tg-how-circle { background:linear-gradient(135deg,#2d8f7f,#45b4a1); }
    .tg-how-step:nth-child(5) .tg-how-circle { background:linear-gradient(135deg,#e0a800,#ffc63d); }
    .tg-how-step h5 { font-weight:700; color:var(--tg-dark); }
    .tg-how-arrow { display:flex; align-items:center; justify-content:center; color:#c5cdc7; font-size:1.6rem; }
    .tg-how-arrow i { animation: tgArrow 1.8s ease-in-out infinite; }
    @keyframes tgArrow { 0%,100%{transform:translateX(0);opacity:.6} 50%{transform:translateX(6px);opacity:1} }
    .tg-result-banner { background:linear-gradient(135deg,#16302d,#2d8f7f); color:#fff; border-radius:18px;
        padding:28px 32px; text-align:center; font-size:1.18rem; font-weight:600; margin-top:56px; box-shadow:0 16px 40px rgba(45,143,127,.3); }

    /* FEATURES + tilt cards */
    .tg-feat-card { background:#fff; border-radius:20px; padding:32px; height:100%; box-shadow:0 6px 24px rgba(0,0,0,.05);
        transition:box-shadow .3s; border:1px solid #eef1ec; position:relative; overflow:hidden; transform-style:preserve-3d; }
    .tg-feat-card::before { content:""; position:absolute; right:-40px; top:-40px; width:120px; height:120px; border-radius:50%;
        background:linear-gradient(135deg,#e3f3ee,transparent); transition:transform .4s; }
    .tg-feat-card:hover { box-shadow:0 22px 48px rgba(0,0,0,.12); }
    .tg-feat-card:hover::before { transform:scale(1.7); }
    .tg-feat-icon { width:60px;height:60px; border-radius:16px; margin-bottom:20px; position:relative; z-index:1; transform: translateZ(30px);
        display:flex; align-items:center; justify-content:center; font-size:1.5rem; color:#fff;
        background:linear-gradient(135deg,var(--tg-green),var(--tg-light)); box-shadow:0 8px 20px rgba(45,143,127,.35); transition: transform .3s; }
    .tg-feat-card:hover .tg-feat-icon { animation: tgWiggle .6s ease; }
    .tg-feat-card:nth-child(even) .tg-feat-icon { background:linear-gradient(135deg,var(--tg-orange),var(--tg-coral)); box-shadow:0 8px 20px rgba(255,140,66,.35); }
    .tg-feat-card h5 { font-weight:700; color:var(--tg-dark); position:relative; z-index:1; }
    .tg-feat-card p { color:#6b7770; margin:0; font-size:.95rem; position:relative; z-index:1; }

    /* USERS */
    .tg-users { background:var(--tg-cream); }
    .tg-user-card { background:#fff; border-radius:16px; padding:24px; height:100%; box-shadow:0 6px 24px rgba(0,0,0,.05);
        display:flex; gap:16px; align-items:flex-start; transition:transform .3s, box-shadow .3s; border:1px solid #eef1ec; }
    .tg-user-card:hover { transform:translateY(-8px); box-shadow:0 20px 44px rgba(0,0,0,.1); }
    .tg-user-ic { flex:0 0 50px; width:50px;height:50px; border-radius:14px; display:flex; align-items:center; justify-content:center;
        color:#fff; font-size:1.15rem; background:linear-gradient(135deg,var(--tg-green),var(--tg-light)); transition:transform .3s; }
    .tg-user-card:hover .tg-user-ic { transform:rotate(-8deg) scale(1.08); }
    .tg-user-card h6 { font-weight:700; margin-bottom:4px; color:var(--tg-dark); }
    .tg-user-card p { margin:0; font-size:.88rem; color:#6b7770; }

    /* IMPACT */
    .tg-impact { position:relative; overflow:hidden; background:linear-gradient(135deg,#0f2421,#16302d); color:#fff; }
    .tg-impact .tg-eyebrow { color:var(--tg-mint); background:rgba(127,224,205,.12); }
    .tg-impact .tg-heading { color:#fff; }
    .tg-impact .tg-sub { color:rgba(255,255,255,.7); }
    .tg-impact-card { background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1); border-radius:18px; padding:30px; height:100%;
        transition:transform .35s, background .35s, border-color .35s; }
    .tg-impact-card:hover { transform:translateY(-10px); background:rgba(255,255,255,.1); border-color:rgba(127,224,205,.4); }
    .tg-impact-card .sdg { color:var(--tg-mint); font-weight:700; font-size:.82rem; margin-bottom:10px; }
    .tg-impact-card h5 { font-weight:700; }
    .tg-impact-card p { color:rgba(255,255,255,.72); margin:0; font-size:.92rem; line-height:1.7; }
    .tg-impact-ic { width:58px;height:58px;border-radius:16px; display:flex;align-items:center;justify-content:center; font-size:1.5rem; color:#fff; margin-bottom:16px;
        background:linear-gradient(135deg,var(--tg-orange),var(--tg-coral)); transition:transform .3s; }
    .tg-impact-card:hover .tg-impact-ic { transform:rotate(8deg) scale(1.08); }

    /* VISION */
    .tg-vision { position:relative; overflow:hidden; color:#fff; text-align:center; padding:110px 0;
        background:linear-gradient(120deg,#2d8f7f,#45b4a1,#7fe0cd,#2d8f7f); background-size:300% 300%; animation:tgGradient 14s ease infinite; }
    .tg-vision h2 { font-size:3rem; font-weight:800; max-width:840px; margin:0 auto 22px; line-height:1.18; letter-spacing:-1px; }
    .tg-vision p { font-size:1.12rem; opacity:.94; max-width:640px; margin:0 auto 32px; }

    @media (max-width: 991px) { .tg-hero-visual { display:none; } .tg-hero { padding:96px 0 110px; } }
    @media (max-width: 768px) {
        .tg-hero h1 { font-size:2.9rem; }
        .tg-heading { font-size:2rem; }
        .tg-vision h2 { font-size:2.1rem; }
        .tg-how-arrow { display:none; }
        .tg-stat-divider { border-right:none; }
    }

    /* ===== ACCESSIBILITY: reduced motion ===== */
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation-duration:.001ms !important; animation-iteration-count:1 !important; transition-duration:.01ms !important; }
        .reveal { opacity:1 !important; transform:none !important; filter:none !important; }
        .tg-particles { display:none; }
    }
</style>
@endsection

@section('content')

<div class="tg-progress" id="tgProgress"></div>

{{-- ============ HERO ============ --}}
<section class="tg-hero">
    <span class="tg-blob b1"></span>
    <span class="tg-blob b2"></span>
    <span class="tg-blob b3"></span>
    <div class="tg-particles" id="tgParticles"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="tg-chip reveal r-down"><span class="dot"></span> {{ __('app.welcome.hero_chip') }}</span>
                <h1 class="reveal r-up d1">{{ __('app.welcome.hero_l1') }}<br>{{ __('app.welcome.hero_l2') }}<br><span class="tg-grad-text">{{ __('app.welcome.hero_l3') }}</span></h1>
                <p class="subtag reveal r-up d2">{{ __('app.welcome.hero_subtag') }}</p>

                <div class="mt-4 d-flex flex-wrap gap-2 reveal r-up d3">
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
                    <span class="tg-ring r2"></span>

                    <div class="tg-float-card fc1" data-tilt>
                        <div class="fc-top">
                            <div class="fc-ic" style="background:linear-gradient(135deg,#ff8c42,#ff6f5e)"><i class="fas fa-utensils"></i></div>
                            <div><h6>{{ __('app.welcome.fc1_title') }}</h6><small>{{ __('app.welcome.fc1_meta') }}</small></div>
                        </div>
                        <span class="fc-tag" style="background:#ffe9d9;color:#d9651f">{{ __('app.welcome.fc1_tag') }}</span>
                    </div>

                    <div class="tg-float-card fc2" data-tilt>
                        <div class="fc-top">
                            <div class="fc-ic" style="background:linear-gradient(135deg,#2d8f7f,#45b4a1)"><i class="fas fa-lightbulb"></i></div>
                            <div><h6>{{ __('app.welcome.fc2_title') }}</h6><small>{{ __('app.welcome.fc2_meta') }}</small></div>
                        </div>
                        <span class="fc-tag" style="background:#d8f0e9;color:#2d8f7f">{{ __('app.welcome.fc2_tag') }}</span>
                    </div>

                    <div class="tg-float-card fc3" data-tilt>
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

    <div class="tg-scroll-cue">
        <div class="mouse"></div>
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

{{-- ============ MARQUEE RIBBON ============ --}}
<div class="tg-marquee">
    @php
        $ribbon = [
            ['fa-utensils', __('app.welcome.sol_food_title')],
            ['fa-lightbulb', __('app.welcome.sol_skill_title')],
            ['fa-location-dot', __('app.welcome.feat1_title')],
            ['fa-comments', __('app.welcome.feat3_title')],
            ['fa-star', __('app.welcome.feat4_title')],
            ['fa-heart', __('app.welcome.feat6_title')],
        ];
    @endphp
    <div class="tg-marquee-track">
        @for ($r = 0; $r < 2; $r++)
            @foreach ($ribbon as $item)
                <span class="tg-marquee-item"><i class="fas {{ $item[0] }}" style="font-size:.95rem;"></i> {{ $item[1] }} <i class="fas fa-circle"></i></span>
            @endforeach
        @endfor
    </div>
</div>

{{-- ============ STAT STRIP ============ --}}
<section class="tg-statstrip">
    <div class="container">
        <div class="inner reveal r-up">
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
    <span class="tg-orb" style="width:340px;height:340px;background:rgba(255,140,66,.12);top:60px;left:-120px;"></span>
    <div class="container">
        <div class="text-center mb-5 reveal r-up">
            <span class="tg-eyebrow">{{ __('app.welcome.problem_eyebrow') }}</span>
            <h2 class="tg-heading">{{ __('app.welcome.problem_title') }}</h2>
            <p class="tg-sub">{{ __('app.welcome.problem_sub') }}</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 reveal r-left d1">
                <div class="tg-problem-card">
                    <span class="tg-pill">{{ __('app.welcome.problem1_pill') }}</span>
                    <div class="stat">130 kg</div>
                    <div class="stat-label">{{ __('app.welcome.problem1_label') }}</div>
                    <p class="stat-desc">{{ __('app.welcome.problem1_desc') }}</p>
                    <div class="src">{{ __('app.welcome.problem1_src') }}</div>
                </div>
            </div>
            <div class="col-md-6 reveal r-right d2">
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
        <div class="text-center mb-5 reveal r-up">
            <span class="tg-eyebrow">{{ __('app.welcome.solution_eyebrow') }}</span>
            <h2 class="tg-heading">{{ __('app.welcome.solution_title') }}</h2>
            <p class="tg-sub">{{ __('app.welcome.solution_sub') }}</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-6 reveal r-left d1">
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
            <div class="col-lg-6 reveal r-right d2">
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

{{-- ============ RECENT COMMUNITY POSTS ============ --}}
<section class="tg-section tg-solution">
    <div class="container">
        <div class="text-center mb-5 reveal r-up">
            <span class="tg-eyebrow">Community Feed</span>
            <h2 class="tg-heading">Explore What's Available Now</h2>
            <p class="tg-sub">Browse food and skills being shared in your community</p>
        </div>

        <div class="row g-3">
            @forelse ($recentFoodPosts as $post)
                <div class="col-md-6 col-lg-4 reveal r-up">
                    <a href="{{ route('food.public-show', $post) }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm" style="transition:all .3s;cursor:pointer;">
                            @if ($post->image)
                                <img src="{{ asset('storage/'.$post->image) }}" class="card-img-top" style="height:200px;object-fit:cover;" alt="{{ $post->title }}">
                            @else
                                <div style="height:200px;background:linear-gradient(135deg,#ff8c42,#ff6f5e);display:flex;align-items:center;justify-content:center;color:#fff;font-size:3rem;"><i class="fas fa-utensils"></i></div>
                            @endif
                            <div class="card-body">
                                <div class="badge bg-warning text-dark mb-2">Food</div>
                                <h6 class="fw-bold">{{ $post->title }}</h6>
                                <small class="text-muted d-block mb-3">{{ $post->neighborhood }}</small>
                                <small class="text-muted"><i class="fas fa-clock"></i> Expires {{ $post->expires_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No food posts available yet</p>
                </div>
            @endforelse

            @forelse ($recentSkillPosts as $post)
                <div class="col-md-6 col-lg-4 reveal r-up">
                    <a href="{{ route('skills.public-show', $post) }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm" style="transition:all .3s;cursor:pointer;">
                            @if ($post->image)
                                <img src="{{ asset('storage/'.$post->image) }}" class="card-img-top" style="height:200px;object-fit:cover;" alt="{{ $post->title }}">
                            @else
                                <div style="height:200px;background:linear-gradient(135deg,#2d8f7f,#45b4a1);display:flex;align-items:center;justify-content:center;color:#fff;font-size:3rem;"><i class="fas fa-lightbulb"></i></div>
                            @endif
                            <div class="card-body">
                                <div class="badge bg-success mb-2">{{ $post->category }}</div>
                                <h6 class="fw-bold">{{ $post->title }}</h6>
                                <small class="text-muted d-block mb-3">{{ $post->neighborhood }}</small>
                                <small class="text-muted"><i class="fas fa-star"></i> {{ ucfirst($post->skill_level) }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No skill posts available yet</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ============ HOW IT WORKS ============ --}}
<section class="tg-section">
    <span class="tg-orb" style="width:300px;height:300px;background:rgba(45,143,127,.1);bottom:0;right:-100px;"></span>
    <div class="container">
        <div class="text-center mb-5 reveal r-up">
            <span class="tg-eyebrow">{{ __('app.welcome.how_eyebrow') }}</span>
            <h2 class="tg-heading">{{ __('app.welcome.how_title') }}</h2>
            <p class="tg-sub">{{ __('app.welcome.how_sub') }}</p>
        </div>
        <div class="row align-items-start">
            <div class="col-md tg-how-step reveal r-up d1">
                <div class="tg-how-circle">01</div>
                <h5>{{ __('app.welcome.how1_title') }}</h5>
                <p class="text-muted">{{ __('app.welcome.how1_desc') }}</p>
            </div>
            <div class="col-md-auto tg-how-arrow reveal r-zoom d2"><i class="fas fa-arrow-right"></i></div>
            <div class="col-md tg-how-step reveal r-up d3">
                <div class="tg-how-circle">02</div>
                <h5>{{ __('app.welcome.how2_title') }}</h5>
                <p class="text-muted">{{ __('app.welcome.how2_desc') }}</p>
            </div>
            <div class="col-md-auto tg-how-arrow reveal r-zoom d4"><i class="fas fa-arrow-right"></i></div>
            <div class="col-md tg-how-step reveal r-up d5">
                <div class="tg-how-circle">03</div>
                <h5>{{ __('app.welcome.how3_title') }}</h5>
                <p class="text-muted">{{ __('app.welcome.how3_desc') }}</p>
            </div>
        </div>
        <div class="tg-result-banner reveal r-zoom d2">
            <i class="fas fa-seedling me-2"></i>
            {{ __('app.welcome.how_result') }}
        </div>
    </div>
</section>

{{-- ============ KEY FEATURES ============ --}}
<section class="tg-section tg-solution">
    <div class="container">
        <div class="text-center mb-5 reveal r-up">
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
                <div class="col-md-6 col-lg-4 reveal r-up d{{ ($i % 3) + 1 }}">
                    <div class="tg-feat-card" data-tilt>
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
        <div class="text-center mb-5 reveal r-up">
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
                <div class="col-md-6 col-lg-4 reveal {{ $i % 2 === 0 ? 'r-left' : 'r-right' }} d{{ ($i % 3) + 1 }}">
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
    <div class="tg-particles" id="tgParticles2"></div>
    <div class="container" style="position:relative;z-index:2">
        <div class="text-center mb-5 reveal r-up">
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
                <div class="col-md-6 col-lg-3 reveal r-up d{{ $i + 1 }}">
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
    <div class="tg-particles" id="tgParticles3"></div>
    <div class="container reveal r-zoom" style="position:relative;z-index:2">
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
(function () {
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // ----- Scroll progress bar -----
    const bar = document.getElementById('tgProgress');
    function onScroll() {
        const h = document.documentElement;
        const scrolled = (h.scrollTop) / (h.scrollHeight - h.clientHeight);
        bar.style.width = Math.min(scrolled * 100, 100) + '%';
    }
    document.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    // ----- Scroll reveal (directional + stagger) -----
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
    }, { threshold: 0.12 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));

    // ----- Animated number counters -----
    function animateCount(el) {
        const target = parseInt(el.getAttribute('data-count'), 10);
        const suffix = el.querySelector('.suf') ? el.querySelector('.suf').outerHTML : '';
        const dur = 1500, start = performance.now();
        function tick(now) {
            const p = Math.min((now - start) / dur, 1);
            const eased = 1 - Math.pow(1 - p, 3); // easeOutCubic
            el.innerHTML = Math.floor(eased * target) + suffix;
            if (p < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }
    const counterIO = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { animateCount(e.target); counterIO.unobserve(e.target); } });
    }, { threshold: 0.5 });
    document.querySelectorAll('.num[data-count]').forEach(el => counterIO.observe(el));

    if (reduce) return; // skip heavy motion for users who prefer reduced motion

    // ----- Floating particles -----
    function spawnParticles(id, count) {
        const host = document.getElementById(id);
        if (!host) return;
        for (let i = 0; i < count; i++) {
            const p = document.createElement('span');
            p.className = 'tg-particle';
            const size = 3 + Math.random() * 6;
            p.style.width = size + 'px';
            p.style.height = size + 'px';
            p.style.left = (Math.random() * 100) + '%';
            p.style.animationDuration = (7 + Math.random() * 9) + 's';
            p.style.animationDelay = (-Math.random() * 12) + 's';
            p.style.opacity = (0.2 + Math.random() * 0.5).toFixed(2);
            host.appendChild(p);
        }
    }
    spawnParticles('tgParticles', 26);
    spawnParticles('tgParticles2', 18);
    spawnParticles('tgParticles3', 18);

    // ----- 3D tilt on cards -----
    const tiltEls = document.querySelectorAll('[data-tilt]');
    tiltEls.forEach(el => {
        el.style.transition = 'transform .15s ease';
        el.addEventListener('mousemove', (e) => {
            const r = el.getBoundingClientRect();
            const px = (e.clientX - r.left) / r.width - 0.5;
            const py = (e.clientY - r.top) / r.height - 0.5;
            el.style.transform = `perspective(700px) rotateY(${px * 10}deg) rotateX(${-py * 10}deg) translateY(-4px)`;
        });
        el.addEventListener('mouseleave', () => { el.style.transform = ''; });
    });
})();
</script>
@endsection
