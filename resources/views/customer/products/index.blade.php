@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container py-5">

    <!-- Slideshow at the top -->
    <div id="productsSlideshow" class="carousel slide mb-5 shadow-lg rounded overflow-hidden" data-bs-ride="carousel">
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
        <button class="carousel-control-prev" type="button" data-bs-target="#productsSlideshow" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productsSlideshow" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark">Products</h1>
        <form action="{{ route('products.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="form-control me-2" placeholder="Search products...">
            <button type="submit" class="btn btn-dark glow-btn">Search</button>
        </form>
    </div>

    <!-- Filters + Product Grid -->
    <div class="row mb-4">
        <!-- Categories Sidebar -->
        <div class="col-md-3">
            <div class="card shadow-lg border-0 category-card">
                <div class="card-header bg-dark text-white fw-bold">Categories</div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('products.index') }}" 
                       class="list-group-item list-group-item-action {{ request('category') ? '' : 'active' }}">
                        All
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                           class="list-group-item list-group-item-action {{ request('category') == $category->id ? 'active' : '' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-md-9">
            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-lg border-0 product-card">
                            @php
                                $images = $product->imageUrls();
                                $mainImage = $images->first() ?? 'https://via.placeholder.com/400x250';
                            @endphp
                            <!-- ✅ Clickable Image with Overlay -->
                            <a href="{{ route('products.show', $product->id) }}" class="product-img-wrapper">
                                <img src="{{ $mainImage }}" class="card-img-top product-img" alt="{{ $product->name }}">
                                <div class="overlay">
                                    <span class="overlay-text">View Product</span>
                                </div>
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-dark">{{ $product->name }}</h5>
                                <p class="card-text text-dark mb-2">₱{{ number_format($product->price, 2) }}</p>
                                <div class="mt-auto">
                                    <a href="{{ route('products.show', $product->id) }}" 
                                       class="btn btn-dark btn-sm glow-btn me-1">View</a>
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-dark btn-sm glow-btn me-1">Cart</button>
                                    </form>
                                    <form action="{{ route('wishlist.store', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-dark btn-sm glow-btn">Wishlist</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">No products found.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

</div>

<!-- ✅ Inline CSS -->
<style>
    .product-img-wrapper {
        position: relative;
        display: block;
        overflow: hidden;
        border-radius: 8px;
    }
    .product-img {
        object-fit: cover;
        max-height: 250px;
        transition: transform 0.4s ease, filter 0.4s ease;
        width: 100%;
    }
    .product-img-wrapper:hover .product-img {
        transform: scale(1.08);
        filter: brightness(0.7);
    }
    .overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.4s ease;
        background: rgba(0,0,0,0.4);
    }
    .overlay-text {
        color: #fff;
        font-size: 1.2rem;
        font-weight: bold;
    }
    .product-img-wrapper:hover .overlay {
        opacity: 1;
    }
    .category-card, .product-card {
        border-radius: 8px;
        overflow: hidden;
    }
    .glow-btn {
        transition: box-shadow 0.3s ease, transform 0.3s ease, background-color 0.3s ease;
    }
    .glow-btn:hover {
        box-shadow: 0 0 10px rgba(255,255,255,0.9);
        transform: scale(1.05);
        background-color: #333;
        color: #fff;
    }
    .list-group-item.active {
        background-color: #000;
        color: #fff;
        border: none;
    }
</style>
@endsection
