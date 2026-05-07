@extends('layouts.app')

@section('title', 'Home')

@section('content')
 <!-- Logo overlay only on right side -->
    <div class="hero-logo"></div>

    <div class="center-background"></div>

<div class="container py-5">

    <!-- Top Slideshow -->
    <div id="topSlideshow" class="carousel slide mb-5 shadow-lg rounded" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/ASUS.png') }}" class="d-block w-100" alt="Slide Show 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/AORUS.png') }}" class="d-block w-100" alt="Slide Show 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/MSI.png') }}" class="d-block w-100" alt="Slide Show 3">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/AI.png') }}" class="d-block w-100" alt="Slide Show 4">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/UGREEN.png') }}" class="d-block w-100" alt="Slide Show 5">
            </div>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#topSlideshow" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#topSlideshow" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Category Grid -->
    <div class="container my-3">
        <div class="row text-center">
            <div class="col-3">
                <a href="{{ route('products.index', ['category' => 3]) }}" class="category-card">
                    <img src="{{ asset('images/GPU.png') }}" alt="Graphics Cards" style="width:301px; height:100px;">
                    <span class="overlay-text">Graphics Cards</span>
                </a>
            </div>
            <div class="col-3">
                <a href="{{ route('products.index', ['category' => 10]) }}" class="category-card">
                    <img src="{{ asset('images/CPU.png') }}" alt="Processors" style="width:301px; height:100px;">
                    <span class="overlay-text">Processors</span>
                </a>
            </div>
            <div class="col-3">
                <a href="{{ route('products.index', ['category' => 6]) }}" class="category-card">
                    <img src="{{ asset('images/MOBO.png') }}" alt="Motherboards" style="width:301px; height:100px;">
                    <span class="overlay-text">Motherboards</span>
                </a>
            </div>
            <div class="col-3">
                <a href="{{ route('products.index', ['category' => 5]) }}" class="category-card">
                    <img src="{{ asset('images/SSD.png') }}" alt="Storage" style="width:301px; height:100px;">
                    <span class="overlay-text">Internal Storage</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Hero + Logo Overlay -->
<div class="hero-text text-center text-md-start">
    <h1 class="fw-bold display-3 text-dark mb-3">
        <span class="brand-highlight">Welcome to</span> <span class="brand-name">ComputeCart</span>
    </h1>
    <p class="lead text-secondary fs-4 mb-4">
        Your one‑stop shop for premium PC parts.<br>
        Browse, wishlist, and order with ease.
    </p>
    <a href="{{ route('products.index') }}" class="btn btn-dark btn-lg shadow glow-btn">
        <i class="bi bi-shop"></i> Shop Now
    </a>
</div>
</div>

<!-- Featured Products -->
<div class="row">
    @php
        $categories = [
            3 => 'Graphics Cards',
            6 => 'Motherboards',
            10 => 'Processors',
            5 => 'Internal Storage'
        ];
    @endphp

    @foreach($categories as $id => $label)
        @php
            $product = $featuredProducts->firstWhere('category_id', $id);
        @endphp

        <div class="col-md-3 mb-4">
            <div class="card h-100 text-center shadow-sm product-card">
                @if($product)
                    <a href="{{ route('products.show', $product->id) }}" class="product-link">
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/placeholder.png') }}"
                             alt="{{ $product->name }}"
                             class="card-img-top product-img">
                        <div class="overlay-text">{{ $product->name }}</div>
                    </a>
                @else
                    <!-- ✅ Placeholder if category has no product -->
                    <div class="product-link">
                        <img src="{{ asset('images/placeholder.png') }}"
                             alt="{{ $label }}"
                             class="card-img-top product-img">
                        <div class="overlay-text">{{ $label }}</div>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>


    <!-- ✅ Inline CSS for Homepage -->
<style>

.hero-text h1 {
    letter-spacing: 1px;
    line-height: 1.2;
}

.brand-highlight {
    color: #000;
    font-weight: 800;
}

.brand-name {
    color: #000;
    font-weight: 800;
}

.hero-text p {
    max-width: 600px;
}

.glow-btn {
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}
.glow-btn:hover {
    box-shadow: 0 0 12px rgba(23,162,184,0.6);
    transform: scale(1.05);
}

.hero {
    position: relative;
}

.hero-logo {
    position: absolute;
    top: 58%; /* moved down a bit for better centering */
    right: calc((100% - 1320px) / 2 + 20px);
    transform: translateY(-50%);
    width: 370px;
    height: 370px;
    background: url('/images/ComputeCart Logo No BG.png') no-repeat center;
    background-size: contain;
    opacity: 0.85;
    transition: transform 0.3s ease;
    pointer-events: auto; /* allow hover */
    animation: none; /* remove idle animations */
}

/* ✅ Pulse forward only on hover */
.hero-logo:hover {
    transform: translateY(-50%) scale(1.1);
}

/* ✅ Trigger gradient borders on white background when logo is hovered */
.hero-logo:hover ~ .center-background::before,
.hero-logo:hover ~ .center-background::after {
    content: "";
    position: absolute;
    top: 0; bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, #0ff, #00f, #f0f);
    background-size: 300% 100%;
    animation: glowline 6s linear infinite;
}

/* Left border */
.hero-logo:hover ~ .center-background::before {
    left: 0;
}

/* Right border */
.hero-logo:hover ~ .center-background::after {
    right: 0;
}

@keyframes glowline {
    0% { background-position: 0% 50%; }
    100% { background-position: 100% 50%; }
}

/* ✅ Force all product images to same size */
.product-img {
    width: 100%;
    height: 220px;       /* adjust height as needed */
    object-fit: contain; /* keeps aspect ratio without cropping */
    padding: 10px;       /* optional: adds breathing space */
}

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

/* ✅ Gradient borders appear on hover */
.center-background:hover::before,
.center-background:hover::after {
    content: "";
    position: absolute;
    top: 0; bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, #0ff, #00f, #f0f);
    background-size: 300% 100%;
    animation: glowline 6s linear infinite;
}

/* Left border */
.center-background:hover::before {
    left: 0;
}

/* Right border */
.center-background:hover::after {
    right: 0;
}

@keyframes glowline {
    0% { background-position: 0% 50%; }
    100% { background-position: 100% 50%; }
}

/* Category Cards */
.category-card {
    position: relative;
    display: inline-block;
    overflow: hidden;
    border-radius: 6px;
    text-decoration: none;
}
.category-card img {
    display: block;
    transition: filter 0.4s ease, transform 0.4s ease;
}
.category-card .overlay-text {
    position: absolute;
    top: 60%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    opacity: 0;
    transition: all 0.4s ease;
    text-shadow: 0 0 8px rgba(255,255,255,0.8);
    pointer-events: none;
}
.category-card:hover img {
    filter: brightness(0.2);
    transform: scale(1.08);
}
.category-card:hover .overlay-text {
    opacity: 1;
    top: 50%;
}

/* Featured Products */
.product-link {
    position: relative;
    display: inline-block;
    overflow: hidden;
    border-radius: 6px;
    text-decoration: none;
}
.product-link img {
    display: block;
    transition: filter 0.4s ease, transform 0.4s ease;
}
.product-link .overlay-text {
    position: absolute;
    top: 60%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    opacity: 0;
    transition: all 0.4s ease;
    text-shadow: 0 0 8px rgba(255,255,255,0.8);
    pointer-events: none;
}
.product-link:hover img {
    filter: brightness(0.2);
    transform: scale(1.08);
}
.product-link:hover .overlay-text {
    opacity: 1;
    top: 50%;
}

/* ✅ Navbar Glow Effects */
.navbar-nav .nav-link {
    padding: 0.6rem 1rem;
    border-radius: 6px;
    transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
}
.navbar-nav .nav-link:hover {
    background-color: rgba(0,0,0,0.05);
    color: #000;
    box-shadow: 0 0 8px rgba(0,0,0,0.2);
}
.navbar-nav .nav-link.active {
    background-color: rgba(0,0,0,0.1);
    color: #17a2b8 !important;
    box-shadow: 0 0 10px rgba(23,162,184,0.6);
}

/* Dropdown Items Glow */
.dropdown-menu .dropdown-item {
    transition: background-color 0.3s ease, color 0.3s ease;
    border-radius: 4px;
}
.dropdown-menu .dropdown-item:hover {
    background-color: rgba(0,0,0,0.05);
    color: #17a2b8;
}

/* ✅ Universal Button Glow */
.btn {
    transition: box-shadow 0.3s ease, transform 0.3s ease, background-color 0.3s ease;
}
.btn:hover {
    box-shadow: 0 0 12px rgba(0,0,0,0.3);
    transform: scale(1.05);
}
.btn:active {
    transform: scale(0.97);
    box-shadow: 0 0 8px rgba(0,0,0,0.4) inset;
}

</style>

</div>
@endsection
