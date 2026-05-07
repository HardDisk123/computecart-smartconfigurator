@extends('layouts.admin')

@section('title', 'Customers')

@section('admin-content')
<div class="container-fluid py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Customers</h2>
    </div>

    <!-- Customers Table Card -->
    <div class="card shadow-lg border-0 rounded">
        <div class="card-header bg-dark text-white fw-bold">Customer List</div>
        <div class="card-body">
            @if($users->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="btn btn-sm btn-warning glow-btn me-1">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger glow-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteUserModal{{ $user->id }}">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                        @include('admin.users.partials.delete-modal', ['user' => $user])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            @else
                <p class="text-muted">No customers found.</p>
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
