<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CustomerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('customer.dashboard', compact('user'));
    }

    public function wishlistToCart(Product $product)
{
    $user = auth()->user();

    // Ensure user has a cart
    $cart = $user->cart()->firstOrCreate([
        'user_id' => $user->id,
    ]);

    // Add product to cart items
    $cart->items()->create([
        'product_id' => $product->id,
        'quantity'   => 1,
    ]);

    // Remove from wishlist pivot
    $user->wishlist()->detach($product->id);

    return redirect()->route('cart.index')
        ->with('success', 'Product moved from wishlist to cart!');
}



}
