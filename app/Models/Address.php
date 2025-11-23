<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Paraguay\Regions\Models\City;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'city_id',
        'street',
        'number',
        'reference',
    ];

    /**
     * Relación con el modelo User, indicando que cada dirección pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el modelo City, indicando que cada dirección pertenece a una ciudad.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Accesor para obtener el departamento asociado a la ciudad de la dirección.
     */
    public function getDepartmentAttribute()
    {
        return $this->city?->department;
    }
}
