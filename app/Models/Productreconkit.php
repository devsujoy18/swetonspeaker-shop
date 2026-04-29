<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productreconkit extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function productcombination()
    {
        return $this->belongsTo(ProductCombination::class);
    }

    public function reconkit()
    {
        return $this->belongsTo(Reconkit::class);
    }
}
