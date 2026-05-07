@extends('layouts.customer')

@section('title', 'Products')

@section('customer-content')
<div class="container py-5">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Browse Products</h2>
        <form action="{{ route('products.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="form-control me-2" placeholder="Search products...">
            <button type="submit" class="btn btn-dark glow-btn">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <!-- Filters -->
    <div class="mb-4">
        <form action="{{ route('products.index') }}" method="GET" class="d-flex align-items-center">
            <label class="me-2 fw-bold">Category:</label>
            <select name="category" class="form-select w-auto" onchange="this.form.submit()">
                <option value="">All</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 shadow-lg border-0 product-card">
                    <!-- Dark Header Strip -->
                    <div class="card-header bg-dark text-white fw-bold">
                        {{ $product->name }}
                    </div>
                    <img src="{{ $product->image_url ?? 'https://via.placeholder.com/400x250' }}" 
                         class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body d-flex flex-column">
                        <p class="text-muted mb-2">₱{{ number_format($product->price, 2) }}</p>
                        <p class="small text-truncate">{{ $product->description }}</p>
                        <div class="mt-auto">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-dark btn-sm glow-btn">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-dark btn-sm glow-btn">
                                    <i class="bi bi-cart-plus"></i> Add
                                </button>
                            </form>
                            <form action="{{ route('wishlist.store', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-dark btn-sm glow-btn">
                                    <i class="bi bi-heart"></i> Wishlist
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No products found.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- ✅ Inline CSS -->
<style>
    .product-card {
        border-radius: 8px;
        overflow: hidden;
    }
    .product-card .card-header {
        border-bottom: none;
    }

    /* Buttons with Hover Effects */
    .glow-btn {
        transition: box-shadow 0.3s ease, transform 0.3s ease, background-color 0.3s ease;
    }
    .glow-btn:hover {
        box-shadow: 0 0 10px rgba(255,255,255,0.9);
        transform: scale(1.05);
        background-color: #333;
        color: #fff;
    }
</style>
@endsection
