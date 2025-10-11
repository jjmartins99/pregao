<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id', 'sku', 'name', 'description', 'kind', 'track_stock', 
        'unit_id', 'min_stock', 'max_stock', 'expiry_control', 'stock_policy',
        'barcode', 'images', 'is_active'
    ];

    protected $casts = [
        'track_stock' => 'boolean',
        'expiry_control' => 'boolean',
        'min_stock' => 'decimal:2',
        'max_stock' => 'decimal:2',
        'images' => 'array',
        'is_active' => 'boolean'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function packagings()
    {
        return $this->hasMany(Packaging::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function priceListItems()
    {
        return $this->hasMany(PriceListItem::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function getDefaultPackagingAttribute()
    {
        return $this->packagings()->where('is_default', true)->first() ?? 
               $this->packagings()->first();
    }

    public function getStockQuantityAttribute()
    {
        if (!$this->track_stock) return 0;
        
        return $this->batches()->sum('quantity');
    }

    public function scopeGoods($query)
    {
        return $query->where('kind', 'GOOD');
    }

    public function scopeServices($query)
    {
        return $query->where('kind', 'SERVICE');
    }
}