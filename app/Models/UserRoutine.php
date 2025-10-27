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
}
