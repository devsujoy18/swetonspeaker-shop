<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productkeyfeature extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productcombination()
    {
        return $this->belongsTo(ProductCombination::class);
    }

    public function keyfeature()
    {
        return $this->belongsTo(Keyfeature::class);
    }
}
