<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class Delivery extends Model
{
    use HasFactory, HasSpatial;

    protected $fillable = [
        'order_id', 'driver_id', 'tracking_number', 'status', 'pickup_address',
        'delivery_address', 'distance_km', 'estimated_time_minutes',
        'pickup_time', 'delivery_time', 'recipient_name', 'recipient_phone',
        'delivery_notes', 'driver_notes', 'current_location', 'route_data'
    ];

    protected $casts = [
    'distance_km' => 'decimal:2',
    'estimated_time_minutes' => 'decimal:2',
    'pickup_time' => 'datetime',
    'delivery_time' => 'datetime',
    'route_data' => 'array',
    'pickup_location' => \MatanYadaev\EloquentSpatial\Objects\Point::class,
    'delivery_location' => \MatanYadaev\EloquentSpatial\Objects\Point::class,
    'current_location' => \MatanYadaev\EloquentSpatial\Objects\Point::class,
];
  

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'pending' => 'Pending',
            'assigned' => 'Assigned',
            'picked_up' => 'Picked Up',
            'in_transit' => 'In Transit',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'failed' => 'Failed',
            'cancelled' => 'Cancelled'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getEstimatedDeliveryTimeAttribute()
    {
        return $this->estimated_time_minutes
            ? now()->addMinutes($this->estimated_time_minutes)
            : null;
    }
}

