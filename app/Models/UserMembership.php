<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMembership extends Model
{
    protected $fillable = [
        'user_id',
        'membership_id',
        'start_at',
        'end_at',
        'status',
    ];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
