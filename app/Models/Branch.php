<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id', 'name', 'code', 'address', 'phone', 'email', 
        'default_tax_rate', 'is_main', 'is_active'
    ];

    protected $casts = [
        'default_tax_rate' => 'decimal:2',
        'is_main' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }

    public function priceLists()
    {
        return $this->hasMany(PriceList::class);
    }

    public function saleLimits()
    {
        return $this->hasOne(SaleLimit::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function getMainWarehouseAttribute()
    {
        return $this->warehouses()->where('type', 'main')->first();
    }
}