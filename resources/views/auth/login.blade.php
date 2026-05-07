@extends('layouts.app')

@section('title', 'Login - ComputeCart')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Roboto, sans-serif;
    }
    .login-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.4);
    }
    .login-card .card-header {
        background-color: #000; /* black header */
        color: #fff;            /* white text */
        font-weight: bold;
        font-size: 1.25rem;
        padding: 1rem;
        text-align: center;
    }
    .login-card .card-body {
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

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card login-card">
                <div class="card-header">
                    Login
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success mb-4 text-center">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="mb-3 text-end">
                                <a href="{{ route('password.request') }}">Forgot your password?</a>
                            </div>
                        @endif

                        <!-- ✅ Glow button -->
                        <button type="submit" class="btn glow-btn w-100">Login</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('register') }}">Don't have an account? Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
