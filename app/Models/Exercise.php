<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exercise extends Model
{
    protected $fillable = ['workout_id', 'name', 'sets', 'reps', 'weight'];

    protected $casts = ['weight' => 'decimal:2'];

    /** Cada exercício pertence a um treino. */
    public function workout(): BelongsTo
    {
        return $this->belongsTo(Workout::class);
    }
}
