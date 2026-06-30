<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workout extends Model
{
    protected $fillable = ['user_id', 'date', 'title', 'notes'];

    protected $casts = ['date' => 'date'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }

    public function totalVolume(): float
    {
        return $this->exercises->sum(fn ($e) => $e->sets * $e->reps * ($e->weight ?? 0));
    }
}
