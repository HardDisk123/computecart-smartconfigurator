@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6">
            @if($product->allImages())
                <!-- Main Image -->
                <div class="main-image mb-3">
                    <img src="{{ $product->imageUrls()[0] }}" class="product-img rounded" alt="Main product image">
                </div>

                <!-- Thumbnails -->
                <div class="thumbnail-gallery d-flex flex-wrap gap-2">
                    @foreach($product->imageUrls() as $url)
                        <div class="thumbnail">
                            <img src="{{ $url }}" class="thumb-img rounded" alt="Thumbnail">
                        </div>
                    @endforeach
                </div>
            @else
                <div class="main-image">
                    <img src="{{ asset('images/placeholder.png') }}" class="product-img rounded" alt="No image available">
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h2 class="fw-bold">{{ $product->name }}</h2>
            <p class="text-muted">Category: {{ $product->category->name }}</p>
            <h4 class="text-primary mb-3">₱{{ number_format($product->price, 2) }}</h4>
            <p><strong>Stock:</strong> {{ $product->stock }}</p>

            <!-- Description -->
            @if($product->description)
                <div class="mb-3">
                    <h5 class="fw-bold">Description</h5>
                    <p>{{ $product->description }}</p>
                </div>
            @endif

            <!-- Specifications -->
            @if($product->details)
                <div class="mb-3">
                    <h5 class="fw-bold">Specifications</h5>
                    <ul class="list-unstyled">
                        @foreach(explode("\n", $product->details) as $line)
                            @if(trim($line) !== '')
                                <li>• {{ trim($line) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Add to Cart -->
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-cart-plus"></i> Add to Cart
                </button>
            </form>
        </div>
    </div>
</div>

<!-- ✅ Inline CSS -->
<style>
    /* Main image with fixed ratio */
    .main-image {
        width: 100%;
        max-width: 500px;
        aspect-ratio: 4 / 3;   /* lock ratio */
        border: 1px solid #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #f8f9fa;
    }
    .product-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }

    /* Thumbnail gallery */
    .thumbnail-gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .thumbnail {
        width: 100px;
        aspect-ratio: 1 / 1;   /* square thumbnails */
        border: 1px solid #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #f8f9fa;
    }
    .thumb-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        cursor: pointer;
    }
</style>
@endsection
