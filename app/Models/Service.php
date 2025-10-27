<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'summary',
        'is_active',
        'is_featured',
        'sort_order',
    ];
}
