<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class DeliveryDriver extends Model
{
    use HasFactory, HasSpatial;

    protected $fillable = [
        'user_id',
        'vehicle_type',
        'license_plate',
        'available',
        'current_location',
    ];

    /**
     * Definir os casts para atributos espaciais
     */
    protected $casts = [
        'current_location' => Point::class, // Cast para objeto de localização
    ];

    /**
     * Relacionamento com o User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     /**
     * Relacionamento com as Entregas
     */
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
   