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
        'duration_seconds',
        'rest_seconds',
        'weight_kg',
        'order',
    ];

    protected $casts = [
        'sets' => 'integer',
        'reps' => 'integer',
        'duration_seconds' => 'integer',
        'rest_seconds' => 'integer',
        'weight_kg' => 'decimal:2',
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

    public function logs()
    {
        return $this->hasMany(UserRoutineExerciseLog::class, 'routine_exercise_id');
    }

    public function getExerciseNameAttribute()
    {
        return $this->exercise ? $this->exercise->name : null;
    }

    public function getExerciseDescriptionAttribute()
    {
        return $this->exercise ? $this->exercise->description : null;
    }
}
