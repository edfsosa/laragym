<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutineExercise extends Model
{
    protected $fillable = [
        'routine_id',
        'exercise_id',
        'sets',
        'reps',
        'weight',
        'rest_seconds',
        'order',
    ];

    protected $casts = [
        'sets' => 'integer',
        'reps' => 'integer',
        'weight' => 'decimal:2',
        'rest_seconds' => 'integer',
        'order' => 'integer',
    ];

    public function routine()
    {
        return $this->belongsTo(Routine::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
