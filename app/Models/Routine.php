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

    /**
     * Obtener la traducción del nivel de la rutina
     */
    public function getLevelTranslatedAttribute()
    {
        $levels = [
            'beginner' => 'Principiante',
            'intermediate' => 'Intermedio',
            'advanced' => 'Avanzado',
        ];

        return $levels[$this->level] ?? $this->level;
    }

    /**
     * Obtener la clase de badge según el nivel de la rutina
     */
    public function getLevelBadgeAttribute()
    {
        switch ($this->level) {
            case 'beginner':
                return 'badge-success';
            case 'intermediate':
                return 'badge-warning';
            case 'advanced':
                return 'badge-error';
            default:
                return 'badge-secondary';
        }
    }

    /**
     * Obtener la traducción del tipo de la rutina
     */
    public function getTypeTranslatedAttribute()
    {
        $types = [
            'strength' => 'Fuerza',
            'cardio' => 'Cardio',
            'flexibility' => 'Flexibilidad',
            'balance' => 'Equilibrio',
        ];

        return $types[$this->type] ?? $this->type;
    }

    /**
     * Obtener la traducción del grupo muscular de la rutina
     */
    public function getMuscleGroupTranslatedAttribute()
    {
        $muscleGroups = [
            'upper_body' => 'Parte Superior',
            'lower_body' => 'Parte Inferior',
            'full_body' => 'Cuerpo Completo',
            'core' => 'Núcleo',
        ];

        return $muscleGroups[$this->muscle_group] ?? $this->muscle_group;
    }

    /**
     * Contar el número de ejercicios en la rutina
     */
    public function getExercisesCountAttribute()
    {
        return $this->exercises()->count();
    }

    /**
     * Obtener la descripción corta de la rutina
     */
    public function getShortDescriptionAttribute()
    {
        return strlen($this->description) > 100
            ? substr($this->description, 0, 100) . '...'
            : $this->description;
    }
}
