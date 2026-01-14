<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'code',
        'logo',
        'admin_fee',
        'instructions',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'admin_fee' => 'decimal:2',
        'instructions' => 'array'
    ];

    /**
     * Calculate total amount including admin fee
     */
    public function calculateTotal(float $amount): float
    {
        return $amount + $this->admin_fee;
    }

    /**
     * Scope to get only active payment methods
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->orderBy('sort_order');
    }
}
