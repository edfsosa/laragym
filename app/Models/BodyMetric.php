<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BodyMetric extends Model
{
    protected $fillable = [
        'user_id',
        'measurement_date',
        'weight',
        'height',
        'bmi',
        'notes',
    ];

    protected $casts = [
        'measurement_date' => 'date',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'bmi' => 'decimal:2',
    ];

    /**
     * Obtiene el usuario al que pertenecen estas métricas corporales.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Calcular BMI automáticamente
    protected static function booted()
    {
        static::saving(function ($metric) {
            if ($metric->weight && $metric->height && $metric->height > 0) {
                $metric->bmi = round($metric->weight / ($metric->height * $metric->height), 2);
            }
        });
    }
}
