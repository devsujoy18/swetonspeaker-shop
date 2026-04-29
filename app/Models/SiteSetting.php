<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'cart_enabled',
        'minimum_cart_amount',
        'cart_disabled_message',
        'home_message',
    ];

    public static function getSettings()
    {
        return self::first() ?? self::create([]);
    }
}
