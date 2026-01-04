<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CbtQuestion extends Model
{
    protected $table = 'cbt_questions';

    protected $fillable = [
        'question',
        'options',
        'category',
        'difficulty',
        'is_active'
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
        'difficulty' => 'integer',
    ];

    /**
     * Scope to get only active questions
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the correct option from the options array
     * 
     * @return array|null
     */
    public function getCorrectOptionAttribute()
    {
        return collect($this->options)->firstWhere('is_correct', true);
    }
}
