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

    /**
     * Obtiene la duración en segundos o minutos formateada según el valor.
     */
    public function getDurationAttribute()
    {
        if ($this->duration_seconds >= 60) {
            $minutes = floor($this->duration_seconds / 60);
            return "{$minutes} min";
        } else {
            return "{$this->duration_seconds} sec";
        }
    }

    /**
     * Obtiene el descanso en segundos o minutos formateada según el valor.
     */
    public function getRestAttribute()
    {
        if ($this->rest_seconds >= 60) {
            $minutes = floor($this->rest_seconds / 60);
            return "{$minutes} min";
        } else {
            return "{$this->rest_seconds} sec";
        }
    }

    /**
     * Obtiene el peso en kg formateado como entero sin decimales.
     */
    public function getWeightKgFormattedAttribute()
    {
        return $this->weight_kg ? number_format($this->weight_kg, 0) . ' kg' : null;
    }
}
