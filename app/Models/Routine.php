<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    protected $fillable = [
        'name',
        'description',
        'level',
        'duration_minutes',
        'type',
        'muscle_group',
    ];

    /**
     * Relación con RoutineExercise, ordenada por el campo 'order'
     */
    public function routineExercises()
    {
        return $this->hasMany(RoutineExercise::class)->orderBy('order');
    }

    /**
     * Relación con Exercise a través de la tabla pivote 'routine_exercises', incluyendo campos adicionales y ordenada por 'order'
     */
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'routine_exercises')
            ->withPivot('sets', 'reps', 'duration_seconds', 'rest_seconds', 'weight_kg', 'order')
            ->withTimestamps()
            ->orderBy('pivot_order');
    }

    /**
     * Relación con UserRoutine
     */
    public function userRoutines()
    {
        return $this->hasMany(UserRoutine::class);
    }
}
