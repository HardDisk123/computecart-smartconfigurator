@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4 text-dark">Your Cart</h1>

    @if($items->count())
        <div class="cart-container shadow-lg rounded">
            <!-- Header -->
            <div class="cart-header d-flex fw-bold">
                <div class="flex-fill">Product</div>
                <div class="flex-fill">Price</div>
                <div class="flex-fill">Quantity</div>
                <div class="flex-fill">Total</div>
                <div class="flex-fill">Action</div>
            </div>

            <!-- Items -->
            @foreach($items as $item)
                <div class="cart-row d-flex align-items-center">
                    <div class="flex-fill">{{ $item->product->name }}</div>
                    <div class="flex-fill">₱{{ number_format($item->product->price, 2) }}</div>
                    <div class="flex-fill">{{ $item->quantity }}</div>
                    <div class="flex-fill">₱{{ number_format($item->product->price * $item->quantity, 2) }}</div>
                    <div class="flex-fill">
                        <button type="button" class="btn btn-sm btn-danger glow-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteCartItemModal{{ Auth::check() ? $item->id : $item->product->id }}">
                            <i class="bi bi-trash"></i> Remove
                        </button>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteCartItemModal{{ Auth::check() ? $item->id : $item->product->id }}" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow-lg">
                              <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title">Remove Item</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body">
                                Are you sure you want to remove <strong>{{ $item->product->name }}</strong> from your cart?
                              </div>
                              <div class="modal-footer">
                                <form action="{{ route('cart.remove', Auth::check() ? $item->id : $item->product->id) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger glow-btn">Yes, Remove</button>
                                </form>
                                <button type="button" class="btn btn-secondary glow-btn" data-bs-dismiss="modal">Cancel</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- ✅ Checkout Button -->
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('checkout.index') }}" class="btn btn-dark btn-lg shadow glow-btn">
                Proceed to Checkout
            </a>
        </div>
    @else
        <p class="text-muted">Your cart is empty.</p>
        <a href="{{ route('products.index') }}" class="btn btn-dark glow-btn">Browse Products</a>
    @endif

    <!-- ✅ Inline CSS -->
    <style>
        .cart-container {
            border-radius: 8px;
            overflow: hidden;
        }
        .cart-header {
            background-color: #111; /* black header */
            color: #fff;
            padding: 12px;
        }
        .cart-row {
            background-color: #fff; /* keep rows white */
            color: #000;
            padding: 12px;
            border-bottom: 1px solid #ddd;
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

        /* Modal Styling */
        .modal-content {
            border-radius: 8px;
        }
        .modal-header {
            border-bottom: none;
        }
        .modal-footer {
            border-top: none;
        }
    </style>
</div>
@endsection
