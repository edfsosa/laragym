<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'image',
        'video_url',
        'serial_number',
        'brand',
        'model',
        'status',
        'purchased_at',
        'purchase_price',
    ];

    protected $casts = [
        'purchased_at' => 'date',
        'purchase_price' => 'decimal:2',
    ];

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }
}
