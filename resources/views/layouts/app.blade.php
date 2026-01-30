<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Witel Monitoring') - Telkom Witel Lampung-Bengkulu</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --telkom-red: #EF4444;
            --telkom-red-dark: #DC2626;
            --telkom-red-light: #F87171;
            --telkom-red-accent: #B91C1C;
            --telkom-gray: #6C757D;
            --telkom-light: #F8F9FA;
            --sidebar-width: 300px;
            --sidebar-collapsed-width: 70px;
        }

        /* Fix for select option text visibility */
        select,
        .form-select,
        select option {
            color: #000 !important;
            background-color: #fff !important;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #F5F7FA;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--telkom-red);
            color: white;
            z-index: 1000;
            box-shadow: 2px 0 15px rgba(239, 68, 68, 0.15);
            transition: width 0.3s ease;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            min-height: 110px;
            display: flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.02) 100%);
            position: relative;
        }

        .sidebar-header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.6) 50%, transparent 100%);
        }

        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            transition: all 0.3s ease;
            width: 100%;
            padding: 16px 20px;
            border: 2px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-brand:hover {
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3), 0 0 40px rgba(255, 255, 255, 0.2);
        }

        .logo-wrapper {
            position: relative;
        }

        .sidebar-brand img {
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.4));
            transition: all 0.3s ease;
        }

        .sidebar-brand:hover img {
            filter: drop-shadow(0 6px 16px rgba(255, 255, 255, 0.5)) drop-shadow(0 0 30px rgba(255, 255, 255, 0.4));
            transform: scale(1.08);
        }

        .brand-text {
            text-align: center;
        }

        .brand-text span {
            font-size: 1.3rem !important;
            font-weight: 900 !important;
            letter-spacing: 2.5px !important;
            color: white !important;
            text-shadow: 0 3px 12px rgba(0, 0, 0, 0.3);
            display: block;
            line-height: 1 !important;
        }

        .brand-text small {
            font-size: 0.65rem !important;
            opacity: 0.95 !important;
            font-weight: 600 !important;
            letter-spacing: 2px !important;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            display: block;
            margin-top: 5px !important;
            color: rgba(255, 255, 255, 0.95) !important;
        }

        /* Hide text elements when collapsed */
        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .sidebar-user-info,
        .sidebar.collapsed .nav-section-title,
        .sidebar.collapsed .sidebar-brand small {
            display: none !important;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 1.5rem 0;
            min-height: 80px;
        }

        .sidebar.collapsed .sidebar-header::after {
            width: 80%;
        }

        .sidebar.collapsed .sidebar-brand {
            padding: 12px;
        }

        .sidebar.collapsed .logo-wrapper {
            margin: 0;
        }

        .sidebar.collapsed .sidebar-brand img {
            width: 45px !important;
        }

        .sidebar.collapsed .sidebar-user {
            padding: 1rem 0.5rem;
            justify-content: center;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem 0;
            margin: 0.25rem 0.5rem;
        }

        .sidebar.collapsed .nav-link i {
            margin: 0;
            font-size: 1.25rem;
        }

        .sidebar-user {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(0, 0, 0, 0.1);
            margin-top: auto;
            /* Push to bottom */
        }

        .sidebar-user-avatar {
            width: 35px;
            height: 35px;
            min-width: 35px;
            border-radius: 50%;
            background: white;
            color: var(--telkom-red);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .sidebar-user-info {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-user-name {
            font-weight: 600;
            font-size: 0.9rem;
            margin: 0;
        }

        .sidebar-user-role {
            font-size: 0.75rem;
            opacity: 0.8;
            margin: 0;
        }

        .sidebar-nav {
            padding: 1rem 0;
            flex-grow: 1;
            /* Allow growing to fill space */
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE and Edge */
        }

        .sidebar-nav::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        .nav-section-title {
            padding: 0.75rem 1.25rem;
            margin: 0.5rem 1rem 0.25rem 1rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.75;
            font-weight: 600;
            white-space: nowrap;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.95);
            padding: 0.75rem 1.25rem;
            margin: 0.25rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 12px;
            white-space: nowrap;
            font-weight: 500;
        }

        .nav-link:hover {
            background: white;
            color: var(--telkom-red);
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .nav-link.active {
            background: white;
            color: var(--telkom-red);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .nav-link i {
            font-size: 1.125rem;
            width: 24px;
            text-align: center;
            display: flex;
            justify-content: center;
            transition: all 0.3s ease;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }

        .topbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2C3E50;
            margin: 0;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0.25rem 0 0 0;
            font-size: 0.875rem;
        }

        .content-wrapper {
            padding: 2rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #E9ECEF;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: #2C3E50;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn-telkom {
            background: linear-gradient(135deg, var(--telkom-red) 0%, var(--telkom-red-dark) 100%);
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
        }

        .btn-telkom:hover {
            background: linear-gradient(135deg, var(--telkom-red-light) 0%, var(--telkom-red) 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(239, 68, 68, 0.35);
        }

        /* Table */
        .table {
            font-size: 0.9rem;
        }

        .table thead th {
            background: #F8F9FA;
            border-bottom: 2px solid #DEE2E6;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6C757D;
        }

        /* Badges */
        .badge {
            padding: 0.375rem 0.75rem;
            font-weight: 500;
            font-size: 0.75rem;
        }

        .badge-lancar {
            background: #28A745;
        }

        .badge-tertunda {
            background: #FFC107;
            color: #000;
        }

        .badge-overdue {
            background: #DC3545;
        }

        /* Form */
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 6px;
            border: 1px solid #DEE2E6;
            padding: 0.625rem 0.875rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--telkom-red);
            box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.2);
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            border: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }
        }

        /* Updated Topbar Styles */
        .topbar {
            background: white;
            padding: 0.8rem 2rem;
            /* box-shadow: 0 1px 2px rgba(0,0,0,0.03); */
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .breadcrumb-nav {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            color: #888;
        }

        .breadcrumb-nav .separator {
            margin: 0 0.5rem;
        }

        .breadcrumb-nav .current {
            color: #333;
            font-weight: 500;
        }

        .header-search {
            position: relative;
            max-width: 400px;
            width: 100%;
            margin: 0 2rem;
        }

        .header-search input {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 50px;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            width: 100%;
            font-size: 0.9rem;
            transition: all 0.2s;
            color: #666;
        }

        .header-search input:focus {
            border-color: var(--telkom-red);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12);
            outline: none;
        }

        .header-search i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            font-size: 0.9rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .header-icon-btn {
            border: none;
            background: none;
            color: #666;
            font-size: 1.1rem;
            padding: 0;
            cursor: pointer;
            transition: color 0.2s;
            display: flex;
            align-items: center;
        }

        .header-icon-btn:hover {
            color: var(--telkom-red);
        }

        .header-profile-img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #eee;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard.ssgs') }}" class="sidebar-brand text-decoration-none">
                <div class="logo-wrapper">
                    <img src="{{ asset('img/telkom-original.png') }}" alt="Telkom Indonesia"
                        style="width: 90px; height: auto;">
                </div>
                <div class="brand-text">
                    <span>MONITORING</span>
                    <small>WITEL LAMPUNG-BENGKULU</small>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Dashboard</div>

            @if(Auth::user()->role === 'admin')
                <a href="{{ route('dashboard') }}" class="nav-link" title="Back to Admin Dashboard">
                    <i class="bi bi-arrow-left-circle"></i>
                    <span>Admin Dashboard</span>
                </a>
            @else
                <a href="{{ route('dashboard.ssgs') }}" class="nav-link {{ request()->routeIs('dashboard.ssgs') ? 'active' : '' }}"
                    title="Dashboard">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            @endif

            <div class="nav-section-title">SSGS Management</div>
            <a href="{{ route('pelanggan.index') }}"
                class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}" title="Data Pelanggan">
                <i class="bi bi-building"></i>
                <span>Data Pelanggan</span>
            </a>
            <a href="{{ route('kunjungan.index') }}"
                class="nav-link {{ request()->routeIs('kunjungan.*') ? 'active' : '' }}" title="Interaksi">
                <i class="bi bi-chat-square-text"></i>
                <span>Interaksi</span>
            </a>
            <a href="{{ route('pembayaran.index') }}"
                class="nav-link {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}" title="Pembayaran">
                <i class="bi bi-cash-coin"></i>
                <span>Pembayaran</span>
            </a>



        </nav>

        {{-- Bagian Khusus Admin --}}
        @if(Auth::user()->role === 'admin')
            <div class="nav-section-title">Admin Management</div>
            <a href="{{ route('admin.users.index') }}"
                class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" title="Manajemen User">
                <i class="bi bi-people-fill"></i>
                <span>Manajemen User</span>
            </a>
        @endif


        <div class="nav-section-title mb-2">Akun</div>
        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            title="Logout">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

        @auth
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <p class="sidebar-user-name">{{ Auth::user()->name }}</p>
                    <p class="sidebar-user-role">{{ strtoupper(str_replace('_', ' ', Auth::user()->role)) }}</p>
                </div>
            </div>
        @endauth
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <div class="topbar">
            <!-- Left: Toggle & Breadcrumb -->
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark p-0 me-3" id="sidebarToggle">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="breadcrumb-nav">
                    <span class="text-muted">Pages</span>
                    <span class="separator">/</span>
                    <span class="current">@yield('page-title', 'Dashboard')</span>
                </div>
            </div>

            <!-- Center: Search -->
            <div class="header-search d-none d-md-block">
                <i class="bi bi-search"></i>
                <input type="text" id="headerSearch" placeholder="Cari pelanggan, kunjungan, pembayaran... (Ctrl+K)">
            </div>

            <!-- Right: Icons & Profile -->
            <div class="header-actions">
                <!-- Notifications -->
                <div class="dropdown">
                    <button class="header-icon-btn position-relative" title="Notifications" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-bell"></i>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 0.5rem; padding: 0.25em 0.4em;">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="width: 320px;">
                        <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                            <h6 class="dropdown-header p-0 m-0">Notifications</h6>
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('mark-read-form').submit();"
                                class="text-decoration-none small text-danger">Mark all as read</a>
                            <form id="mark-read-form" action="{{ route('notifications.markRead') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        </div>
                        <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                            @forelse(Auth::user()->notifications->take(5) as $notification)
                            <a href="{{ $notification->data['action_url'] ?? '#' }}"
                                class="list-group-item list-group-item-action px-3 py-3 {{ $notification->read_at ? '' : 'bg-light' }}">
                                <div class="d-flex align-items-start">
                                    <div class="bg-{{ $notification->data['type'] ?? 'primary' }} bg-opacity-10 text-{{ $notification->data['type'] ?? 'primary' }} rounded-circle p-2 me-3 d-flex align-items-center justify-content-center"
                                        style="width: 32px; height: 32px; min-width: 32px;">
                                        <i class="{{ $notification->data['icon'] ?? 'bi-bell' }}" style="font-size: 0.9rem;"></i>
                                    </div>
                                    <div>
                                        <p class="mb-1 small fw-bold text-dark">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                        <p class="mb-1 small text-muted">{{ $notification->data['message'] ?? '' }}</p>
                                        <small class="text-secondary" style="font-size: 0.7rem;">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <div class="p-3 text-center text-muted">
                                <small>No notifications</small>
                            </div>
                            @endforelse
                        </div>
                        <div class="text-center p-2 border-top">
                            <a href="{{ route('notifications.index') }}"
                                class="small text-decoration-none fw-bold text-danger">View All Notifications</a>
                        </div>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        @auth
                            <div class="header-profile-img text-white d-flex align-items-center justify-content-center fw-bold"
                                style="font-size: 0.9rem; background-color: var(--telkom-red);">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @else
                            <div
                                class="header-profile-img bg-secondary text-white d-flex align-items-center justify-content-center">
                                <i class="bi bi-person"></i>
                            </div>
                        @endauth
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        @auth
                            <li>
                                <h6 class="dropdown-header">{{ Auth::user()->name }}</h6>
                            </li>
                        @endauth
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i
                                    class="bi bi-person me-2"></i> Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
                <form id="logout-form-header" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <div class="content-wrapper">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Check localStorage
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('collapsed');
            }

            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');

                // Save state
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            });
        });

        // Search Functionality
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.querySelector('#headerSearch');

            if (searchInput) {
                searchInput.addEventListener('input', function (e) {
                    const searchTerm = e.target.value.toLowerCase();

                    // Search in tables
                    const tables = document.querySelectorAll('table tbody tr');
                    let visibleCount = 0;

                    tables.forEach(row => {
                        // Skip if it's the no-results row
                        if (row.classList.contains('no-results-row')) {
                            return;
                        }

                        const text = row.textContent.toLowerCase();
                        if (text.includes(searchTerm) || searchTerm === '') {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Search in cards
                    const cards = document.querySelectorAll('.card');
                    cards.forEach(card => {
                        const text = card.textContent.toLowerCase();
                        if (text.includes(searchTerm) || searchTerm === '') {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Show "no results" message if needed
                    if (searchTerm && visibleCount === 0 && tables.length > 0) {
                        let noResultsRow = document.querySelector('.no-results-row');
                        if (!noResultsRow) {
                            const tbody = document.querySelector('table tbody');
                            if (tbody) {
                                noResultsRow = document.createElement('tr');
                                noResultsRow.className = 'no-results-row';
                                const colCount = tbody.closest('table').querySelector('thead tr')?.children.length || 5;
                                noResultsRow.innerHTML = `
                                    <td colspan="${colCount}" class="text-center py-4 text-muted">
                                        <i class="bi bi-search fs-3 d-block mb-2"></i>
                                        Tidak ada hasil untuk "${e.target.value}"
                                    </td>
                                `;
                                tbody.appendChild(noResultsRow);
                            }
                        }
                    } else {
                        const noResultsRow = document.querySelector('.no-results-row');
                        if (noResultsRow) {
                            noResultsRow.remove();
                        }
                    }
                });

                // Add keyboard shortcut (Ctrl/Cmd + K)
                document.addEventListener('keydown', function (e) {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                        e.preventDefault();
                        searchInput.focus();
                    }
                });
            }
    });
    </script>

    @stack('scripts')
</body>

</html>