<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberRoutine extends Model
{
    protected $fillable = [
        'user_id',
        'routine_id',
        'trainer_id',
        'assigned_date',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function routine()
    {
        return $this->belongsTo(Routine::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
