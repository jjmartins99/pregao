<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'name', 'code', 'conversion_factor', 
        'barcode', 'price_adjustment', 'is_default', 'is_active'
    ];

    protected $casts = [
        'conversion_factor' => 'decimal:3',
        'price_adjustment' => 'decimal:2',
        'is_default' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'packaging_type', 'code');
    }

    public function getPriceForProduct($productPrice)
    {
        if ($this->price_adjustment) {
            return $productPrice + $this->price_adjustment;
        }
        
        return $productPrice * $this->conversion_factor;
    }

    public function getBaseQuantity($quantity)
    {
        return $quantity * $this->conversion_factor;
    }

    public function getPackagedQuantity($baseQuantity)
    {
        return $baseQuantity / $this->conversion_factor;
    }
}