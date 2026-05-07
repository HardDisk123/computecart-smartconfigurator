@extends('layouts.admin')

@section('title','Manage Categories')

@section('admin-content')
<div class="container py-5">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Categories</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-dark glow-btn">
            <i class="bi bi-plus-circle me-1"></i> Add Category
        </a>
    </div>

    <!-- Categories Table Card -->
    <div class="card shadow-lg border-0 rounded">
        <div class="card-header bg-dark text-white fw-bold">Category List</div>
        <div class="card-body">

            <!-- Categories Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Created At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->created_at->format('M d, Y') }}</td>

                                <td class="text-end">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                       class="btn btn-sm btn-warning glow-btn me-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <!-- Delete Button -->
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-danger glow-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteCategoryModal{{ $category->id }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>

                                    <!-- Delete Modal -->
                                    @include('admin.categories.partials.delete-modal', ['category' => $category])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Inline CSS -->
<style>
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
