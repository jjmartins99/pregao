<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductListing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'store_id', 'product_id', 'price', 'sale_price', 'quantity',
        'min_order_quantity', 'max_order_quantity', 'is_available',
        'is_featured', 'views', 'sales', 'description', 'images',
        'specifications'
    ];

    protected $casts = [
        'price' => 'decimal:4',
        'sale_price' => 'decimal:4',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'images' => 'array',
        'specifications' => 'array'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, OrderItem::class);
    }

    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->sale_price) return 0;
        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function getStockStatusAttribute()
    {
        if ($this->quantity <= 0) return 'out_of_stock';
        if ($this->quantity <= 10) return 'low_stock';
        return 'in_stock';
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function incrementSales($quantity = 1)
    {
        $this->increment('sales', $quantity);
        $this->decrement('quantity', $quantity);
    }
}