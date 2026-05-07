<?php  

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ConfiguratorController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\Review;

// ✅ Homepage Route with Featured Products + Categories
Route::get('/', function () {
    $featuredProducts = Product::take(6)->get(); 
    $categories = Category::orderBy('created_at', 'desc')->paginate(10);

    return view('customer.home', compact('featuredProducts', 'categories'));
})->name('home');

// Redirect /dashboard based on role
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->role_id == 1) {
            // Admin → Admin Dashboard
            return redirect()->route('admin.dashboard');
        }
        // Customer → Home page
        return redirect()->route('home');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

// ✅ Profile routes (customer account management)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Admin routes with prefix, name, and admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.home'); 
    })->name('index');

    Route::get('/dashboard', function () {
        $stats = [
            'products'  => Product::count(),
            'orders'    => Order::count(),
            'customers' => User::count(),
            'reviews'   => Review::count(),
        ];

        $recentOrders = Order::latest()->take(5)->get();

        $productCounts = Category::withCount('products')->pluck('products_count','name');
        $ordersPerMonth = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                            ->groupBy('month')
                            ->pluck('count','month');
        $customerGrowth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                            ->groupBy('month')
                            ->pluck('count','month');

        if ($productCounts->isEmpty()) {
            $productCounts = collect([
                'CPU' => 5,
                'GPU' => 3,
                'RAM' => 7,
                'Storage' => 4,
            ]);
        }

        if ($ordersPerMonth->isEmpty()) {
            $ordersPerMonth = collect([
                1 => 2,  
                2 => 5,  
                3 => 3,  
                4 => 6,  
            ]);
        }

        if ($customerGrowth->isEmpty()) {
            $customerGrowth = collect([
                1 => 1,  
                2 => 2,  
                3 => 4,  
                4 => 6,  
            ]);
        }

        return view('admin.dashboard', compact(
            'stats','recentOrders','productCounts','ordersPerMonth','customerGrowth'
        ));
    })->name('dashboard');

    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);

    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');

    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews.index');
    Route::delete('/reviews/{review}', [AdminController::class, 'deleteReview'])->name('reviews.delete');
    Route::patch('/reviews/{review}/approve', [AdminController::class, 'approveReview'])->name('reviews.approve');
    Route::patch('/reviews/{review}/reject', [AdminController::class, 'rejectReview'])->name('reviews.reject');
});

// ✅ Customer routes (storefront) — PUBLICLY ACCESSIBLE
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// ✅ Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');

// ✅ SmartConfigurator routes
Route::get('/configurator', [ConfiguratorController::class, 'show'])->name('configurator.show');
Route::post('/configurator/recommend', [ConfiguratorController::class, 'recommend'])->name('configurator.recommend');
Route::post('/configurator/add-to-cart', [ConfiguratorController::class, 'addToCart'])->name('configurator.addToCart');

// ✅ Checkout routes (handled by CheckoutController)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// ✅ Order + Wishlist + Reviews (must be logged in)
Route::middleware('auth')->group(function () {
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/{product}/move-to-cart', [CustomerController::class, 'wishlistToCart'])->name('wishlist.moveToCart');

    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__.'/auth.php';