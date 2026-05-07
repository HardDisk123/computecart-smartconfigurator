@extends('layouts.admin')

@section('title','Edit Category')

@section('admin-content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded">
        <div class="card-header bg-dark text-white fw-bold fs-4">Edit Category</div>
        <div class="card-body">
            <form action="{{ route('admin.categories.update',$category->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-bold">Category Name</label>
                    <input type="text" name="name" class="form-control form-control-dark" 
                           value="{{ $category->name }}" required>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-dark glow-btn me-2">Update Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark glow-btn">Cancel</a>
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
