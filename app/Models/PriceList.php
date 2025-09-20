<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id', 'name', 'is_default', 'is_active', 
        'valid_from', 'valid_to'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function items()
    {
        return $this->hasMany(PriceListItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('valid_from')
                          ->orWhere('valid_from', '<=', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('valid_to')
                          ->orWhere('valid_to', '>=', now());
                    });
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function getPriceForProduct($productId, $packagingType = 'UN', $quantity = 1)
    {
        return $this->items()
            ->where('product_id', $productId)
            ->where('packaging_type', $packagingType)
            ->where('min_quantity', '<=', $quantity)
            ->orderBy('min_quantity', 'desc')
            ->value('price');
    }
}