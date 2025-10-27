<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoutineExerciseLog extends Model
{
    protected $fillable = [
        'user_routine_id',
        'routine_exercise_id',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function userRoutine()
    {
        return $this->belongsTo(UserRoutine::class);
    }

    public function routineExercise()
    {
        return $this->belongsTo(RoutineExercise::class);
    }
}
