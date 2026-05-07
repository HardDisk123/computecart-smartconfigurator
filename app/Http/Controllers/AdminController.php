<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // ----------------------
        // Stats array
        // ----------------------
        $stats = [
            'products'  => Product::count(),
            'orders'    => Order::count(),
            'customers' => User::where('role_id', 2)->count(),
            'reviews'   => Review::count(),
        ];

        // Total revenue
        $totalRevenue = Order::sum('total');

        // Recent Orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Products for management table
        $products = Product::latest()->take(10)->get();

        // Top Products by number of orders
        $topProducts = Product::withCount('orderItems')
                        ->orderBy('order_items_count', 'desc')
                        ->take(5)
                        ->get();

        // Average ratings for products
        $averageRatings = Product::withAvg('reviews', 'rating')
                            ->orderByDesc('reviews_avg_rating')
                            ->take(5)
                            ->get();

        // Most wishlisted products
        $mostWishlisted = Product::withCount('wishlist')
                            ->orderByDesc('wishlist_count')
                            ->take(5)
                            ->get();

        // Chart data for recent orders
        $ordersChartLabels = $recentOrders->pluck('created_at')->map->format('M d');
        $ordersChartData   = $recentOrders->pluck('total');

        // Fetch all categories
        $categories = Category::paginate(10); // or whatever page size you want;

        return view('admin.dashboard', compact(
            'stats', 'totalRevenue', 'recentOrders', 'products', 'topProducts', 
            'averageRatings', 'mostWishlisted', 'ordersChartLabels', 'ordersChartData', 'categories'
        ));
    }

    // ----------------------
    // Product creation / editing with categories
    // ----------------------
    public function create()
    {
        $categories = Category::paginate(10); // or whatever page size you want
        return view('admin.products.create', compact('categories'));
    }

    public function edit(Product $product)
    {
        $categories = Category::paginate(10); // or whatever page size you want
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function store(Request $request)
    {
        Product::create($request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]));

        return redirect()->route('admin.dashboard')->with('success', 'Product added successfully!');
    }

    // ----------------------
    // Reviews management
    // ----------------------
    public function reviews()
    {
        $reviews = \App\Models\Review::with('product','user')->latest()->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function deleteReview(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')
                         ->with('success', 'Review deleted successfully.');
    }

    public function approveReview(Review $review)
    {
        $review->update(['approved' => true]);
        return redirect()->route('admin.reviews.index')
                         ->with('success', 'Review approved successfully.');
    }

    public function rejectReview(Review $review)
    {
        $review->update(['approved' => false]);
        return redirect()->route('admin.reviews.index')
                         ->with('success', 'Review rejected successfully.');
    }

    // ----------------------
    // Orders management
    // ----------------------
    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // ----------------------
// Users / Customers management
// ----------------------
public function users()
{
    $users = User::where('role_id', 2)->latest()->paginate(10);
    return view('admin.users.index', compact('users'));
}

public function editUser(User $user)
{
    return view('admin.users.edit', compact('user'));
}

public function updateUser(Request $request, User $user)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
    ]);

    $user->update($request->only(['name','email']));

    return redirect()->route('admin.users.index')
                     ->with('success','Customer updated successfully.');
}

public function destroyUser(User $user)
{
    $user->delete();

    return redirect()->route('admin.users.index')
                     ->with('success','Customer deleted successfully.');
}
}