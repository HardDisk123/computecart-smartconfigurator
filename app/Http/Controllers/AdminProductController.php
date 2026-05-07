<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name','like','%'.$request->search.'%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id',$request->category_id);
        }

        $products   = $query->paginate(10);
        $categories = Category::all();

        return view('admin.products.index', compact('products','categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'description' => 'nullable|string',
            'details'     => 'nullable|string',
            'image'       => 'nullable|file|max:4096',
            'image1'      => 'nullable|file|max:4096',
            'image2'      => 'nullable|file|max:4096',
            'image3'      => 'nullable|file|max:4096',
            'image4'      => 'nullable|file|max:4096',
        ]);

        $data = $request->only([
            'name','description','details','price','stock','category_id'
        ]);

        foreach (['image','image1','image2','image3','image4'] as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('products', 'public');
                $data[$field] = $path;
            }
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
                         ->with('success','Product added successfully!');
    }

    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'description' => 'nullable|string',
            'details'     => 'nullable|string',
            'image'       => 'nullable|file|max:4096',
            'image1'      => 'nullable|file|max:4096',
            'image2'      => 'nullable|file|max:4096',
            'image3'      => 'nullable|file|max:4096',
            'image4'      => 'nullable|file|max:4096',
        ]);

        $data = $request->only([
            'name','description','details','price','stock','category_id'
        ]);

        foreach (['image','image1','image2','image3','image4'] as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists
                if ($product->$field) {
                    Storage::disk('public')->delete($product->$field);
                }

                // Store new file
                $path = $request->file($field)->store('products', 'public');
                $data[$field] = $path;
            }
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success','Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->deleteImages();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success','Product deleted successfully!');
    }
}
