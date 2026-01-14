<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RegistrationPath extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'registration_fee',
        'start_date',
        'end_date',
        'is_active',
        'quota',
        'requirements',
        'system_type',
        'degree_level',
        'wave',
        'period'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'registration_fee' => 'decimal:2',
        'requirements' => 'array'
    ];

    /**
     * Get registrations for this path
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get study programs available for this path
     */
    public function studyPrograms(): BelongsToMany
    {
        return $this->belongsToMany(StudyProgram::class, 'registration_path_study_program')
            ->withTimestamps();
    }

    /**
     * Check if registration path is currently open
     */
    public function isOpen(): bool
    {
        $now = now();
        return $this->is_active 
            && $now->greaterThanOrEqualTo($this->start_date)
            && $now->lessThanOrEqualTo($this->end_date);
    }

    /**
     * Check if registration path has quota available
     */
    public function hasQuotaAvailable(): bool
    {
        if ($this->quota === null) {
            return true; // Unlimited quota
        }

        return $this->registrations()->count() < $this->quota;
    }

    /**
     * Scope to get only active registration paths
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get only open registration paths
     */
    public function scopeOpen($query)
    {
        $now = now();
        return $query->where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now);
    }

    /**
     * Scope to filter by degree level
     */
    public function scopeByDegreeLevel($query, string $level)
    {
        return $query->where('degree_level', $level);
    }

    /**
     * Scope to filter by system type
     */
    public function scopeBySystemType($query, string $type)
    {
        return $query->where('system_type', $type);
    }

    /**
     * Scope to filter by study program
     */
    public function scopeByStudyProgram($query, int $programId)
    {
        return $query->whereHas('studyPrograms', function ($q) use ($programId) {
            $q->where('study_programs.id', $programId);
        });
    }

    /**
     * Get formatted registration fee
     */
    public function getFormattedFeeAttribute(): string
    {
        return 'Rp ' . number_format($this->registration_fee, 0, ',', '.');
    }

    /**
     * Get formatted date range
     */
    public function getDateRangeAttribute(): string
    {
        return $this->start_date->format('d M Y') . ' - ' . $this->end_date->format('d M Y');
    }
}
