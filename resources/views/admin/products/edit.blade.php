@extends('layouts.admin')

@section('title','Edit Product')

@section('admin-content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded">
        <div class="card-header bg-dark text-white fw-bold fs-4">Edit Product</div>
        <div class="card-body">
            <form action="{{ route('admin.products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <!-- Product Name -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Product Name</label>
                    <input type="text" name="name" class="form-control form-control-dark" 
                           value="{{ old('name',$product->name) }}" required>
                    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Category</label>
                    <select name="category_id" class="form-select form-control-dark" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id',$product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- Price -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Price</label>
                    <input type="number" name="price" class="form-control form-control-dark" step="0.01" 
                           value="{{ old('price',$product->price) }}" required>
                    @error('price') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- Stock -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Stock</label>
                    <input type="number" name="stock" class="form-control form-control-dark" 
                           value="{{ old('stock',$product->stock) }}" required>
                    @error('stock') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control form-control-dark" rows="4">{{ old('description',$product->description) }}</textarea>
                    @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- Details -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Details</label>
                    <textarea name="details" class="form-control form-control-dark" rows="3">{{ old('details',$product->details) }}</textarea>
                    @error('details') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- Product Images -->
                @foreach(['image','image1','image2','image3','image4'] as $field)
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            {{ $field === 'image' ? 'Main Image' : 'Additional Image '.substr($field,-1) }}
                        </label>

                        <!-- Fixed preview container -->
                        <div class="image-preview mb-2">
                            @if($product->$field)
                                <img src="{{ asset('storage/'.$product->$field) }}" alt="{{ $product->name }}">
                            @endif
                        </div>

                        <!-- Upload new file -->
                        <input type="file" name="{{ $field }}" class="form-control form-control-dark">
                        @error($field) <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                @endforeach

                <!-- Submit -->
                <div class="text-end">
                    <button type="submit" class="btn btn-dark glow-btn me-2">
                        <i class="bi bi-save"></i> Update Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark glow-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ✅ Inline CSS -->
<style>
    .form-control-dark {
        border-radius: 6px;
        transition: box-shadow 0.3s ease, border-color 0.3s ease;
    }
    .form-control-dark:focus {
        border-color: #000;
        box-shadow: 0 0 8px rgba(0,0,0,0.5);
    }

    /* Fixed preview box for images */
    .image-preview {
        width: 200px;
        height: 200px;
        border: 1px solid #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #f8f9fa;
    }
    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: contain; /* keeps image inside box */
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
