<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Witel Gov Monitoring') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .hero-section {
            background: linear-gradient(135deg, #e30613 0%, #ff4757 100%);
            color: white;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }

        .btn-light-custom {
            background-color: white;
            color: #e30613;
            font-weight: 600;
        }

        .btn-light-custom:hover {
            background-color: #f8f9fa;
            color: #b90510;
        }
    </style>
</head>

<body class="antialiased bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-danger" href="#">
                <i class="fas fa-chart-line me-2"></i>Witel Gov Monitoring
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="btn btn-outline-danger">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item me-2">
                                <a href="{{ route('login') }}" class="btn btn-outline-danger">Log in</a>
                            </li>
                            {{-- @if (Route::has('register'))
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="btn btn-danger">Register</a>
                            </li>
                            @endif --}}
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section text-center pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-3 fw-bold mb-4">Monitoring Sales Government & SSGS</h1>
                    <p class="lead mb-5 opacity-75">
                        Sistem Informasi Dashboard Monitoring Kinerja dan Penjualan <br>
                        Telkom Witel Lampung - Bengkulu
                    </p>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-light-custom btn-lg px-5 py-3 rounded-pill shadow">
                            Akses Dashboard <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light-custom btn-lg px-5 py-3 rounded-pill shadow">
                            Login Sekarang <i class="fas fa-sign-in-alt ms-2"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <footer class="py-4 bg-white text-center text-muted border-top">
        <div class="container">
            <small>&copy; {{ date('Y') }} PT Telekomunikasi Indonesia Tbk. Witel Lampung - Bengkulu. All rights
                reserved.</small>
        </div>
    </footer>

</body>

</html>