<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Media Bridge - المنصة الوسيطة للتسويق الرقمي')</title>
    <meta name="description"
        content="@yield('meta_description', 'منصة رقمية وسيطة تربط الشركات بوكالات التسويق الرقمي لإطلاق حملات إعلانية احترافية بشفافية وكفاءة.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @stack('styles')

    <style>
        /* ===== DESIGN TOKENS ===== */
        :root {
            --primary: #0d9488;
            --primary-dark: #0f766e;
            --primary-light: #99f6e4;
            --primary-glow: rgba(13, 148, 136, 0.15);
            --accent: #f59e0b;
            --accent-dark: #d97706;
            --accent-light: #fef3c7;
            --dark: #0f172a;
            --dark-soft: #1e293b;
            --text: #334155;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --surface: #ffffff;
            --surface-alt: #f8fafc;
            --surface-glass: rgba(255, 255, 255, 0.75);
            --border: #e2e8f0;
            --border-light: #f1f5f9;
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.04);
            --shadow-md: 0 4px 16px rgba(15, 23, 42, 0.06);
            --shadow-lg: 0 8px 32px rgba(15, 23, 42, 0.08);
            --shadow-xl: 0 16px 48px rgba(15, 23, 42, 0.12);
            --radius-sm: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.25rem;
            --radius-2xl: 1.5rem;
        }

        /* ===== GLOBAL ===== */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Cairo", sans-serif;
            background: var(--surface-alt);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        ::selection {
            background: var(--primary);
            color: #fff;
        }

        a {
            text-decoration: none;
            transition: all 0.2s ease;
        }

        img {
            max-width: 100%;
        }

        /* ===== NAVBAR ===== */
        .app-navbar {
            background: var(--surface-glass);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid var(--border-light);
            transition: box-shadow 0.3s ease;
        }

        .app-navbar.scrolled {
            box-shadow: var(--shadow-md);
        }

        .app-navbar .navbar-brand {
            font-weight: 900;
            font-size: 1.35rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }

        .app-navbar .navbar-brand .brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: var(--radius-sm);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.1rem;
            margin-left: 0.5rem;
        }

        .app-navbar .nav-link {
            font-weight: 500;
            color: var(--text) !important;
            padding: 0.5rem 0.85rem !important;
            border-radius: var(--radius-sm);
            font-size: 0.92rem;
            transition: all 0.2s ease;
            position: relative;
        }

        .app-navbar .nav-link:hover,
        .app-navbar .nav-link.active {
            color: var(--primary) !important;
            background: var(--primary-glow);
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            font-weight: 600;
            padding: 0.5rem 1.25rem;
            border-radius: var(--radius-sm);
            box-shadow: 0 2px 8px rgba(13, 148, 136, 0.25);
            transition: all 0.25s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), #115e59);
            box-shadow: 0 4px 16px rgba(13, 148, 136, 0.35);
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
            font-weight: 600;
            border-radius: var(--radius-sm);
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        .btn-accent {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border: none;
            color: #fff;
            font-weight: 700;
            padding: 0.65rem 1.5rem;
            border-radius: var(--radius-sm);
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
            transition: all 0.25s ease;
        }

        .btn-accent:hover {
            background: linear-gradient(135deg, var(--accent-dark), #b45309);
            box-shadow: 0 4px 16px rgba(245, 158, 11, 0.4);
            transform: translateY(-1px);
            color: #fff;
        }

        /* ===== CARDS ===== */
        .card {
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            background: var(--surface);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .card-body {
            padding: 1.25rem;
        }

        /* ===== STAT CARDS ===== */
        .stat-card {
            border: none;
            border-radius: var(--radius-lg);
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 60%);
            pointer-events: none;
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            margin-bottom: 0.75rem;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
        }

        .stat-card .stat-label {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
        }

        .stat-gradient-1 {
            background: linear-gradient(135deg, #0d9488, #0f766e);
        }

        .stat-gradient-2 {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        .stat-gradient-3 {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .stat-gradient-4 {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .stat-gradient-5 {
            background: linear-gradient(135deg, #ec4899, #db2777);
        }

        .stat-gradient-6 {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
        }

        /* ===== HERO ===== */
        .hero-section {
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark-soft) 40%, var(--primary-dark) 100%);
            color: #fff;
            border-radius: var(--radius-2xl);
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -100px;
            left: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, var(--primary-glow) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -150px;
            right: -150px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-section h1 {
            font-weight: 900;
            font-size: 2.5rem;
            line-height: 1.3;
            margin-bottom: 1rem;
        }

        .hero-section .lead {
            font-size: 1.15rem;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.8;
            max-width: 600px;
        }

        .hero-stat-box {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-lg);
            padding: 1rem 1.25rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .hero-stat-box:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-3px);
        }

        .hero-stat-box .stat-num {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--accent);
        }

        .hero-stat-box .stat-txt {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* ===== SECTION HEADERS ===== */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .section-header h2 {
            font-weight: 700;
            font-size: 1.25rem;
            position: relative;
            padding-right: 1rem;
            color: var(--dark);
        }

        .section-header h2::before {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 70%;
            background: linear-gradient(to bottom, var(--primary), var(--accent));
            border-radius: 4px;
        }

        /* ===== TABLES ===== */
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background: var(--surface-alt);
            font-weight: 700;
            color: var(--text-muted);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-bottom: 2px solid var(--border);
            padding: 0.85rem 1rem;
        }

        .table tbody td {
            padding: 0.85rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-light);
        }

        .table tbody tr:hover {
            background: var(--surface-alt);
        }

        /* ===== BADGES ===== */
        .badge-status {
            border-radius: 999px;
            font-weight: 600;
            padding: 0.4rem 0.85rem;
            font-size: 0.8rem;
        }

        .badge-primary {
            background: var(--primary-glow);
            color: var(--primary);
        }

        .badge-warning {
            background: var(--accent-light);
            color: var(--accent-dark);
        }

        .badge-success {
            background: #dcfce7;
            color: #16a34a;
        }

        .badge-danger {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-info {
            background: #dbeafe;
            color: #2563eb;
        }

        /* ===== ALERTS ===== */
        .alert {
            border-radius: var(--radius-md);
            border: none;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #166534;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
        }

        /* ===== FORM CONTROLS ===== */
        .form-control,
        .form-select {
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0.6rem 0.85rem;
            font-size: 0.92rem;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark-soft);
            margin-bottom: 0.35rem;
        }

        /* ===== FOOTER ===== */
        .app-footer {
            background: var(--dark);
            color: rgba(255, 255, 255, 0.7);
            padding: 3rem 0 1.5rem;
            margin-top: 3rem;
        }

        .app-footer h5 {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .app-footer a {
            color: rgba(255, 255, 255, 0.6);
            display: block;
            padding: 0.25rem 0;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .app-footer a:hover {
            color: var(--primary-light);
            padding-right: 0.35rem;
        }

        .footer-brand {
            font-weight: 900;
            font-size: 1.5rem;
            color: #fff !important;
            margin-bottom: 0.75rem;
            display: inline-block;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 1.25rem;
            margin-top: 2rem;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.4);
        }

        /* ===== NOTIFICATION DOT ===== */
        .notify-dot {
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            position: absolute;
            top: 4px;
            right: 4px;
            border: 2px solid #fff;
        }

        /* ===== ICON BOXES ===== */
        .icon-box {
            width: 52px;
            height: 52px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
        }

        .icon-box-primary {
            background: var(--primary-glow);
            color: var(--primary);
        }

        .icon-box-accent {
            background: var(--accent-light);
            color: var(--accent-dark);
        }

        .icon-box-info {
            background: #dbeafe;
            color: #2563eb;
        }

        .icon-box-purple {
            background: #ede9fe;
            color: #7c3aed;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.5s ease forwards;
        }

        .animate-delay-1 {
            animation-delay: 0.1s;
        }

        .animate-delay-2 {
            animation-delay: 0.2s;
        }

        .animate-delay-3 {
            animation-delay: 0.3s;
        }

        .animate-delay-4 {
            animation-delay: 0.4s;
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--surface-alt);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--text-light);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 1.25rem;
            }

            .hero-section h1 {
                font-size: 1.75rem;
            }

            .stat-card .stat-value {
                font-size: 1.35rem;
            }
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            background: linear-gradient(135deg, var(--dark), var(--primary-dark));
            color: #fff;
            border-radius: var(--radius-xl);
            padding: 2rem 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::after {
            content: '';
            position: absolute;
            top: -80px;
            left: -80px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05), transparent 70%);
        }

        .page-header h1 {
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }

        .page-header p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--border);
            margin-bottom: 1rem;
        }

        .empty-state p {
            font-size: 1rem;
            max-width: 300px;
            margin: 0 auto;
        }

        /* ===== LIST GROUP ===== */
        .list-group-item {
            border-color: var(--border-light);
            padding: 0.85rem 1rem;
            transition: background 0.2s ease;
        }

        .list-group-item:hover {
            background: var(--surface-alt);
        }
    </style>
    @stack('styles')
</head>

<body>
    @php($user = auth()->user())

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg sticky-top app-navbar" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <span class="brand-icon"><i class="bi bi-megaphone-fill"></i></span>
                Media Bridge
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}"><i class="bi bi-house-door ms-1"></i> الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                            href="{{ route('about') }}">عن المنصة</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('how-it-works') ? 'active' : '' }}"
                            href="{{ route('how-it-works') }}">طريقة العمل</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('agencies.index') ? 'active' : '' }}"
                            href="{{ route('agencies.index') }}">دليل الوكالات</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                            href="{{ route('contact') }}">تواصل معنا</a></li>
                    @auth
                        @if($user->isCompany())
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('company.*') ? 'active' : '' }}"
                                    href="{{ route('company.dashboard') }}"><i class="bi bi-speedometer2 ms-1"></i> لوحة
                                    الشركة</a></li>
                        @elseif($user->isAgency())
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('agency.*') ? 'active' : '' }}"
                                    href="{{ route('agency.dashboard') }}"><i class="bi bi-speedometer2 ms-1"></i> لوحة
                                    الوكالة</a></li>
                        @elseif($user->isAdmin())
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                                    href="{{ route('admin.dashboard') }}"><i class="bi bi-gear ms-1"></i> لوحة الإدارة</a></li>
                        @endif
                    @endauth
                </ul>

                <div class="d-flex align-items-center gap-2">
                    @guest
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-left ms-1"></i> تسجيل الدخول
                        </a>
                        <a class="btn btn-primary btn-sm" href="{{ route('register') }}">
                            إنشاء حساب <i class="bi bi-arrow-left me-1"></i>
                        </a>
                    @else
                        <a class="btn btn-outline-secondary btn-sm position-relative"
                            href="{{ route('conversations.index') }}" title="المحادثات">
                            <i class="bi bi-chat-dots"></i>
                            @if(($navStats['unread_messages'] ?? 0) > 0)
                                <span class="notify-dot"></span>
                            @endif
                        </a>
                        <a class="btn btn-outline-secondary btn-sm position-relative"
                            href="{{ route('notifications.index') }}" title="الإشعارات">
                            <i class="bi bi-bell"></i>
                            @if(($navStats['unread_notifications'] ?? 0) > 0)
                                <span class="notify-dot"></span>
                            @endif
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle ms-1"></i> {{ $user->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-start">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                            class="bi bi-person ms-2"></i> الملف الشخصي</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right ms-2"></i>
                                            تسجيل الخروج</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="py-4">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3 animate-in" role="alert">
                    <i class="bi bi-check-circle-fill ms-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-3 animate-in" role="alert">
                    <i class="bi bi-exclamation-triangle-fill ms-2"></i>
                    <ul class="mb-0 me-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
            @isset($slot)
                {{ $slot }}
            @endisset
        </div>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="app-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <a href="{{ route('home') }}" class="footer-brand">
                        <i class="bi bi-megaphone-fill ms-2"></i> Media Bridge
                    </a>
                    <p class="mt-2" style="font-size: 0.9rem; line-height: 1.8;">
                        منصة رقمية وسيطة تنظم العلاقة بين الشركات ووكالات التسويق الرقمي من خلال آلية عمل واضحة وشفافة
                        تضمن أفضل جودة بأفضل سعر.
                    </p>
                </div>
                <div class="col-lg-2 col-6">
                    <h5>روابط سريعة</h5>
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <a href="{{ route('about') }}">عن المنصة</a>
                    <a href="{{ route('how-it-works') }}">طريقة العمل</a>
                    <a href="{{ route('agencies.index') }}">دليل الوكالات</a>
                </div>
                <div class="col-lg-2 col-6">
                    <h5>الدعم</h5>
                    <a href="{{ route('contact') }}">تواصل معنا</a>
                    <a href="{{ route('faq') }}">الأسئلة الشائعة</a>
                    <a href="{{ route('pricing') }}">الباقات</a>
                    <a href="{{ route('features') }}">المزايا</a>
                </div>
                <div class="col-lg-4">
                    <h5>تواصل معنا</h5>
                    <p style="font-size: 0.9rem;">
                        <i class="bi bi-envelope ms-2"></i> support@mediabridge.sa
                    </p>
                    <p style="font-size: 0.9rem;">
                        <i class="bi bi-geo-alt ms-2"></i> المملكة العربية السعودية
                    </p>
                    <div class="d-flex gap-2 mt-2">
                        <a href="#" class="btn btn-outline-light btn-sm"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom text-center">
                جميع الحقوق محفوظة &copy; {{ date('Y') }} Media Bridge - الجامعة السعودية الإلكترونية
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            document.getElementById('mainNavbar')?.classList.toggle('scrolled', window.scrollY > 10);
        });
    </script>
    @stack('scripts')
</body>

</html>