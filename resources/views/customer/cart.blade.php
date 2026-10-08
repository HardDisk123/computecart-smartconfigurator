@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
<div class="container py-5">

    <h1 class="fw-bold mb-4 text-dark">Your Cart</h1>

    @if($items->count())

        <div class="cart-container shadow-lg rounded">

            <!-- Header -->
            <div class="cart-header">
                <div class="product-column">Product</div>
                <div class="price-column">Price</div>
                <div class="quantity-column">Quantity</div>
                <div class="total-column">Total</div>
                <div class="action-column">Action</div>
            </div>

            <!-- Items -->
            @foreach($items as $item)

                <div class="cart-row">

                    <!-- Product -->
                    <div class="product-column product-name">
                        {{ $item->product->name }}
                    </div>

                    <!-- Price -->
                    <div class="price-column">
                        ₱{{ number_format($item->product->price, 2) }}
                    </div>

                    <!-- Quantity -->
                    <div class="quantity-column">
                        {{ $item->quantity }}
                    </div>

                    <!-- Total -->
                    <div class="total-column">
                        ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                    </div>

                    <!-- Action -->
                    <div class="action-column">

                        <button
                            type="button"
                            class="btn btn-sm btn-danger glow-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteCartItemModal{{ Auth::check() ? $item->id : $item->product->id }}">
                            <i class="bi bi-trash"></i> Remove
                        </button>

                        <!-- Delete Modal -->
                        <div
                            class="modal fade"
                            id="deleteCartItemModal{{ Auth::check() ? $item->id : $item->product->id }}"
                            tabindex="-1"
                            aria-hidden="true">

                            <div class="modal-dialog modal-dialog-centered">

                                <div class="modal-content shadow-lg">

                                    <div class="modal-header bg-dark text-white">
                                        <h5 class="modal-title">Remove Item</h5>

                                        <button
                                            type="button"
                                            class="btn-close btn-close-white"
                                            data-bs-dismiss="modal">
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        Are you sure you want to remove
                                        <strong>{{ $item->product->name }}</strong>
                                        from your cart?
                                    </div>

                                    <div class="modal-footer">

                                        <form
                                            action="{{ route('cart.remove', Auth::check() ? $item->id : $item->product->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger glow-btn">
                                                Yes, Remove
                                            </button>

                                        </form>

                                        <button
                                            type="button"
                                            class="btn btn-secondary glow-btn"
                                            data-bs-dismiss="modal">
                                            Cancel
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <!-- Checkout Button -->
        <div class="d-flex justify-content-end mt-3">
            <a
                href="{{ route('checkout.index') }}"
                class="btn btn-dark btn-lg shadow glow-btn">
                Proceed to Checkout
            </a>
        </div>

    @else

        <p class="text-muted">Your cart is empty.</p>

        <a
            href="{{ route('products.index') }}"
            class="btn btn-dark glow-btn">
            Browse Products
        </a>

    @endif


    <!-- Inline CSS -->
    <style>

        /* =========================================
           CART CONTAINER
        ========================================= */
        .cart-container {
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
        }


        /* =========================================
           FIXED COLUMN LAYOUT
        ========================================= */
        .cart-header,
        .cart-row {
            display: grid;
            grid-template-columns: 40% 15% 15% 15% 15%;
            align-items: center;
        }


        /* =========================================
           HEADER
        ========================================= */
        .cart-header {
            background-color: #111;
            color: #fff;
            padding: 15px 20px;
            font-weight: 700;
        }

        .cart-header .product-column {
            text-align: left;
        }

        .cart-header .price-column,
        .cart-header .quantity-column,
        .cart-header .total-column,
        .cart-header .action-column {
            text-align: center;
        }


        /* =========================================
           CART ROW
        ========================================= */
        .cart-row {
            background-color: #fff;
            color: #000;
            padding: 16px 20px;
            min-height: 70px;
            border-bottom: 1px solid #ddd;
        }

        .cart-row:last-child {
            border-bottom: none;
        }


        /* =========================================
           PRODUCT
        ========================================= */
        .product-name {
            text-align: left;
            padding-right: 20px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }


        /* =========================================
           PRICE
        ========================================= */
        .price-column {
            text-align: center;
            white-space: nowrap;
        }


        /* =========================================
           QUANTITY
        ========================================= */
        .quantity-column {
            text-align: center;
            font-weight: 600;
        }


        /* =========================================
           TOTAL
        ========================================= */
        .total-column {
            text-align: center;
            font-weight: 600;
            white-space: nowrap;
        }


        /* =========================================
           ACTION
        ========================================= */
        .action-column {
            display: flex;
            justify-content: center;
            align-items: center;
        }


        /* =========================================
           BUTTON HOVER EFFECT
        ========================================= */
        .glow-btn {
            transition:
                box-shadow 0.3s ease,
                transform 0.3s ease,
                background-color 0.3s ease;
        }

        .glow-btn:hover {
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.9);
            transform: scale(1.05);
            background-color: #333;
            color: #fff;
        }


        /* =========================================
           MODAL
        ========================================= */
        .modal-content {
            border-radius: 8px;
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
        }


        /* =========================================
           RESPONSIVE
        ========================================= */
        @media (max-width: 768px) {

            .cart-container {
                overflow-x: auto;
            }

            .cart-header,
            .cart-row {
                min-width: 800px;
            }

        }

    </style>

</div>
@endsection
