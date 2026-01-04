<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroCard extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'background_image',
        'button_text',
        'button_link',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
