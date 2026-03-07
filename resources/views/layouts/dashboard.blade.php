<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Media Bridge - لوحة التحكم')</title>

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
            --primary-light: #ccfbf1;
            --accent: #f59e0b;
            --accent-light: #fef3c7;
            --dark: #0f172a;
            --dark-alt: #1e293b;
            --text: #1e293b;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --surface: #ffffff;
            --surface-alt: #f8fafc;
            --border-light: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.12);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --sidebar-width: 260px;
        }

        * {
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: var(--surface-alt);
            color: var(--text);
        }

        /* ===== SIDEBAR ===== */
        .dashboard-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--dark);
            color: #fff;
            z-index: 1040;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-align: center;
        }

        .sidebar-brand h2 {
            font-size: 1.15rem;
            font-weight: 800;
            margin: 0;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-brand small {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .sidebar-nav {
            padding: 0.75rem 0;
        }

        .sidebar-section {
            padding: 0.5rem 1.25rem 0.25rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-light);
            font-weight: 700;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.6rem 1.25rem;
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border-radius: 0;
            margin: 0 0.5rem;
            border-radius: var(--radius-sm);
        }

        .sidebar-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
        }

        .sidebar-link.active {
            color: #fff;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            box-shadow: 0 2px 8px rgba(13, 148, 136, 0.3);
        }

        .sidebar-link i {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
        }

        .sidebar-user {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            position: absolute;
            bottom: 0;
            width: 100%;
            background: var(--dark);
        }

        .sidebar-user .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-user .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .sidebar-user .user-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #fff;
        }

        .sidebar-user .user-role {
            font-size: 0.72rem;
            color: var(--text-light);
        }

        /* ===== MAIN CONTENT ===== */
        .dashboard-content {
            margin-right: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .dashboard-topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border-light);
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .topbar-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .dashboard-body {
            flex: 1;
            padding: 1.5rem;
        }

        /* ===== MOBILE TOGGLE ===== */
        .sidebar-toggle {
            display: none;
            background: var(--primary);
            border: none;
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            font-size: 1.2rem;
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1035;
        }

        @media (max-width: 991.98px) {
            .sidebar-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .dashboard-sidebar {
                transform: translateX(100%);
            }

            .dashboard-sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .dashboard-content {
                margin-right: 0;
            }
        }

        /* ===== REUSABLE COMPONENTS (same as app.blade.php) ===== */
        .page-header {
            background: linear-gradient(135deg, var(--dark), var(--dark-alt));
            color: #fff;
            padding: 1.5rem 2rem;
            border-radius: var(--radius-lg);
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .page-header p {
            opacity: 0.7;
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        .card {
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            background: var(--surface);
        }

        .stat-card {
            border-radius: var(--radius-md);
            padding: 1.25rem;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .stat-card .stat-icon {
            font-size: 2rem;
            opacity: 0.3;
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
        }

        .stat-card .stat-label {
            font-size: 0.85rem;
            opacity: 0.85;
        }

        .stat-gradient-1 {
            background: linear-gradient(135deg, #0d9488, #14b8a6);
        }

        .stat-gradient-2 {
            background: linear-gradient(135deg, #6366f1, #818cf8);
        }

        .stat-gradient-3 {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
        }

        .stat-gradient-4 {
            background: linear-gradient(135deg, #10b981, #34d399);
        }

        .stat-gradient-5 {
            background: linear-gradient(135deg, #ef4444, #f87171);
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .icon-box-primary {
            background: var(--primary-light);
            color: var(--primary);
        }

        .icon-box-accent {
            background: var(--accent-light);
            color: var(--accent);
        }

        .icon-box-danger {
            background: #fee2e2;
            color: #dc2626;
        }

        .icon-box-info {
            background: #e0f2fe;
            color: #0284c7;
        }

        .badge-status {
            font-size: 0.75rem;
            padding: 0.35em 0.75em;
            border-radius: 50px;
            font-weight: 600;
        }

        .badge-primary {
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: var(--accent-light);
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-info {
            background: #e0f2fe;
            color: #075985;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-accent {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        .btn-accent:hover {
            background: #d97706;
            border-color: #d97706;
            color: #fff;
        }

        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .table thead th {
            background: var(--surface-alt);
            font-weight: 700;
            color: var(--text-muted);
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border-light);
            padding: 0.75rem 1rem;
        }

        .table tbody td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
        }

        /* Scrollbar */
        .dashboard-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .dashboard-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .dashboard-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        /* ===== PAGINATION ===== */
        .pagination .page-link {
            border: 1px solid var(--border-light);
            color: var(--text);
            font-size: 0.82rem;
            padding: 0.4rem 0.75rem;
            border-radius: var(--radius-sm) !important;
            transition: all 0.2s ease;
        }
        .pagination .page-link:hover {
            background: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary);
        }
        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 2px 6px rgba(13, 148, 136, 0.3);
        }
        .pagination .page-item.disabled .page-link {
            background: var(--surface-alt);
            color: var(--text-light);
            border-color: var(--border-light);
        }

        @stack('inline-styles')
    </style>
</head>

<body>
    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="dashboard-sidebar" id="dashboardSidebar">
        <div class="sidebar-brand">
            <h2>Media Bridge</h2>
            <small>لوحة التحكم</small>
        </div>

        <nav class="sidebar-nav">
            @auth
                @if(auth()->user()->isAdmin())
                    <div class="sidebar-section">الرئيسية</div>
                    <a href="{{ route('admin.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> لوحة التحكم
                    </a>

                    <div class="sidebar-section mt-3">إدارة المستخدمين</div>
                    <a href="{{ route('admin.users.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> المستخدمون
                    </a>

                    <div class="sidebar-section mt-3">إدارة المحتوى</div>
                    <a href="{{ route('admin.campaigns.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.campaigns.*') ? 'active' : '' }}">
                        <i class="bi bi-megaphone"></i> الحملات
                    </a>
                    <a href="{{ route('admin.proposals.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.proposals.*') ? 'active' : '' }}">
                        <i class="bi bi-collection"></i> العروض
                    </a>

                    <div class="sidebar-section mt-3">البيانات المرجعية</div>
                    <a href="{{ route('admin.categories.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-grid"></i> التصنيفات
                    </a>
                    <a href="{{ route('admin.services.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i> الخدمات
                    </a>
                    <a href="{{ route('admin.industries.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.industries.*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i> القطاعات
                    </a>

                    <div class="sidebar-section mt-3">النظام</div>
                    <a href="{{ route('admin.reports.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="bi bi-flag"></i> البلاغات
                    </a>
                    <a href="{{ route('admin.settings.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="bi bi-sliders"></i> الإعدادات
                    </a>

                @elseif(auth()->user()->isCompany())
                    <div class="sidebar-section">الرئيسية</div>
                    <a href="{{ route('company.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('company.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> لوحة التحكم
                    </a>

                    <div class="sidebar-section mt-3">الحملات</div>
                    <a href="{{ route('company.campaigns.index') }}"
                        class="sidebar-link {{ request()->routeIs('company.campaigns.*') ? 'active' : '' }}">
                        <i class="bi bi-megaphone"></i> حملاتي
                    </a>
                    <a href="{{ route('company.campaigns.create') }}"
                        class="sidebar-link {{ request()->routeIs('company.campaigns.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle"></i> إنشاء حملة
                    </a>

                    <div class="sidebar-section mt-3">التواصل</div>
                    <a href="{{ route('conversations.index') }}"
                        class="sidebar-link {{ request()->routeIs('conversations.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots"></i> المحادثات
                    </a>
                    <a href="{{ route('notifications.index') }}"
                        class="sidebar-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                        <i class="bi bi-bell"></i> الإشعارات
                    </a>

                    <div class="sidebar-section mt-3">الحساب</div>
                    <a href="{{ route('company.reviews.index') }}"
                        class="sidebar-link {{ request()->routeIs('company.reviews.*') ? 'active' : '' }}">
                        <i class="bi bi-star"></i> التقييمات
                    </a>
                    <a href="{{ route('company.profile.edit') }}"
                        class="sidebar-link {{ request()->routeIs('company.profile.*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i> ملف الشركة
                    </a>

                @elseif(auth()->user()->isAgency())
                    <div class="sidebar-section">الرئيسية</div>
                    <a href="{{ route('agency.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('agency.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> لوحة التحكم
                    </a>

                    <div class="sidebar-section mt-3">الحملات</div>
                    <a href="{{ route('agency.campaigns.index') }}"
                        class="sidebar-link {{ request()->routeIs('agency.campaigns.*') ? 'active' : '' }}">
                        <i class="bi bi-search"></i> تصفح الحملات
                    </a>
                    <a href="{{ route('agency.favorites.index') }}"
                        class="sidebar-link {{ request()->routeIs('agency.favorites.*') ? 'active' : '' }}">
                        <i class="bi bi-bookmark-star"></i> المحفوظات
                    </a>

                    <div class="sidebar-section mt-3">العروض</div>
                    <a href="{{ route('agency.proposals.index') }}"
                        class="sidebar-link {{ request()->routeIs('agency.proposals.*') ? 'active' : '' }}">
                        <i class="bi bi-send"></i> عروضي
                    </a>
                    <a href="{{ route('agency.projects.index') }}"
                        class="sidebar-link {{ request()->routeIs('agency.projects.*') ? 'active' : '' }}">
                        <i class="bi bi-folder2-open"></i> مشاريعي
                    </a>

                    <div class="sidebar-section mt-3">التواصل</div>
                    <a href="{{ route('conversations.index') }}"
                        class="sidebar-link {{ request()->routeIs('conversations.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots"></i> المحادثات
                    </a>
                    <a href="{{ route('notifications.index') }}"
                        class="sidebar-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                        <i class="bi bi-bell"></i> الإشعارات
                    </a>

                    <div class="sidebar-section mt-3">الحساب</div>
                    <a href="{{ route('agency.profile.edit') }}"
                        class="sidebar-link {{ request()->routeIs('agency.profile.*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i> ملف الوكالة
                    </a>
                @endif

                {{-- Common: back to site + logout --}}
                <div class="sidebar-section mt-3">عام</div>
                <a href="{{ route('home') }}" class="sidebar-link">
                    <i class="bi bi-globe"></i> الموقع الرئيسي
                </a>
            @endauth
        </nav>

        <!-- User info at bottom -->
        @auth
            <div class="sidebar-user">
                <div class="user-info">
                    <div class="user-avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</div>
                    <div class="flex-grow-1">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">{{ auth()->user()->role->label() }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light"
                            style="padding: 0.2rem 0.5rem; font-size: 0.75rem;" title="تسجيل الخروج">
                            <i class="bi bi-box-arrow-left"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </aside>

    <!-- Main Content -->
    <div class="dashboard-content">
        <div class="dashboard-topbar">
            <div class="d-flex align-items-center gap-2">
                <button class="sidebar-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
                <span class="topbar-title">@yield('title', 'لوحة التحكم')</span>
            </div>
            <div class="topbar-actions">
                <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-outline-secondary position-relative"
                    title="الإشعارات">
                    <i class="bi bi-bell"></i>
                    @if(auth()->user()?->unreadNotifications?->count())
                        <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 0.6rem;">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
            </div>
        </div>

        <div class="dashboard-body">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill ms-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill ms-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('dashboardSidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }
    </script>
    @stack('scripts')
</body>

</html>