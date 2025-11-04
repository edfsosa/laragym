<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_membership_id',
        'amount',
        'method',
        'status',
        'paid_at',
        'transaction_reference',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function userMembership()
    {
        return $this->belongsTo(UserMembership::class, 'user_membership_id');
    }

    public function getMembershipNameAttribute()
    {
        return $this->userMembership ? $this->userMembership->membership->name : null;
    }

    public function getAmountFormattedAttribute() // en guaranies paraguayos
    {
        return number_format($this->amount, 0, ',', '.') . ' Gs';
    }

    public function getPaidAtFormattedAttribute()
    {
        return $this->paid_at ? $this->paid_at->format('d/m/Y H:i') : null;
    }
    
    public function getMethodLabelAttribute()
    {
        $methods = [
            'cash' => __('Cash'),
            'credit_card' => __('Credit card'),
            'debit_card' => __('Debit card'),
            'bank_transfer' => __('Bank transfer'),
            'qr_code' => __('QR code'),
            'other' => __('Other'),
        ];

        return $methods[$this->method] ?? __('Unknown');
    }

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'paid' => __('Paid'),
            'pending' => __('Pending'),
            'failed' => __('Failed'),
        ];

        return $statuses[$this->status] ?? __('Unknown');
    }
}
