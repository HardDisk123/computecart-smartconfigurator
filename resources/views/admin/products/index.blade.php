@extends('layouts.admin')

@section('title','Manage Products')

@section('admin-content')
<div class="container-fluid py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Products</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-dark glow-btn">
            <i class="bi bi-plus-circle"></i> Add Product
        </a>
    </div>

    <!-- Filter Card -->
    <div class="card shadow-lg border-0 rounded mb-4">
        <div class="card-header bg-dark text-white fw-bold">Filter Products</div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-control-dark" 
                           placeholder="Search products..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="category_id" class="form-select form-control-dark">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-dark glow-btn w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table Card -->
    <div class="card shadow-lg border-0 rounded">
        <div class="card-header bg-dark text-white fw-bold">Product List</div>
        <div class="card-body">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Images</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @php
                                    $images = $product->imageUrls();
                                @endphp
                                @if($images->isNotEmpty())
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($images as $url)
                                            <img src="{{ $url }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="img-thumbnail product-thumb">
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                            <td>₱{{ number_format($product->price,2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('admin.products.edit',$product->id) }}" 
                                       class="btn btn-sm btn-warning glow-btn">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <a href="{{ route('admin.products.show',$product->id) }}" 
                                       class="btn btn-sm btn-info glow-btn">
                                        <i class="bi bi-eye"></i> View
                                    </a>

                                    <button type="button" 
                                            class="btn btn-sm btn-danger glow-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteProductModal{{ $product->id }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </td>

                            @include('admin.products.partials.delete-modal', ['product' => $product])
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $products->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- ✅ Inline CSS -->
<style>
    /* Pagination container */
    .pagination {
        justify-content: center;
    }

    /* Pagination links */
    .pagination .page-link {
        color: #000;
        font-size: 0.85rem;
        padding: 6px 10px;
        border: none;
    }

    .pagination .page-link:hover {
        background-color: #f0f0f0;
        color: #000;
    }

    .pagination .page-item.active .page-link {
        background-color: #000;
        color: #fff;
        border-radius: 4px;
    }

    .pagination .page-item.disabled .page-link {
        color: #999;
    }

    /* ✅ Force arrow icons (SVG) to be small and black */
    .pagination .page-link svg {
        width: 14px !important;
        height: 14px !important;
        fill: #000 !important;
        vertical-align: middle;
    }

    .form-control-dark {
        border-radius: 6px;
        transition: box-shadow 0.3s ease, border-color 0.3s ease;
    }
    .form-control-dark:focus {
        border-color: #000;
        box-shadow: 0 0 8px rgba(0,0,0,0.5);
    }
    .product-thumb {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border: 2px solid #000;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.4);
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
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
</style>
@endsection
