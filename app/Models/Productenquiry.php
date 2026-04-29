<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productenquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'whatsapp_no',
        'email',
        'product_name',
        'quantity',
        'location',
        'comments'
    ];
}