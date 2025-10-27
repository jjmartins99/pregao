<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'customer_id', 'store_id', 'status', 'subtotal',
        'shipping_cost', 'tax_amount', 'discount_amount', 'total',
        'shipping_address', 'billing_address', 'customer_notes', 'admin_notes',
        'cancelled_at', 'shipped_at', 'delivered_at'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'cancelled_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'refunded' => 'Refunded'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getIsPaidAttribute()
    {
        return $this->payment_status === 'paid';
    }

    public function getItemsCountAttribute()
    {
        return $this->items->sum('quantity');
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}