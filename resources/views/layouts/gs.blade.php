<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dashboard') - Monitoring Sales Government</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- VITE --}}
    @vite(['resources/sass/app.scss','resources/js/app.js'])

    {{-- ICON --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    {{-- FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- CHART --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- STACK STYLE (MAP / CHART) --}}
    @stack('styles')

    <style>
        /* 
         * ==========================================
         * 1. GLOBAL ENTERPRISE DESIGN TOKEN SYSTEM
         * ==========================================
         */
        :root {
            /* COLOR TOKENS */
            --color-primary: #e30613;
            --color-primary-hover: #c70510;
            --color-success: #198754;
            --color-danger: #dc3545;
            --color-bg-main: #f8f9fa;
            --color-bg-card: #ffffff;
            --color-text-primary: #212529;
            --color-text-secondary: #6c757d;
            --color-border: #dee2e6;
            --color-hover: #f1f3f5;
            --color-divider: #e9ecef;

            /* SPACING TOKENS */
            --space-xs: 4px;
            --space-sm: 8px;
            --space-md: 16px;
            --space-lg: 24px;
            --space-xl: 32px;

            /* RADIUS TOKENS */
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;

            /* SHADOW TOKENS */
            --shadow-sm: 0 4px 12px rgba(0,0,0,0.05);
            --shadow-md: 0 12px 30px rgba(0,0,0,0.08);
            --shadow-lg: 0 25px 60px rgba(0,0,0,0.12);

            /* LAYOUT */
            --navbar-height: 90px;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;

            /* SIDEBAR TOKENS (LIGHT DEFAULT) */
            --sidebar-bg: linear-gradient(180deg, #E30613 0%, #B30000 100%);
            --sidebar-text: #ffffff;
            --sidebar-active-bg: #ffffff;
            --sidebar-active-text: #E30613;
        }

        [data-theme="dark"] {
            --color-bg-main: #111827;
            --color-bg-card: #1f2937;
            --color-text-primary: #f9fafb;
            --color-text-secondary: #9ca3af;
            --color-border: #374151;
            --color-hover: #2d3748;
            --color-divider: #374151;
            --shadow-sm: 0 4px 12px rgba(0,0,0,0.3);
            --shadow-md: 0 12px 30px rgba(0,0,0,0.4);
            --shadow-lg: 0 25px 60px rgba(0,0,0,0.5);

            /* SIDEBAR TOKENS (DARK MODE) */
            --sidebar-bg: #111827;
            --sidebar-text: #e5e7eb;
            --sidebar-active-bg: #E30613;
            --sidebar-active-text: #ffffff;
        }

        :root {
            --telkom-red: #E30613;
            --telkom-dark: #B30000;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --navbar-height: 90px;
        }

        body {
            background: var(--color-bg-main);
            color: var(--color-text-primary);
            margin:0;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* ================= NAVBAR ================= */
        .navbar-gov {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--navbar-height);
            background: var(--color-bg-card);
            z-index: 1050;
            display: flex;
            align-items: center;
            padding: 0 24px;
            color: var(--color-text-primary);
            box-shadow: var(--shadow-sm);
            transition: left 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
            overflow: visible; /* Fix Dropdown Clipping */
        }

        .navbar-gov.collapsed {
            left: var(--sidebar-collapsed-width);
        }

        .navbar-brand-text {
            display: none; /* Hidden in new design, moved to sidebar */
        }

        /* ================= SIDEBAR ================= */
        .sidebar-gov {
            position: fixed;
            top: 0; /* Full height */
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            padding: 24px 16px;
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            z-index: 1060;
            transition: width 0.3s ease, background 0.3s ease;
            box-shadow: 4px 0 24px rgba(0,0,0,0.1);
        }

        .sidebar-gov.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        /* Logo Section */
        .sidebar-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 30px;
            transition: all 0.3s;
        }
        .sidebar-logo img {
            width: 140px;
            height: auto;
            margin-bottom: 12px;
            transition: all 0.3s;
        }
        .sidebar-logo-text {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            line-height: 1.4;
            text-transform: uppercase;
            white-space: nowrap;
        }
        
        /* Logo menjadi putih bersih saat Dark Mode */
        [data-theme="dark"] .sidebar-logo img {
            filter: grayscale(100%) brightness(1000%);
        }

        .sidebar-gov.collapsed .sidebar-logo img { width: 40px; margin-bottom: 0; }
        .sidebar-gov.collapsed .sidebar-logo-text { display: none; }

        /* Menu Links */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--sidebar-text);
            opacity: 0.9;
            border-radius: 12px;
            text-decoration: none;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-active-text);
            transform: translateX(4px);
            box-shadow: var(--shadow-sm);
            opacity: 1;
        }
        
        .nav-link.active {
            font-weight: 700;
        }

        .nav-link i {
            font-size: 1.2rem;
            min-width: 24px;
            text-align: center;
        }

        .sidebar-gov.collapsed .nav-link {
            justify-content: center;
            padding: 12px;
            transform: none;
        }
        .sidebar-gov.collapsed .nav-link span { display: none; }
        .sidebar-gov.collapsed .nav-link:hover { transform: none; }

        .nav-separator {
            border-top: 1px solid rgba(255,255,255,0.15);
            margin: 8px 0;
        }

        .sidebar-footer {
            margin-top: auto;
            font-size: 11px;
            opacity: 0.8;
            padding-top: 12px;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            white-space: nowrap;
        }
        .sidebar-gov.collapsed .sidebar-footer { display: none; }

        /* ================= NAVBAR ITEMS ================= */
        .toggle-btn {
            background: none;
            border: none;
            color: var(--telkom-red);
            font-size: 1.5rem;
            cursor: pointer;
            margin-right: 16px;
            padding: 0;
        }

        [data-theme="dark"] .toggle-btn {
            color: var(--color-text-primary);
        }

        /* Search Bar */
        .search-container {
            flex: 1;
            display: flex;
            justify-content: center;
            margin: 0 20px;
        }
        .search-box {
            position: relative;
            width: 100%;
            max-width: 400px;
        }
        .search-box input {
            width: 100%;
            padding: 10px 20px 10px 45px;
            border-radius: 50px;
            border: none;
            outline: none;
            font-size: 14px;
            background: #fff;
            color: #333;
            transition: all 0.3s;
        }
        .search-box input:focus {
            box-shadow: 0 0 0 3px rgba(255,255,255,0.3);
        }
        .search-box i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        /* ================= CONTENT ================= */
        .content-gov {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 50px 30px;
            min-height: calc(100vh - var(--navbar-height));
            transition: margin-left 0.3s ease;
        }
        
        .content-gov.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* LOGIN PAGE (NO SIDEBAR SHIFT) */
        body.guest .content-gov {
            margin-left: 0;
            margin-top: 0;
        }
        body.guest .navbar-gov {
            padding-left: 20px; /* Reset padding for guest */
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar-gov { transform: translateX(-100%); width: var(--sidebar-width); }
            .sidebar-gov.show { transform: translateX(0); }
            .navbar-gov { left: 0; }
            .content-gov { 
                margin-left: 0 !important; 
                padding: 20px 15px; /* Padding lebih kecil di mobile agar luas */
            }
            .search-container { display: none; } /* Hide search on mobile for simplicity */
            .breadcrumb-nav { display: none; }
        }

        /* Overlay Hitam saat Sidebar Mobile Aktif */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1055; /* Di atas Navbar (1050), di bawah Sidebar (1060) */
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        /* 
         * ==========================================
         * 3. PREMIUM PROFILE POPOVER COMPONENT
         * ==========================================
         */
        .profile-dropdown-wrapper {
            position: relative;
            display: inline-block;
        }

        /* TRIGGER */
        .profile-trigger {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            transition: transform 0.2s ease;
        }
        .profile-trigger:active {
            transform: scale(0.95);
        }

        .avatar-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--color-primary), #ff6b6b);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            box-shadow: var(--shadow-sm);
            border: 2px solid var(--color-bg-card);
        }

        /* POPOVER */
        .profile-popover {
            position: absolute;
            top: calc(100% + 14px);
            right: 0;
            width: 280px;
            background: var(--color-bg-card);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--color-border);
            z-index: 2000;
            
            /* ANIMATION SYSTEM */
            opacity: 0;
            transform: translateY(-8px) scale(0.98);
            visibility: hidden;
            transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
            transform-origin: top right;
        }

        .profile-popover.active {
            opacity: 1;
            transform: translateY(0) scale(1);
            visibility: visible;
        }

        /* HEADER */
        .popover-header {
            padding: var(--space-lg);
            display: flex;
            align-items: center;
            gap: var(--space-md);
        }
        .header-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--color-primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
        }
        .header-info {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .user-name {
            font-weight: 700;
            font-size: 15px;
            color: var(--color-text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-email {
            font-size: 12px;
            color: var(--color-text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-role-badge {
            display: inline-block;
            margin-top: 4px;
            font-size: 10px;
            font-weight: 700;
            color: var(--color-primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: rgba(227, 6, 19, 0.1);
            padding: 2px 6px;
            border-radius: 4px;
            align-self: flex-start;
        }

        .popover-divider {
            height: 1px;
            background: var(--color-divider);
            margin: 0;
        }

        /* MENU */
        .popover-menu {
            padding: var(--space-sm);
        }
        .menu-item {
            display: flex;
            align-items: center;
            gap: var(--space-md);
            padding: 0 var(--space-lg);
            height: 44px;
            color: var(--color-text-primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: var(--radius-md);
            transition: background 0.2s ease;
        }
        .menu-item:hover {
            background: var(--color-hover);
            color: var(--color-text-primary);
        }
        .menu-item.text-danger {
            color: var(--color-danger);
        }
        .menu-item.text-danger:hover {
            background: rgba(220, 53, 69, 0.05);
        }
        .menu-item i {
            font-size: 18px;
            opacity: 0.8;
        }

        /* THEME TOGGLE */
        .theme-toggle-btn {
            background: none;
            border: none;
            color: var(--color-text-secondary);
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .theme-toggle-btn:hover {
            background: var(--color-hover);
            color: var(--color-primary);
        }

        /* 
         * ==========================================
         * 4. REUSABLE CARD COMPONENT
         * ==========================================
         */
        .card-dashboard {
            background: var(--color-bg-card);
            color: var(--color-text-primary);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            overflow: hidden;
            margin-bottom: var(--space-lg);
        }
        
        .card-dashboard:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .card-dashboard .card-header {
            background: transparent;
            border-bottom: 1px solid var(--color-border);
            padding: var(--space-lg);
            font-weight: 700;
            color: var(--color-text-primary);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-dashboard .card-body {
            padding: var(--space-lg);
        }

        [data-theme="dark"] .breadcrumb-item + .breadcrumb-item::before {
            color: var(--color-text-secondary);
        }

        /* 
         * ==========================================
         * 5. DARK MODE GLOBAL OVERRIDES
         * ==========================================
         */
        [data-theme="dark"] .bg-white { background-color: var(--color-bg-card) !important; color: var(--color-text-primary) !important; }
        [data-theme="dark"] .bg-light { background-color: var(--color-hover) !important; color: var(--color-text-primary) !important; }
        [data-theme="dark"] .text-dark { color: var(--color-text-primary) !important; }
        [data-theme="dark"] .text-muted { color: var(--color-text-secondary) !important; }
        
        /* Bootstrap Card Override */
        [data-theme="dark"] .card { background-color: var(--color-bg-card); border-color: var(--color-border); color: var(--color-text-primary); }
        [data-theme="dark"] .card-header { border-bottom-color: var(--color-border); }
        [data-theme="dark"] .card-footer { border-top-color: var(--color-border); background-color: var(--color-bg-main); }

        /* Bootstrap Table Override (Aktivitas Marketing & Wilayah) */
        [data-theme="dark"] .table { color: var(--color-text-primary); border-color: var(--color-border); }
        [data-theme="dark"] .table > :not(caption) > * > * { background-color: transparent; border-bottom-color: var(--color-border); color: var(--color-text-primary); box-shadow: none; }
        [data-theme="dark"] .table-hover > tbody > tr:hover > * { background-color: var(--color-hover); color: var(--color-text-primary); }
        
        /* Table Danger Override for Dark Mode (Agar tidak terlalu terang) */
        [data-theme="dark"] .table-danger { background-color: rgba(220, 53, 69, 0.2) !important; color: #ffdae0 !important; }
        [data-theme="dark"] .table-danger th, 
        [data-theme="dark"] .table-danger td { background-color: rgba(220, 53, 69, 0.2) !important; color: #ffdae0 !important; border-color: rgba(220, 53, 69, 0.3); }

        /* Form Controls */
        [data-theme="dark"] .form-control, 
        [data-theme="dark"] .form-select { background-color: var(--color-bg-main); border-color: var(--color-border); color: var(--color-text-primary); }
        [data-theme="dark"] .form-control:focus, 
        [data-theme="dark"] .form-select:focus { background-color: var(--color-bg-card); border-color: var(--color-primary); color: var(--color-text-primary); }
    </style>
</head>

<body class="{{ Auth::check() ? '' : 'guest' }}">

@auth
{{-- OVERLAY MOBILE --}}
<div class="sidebar-overlay"></div>

{{-- ================= SIDEBAR ================= --}}
<div class="sidebar-gov">
    {{-- LOGO SECTION --}}
    <div class="sidebar-logo">
        <img src="{{ asset('img/telkom-original.png') }}" alt="Telkom Indonesia">
        <div class="sidebar-logo-text">
            MONITORING<br>WITEL LAMPUNG–BENGKULU
        </div>
    </div>

    {{-- MENU --}}
    <a href="/dashboard-gs" class="nav-link {{ request()->is('dashboard-gs*') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
    </a>

    <div class="nav-separator"></div>

    <a href="/peluang-gs" class="nav-link {{ request()->is('peluang-gs*') ? 'active' : '' }}">
        <i class="bi bi-briefcase"></i> <span>Peluang Proyek GS</span>
    </a>
    <a href="/data-wilayah-gs" class="nav-link {{ request()->is('data-wilayah-gs*') ? 'active' : '' }}">
        <i class="bi bi-geo-alt"></i> <span>Wilayah</span>
    </a>
    <a href="/aktivitas-marketing" class="nav-link {{ request()->is('aktivitas-marketing*') ? 'active' : '' }}">
        <i class="bi bi-activity"></i> <span>Aktivitas Marketing</span>
    </a>

    <div class="sidebar-footer">
        © 2026 Telkom Indonesia<br>
        Monitoring Sales Government
    </div>
</div>

{{-- ================= NAVBAR ================= --}}
<nav class="navbar-gov">
    {{-- LEFT: TOGGLE & BREADCRUMB --}}
    <div class="d-flex align-items-center">
        <button class="toggle-btn" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        
        {{-- BREADCRUMB --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><span style="font-size: 0.9rem; color: var(--color-text-secondary);">Pages</span></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page" style="font-size: 0.9rem; color: var(--color-text-primary);">
                    @yield('title', 'Dashboard')
                </li>
            </ol>
        </nav>
    </div>

    {{-- RIGHT: USER --}}
    <div class="ms-auto d-flex align-items-center gap-3">
        {{-- THEME TOGGLE --}}
        <button class="theme-toggle-btn" id="themeToggle" title="Toggle Dark Mode">
            <i class="bi bi-moon-stars"></i>
        </button>

        <div class="d-none d-md-block text-end me-2">
            <div style="font-size: 14px; font-weight: 600; color: var(--color-text-primary);">Hallo, {{ Auth::user()->name }}</div>
            <div style="font-size: 11px; color: var(--color-text-secondary);">{{ Auth::user()->email }}</div>
        </div>
        
        {{-- PREMIUM PROFILE DROPDOWN --}}
        <div class="profile-dropdown-wrapper">
            <button class="profile-trigger" id="profileTrigger">
                <div class="avatar-circle">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </button>

            <div class="profile-popover" id="profilePopover">
                <div class="popover-header">
                    <div class="header-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="header-info">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-email">{{ Auth::user()->email }}</div>
                        <div class="user-role-badge">{{ strtoupper(Auth::user()->role) }}</div>
                    </div>
                </div>
                
                <div class="popover-divider"></div>

                <div class="popover-menu">
                    <a href="#" class="menu-item text-danger" id="btn-logout-trigger">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
            @csrf
        </form>
    </div>
</nav>
@endauth

{{-- ================= CONTENT ================= --}}
<div class="content-gov">
    @yield('content')
</div>

{{-- STACK SCRIPT (MAP / CHART) --}}
@stack('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar-gov');
        const content = document.querySelector('.content-gov');
        const navbar = document.querySelector('.navbar-gov');
        const overlay = document.querySelector('.sidebar-overlay');

        if(toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('collapsed');
                navbar.classList.toggle('collapsed');
                
                // Mobile handling
                if(window.innerWidth <= 768) {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                }
            });
        }

        // Tutup sidebar saat klik overlay (Mobile)
        if(overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }

        /* ==========================================
         * PREMIUM POPOVER LOGIC
         * ========================================== */
        const profileTrigger = document.getElementById('profileTrigger');
        const profilePopover = document.getElementById('profilePopover');

        if(profileTrigger && profilePopover) {
            // Toggle Click
            profileTrigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                profilePopover.classList.toggle('active');
            });

            // Close on Click Outside
            document.addEventListener('click', function(e) {
                if (!profileTrigger.contains(e.target) && !profilePopover.contains(e.target)) {
                    profilePopover.classList.remove('active');
                }
            });

            // Close on ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    profilePopover.classList.remove('active');
                }
            });
        }

        /* ==========================================
         * DARK MODE TOGGLE
         * ========================================== */
        const themeToggle = document.getElementById('themeToggle');
        const htmlEl = document.documentElement;
        
        // Load saved theme
        if(localStorage.getItem('theme') === 'dark') {
            htmlEl.setAttribute('data-theme', 'dark');
        }

        if(themeToggle) {
            themeToggle.addEventListener('click', function() {
                if(htmlEl.getAttribute('data-theme') === 'dark') {
                    htmlEl.removeAttribute('data-theme');
                    localStorage.setItem('theme', 'light');
                } else {
                    htmlEl.setAttribute('data-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                }
            });
        }

        /* ==========================================
         * LOGOUT CONFIRMATION (SWEETALERT)
         * ========================================== */
        const btnLogout = document.getElementById('btn-logout-trigger');
        if(btnLogout) {
            btnLogout.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi Logout',
                    text: "Apakah Anda yakin ingin keluar?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });
            });
        }
    });
</script>

</body>
</html>
