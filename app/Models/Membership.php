<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_days',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Obtener las membresías de usuario asociadas a esta membresía.
     */
    public function userMemberships()
    {
        return $this->hasMany(UserMembership::class);
    }

    /**
     * Obtener el precio formateado de la membresía en guaraníes.
     */
    public function getPriceFormattedAttribute()
    {
        return 'Gs. ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Obtener la duración formateada de la membresía en días.
     */
    public function getDurationDaysFormattedAttribute()
    {
        return $this->duration_days . ' días';
    }
}
