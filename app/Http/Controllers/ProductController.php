<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // Product listing
    public function index(Request $request)
    {
        $query = Product::query();

        // Optional search filter
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Optional category filter
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('customer.products.index', compact('products', 'categories'));
    }

    // Product detail page
    public function show(Product $product)
    {
        // Eager load category + reviews + review authors
        $product->load('category','reviews.user');

        return view('customer.products.show', compact('product'));
    }
}

