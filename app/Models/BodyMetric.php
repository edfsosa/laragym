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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
