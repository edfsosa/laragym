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
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_minutes' => 'integer',
    ];

    public function exercises()
    {
        return $this->hasMany(RoutineExercise::class);
    }
}
