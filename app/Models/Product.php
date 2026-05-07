<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Category;
use App\Models\Review;
use App\Models\CartItem;
use App\Models\Wishlist;
use App\Models\OrderItem;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'details',
        'price',
        'stock',
        'category_id',
        'image',
        'image1',
        'image2',
        'image3',
        'image4',
    ];

    /**
     * Relationships
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Helpers
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    // ✅ Collect all product images
    public function allImages()
    {
        return array_filter([
            $this->image,
            $this->image1,
            $this->image2,
            $this->image3,
            $this->image4,
        ]);
    }

    // ✅ Build full URLs for images stored in storage/app/public/products
    public function imageUrls()
    {
        return collect($this->allImages())->map(fn($img) => asset('storage/' . $img));
    }

     public function deleteImages()
    {
        foreach ($this->allImages() as $img) {
            if (Storage::disk('public')->exists($img)) {
                Storage::disk('public')->delete($img);
            }

        }
}
}
