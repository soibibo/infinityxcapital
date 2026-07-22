<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCardType extends Model
{
    protected $fillable = [
        'name',
        'code',
        'is_active',
        'instructions',
        'icon',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function submissions()
    {
        return $this->hasMany(GiveawaySubmission::class, 'gift_card_type_id');
    }
}
