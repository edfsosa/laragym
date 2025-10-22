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

    public function userMemberships()
    {
        return $this->hasMany(UserMembership::class);
    }
}
