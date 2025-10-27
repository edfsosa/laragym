<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'description',
        'summary',
        'is_active',
        'sort_order',
        'image_path',
    ];
}
