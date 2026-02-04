<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Witel Monitoring') }} - @yield('title')</title>

    <!-- Bootstrap CSS (via Vite) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --telkom-red: #e30613;
            --telkom-dark: #2d2d2d;
            --telkom-grey: #f4f6f9;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --header-height: 70px;
            --transition-speed: 0.3s;
        }

        /* Fix for select option text visibility */
        select,
        .form-select,
        select option {
            color: #000 !important;
            background-color: #fff !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--telkom-grey);
            overflow-x: hidden;
        }

        /* -------------------------------------------
           SIDEBAR
        ------------------------------------------- */
        #sidebar-wrapper {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            background: linear-gradient(180deg, var(--telkom-red) 0%, #b90510 100%);
            color: white;
            transition: all var(--transition-speed);
            display: flex;
            /* Flex container */
            flex-direction: column;
            /* Column layout */
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }

        /* Collapsed State */
        body.sb-sidenav-toggled #sidebar-wrapper {
            width: var(--sidebar-collapsed-width);
        }

        body.sb-sidenav-toggled #sidebar-wrapper .sidebar-brand h4,
        body.sb-sidenav-toggled #sidebar-wrapper .sidebar-brand small,
        body.sb-sidenav-toggled #sidebar-wrapper .sidebar-menu span {
            display: none;
            opacity: 0;
        }

        body.sb-sidenav-toggled #sidebar-wrapper .sidebar-menu a,
        body.sb-sidenav-toggled #sidebar-wrapper .sidebar-menu button {
            justify-content: center;
            padding: 1rem 0;
        }

        body.sb-sidenav-toggled #sidebar-wrapper .sidebar-menu i {
            margin-right: 0;
            font-size: 1.2rem;
        }

        /* Brand */
        .sidebar-brand {
            height: var(--header-height);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 0 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.05);
            white-space: nowrap;
        }

        .sidebar-brand h4 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .sidebar-brand small {
            font-size: 0.7rem;
            opacity: 0.8;
            margin-top: 4px;
        }

        /* Menu */
        .sidebar-menu {
            padding: 1.5rem 0.5rem;
            display: flex;
            flex-direction: column;
            flex: 1;
            /* Take remaining height */
            overflow-y: auto;
            /* Allow scrolling for menu items */
            overflow-x: hidden;
        }

        .sidebar-menu a,
        .sidebar-menu button {
            display: flex;
            align-items: center;
            padding: 0.8rem 1.2rem;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: all 0.2s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            position: relative;
            white-space: nowrap;
            cursor: pointer;
            flex-shrink: 0;
            /* Prevent items from shrinking */
        }

        .sidebar-menu a:hover,
        .sidebar-menu button:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(3px);
        }

        .sidebar-menu a.active {
            background-color: white;
            color: var(--telkom-red);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-weight: 600;
        }

        .sidebar-menu i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 12px;
            text-align: center;
            transition: margin 0.3s;
        }

        /* Custom Button & Form Styles */
        .btn-telkom {
            background: linear-gradient(135deg, var(--telkom-red) 0%, #ff4757 100%);
            border: none;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(227, 6, 19, 0.3);
            transition: all 0.3s;
        }

        .btn-telkom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(227, 6, 19, 0.4);
            color: white;
        }

        .form-control,
        .form-select {
            border: 1px solid #e0e0e0;
            padding: 0.7rem 1rem;
            border-radius: 8px;
            background-color: #fcfcfc;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--telkom-red);
            box-shadow: 0 0 0 0.2rem rgba(227, 6, 19, 0.1);
            background-color: white;
        }

        .form-label {
            font-weight: 600;
            color: var(--telkom-dark);
            margin-bottom: 0.5rem;
        }

        .logout-section {
            margin-top: auto;
            /* Push to bottom */
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            padding-bottom: 1rem;
        }

        /* -------------------------------------------
           MAIN CONTENT
        ------------------------------------------- */
        #page-content-wrapper {
            margin-left: var(--sidebar-width);
            transition: all var(--transition-speed);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        body.sb-sidenav-toggled #page-content-wrapper {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* -------------------------------------------
           NAVBAR (Top Header)
        ------------------------------------------- */
        .navbar-custom {
            height: var(--header-height);
            background: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.04);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        #sidebarToggle {
            background: transparent;
            border: none;
            font-size: 1.25rem;
            color: var(--telkom-dark);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: background 0.3s;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.5rem;
        }

        #sidebarToggle:hover {
            background-color: #f0f0f0;
            color: var(--telkom-red);
        }

        .user-dropdown {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info {
            text-align: right;
            line-height: 1.2;
        }

        .user-info .name {
            display: block;
            font-weight: 600;
            color: var(--telkom-dark);
            font-size: 0.95rem;
        }

        .user-info .role {
            font-size: 0.75rem;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--telkom-red), #ff6b6b);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(227, 6, 19, 0.2);
        }

        /* -------------------------------------------
           CONTENT AREA
        ------------------------------------------- */
        .content-wrapper {
            padding: 2rem;
            flex: 1;
        }

        .page-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: end;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--telkom-dark);
            margin-bottom: 0.25rem;
        }

        .breadcrumb {
            margin: 0;
            background: transparent;
            padding: 0;
            font-size: 0.9rem;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .icon-circle {
            width: 54px;
            height: 54px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Responsive Mobile */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #page-content-wrapper {
                margin-left: 0;
            }

            body.sb-sidenav-toggled #sidebar-wrapper {
                margin-left: 0;
                width: var(--sidebar-width);
            }

            body.sb-sidenav-toggled #page-content-wrapper {
                margin-left: 0;
            }

            body.sb-sidenav-toggled #sidebar-wrapper .sidebar-brand h4,
            body.sb-sidenav-toggled #sidebar-wrapper .sidebar-brand small,
            body.sb-sidenav-toggled #sidebar-wrapper .sidebar-menu span {
                display: block;
                opacity: 1;
            }

            /* Overlay effect for mobile */
            body.sb-sidenav-toggled::before {
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 900;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-brand">
                <h4>Monitoring Gov</h4>
                <small>Telkom Witel Lampung-Bengkulu</small>
            </div>

            <nav class="sidebar-menu">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('wilayah.index') }}" class="{{ request()->routeIs('wilayah.*') ? 'active' : '' }}">
                        <i class="fas fa-map-marked-alt"></i>
                        <span>Data Wilayah</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i>
                        <span>Manajemen User</span>
                    </a>
                @endif

                <div class="logout-section">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <!-- Top Navbar -->
            <nav class="navbar-custom">
                <button id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="ms-3 d-none d-md-block text-muted">
                    <i class="far fa-calendar-alt me-1"></i>
                    {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                </div>

                <div class="user-dropdown">
                    <div class="user-info d-none d-sm-block">
                        <span class="name">{{ auth()->user()->name }}</span>
                        <span class="role">{{ auth()->user()->role }}</span>
                    </div>
                    <div class="user-avatar">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="content-wrapper">
                <div class="page-header">
                    <div>
                        <h2 class="page-title">@yield('page-title')</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @yield('breadcrumb')
                            </ol>
                        </nav>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts via Vite (Bootstrap Bundle included) -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const body = document.body;

            // Restore state from local storage
            if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
                body.classList.add('sb-sidenav-toggled');
            }

            sidebarToggle.addEventListener('click', function (event) {
                event.preventDefault();
                body.classList.toggle('sb-sidenav-toggled');

                // Save state to local storage
                localStorage.setItem('sb|sidebar-toggle', body.classList.contains('sb-sidenav-toggled'));
            });

            // Mobile overlay click to close
            document.addEventListener('click', function (e) {
                if (window.innerWidth <= 768 &&
                    body.classList.contains('sb-sidenav-toggled') &&
                    !e.target.closest('#sidebar-wrapper') &&
                    !e.target.closest('#sidebarToggle')) {
                    body.classList.remove('sb-sidenav-toggled');
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>