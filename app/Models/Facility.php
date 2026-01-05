<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'images',
        'status',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'images' => 'array',
    ];

    /**
     * Scope to get only published facilities
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($facility) {
            if (empty($facility->slug)) {
                $facility->slug = Str::slug($facility->name);
            }
        });

        static::updating(function ($facility) {
            if ($facility->isDirty('name')) {
                $facility->slug = Str::slug($facility->name);
            }
        });
    }
}
