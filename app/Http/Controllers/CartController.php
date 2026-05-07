<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            // Admins should not see a cart → redirect
            return redirect()->route('admin.dashboard')
                ->with('info', 'Admins do not have a cart.');
        }

        if (Auth::check()) {
            // Logged in customer → DB cart
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $items = $cart->items()->with('product')->get();
        } else {
            // Guest → session cart
            $sessionCart = session()->get('cart', []);
            $items = collect($sessionCart)->map(function ($quantity, $productId) {
                $product = Product::find($productId);
                return (object)[
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            });
        }

        return view('customer.cart', compact('items'));
    }

    public function add(Product $product)
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard')
                ->with('info', 'Admins cannot add items to a cart.');
        }

        if (Auth::check()) {
            // Logged in customer → DB cart
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => 1,
            ]);
        } else {
            // Guest → session cart
            $cart = session()->get('cart', []);
            $cart[$product->id] = ($cart[$product->id] ?? 0) + 1;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function remove($itemId)
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard')
                ->with('info', 'Admins cannot remove items from a cart.');
        }

        if (Auth::check()) {
            // Logged in customer → remove from DB cart
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $item = $cart->items()->find($itemId);

            if ($item) {
                $item->delete();
            }
        } else {
            // Guest → remove from session cart
            $cart = session()->get('cart', []);
            unset($cart[$itemId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed!');
    }

    public function checkout()
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

        return view('customer.checkout', compact('cart'));
    }
}