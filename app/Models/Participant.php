<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'customer_id',
        'subscription_fee',
    ];

    public function winners(): HasMany
    {
        return $this->hasMany(Winner::class);
    }
}
