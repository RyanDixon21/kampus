<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CbtResult extends Model
{
    protected $table = 'cbt_results';

    protected $fillable = [
        'registration_id',
        'total_questions',
        'correct_answers',
        'score',
        'started_at',
        'completed_at'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'score' => 'integer',
    ];

    /**
     * Get the registration that owns this result
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
