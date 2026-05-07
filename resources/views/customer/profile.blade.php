@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container py-5">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">My Profile</h2>
        <a href="{{ route('profile.edit') }}" class="btn btn-dark btn-sm glow-btn">
            <i class="bi bi-pencil-square"></i> Edit Profile
        </a>
    </div>

    <!-- Profile Card -->
    <div class="card shadow-lg border-0 mb-4 profile-card">
        <div class="card-header bg-dark text-white fw-bold">Profile Information</div>
        <div class="card-body text-center">
            <img src="{{ $user->picture ? asset('storage/'.$user->picture) : 'https://via.placeholder.com/150' }}"
                 class="rounded-circle mb-3" width="120" height="120" alt="Profile Picture">
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <p class="text-muted mb-1">{{ $user->email }}</p>
            <p class="text-muted">Member Since: {{ $user->created_at->format('M d, Y') }}</p>
        </div>
    </div>

    <!-- Tabbed Interface -->
<ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active tab-btn" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">
            <i class="bi bi-bag-check me-1"></i> Orders
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link tab-btn" id="wishlist-tab" data-bs-toggle="tab" data-bs-target="#wishlist" type="button" role="tab">
            <i class="bi bi-heart me-1"></i> Wishlist
        </button>
    </li>
</ul>

<!-- ✅ Inline CSS -->
<style>
    /* Base Tab Buttons */
    .tab-btn {
        font-weight: 600;
        background-color: #000; /* solid black */
        color: #fff;            /* gray text */
        border: none;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    /* Hover effect */
    .tab-btn:hover {
        background-color: #333; /* dark gray */
        color: #fff;
        transform: scale(1.05);
    }

    /* Active tab stays gray */
    .tab-btn.active,
    .nav-tabs .nav-link.active {
        background-color: #333; /* dark gray */
        color: #fff;
        border: none;
    }
</style>

    <div class="tab-content" id="profileTabsContent">

        <!-- Orders -->
<div class="tab-pane fade show active" id="orders" role="tabpanel">
    <div class="card shadow-lg border-0 mb-4">
        <!-- ✅ Match the black header style -->
        <div class="card-header bg-black text-white fw-bold">My Orders</div>
        <div class="card-body">
            @if($orders->count())
                <div class="table-responsive">
                    <table class="table align-middle shadow-sm">
                        <!-- ✅ Black table header -->
                        <thead class="table-dark">
                            <tr>
                                <th>Order #</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>₱{{ number_format($order->total, 2) }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">You have no orders yet.</p>
            @endif
        </div>
    </div>
</div>


        <!-- Wishlist -->
<div class="tab-pane fade" id="wishlist" role="tabpanel">
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-header bg-dark text-white fw-bold">My Wishlist</div>
        <div class="card-body">
            @if($wishlist->count())
                <div class="row g-4">
                    @foreach($wishlist as $item)
                        <div class="col-md-4 col-lg-3">
                            <div class="card h-100 shadow-lg border-0 product-card">
                                <div class="card-header bg-dark text-white fw-bold">
                                    {{ $item->name }}
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <p class="text-muted mb-2">₱{{ number_format($item->price, 2) }}</p>
                                    <div class="mt-auto">
                                        <form action="{{ route('wishlist.moveToCart', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-dark btn-sm glow-btn">
                                                <i class="bi bi-cart-plus"></i> Move to Cart
                                            </button>
                                        </form>
                                        <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm glow-btn">
                                                <i class="bi bi-trash"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Your wishlist is empty.</p>
            @endif
        </div>
    </div>
</div>


    </div>
</div>

<!-- ✅ Inline CSS -->
<style>
    .profile-card, .product-card {
        border-radius: 8px;
        overflow: hidden;
    }
    .profile-card .card-header,
    .product-card .card-header {
        border-bottom: none;
    }

    /* Buttons with Hover Effects */
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
