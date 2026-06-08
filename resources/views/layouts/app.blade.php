<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Togetherly</title>

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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

        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', Tahoma, sans-serif;
            background-color: var(--tg-cream);
            color: #2b3a36;
        }

        /* ===== NAVBAR ===== */
        .tg-navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 2px 20px rgba(0,0,0,0.04);
            padding: 12px 0;
        }
        .tg-navbar .container {
            display: flex; align-items: center; justify-content: space-between;
        }
        .tg-navbar .navbar-brand {
            font-weight: 800; font-size: 1.25rem; color: var(--tg-dark) !important;
            display: flex; align-items: center; gap: 8px; flex-shrink: 0;
            margin: 0;
        }
        .tg-logo-mark {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--tg-green), var(--tg-light));
            display: inline-flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 800; font-size: 1.1rem;
            box-shadow: 0 6px 16px rgba(45,143,127,0.35);
        }
        .tg-nav-center {
            display: flex; align-items: center; justify-content: center; gap: 2px; flex: 1;
            margin: 0 30px;
        }
        .tg-navbar .nav-link {
            color: #5a6b66 !important; font-weight: 500; font-size: .85rem;
            padding: 6px 10px !important; border-radius: 6px; transition: all .2s;
            white-space: nowrap; display: inline-flex; align-items: center; gap: 5px;
        }
        .tg-navbar .nav-link i {
            font-size: 0.95rem;
        }
        .tg-navbar .nav-link:hover { color: var(--tg-green) !important; background: rgba(45,143,127,0.08); }
        .tg-navbar .nav-link.active { color: var(--tg-green) !important; background: rgba(45,143,127,0.12); font-weight: 600; }
        .tg-nav-divider { width: 1px; height: 20px; background: rgba(0,0,0,0.08); margin: 0 8px; }
        .tg-nav-right {
            display: flex; align-items: center; gap: 8px; flex-shrink: 0;
        }
        .tg-search-compact {
            display: none;
        }
        @media (max-width: 1200px) {
            .tg-nav-center { margin: 0 15px; gap: 0px; }
            .tg-navbar .nav-link { padding: 5px 8px !important; font-size: .8rem; }
            .tg-nav-divider { margin: 0 6px; }
        }
        .tg-nav-badge {
            position: absolute; top: -3px; right: -3px; background: var(--tg-coral);
            color: #fff; font-size: .55rem; font-weight: 700; border-radius: 8px;
            padding: 2px 4px; line-height: 1; min-width: 16px; text-align: center;
        }
        .tg-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--tg-orange), var(--tg-coral));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .9rem; box-shadow: 0 4px 12px rgba(255,140,66,.35);
        }
        .tg-btn-pill {
            background: linear-gradient(135deg, var(--tg-green), var(--tg-light));
            color: #fff !important; font-weight: 700; border: none;
            padding: 9px 22px; border-radius: 30px; transition: all .25s;
            box-shadow: 0 6px 18px rgba(45,143,127,.3);
        }
        .tg-btn-pill:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(45,143,127,.45); color:#fff; }

        /* ===== GLOBAL BUTTONS ===== */
        .btn-primary {
            background: linear-gradient(135deg, var(--tg-green), var(--tg-light));
            border: none; font-weight: 600; border-radius: 12px; padding: 10px 22px;
            box-shadow: 0 6px 16px rgba(45,143,127,.25); transition: all .25s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 22px rgba(45,143,127,.4);
            background: linear-gradient(135deg, #28806f, var(--tg-green)); }
        .btn-secondary {
            background: linear-gradient(135deg, var(--tg-orange), var(--tg-coral));
            border: none; font-weight: 600; border-radius: 12px; padding: 10px 22px;
            box-shadow: 0 6px 16px rgba(255,140,66,.25); transition: all .25s;
        }
        .btn-secondary:hover { transform: translateY(-2px); box-shadow: 0 10px 22px rgba(255,140,66,.4);
            background: linear-gradient(135deg, #f57a2e, var(--tg-orange)); }
        .btn-outline-primary { border: 2px solid var(--tg-green); color: var(--tg-green); font-weight: 600; border-radius: 12px; }
        .btn-outline-primary:hover { background: var(--tg-green); border-color: var(--tg-green); }
        .btn-danger { border-radius: 12px; font-weight: 600; }

        /* ===== CARDS / FORMS ===== */
        .card { border: none; border-radius: 18px; box-shadow: 0 6px 24px rgba(0,0,0,0.06); }
        .form-control, .form-select {
            border-radius: 12px; border: 1.5px solid #e2e8e4; padding: 11px 14px; font-size: .95rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--tg-light); box-shadow: 0 0 0 .2rem rgba(69,180,161,.18);
        }
        .form-label { font-weight: 600; color: #3c4a45; font-size: .9rem; }

        .badge.bg-warning { background: linear-gradient(135deg, var(--tg-orange), var(--tg-coral)) !important; color:#fff !important; }
        .badge.bg-success { background: linear-gradient(135deg, var(--tg-green), var(--tg-light)) !important; }
        .badge.bg-info { background: #e3f3ee !important; color: var(--tg-green) !important; }
        .badge.bg-primary { background: var(--tg-green) !important; }

        .section-title { color: var(--tg-dark); font-weight: 800; letter-spacing: -.5px; }

        /* ===== ALERTS ===== */
        .alert { border: none; border-radius: 14px; font-weight: 500; }
        .alert-success { background: #d8f0e9; color: #1c6b5b; }
        .alert-danger { background: #fde2e0; color: #a33; }
        .alert-info { background: #e3f3ee; color: #2d6b5f; }

        /* ===== FOOTER ===== */
        .tg-footer {
            background: var(--tg-dark); color: rgba(255,255,255,.85);
            padding: 60px 0 30px; margin-top: 80px;
        }
        .tg-footer a { color: rgba(255,255,255,.7); text-decoration: none; transition: color .2s; }
        .tg-footer a:hover { color: var(--tg-mint); }
        .tg-footer .brand { display:flex; align-items:center; gap:10px; font-weight:800; font-size:1.3rem; color:#fff; margin-bottom:14px; }
        .tg-footer h6 { color:#fff; font-weight:700; margin-bottom:16px; }
        .tg-footer .social a {
            display:inline-flex; width:38px;height:38px; border-radius:10px; align-items:center;justify-content:center;
            background:rgba(255,255,255,.08); margin-right:8px; color:#fff;
        }
        .tg-footer .social a:hover { background: var(--tg-green); }
        .tg-footer .bottom { border-top:1px solid rgba(255,255,255,.1); margin-top:40px; padding-top:20px; font-size:.85rem; opacity:.7; }
    </style>
    @yield('extra_css')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar sticky-top tg-navbar">
        <div class="container d-flex align-items-center">
            <!-- Logo (Left) -->
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <span class="tg-logo-mark">T</span> <span class="d-none d-sm-inline">Togetherly</span>
            </a>

            @auth
                <!-- Center Navigation -->
                <div class="tg-nav-center d-none d-lg-flex">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-gauge-high"></i> Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('food.*') ? 'active' : '' }}" href="{{ route('food.index') }}">
                        <i class="fas fa-utensils"></i> Food
                    </a>
                    <a class="nav-link {{ request()->routeIs('skills.*') ? 'active' : '' }}" href="{{ route('skills.index') }}">
                        <i class="fas fa-lightbulb"></i> Skills
                    </a>
                    <a class="nav-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}" href="{{ route('favorites.index') }}">
                        <i class="fas fa-bookmark"></i> Saved
                    </a>
                    <a class="nav-link {{ request()->routeIs('impact') ? 'active' : '' }}" href="{{ route('impact') }}">
                        <i class="fas fa-leaf"></i> Impact
                    </a>
                    <div class="tg-nav-divider"></div>
                    <a class="nav-link position-relative {{ request()->routeIs('messages.*') ? 'active' : '' }}" href="{{ route('messages.inbox') }}">
                        <i class="fas fa-envelope"></i> Messages
                        @php $unread = \App\Models\Message::where('recipient_id', Auth::id())->where('is_read', false)->count(); @endphp
                        @if ($unread > 0)<span class="tg-nav-badge">{{ $unread }}</span>@endif
                    </a>
                </div>
            @endauth

            <!-- Right Side (Notifications, User, Language) -->
            <div class="tg-nav-right">
                @auth
                    <!-- Notifications Dropdown -->
                    <div class="dropdown d-none d-lg-inline-block">
                        <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            @php $noteCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count(); @endphp
                            @if ($noteCount > 0)<span class="tg-nav-badge">{{ $noteCount }}</span>@endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:14px; width:320px; max-height:400px; overflow-y:auto;">
                            <li class="d-flex justify-content-between align-items-center px-3 py-2">
                                <strong>Notifications</strong>
                                <a href="{{ route('notifications.index') }}" class="small text-decoration-none" style="color:var(--tg-green)">View All</a>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            @php $recentNotes = \App\Models\Notification::where('user_id', Auth::id())->latest()->limit(5)->get(); @endphp
                            @forelse ($recentNotes as $note)
                                <li>
                                    <form action="{{ route('notifications.read', $note) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item d-flex gap-2 align-items-start py-2 {{ $note->is_read ? '' : 'bg-light' }}" style="white-space:normal;">
                                            <i class="fas {{ $note->icon }} mt-1" style="color:var(--tg-green)"></i>
                                            <span>
                                                <span class="d-block fw-semibold" style="font-size:.85rem;">{{ $note->title }}</span>
                                                <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                                            </span>
                                        </button>
                                    </form>
                                </li>
                            @empty
                                <li class="text-center text-muted py-3"><small>No notifications</small></li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- User Menu Dropdown -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (Auth::user()->avatar)
                                <img src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="" class="tg-avatar" style="object-fit:cover;">
                            @else
                                <div class="tg-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:14px; min-width:220px;">
                            <li class="px-3 py-2 border-bottom">
                                <div class="fw-bold small">{{ Auth::user()->name }}</div>
                                <small class="text-muted">⭐ {{ number_format(Auth::user()->rating, 1) }}</small>
                            </li>
                            <li><a class="dropdown-item small py-2" href="{{ route('profile.show', Auth::user()) }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item small py-2" href="{{ route('profile.edit') }}"><i class="fas fa-pen me-2"></i>Edit</a></li>
                            <li><a class="dropdown-item small py-2" href="{{ route('claims.index') }}"><i class="fas fa-hand-holding-heart me-2"></i>Claims</a></li>
                            <li><a class="dropdown-item small py-2" href="{{ route('bookings.index') }}"><i class="fas fa-calendar-check me-2"></i>Bookings</a></li>
                            @if (Auth::user()->is_admin)
                                <li><hr class="dropdown-divider my-1"></li>
                                <li><a class="dropdown-item small py-2 text-primary fw-semibold" href="{{ route('admin.index') }}"><i class="fas fa-shield-halved me-2"></i>Admin</a></li>
                            @endif
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item small py-2 text-danger" type="submit"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <!-- Language Switcher -->
                    <div class="dropdown d-none d-lg-inline-block">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-globe"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:14px;">
                            <li><a class="dropdown-item small {{ app()->getLocale() === 'en' ? 'active' : '' }}" href="{{ route('locale.switch', 'en') }}">English @if(app()->getLocale() === 'en')<i class="fas fa-check ms-2"></i>@endif</a></li>
                            <li><a class="dropdown-item small {{ app()->getLocale() === 'ko' ? 'active' : '' }}" href="{{ route('locale.switch', 'ko') }}">한국어 @if(app()->getLocale() === 'ko')<i class="fas fa-check ms-2"></i>@endif</a></li>
                        </ul>
                    </div>
                @else
                    <!-- Guest Buttons -->
                    <a class="nav-link small" href="{{ route('login') }}">Login</a>
                    <a class="tg-btn-pill" href="{{ route('register') }}">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash messages -->
    @if ($errors->any())
        <div class="container mt-3">
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        </div>
    @endif
    @if (session('success'))
        <div class="container mt-3"><div class="alert alert-success"><i class="fas fa-circle-check me-2"></i>{{ session('success') }}</div></div>
    @endif

    <main>@yield('content')</main>

    <!-- Footer -->
    <footer class="tg-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="brand"><span class="tg-logo-mark">T</span> {{ __('app.brand') }}</div>
                    <p class="small" style="max-width:300px;">{{ __('app.footer.about') }}</p>
                </div>
                <div class="col-6 col-lg-2">
                    <h6>{{ __('app.footer.explore') }}</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('welcome') }}">{{ __('app.footer.home') }}</a></li>
                        @auth
                            <li class="mb-2"><a href="{{ route('food.index') }}">{{ __('app.nav.food') }}</a></li>
                            <li class="mb-2"><a href="{{ route('skills.index') }}">{{ __('app.nav.skills') }}</a></li>
                        @else
                            <li class="mb-2"><a href="{{ route('register') }}">{{ __('app.nav.get_started') }}</a></li>
                            <li class="mb-2"><a href="{{ route('login') }}">{{ __('app.nav.login') }}</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h6>{{ __('app.footer.impact') }}</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">{{ __('app.footer.sdg_waste') }}</a></li>
                        <li class="mb-2"><a href="#">{{ __('app.footer.sdg_community') }}</a></li>
                        <li class="mb-2"><a href="#">{{ __('app.footer.sdg_education') }}</a></li>
                        <li class="mb-2"><a href="#">{{ __('app.footer.sdg_poverty') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="bottom text-center">
                &copy; {{ date('Y') }} {{ __('app.brand') }} · {{ __('app.university') }} · {{ __('app.footer.rights') }}
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('extra_js')
</body>
</html>
