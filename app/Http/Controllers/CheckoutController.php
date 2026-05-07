<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            // Admins should not see checkout → redirect
            return redirect()->route('admin.dashboard')
                ->with('info', 'Admins do not have a checkout page.');
        }

        if (Auth::check()) {
            // Logged in customer → DB cart
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $cart->load('items.product');
        } else {
            // Guest → session cart
            $sessionCart = session()->get('cart', []);
            $cart = (object)[
                'items' => collect($sessionCart)->map(function ($quantity, $productId) {
                    $product = Product::find($productId);
                    return (object)[
                        'product' => $product,
                        'quantity' => $quantity,
                    ];
                }),
            ];
        }

        // ✅ Always pass $cart to the view
        return view('customer.checkout', compact('cart'));
    }
}