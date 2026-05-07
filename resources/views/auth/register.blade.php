@extends('layouts.app')
@section('title', 'Register')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Roboto, sans-serif;
    }
    .register-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.4);
    }
    .register-card .card-header {
        background-color: #000; /* black header */
        color: #fff;            /* white text */
        font-weight: bold;
        font-size: 1.25rem;
        padding: 1rem;
        text-align: center;
    }
    .register-card .card-body {
        background-color: #fff; /* white body */
        color: #000;            /* black text */
        padding: 2rem;
    }
    .form-label {
        font-weight: 600;
    }
    .form-control {
        border: 1px solid #ccc;
        background-color: #fff;
        color: #000;
    }
    .form-control:focus {
        border-color: #000;
        box-shadow: 0 0 6px rgba(0,0,0,0.4);
    }
    /* ✅ Glow button styling */
    .glow-btn {
        background-color: #111;
        border: none;
        color: #fff;
        font-weight: bold;
        transition: box-shadow 0.3s ease, transform 0.3s ease, background-color 0.3s ease;
    }
    .glow-btn:hover {
        box-shadow: 0 0 10px rgba(255,255,255,0.9);
        transform: scale(1.05);
        background-color: #333;
        color: #fff;
    }
    a {
        color: #000;
        text-decoration: underline;
    }
    a:hover {
        color: #333;
    }
</style>

<div class="row justify-content-center py-5">
    <div class="col-md-6">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card register-card">
            <div class="card-header">Register</div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <!-- ✅ Glow button -->
                    <button type="submit" class="btn glow-btn w-100">Register</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}">Already have an account? Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
