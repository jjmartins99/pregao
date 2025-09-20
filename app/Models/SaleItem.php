<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id', 'product_id', 'batch_id', 'quantity', 
        'unit_price', 'tax_rate', 'discount_rate', 'discount_amount', 
        'total', 'packaging_type', 'packaging_factor', 'notes'
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'unit_price' => 'decimal:4',
        'tax_rate' => 'decimal:2',
        'discount_rate' => 'decimal:2',
        'discount_amount' => 'decimal:4',
        'total' => 'decimal:4',
        'packaging_factor' => 'decimal:3'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function packaging()
    {
        return $this->belongsTo(Packaging::class, 'packaging_type', 'code');
    }

    public function getBaseQuantityAttribute()
    {
        return $this->quantity * $this->packaging_factor;
    }

    public function getSubtotalAttribute()
    {
        return $this->unit_price * $this->quantity;
    }

    public function getTaxAmountAttribute()
    {
        return $this->subtotal * ($this->tax_rate / 100);
    }

    public function getTotalBeforeDiscountAttribute()
    {
        return $this->subtotal + $this->tax_amount;
    }
}