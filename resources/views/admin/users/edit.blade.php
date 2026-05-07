@extends('layouts.admin')

@section('title','Edit Customer')

@section('admin-content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded">
        <div class="card-header bg-dark text-white fw-bold fs-4">Edit Customer</div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Name</label>
                    <input type="text" id="name" name="name" 
                           class="form-control form-control-dark" 
                           value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" id="email" name="email" 
                           class="form-control form-control-dark" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-dark glow-btn me-2">
                        <i class="bi bi-save"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark glow-btn">Cancel</a>
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
