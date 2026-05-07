@extends('layouts.admin')

@section('title', 'Manage Reviews')

@section('admin-content')
<div class="container-fluid py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Reviews</h2>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success mb-4 shadow-sm rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Reviews Table Card -->
    <div class="card shadow-lg border-0 rounded">
        <div class="card-header bg-dark text-white fw-bold">Review List</div>
        <div class="card-body">
            @if($reviews->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Product</th>
                                <th>User</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviews as $review)
                                <tr>
                                    <td>{{ $review->product->name }}</td>
                                    <td>{{ $review->user->name }}</td>
                                    <td>{{ $review->rating }}/5</td>
                                    <td>{{ $review->comment }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($review->status === 'approved') bg-success 
                                            @elseif($review->status === 'pending') bg-warning 
                                            @else bg-danger @endif">
                                            {{ ucfirst($review->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-success glow-btn me-1">
                                                <i class="bi bi-check-circle"></i> Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-warning glow-btn me-1">
                                                <i class="bi bi-x-circle"></i> Reject
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger glow-btn">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $reviews->links() }}
                </div>
            @else
                <p class="text-muted">No reviews found.</p>
            @endif
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
