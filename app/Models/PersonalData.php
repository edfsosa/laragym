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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
