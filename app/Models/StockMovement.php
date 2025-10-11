<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'warehouse_id', 'batch_id', 'quantity', 'type', 
        'movement_type', 'reference_id', 'reference_type', 'notes', 'user_id'
    ];

    protected $casts = [
        'quantity' => 'decimal:3'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }

    public function scopeIn($query)
    {
        return $query->where('type', 'IN');
    }

    public function scopeOut($query)
    {
        return $query->where('type', 'OUT');
    }
}