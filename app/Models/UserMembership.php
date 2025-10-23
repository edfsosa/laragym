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

    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : null;
    }

    public function getMembershipNameAttribute()
    {
        return $this->membership ? $this->membership->name : null;
    }

    public function getMembershipDescriptionAttribute()
    {
        return $this->membership ? $this->membership->description : null;
    }

    public function getMembershipPriceAttribute() // en formato guaranies paraguayos
    {
        return $this->membership ? number_format($this->membership->price, 0, ',', '.') . ' Gs.' : null;
    }
}
