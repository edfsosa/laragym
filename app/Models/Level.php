<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'name',
        'min_xp',
        'description',
        'icon',
    ];

    protected $casts = [
        'min_xp' => 'integer',
    ];

    public static function getLevelByXp(int $xp): ?Level
    {
        return self::where('min_xp', '<=', $xp)
            ->orderBy('min_xp', 'desc')
            ->first();
    }
}
