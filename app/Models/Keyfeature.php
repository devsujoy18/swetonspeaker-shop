<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyfeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order_no'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_keyfeature')
                    ->withPivot('id','category_id','keyfeature_id','keyfeature_value', 'order_no', 'status', 'created_at', 'updated_at');
    }
}
