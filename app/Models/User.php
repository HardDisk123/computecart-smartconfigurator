<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Product;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Review;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship: User belongs to Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user is Admin
     */
    public function isAdmin()
    {
        return $this->role && $this->role->name === 'admin';
    }

    /**
     * Check if user is Customer
     */
    public function isCustomer()
    {
        return $this->role && $this->role->name === 'customer';
    }

    /**
     * Relationship: User has many Orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relationship: User has many Wishlist items
     */
    public function wishlist()
{
    return $this->belongsToMany(Product::class, 'wishlist');
}


    /**
     * Relationship: User has many Reviews
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cart()
{
    return $this->hasMany(Cart::class);
}

public function sendPasswordResetNotification($token)
{
    $this->notify(new CustomResetPassword($token));
}

}