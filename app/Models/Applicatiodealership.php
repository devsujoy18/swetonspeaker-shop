<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicatiodealership extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'organisation_name',
        'contact_person',
        'address',
        'mobile_no',
        'speaker',
        'created_at',
        'updated_at'
    ];
}
