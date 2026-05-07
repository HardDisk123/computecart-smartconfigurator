@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">

    <!-- Product Details -->
    <div class="row mb-5">
        <div class="col-md-6">
            <!-- ✅ Product Image Carousel -->
            <div id="productGallery" class="carousel slide shadow-lg rounded overflow-hidden" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php
                        $images = $product->imageUrls();
                    @endphp

                    @foreach($images as $url)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <img src="{{ $url }}" class="d-block w-100 rounded" alt="{{ $product->name }}">
                        </div>
                    @endforeach

                    @if($images->isEmpty())
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/600x400" class="d-block w-100 rounded" alt="No image available">
                        </div>
                    @endif
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#productGallery" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productGallery" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>

        <div class="col-md-6">
            <h1 class="fw-bold">{{ $product->name }}</h1>
            <p class="text-muted">₱{{ number_format($product->price, 2) }}</p>

            <!-- Description -->
            @if($product->description)
                <div class="mb-3">
                    <div class="section-header bg-dark text-white fw-bold px-3 py-2 rounded">Description</div>
                    <p class="mt-2">{{ $product->description }}</p>
                </div>
            @endif

            <!-- Specifications -->
            @if($product->details)
                <div class="mb-3">
                    <div class="section-header bg-dark text-white fw-bold px-3 py-2 rounded">Specifications</div>
                    <ul class="list-unstyled mt-2">
                        @foreach(explode("\n", $product->details) as $line)
                            @if(trim($line) !== '')
                                <li>• {{ trim($line) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="mt-4">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-lg me-2 glow-btn">Add to Cart</button>
                </form>
                <form action="{{ route('wishlist.store', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-dark btn-lg glow-btn">Add to Wishlist</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row">
        <div class="col-md-8">
            <div class="section-header bg-dark text-white fw-bold px-3 py-2 rounded mb-4">Customer Reviews</div>

            @forelse($product->reviews as $review)
                <div class="card mb-3 shadow-lg border-0 rounded">
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">{{ $review->user->name }}</h6>
                        <p class="text-muted mb-2">{{ $review->created_at->format('M d, Y') }}</p>
                        <p>{{ $review->comment ?? $review->content }}</p>
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= $review->rating ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                            @endfor
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">No reviews yet. Be the first to review this product!</p>
            @endforelse

            <!-- Review Form -->
            @auth
                <div class="card mt-4 shadow-lg border-0 rounded">
                    <div class="card-header bg-dark text-white fw-bold">Leave a Review</div>
                    <div class="card-body">
                        <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating</label>
                                <select name="rating" id="rating" class="form-select" required>
                                    <option value="">Select rating</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Review</label>
                                <textarea name="comment" id="comment" rows="3" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-dark glow-btn">Submit Review</button>
                        </form>
                    </div>
                </div>
            @else
                <p class="text-muted mt-3">Please <a href="{{ route('login') }}">login</a> to leave a review.</p>
            @endauth
        </div>
    </div>

</div>

<!-- ✅ Inline CSS -->
<style>
    .section-header {
        font-size: 1rem;
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
</style>
@endsection
