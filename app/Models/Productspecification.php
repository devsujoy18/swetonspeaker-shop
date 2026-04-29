<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productspecification extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function productcombination()
    {
        return $this->belongsTo(ProductCombination::class);
    }

    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }
}
