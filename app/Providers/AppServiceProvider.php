<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;   
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Make categories available in all views
        View::composer('*', function ($view) {
            $view->with('categories', Category::all());
        });

        // Make featured products available in all views
        View::composer('*', function ($view) {
            $featuredProducts = Product::whereIn('category_id', [3, 6, 10, 5])->get();
            $view->with('featuredProducts', $featuredProducts);
        });
    }
}
