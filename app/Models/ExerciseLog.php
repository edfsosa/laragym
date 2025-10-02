<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseLog extends Model
{
    protected $fillable = [
        'member_routine_id',
        'routine_exercise_id',
        'log_date',
        'completed',
    ];

    protected $casts = [
        'log_date' => 'date',
        'completed' => 'boolean',
    ];

    public function memberRoutine()
    {
        return $this->belongsTo(MemberRoutine::class);
    }

    public function routineExercise()
    {
        return $this->belongsTo(RoutineExercise::class);
    }
}
