<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    protected $fillable = [
        'user_id',
        'document_number',
        'gender',
        'birth_date',
        'phone',
        'avatar',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Relación con el modelo User, indicando que cada registro de datos personales pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accesor para obtener la representación traducida del género.
     */
    public function getGenderTranslatedAttribute()
    {
        return match($this->gender) {
            'male' => __('Masculino'),
            'female' => __('Femenino'),
            default => null,
        };
    }

    /**
     * Accesor para obtener la fecha de nacimiento formateada dd/mm/yyyy.
     */
    public function getBirthDateFormattedAttribute()
    {
        return $this->birth_date?->format('d/m/Y');
    }
}
