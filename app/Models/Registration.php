<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    protected $fillable = [
        'registration_number',
        'registration_path_id',
        'first_choice_program_id',
        'second_choice_program_id',
        'program_type',
        'name',
        'email',
        'phone',
        'date_of_birth',
        'address',
        'voucher_code',
        'referral_code',
        'payment_method',
        'payment_amount',
        'discount_amount',
        'final_amount',
        'payment_status',
        'payment_date',
        'payment_proof',
        'status',
        'data_confirmed_at',
        'cbt_score',
        'cbt_completed_at'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'payment_date' => 'datetime',
        'data_confirmed_at' => 'datetime',
        'cbt_completed_at' => 'datetime',
        'payment_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
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

    /**
     * Get the registration path
     */
    public function registrationPath(): BelongsTo
    {
        return $this->belongsTo(RegistrationPath::class);
    }

    /**
     * Get the first choice program
     */
    public function firstChoiceProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class, 'first_choice_program_id');
    }

    /**
     * Get the second choice program
     */
    public function secondChoiceProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class, 'second_choice_program_id');
    }

    /**
     * Get the voucher used
     */
    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class, 'voucher_code', 'code');
    }
}
