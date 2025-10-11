<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'logo', 'banner',
        'contact_email', 'contact_phone', 'address', 'rating', 'total_ratings',
        'is_verified', 'is_active', 'settings'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'settings' => 'array',
        'rating' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(StoreCategory::class, 'store_store_category');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function listings()
    {
        return $this->hasMany(ProductListing::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function deliveryDrivers()
    {
        return $this->hasMany(DeliveryDriver::class);
    }

    public function getTotalSalesAttribute()
    {
        return $this->orders()->where('status', 'delivered')->count();
    }

    public function getTotalRevenueAttribute()
    {
        return $this->orders()->where('status', 'delivered')->sum('total');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
}