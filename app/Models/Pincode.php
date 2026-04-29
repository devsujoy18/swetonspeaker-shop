<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    protected $fillable = [
        'scrcd',
        'region',
        'state',
        'pin_code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
