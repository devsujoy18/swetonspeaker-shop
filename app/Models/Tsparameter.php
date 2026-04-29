<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tsparameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order_no'
    ];
}
