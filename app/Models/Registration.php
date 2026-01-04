<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Registration extends Model
{
    protected $fillable = [
        'registration_number',
        'name',
        'email',
        'phone',
        'address',
        'status',
        'payment_amount',
        'payment_status',
        'payment_date',
        'cbt_score',
        'cbt_completed_at'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'cbt_completed_at' => 'datetime',
        'payment_amount' => 'decimal:2',
        'cbt_score' => 'integer',
    ];

    /**
     * Scope to get pending registrations
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get paid registrations
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Get the CBT result for this registration
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cbtResult(): HasOne
    {
        return $this->hasOne(CbtResult::class);
    }
}
