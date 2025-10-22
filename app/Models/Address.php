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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function department()
    {
        return $this->city->department();
    }
}
