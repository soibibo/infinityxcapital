<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'key',
        'name',
        'desc',
        'fee',
        'image',
        'category',
        'badge',
        'power',
        'range',
        'delivery',
        'gradient',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];
}
