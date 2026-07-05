<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiveawaySubmission extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'car_model',
        'car_name',
        'car_fee',
        'street',
        'city',
        'zip',
        'country',
        'payment_method',
        'payment_status',
        'payment_proof',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
