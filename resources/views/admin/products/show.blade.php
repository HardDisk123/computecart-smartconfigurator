@extends('layouts.admin')

@section('title','Product Details')

@section('admin-content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded">
        <div class="card-header bg-dark text-white fw-bold fs-4">Product Details</div>
        <div class="card-body">

            <!-- Product Images Carousel -->
            <div class="mb-4 text-center">
                <div id="adminProductGallery" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @php
                            $images = $product->allImages();
                        @endphp

                        @foreach($images as $img)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img src="{{ asset('storage/'.$img) }}" 
                                     alt="{{ $product->name }}" 
                                     class="d-block mx-auto img-fluid product-img-thumb">
                            </div>
                        @endforeach

                        @if(empty($images))
                            <div class="carousel-item active">
                                <img src="https://via.placeholder.com/300x200" 
                                     alt="No image available" 
                                     class="d-block mx-auto img-fluid product-img-thumb">
                            </div>
                        @endif
                    </div>

                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#adminProductGallery" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#adminProductGallery" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>

            <!-- Product Info -->
            <dl class="row mb-4">
                <dt class="col-sm-3 fw-bold">Name:</dt>
                <dd class="col-sm-9">{{ $product->name }}</dd>

                <dt class="col-sm-3 fw-bold">Category:</dt>
                <dd class="col-sm-9">{{ $product->category->name ?? 'Uncategorized' }}</dd>

                <dt class="col-sm-3 fw-bold">Price:</dt>
                <dd class="col-sm-9">₱{{ number_format($product->price,2) }}</dd>

                <dt class="col-sm-3 fw-bold">Stock:</dt>
                <dd class="col-sm-9">{{ $product->stock }}</dd>

                <dt class="col-sm-3 fw-bold">Description:</dt>
                <dd class="col-sm-9">{{ $product->description ?? 'No description provided' }}</dd>

                <dt class="col-sm-3 fw-bold">Details:</dt>
                <dd class="col-sm-9">{{ $product->details ?? 'No details provided' }}</dd>
            </dl>

            <!-- Actions -->
            <div class="text-end">
                <a href="{{ route('admin.products.edit',$product->id) }}" class="btn btn-warning glow-btn me-1">
                    <i class="bi bi-pencil"></i> Edit
                </a>

                <button type="button" class="btn btn-danger glow-btn me-1" 
                        data-bs-toggle="modal" 
                        data-bs-target="#deleteProductModal{{ $product->id }}">
                    <i class="bi bi-trash"></i> Delete
                </button>
                @include('admin.products.partials.delete-modal', ['product' => $product])

                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark glow-btn">Back</a>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Inline CSS -->
<style>
    .product-img-thumb {
        max-height: 300px;
        object-fit: cover;
        border: 3px solid #000;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.5);
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
