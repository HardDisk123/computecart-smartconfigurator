<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'ComputeCart')</title>

    <!-- Responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 + Tabler + Volt CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/tabler.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/volt.css') }}" rel="stylesheet">

    <!-- ✅ Inline CSS Styles -->
<style>

/* ✅ Solid White Center Background Layer with Floating Shadow */
    .center-background {
        position: fixed;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 95%; /* ✅ wider so content is closer to edges */
        max-width: 1400px; /* ✅ optional: cap width for large screens */
        height: 100%;
        background-color: #ffffff;
        border-radius: 12px;
        z-index: -1; /* sits above video but behind content */
        box-shadow: 0 8px 24px rgba(0,0,0,0.25); /* ✅ floating shadow */
    }

    body {
        min-height: 100vh;
        font-family: 'Segoe UI', Roboto, sans-serif;
        position: relative;
        overflow-x: hidden;
        margin: 0;
        background-color: #ffffff; /* ✅ force solid white background */
    }

    /* ✅ Background video element */
    #bg-video {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -2;
    }

    /* ❌ Removed animated gradient overlay from body */
    body::after {
        content: none !important;
        background: none !important;
        animation: none !important;
    }

    /* ✅ Gradient overlay applied to video */
    #bg-video::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg,
            rgba(0,0,0,0.25),
            rgba(50,50,50,0.15),
            rgba(0,0,0,0.3));
        background-size: 200% 200%;
        animation: gradientShift 15s ease infinite;
        z-index: 1; /* sits above video but behind content */
        pointer-events: none;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* ✅ Force dropdown to stay dark */
    .navbar .dropdown-menu {
        background-color: #111 !important;
        position: relative;
        z-index: 1000;
        border-radius: 6px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.4);
    }

    .navbar .dropdown-menu.show {
        opacity: 1;
        transform: translateY(0);
        visibility: visible;
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 0 12px rgba(255,255,255,0.3);
        animation: dropdownFade 0.3s ease forwards;
    }

    .navbar .dropdown-menu .dropdown-item {
        color: #fff;
        font-weight: 500;
        opacity: 0;
        transform: translateY(-5px);
        transition: color 0.3s ease, text-shadow 0.3s ease, background-color 0.3s ease;
        animation: itemFade 0.4s ease forwards;
    }

    .navbar .dropdown-menu .dropdown-item:hover {
        background-color: #222;
        color: #fff;
        text-shadow: 0 0 8px rgba(255,255,255,0.9);
    }

    @keyframes dropdownFade {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes itemFade {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Navbar */
    .navbar {
        background-color: #111 !important;
    }
    .navbar a {
        color: #fff !important;
        font-weight: 500;
        transition: color 0.3s ease, text-shadow 0.3s ease;
    }
    .navbar a:hover {
        color: #fff !important;
        text-shadow: 0 0 8px rgba(255,255,255,0.8);
    }

    /* Footer */
    footer {
        background-color: #111;
        color: #ccc;
        padding: 20px 0;
        text-align: center;
    }

    /* Toast Notifications */
    .toast-container {
        z-index: 2000;
    }
</style>

</head>
<div class="center-background"></div>
<body class="d-flex flex-column min-vh-100 bg-light">
<link rel="stylesheet" href="{{ asset('css/configurator-ui.css') }}">

    <!-- ✅ Background video -->
    <video id="bg-video" autoplay muted loop>
        <source src="/images/BG.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <main class="flex-grow-1 py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- Toast Notifications -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        @if(session('success'))
            <div class="toast align-items-center text-bg-success border-0 show">
                <div class="d-flex">
                    <div class="toast-body">{{ session('success') }}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show">
                <div class="d-flex">
                    <div class="toast-body">{{ session('error') }}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
    </div>

    <!-- JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/tabler.min.js') }}"></script>
    <script src="{{ asset('js/volt.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
    @yield('scripts')
</body>
</html>
