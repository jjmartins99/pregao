<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_list_id', 'product_id', 'price', 
        'min_quantity', 'packaging_type'
    ];

    protected $casts = [
        'price' => 'decimal:4',
        'min_quantity' => 'decimal:3'
    ];

    public function priceList()
    {
        return $this->belongsTo(PriceList::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function packaging()
    {
        return $this->belongsTo(Packaging::class, 'packaging_type', 'code');
    }

    public function scopeForPackaging($query, $packagingType)
    {
        return $query->where('packaging_type', $packagingType);
    }

    public function scopeForQuantity($query, $quantity)
    {
        return $query->where('min_quantity', '<=', $quantity)
                    ->orderBy('min_quantity', 'desc');
    }
}