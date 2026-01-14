<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StudyProgram extends Model
{
    protected $fillable = [
        'name',
        'code',
        'faculty',
        'degree_level',
        'program_type',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Get registrations with this as first choice
     */
    public function firstChoiceRegistrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'first_choice_program_id');
    }

    /**
     * Get registrations with this as second choice
     */
    public function secondChoiceRegistrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'second_choice_program_id');
    }

    /**
     * Get registration paths that offer this program
     */
    public function registrationPaths(): BelongsToMany
    {
        return $this->belongsToMany(RegistrationPath::class, 'registration_path_study_program')
            ->withTimestamps();
    }

    /**
     * Scope to get only active programs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by degree level
     */
    public function scopeDegreeLevel($query, string $level)
    {
        return $query->where('degree_level', $level);
    }

    /**
     * Scope to filter by program type (IPA/IPS)
     */
    public function scopeByProgramType($query, string $type)
    {
        return $query->where('program_type', $type);
    }

    /**
     * Scope to filter by faculty
     */
    public function scopeFaculty($query, string $faculty)
    {
        return $query->where('faculty', $faculty);
    }

    /**
     * Get full name with degree level
     */
    public function getFullNameAttribute(): string
    {
        return $this->degree_level . ' - ' . $this->name;
    }
}
