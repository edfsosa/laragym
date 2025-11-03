<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'description',
        'type',
        'image_url',
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
        return $this->hasMany(Exercise::class, 'equipment_id');
    }

    public function maintenances()
    {
        return $this->hasMany(EquipmentMaintenance::class, 'equipment_id');
    }

    public function lastMaintenance()
    {
        return $this->hasOne(EquipmentMaintenance::class, 'equipment_id')->latestOfMany('performed_at');
    }

    public function nextMaintenance()
    {
        return $this->hasOne(EquipmentMaintenance::class)
            ->ofMany('next_due_at', 'min')
            ->whereIn('status', ['pending', 'in_progress'])
            ->whereNotNull('next_due_at');
    }
}
