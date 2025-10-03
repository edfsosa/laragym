<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
        'equipment_id',
        'name',
        'description',
        'muscle_group',
        'image_url',
        'video_url',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function routineExercises()
    {
        return $this->hasMany(RoutineExercise::class);
    }
}
