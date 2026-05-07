<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Show the user's wishlist.
     */
    public function index()
    {
        $wishlist = Auth::user()->wishlist()->get();
        return view('wishlist.index', compact('wishlist'));
    }

    /**
     * Add a product to the wishlist.
     */
    public function store($productId)
{
    $product = Product::findOrFail($productId);

    // prevent duplicates
    if (!Auth::user()->wishlist()->where('product_id', $productId)->exists()) {
        Auth::user()->wishlist()->attach($productId);
    }

    return back()->with('success', 'Product added to wishlist!');
}


    /**
     * Remove a product from the wishlist.
     */
    public function destroy($productId)
{
    Auth::user()->wishlist()->detach($productId);
    return back()->with('success', 'Product removed from wishlist!');
}

}