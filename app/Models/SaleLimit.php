<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'max_lines',
        'max_quantity_per_line',
        'max_total_amount',
        'max_total_quantity',
        'action',
        'is_active'
    ];

    protected $casts = [
        'max_quantity_per_line' => 'decimal:3',
        'max_total_amount' => 'decimal:2',
        'max_total_quantity' => 'decimal:3',
        'is_active' => 'boolean'
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}