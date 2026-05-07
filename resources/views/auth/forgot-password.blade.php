@extends('layouts.app')

@section('title', 'Forgot Password - ComputeCart')

@section('content')
<style>
    body {
        background-color: #f8f9fa; /* light background */
        font-family: 'Segoe UI', Roboto, sans-serif;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    nav.navbar {
        background-color: #000;
    }
    nav.navbar a {
        color: #fff !important;
        font-weight: bold;
    }
    footer {
        background-color: #000;
        color: #fff;
        text-align: center;
        padding: 1rem;
        margin-top: auto;
    }
    .guest-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.4);
    }
    .guest-card .card-header {
        background-color: #000; /* black header */
        color: #fff;            /* white text */
        font-weight: bold;
        font-size: 1.25rem;
        padding: 1rem;
        text-align: center;
    }
    .guest-card .card-body {
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
    /* Glow button */
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
        <div class="card guest-card">
            <div class="card-header">Forgot Password</div>
            <div class="card-body">

                <p class="mb-4 text-muted">
                    Forgot your password? No problem. Just enter your email address and we’ll send you a reset link so you can choose a new one.
                </p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success mb-4 text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" 
                               required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Glow button -->
                    <button type="submit" class="btn glow-btn w-100">
                        Send Password Reset Link
                    </button>
                </form>

                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
