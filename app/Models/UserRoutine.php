<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoutine extends Model
{
    protected $fillable = [
        'user_id',
        'routine_id',
        'assigned_by',
        'assigned_at',
        'completed_at',
        'status',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function routine()
    {
        return $this->belongsTo(Routine::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function exerciseLogs()
    {
        return $this->hasMany(UserRoutineExerciseLog::class, 'user_routine_id');
    }

    public function getRoutineNameAttribute()
    {
        return $this->routine ? $this->routine->name : null;
    }

    public function getRoutineDescriptionAttribute()
    {
        return $this->routine ? $this->routine->description : null;
    }

    public function getRoutineLevelTranslatedAttribute()
    {
        if (!$this->routine) {
            return null;
        }

        switch ($this->routine->level) {
            case 'beginner':
                return __('Beginner');
            case 'intermediate':
                return __('Intermediate');
            case 'advanced':
                return __('Advanced');
            default:
                return $this->routine->level;
        }
    }

    public function getRoutineDurationMinutesAttribute()
    {
        return $this->routine ? $this->routine->duration_minutes : null;
    }

    public function getRoutineTypeAttribute()
    {
        return $this->routine ? $this->routine->type : null;
    }

    public function getStatusTranslatedAttribute()
    {
        switch ($this->status) {
            case 'assigned':
                return __('Assigned');
            case 'in_progress':
                return __('In Progress');
            case 'paused':
                return __('Paused');
            case 'completed':
                return __('Completed');
            case 'cancelled':
                return __('Cancelled');
            default:
                return $this->status;
        }
    }

    public function getAssignedAtFormattedAttribute()
    {
        return $this->assigned_at ? $this->assigned_at->diffForHumans() : null;
    }

    public function getAssignedByNameAttribute()
    {
        return $this->assignedBy ? $this->assignedBy->name : null;
    }

    protected static function booted()
    {
        static::created(function (UserRoutine $userRoutine) {
            // Obtener todos los ejercicios de la rutina
            $routineExercises = $userRoutine->routine->routineExercises;

            // Crear un log para cada ejercicio en la rutina
            foreach ($routineExercises as $routineExercise) {
                UserRoutineExerciseLog::create([
                    'user_routine_id' => $userRoutine->id,
                    'routine_exercise_id' => $routineExercise->id,
                    'status' => 'pending',
                ]);
            }
        });
    }
}
