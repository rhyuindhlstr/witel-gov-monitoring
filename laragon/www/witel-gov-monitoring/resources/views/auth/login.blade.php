<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'Witel Monitoring') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --telkom-red: #e30613;
            --telkom-dark: #2d2d2d;
            --telkom-grey: #f4f6f9;
            --telkom-light-red: #ff4757;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            overflow: hidden;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .login-wrapper {
            display: flex;
            height: 100vh;
            position: relative;
        }

        /* LEFT SIDE - Login Form */
        .login-form-section {
            flex: 0 0 45%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            background: white;
            position: relative;
            z-index: 2;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .telkom-logo-img {
            max-width: 200px;
            height: auto;
            margin: 0 auto 1.5rem;
            display: block;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--telkom-dark);
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .form-subtitle {
            font-size: 0.9rem;
            color: #6c757d;
            text-align: center;
            margin-bottom: 2rem;
            display: block;
        }



        .login-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--telkom-dark);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--telkom-red);
            box-shadow: 0 0 0 0.2rem rgba(227, 6, 19, 0.15);
            outline: none;
        }

        .invalid-feedback {
            font-size: 0.85rem;
        }

        .form-check {
            margin-bottom: 1.5rem;
        }

        .form-check-input:checked {
            background-color: var(--telkom-red);
            border-color: var(--telkom-red);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(227, 6, 19, 0.15);
        }

        .forgot-password {
            color: var(--telkom-red);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .forgot-password:hover {
            color: var(--telkom-light-red);
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, var(--telkom-red) 0%, var(--telkom-light-red) 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(227, 6, 19, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(227, 6, 19, 0.4);
        }

        /* RIGHT SIDE - Image Carousel */
        .carousel-section {
            flex: 1;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #e30613 0%, #ff4757 100%);
        }

        .carousel-container {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .carousel-slide {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-slide.active {
            opacity: 1;
        }

        .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .carousel-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2rem;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, transparent 100%);
            color: white;
            text-align: center;
        }

        .carousel-overlay h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .carousel-overlay p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .carousel-indicators {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
            margin: 0;
            /* Override Bootstrap */
            padding: 0;
            /* Override Bootstrap */
            right: auto;
            /* Override Bootstrap */
            width: auto;
            /* Override Bootstrap */
        }

        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s;
        }

        .indicator.active {
            background: white;
            width: 30px;
            border-radius: 6px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-form-section {
                flex: 0 0 auto;
                padding: 2rem 1.5rem;
            }

            .carousel-section {
                flex: 1;
                min-height: 300px;
            }

            .carousel-overlay h2 {
                font-size: 1.5rem;
            }

            .carousel-overlay p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <!-- LEFT SIDE: Login Form -->
        <div class="login-form-section">
            <div class="form-container">
                <!-- Logo outside card -->
                <div class="logo-section">
                    <img src="{{ asset('images/telkom_logo.png') }}" alt="Telkom Indonesia" class="telkom-logo-img">
                </div>

                <!-- Card with login form -->
                <div class="login-card">
                    <h1 class="form-title">Login</h1>
                    <p class="form-subtitle">Monitoring Sales Government & SSGS</p>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-3" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder="abc@xyz.com" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="form-label">Password:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password"
                                    class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="••••••••••••••" required
                                    autocomplete="current-password">
                                <button class="btn btn-outline-secondary border-start-0" type="button"
                                    id="togglePassword" style="border-color: #dee2e6;">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                <label class="form-check-label" for="remember_me">
                                    Remember me
                                </label>
                            </div>

                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="btn btn-login">
                            Log in
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE: Animated Carousel -->
        <div class="carousel-section">
            <div class="carousel-container">
                <div class="carousel-slide active">
                    <img src="{{ asset('images/telkom_building_1.png') }}" alt="Telkom Indonesia Building">
                </div>
                <div class="carousel-slide">
                    <img src="{{ asset('images/telkom_building_2.png') }}" alt="Telkom Indonesia Office">
                </div>
                <div class="carousel-slide">
                    <img src="{{ asset('images/telkom_building_3.png') }}" alt="Telkom Indonesia Interior">
                </div>

                <div class="carousel-overlay">
                    <h2>PT Telekomunikasi Indonesia</h2>
                    <p>Witel Lampung - Bengkulu</p>
                </div>

                <div class="carousel-indicators">
                    <div class="indicator active" data-slide="0"></div>
                    <div class="indicator" data-slide="1"></div>
                    <div class="indicator" data-slide="2"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password Toggle
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const toggleIcon = document.querySelector('#toggleIcon');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        });
    </script>
    <script>
        // Carousel Animation
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('.indicator');
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(ind => ind.classList.remove('active'));

            slides[index].classList.add('active');
            indicators[index].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        // Auto advance every 5 seconds
        setInterval(nextSlide, 5000);

        // Click indicators to change slides
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });
    </script>
</body>

</html>