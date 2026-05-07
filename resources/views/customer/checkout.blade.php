@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4 text-dark">Checkout</h1>

    @if($cart && $cart->items->count())
        <div class="row">
            <!-- Order Summary -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg checkout-card">
                    <div class="card-header fw-bold bg-dark text-white">Order Summary</div>
                    <div class="card-body">
                        <ul class="list-group mb-3">
                            @foreach($cart->items as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item->product->name }} (x{{ $item->quantity }})
                                    <span>₱{{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <h5 class="fw-bold text-dark">
                            Total: ₱{{ number_format($cart->items->sum(fn($i) => $i->product->price * $i->quantity), 2) }}
                        </h5>
                    </div>
                </div>
            </div>

            <!-- Shipping & Payment -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg checkout-card">
                    <div class="card-header fw-bold bg-dark text-white">Shipping & Payment</div>
                    <div class="card-body">
                        <form action="{{ route('orders.checkout') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Shipping Address</label>
                                <textarea name="address" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Payment Method</label>
                                <select name="payment_method" class="form-select" required>
                                    <option value="cod">Cash on Delivery</option>
                                    <option value="card">Credit/Debit Card</option>
                                    <option value="gcash">GCash</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 btn-lg shadow glow-btn">
                                Place Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="text-muted">Your cart is empty.</p>
        <a href="{{ route('products.index') }}" class="btn btn-dark glow-btn">Browse Products</a>
    @endif

    <!-- ✅ Inline CSS for Checkout -->
    <style>
        .checkout-card {
            border-radius: 8px;
        }
        .checkout-card .card-header {
            border-bottom: none;
        }
        .checkout-card .card-body {
            background-color: #fff;
        }
        .list-group-item {
            background-color: #f8f9fa;
            border: none;
        }

        /* Buttons with Hover Effects */
        .glow-btn {
            transition: box-shadow 0.3s ease, transform 0.3s ease, background-color 0.3s ease;
        }
        .glow-btn:hover {
            box-shadow: 0 0 10px rgba(255,255,255,0.9);
            transform: scale(1.05);
            background-color: #333; /* darker shade on hover */
            color: #fff;
        }
    </style>
</div>
@endsection
