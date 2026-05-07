@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded">
        <div class="card-header bg-dark text-white fw-bold fs-4">Edit Profile</div>
        <div class="card-body">

            <!-- ✅ Success message -->
            @if (session('status'))
                <div class="alert alert-success mb-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label fw-bold">Profile Picture</label>
                    <input type="file" name="picture" class="form-control form-control-dark">
                    @error('picture')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control form-control-dark">
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control form-control-dark">
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">New Password</label>
                    <input type="password" name="password" class="form-control form-control-dark">
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control form-control-dark">
                    @error('password_confirmation')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-dark glow-btn me-2">Save Changes</button>
                <a href="{{ route('profile.show') }}" class="btn btn-outline-dark glow-btn">Cancel</a>
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
