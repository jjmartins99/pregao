<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'abbreviation', 'type', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeWeight($query)
    {
        return $query->where('type', 'weight');
    }

    public function scopeVolume($query)
    {
        return $query->where('type', 'volume');
    }

    public function scopeLength($query)
    {
        return $query->where('type', 'length');
    }

    public function scopeUnit($query)
    {
        return $query->where('type', 'unit');
    }
}