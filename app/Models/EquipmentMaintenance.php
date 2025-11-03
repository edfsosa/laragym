<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentMaintenance extends Model
{
    /** @use HasFactory<\Database\Factories\EquipmentMaintenanceFactory> */
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'type',
        'title',
        'description',
        'status',
        'performed_at',
        'next_due_at',
        'cost',
        'vendor',
    ];

    protected $casts = [
        'performed_at' => 'datetime',
        'next_due_at' => 'datetime',
        'cost' => 'decimal:2',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    // Scopes útiles
    public function scopeDue($q)          { return $q->whereNotNull('next_due_at')->where('next_due_at', '<=', now()); }
    public function scopePending($q)      { return $q->where('status', 'pending'); }
    public function scopeInProgress($q)   { return $q->where('status', 'in_progress'); }
    public function scopeCompleted($q)    { return $q->where('status', 'completed'); }
}
