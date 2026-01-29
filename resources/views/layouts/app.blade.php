<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Monitoring Aktivitas Sales Government</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- VITE --}}
    @vite(['resources/sass/app.scss','resources/js/app.js'])

    {{-- ICON --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    {{-- CHART --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- STACK STYLE (MAP / CHART) --}}
    @stack('styles')

    <style>
        body {
            background:#f4f6f9;
            margin:0;
        }

        /* ================= NAVBAR ================= */
        .navbar-gov {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: linear-gradient(90deg,#b30000,#ff1a1a);
            z-index: 1050;
            display: flex;
            align-items: center;
            padding: 0 20px;
            color: #fff;
        }

        /* ================= SIDEBAR ================= */
        .sidebar-gov {
            position: fixed;
            top: 56px;
            left: 0;
            bottom: 0;
            width: 240px;
            background: linear-gradient(180deg,#b30000,#7a0000);
            padding: 16px;
            color: #fff;
            display: flex;
            flex-direction: column;
        }

        .sidebar-gov a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 6px;
            transition: .2s;
            font-size: 14px;
        }

        .sidebar-gov a:hover,
        .sidebar-gov a.active {
            background: #fff;
            color: #b30000;
        }

        .sidebar-footer {
            margin-top: auto;
            font-size: 12px;
            opacity: .85;
            padding-top: 12px;
        }

        /* ================= CONTENT ================= */
        .content-gov {
            margin-left: 240px;
            margin-top: 56px;
            padding: 24px;
            min-height: calc(100vh - 56px);
        }

        /* LOGIN PAGE (NO SIDEBAR SHIFT) */
        body.guest .content-gov {
            margin-left: 0;
        }
    </style>
</head>

<body class="{{ Auth::check() ? '' : 'guest' }}">

{{-- ================= NAVBAR ================= --}}
<nav class="navbar-gov">
    <img src="{{ asset('images/logotelkom.png') }}" height="28" class="me-2">
    <strong>Monitoring Aktivitas Sales Government</strong>

    <div class="ms-auto">
        @auth
            Halo, {{ Auth::user()->name }} |
            <a href="{{ route('logout') }}" class="text-white text-decoration-none"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="text-white text-decoration-none">
                Login
            </a>
        @endguest
    </div>
</nav>

{{-- ================= SIDEBAR (LOGIN ONLY) ================= --}}
@auth
<div class="sidebar-gov">
    <a href="/dashboard-gs" class="{{ request()->is('dashboard-gs*') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard GS
    </a>
    <a href="/peluang-gs">
        <i class="bi bi-briefcase"></i> Peluang Proyek GS
    </a>
    <a href="/wilayah">
        <i class="bi bi-geo-alt"></i> Wilayah
    </a>
    <a href="/aktivitas-marketing">
        <i class="bi bi-activity"></i> Aktivitas Marketing
    </a>

    <div class="sidebar-footer">
        © 2026 Telkom Indonesia<br>
        Monitoring Sales Government
    </div>
</div>
@endauth

{{-- ================= CONTENT ================= --}}
<div class="content-gov">
    @yield('content')
</div>

{{-- STACK SCRIPT (MAP / CHART) --}}
@stack('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
