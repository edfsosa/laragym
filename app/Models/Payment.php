<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'membership_id',
        'amount',
        'paid_at',
        'method',
    ];

    protected $casts = [
        'paid_at' => 'date',
        'amount' => 'decimal:2',
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
