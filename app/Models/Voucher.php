<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'max_uses',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
        'applicable_paths'
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'decimal:2',
        'applicable_paths' => 'array'
    ];

    /**
     * Get registrations using this voucher
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'voucher_code', 'code');
    }

    /**
     * Check if voucher is currently valid
     */
    public function isValid(): bool
    {
        $now = now();
        return $this->is_active
            && $now->greaterThanOrEqualTo($this->valid_from)
            && $now->lessThanOrEqualTo($this->valid_until);
    }

    /**
     * Check if voucher can still be used
     */
    public function canBeUsed(): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        if ($this->max_uses === null) {
            return true; // Unlimited uses
        }

        return $this->used_count < $this->max_uses;
    }

    /**
     * Calculate discount amount for given base amount
     */
    public function calculateDiscount(float $amount): float
    {
        if ($this->type === 'percentage') {
            $discount = ($amount * $this->value) / 100;
        } else {
            $discount = $this->value;
        }

        // Discount cannot exceed the base amount
        return min($discount, $amount);
    }

    /**
     * Check if voucher is applicable to a registration path
     */
    public function isApplicableToPath(int $pathId): bool
    {
        if (empty($this->applicable_paths)) {
            return true; // Applicable to all paths
        }

        return in_array($pathId, $this->applicable_paths);
    }

    /**
     * Increment used count
     */
    public function incrementUsedCount(): void
    {
        $this->increment('used_count');
    }

    /**
     * Scope to get only valid vouchers
     */
    public function scopeValid($query)
    {
        $now = now();
        return $query->where('is_active', true)
            ->where('valid_from', '<=', $now)
            ->where('valid_until', '>=', $now);
    }
}
