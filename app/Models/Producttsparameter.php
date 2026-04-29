<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producttsparameter extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function productcombination()
    {
        return $this->belongsTo(ProductCombination::class);
    }

    public function tsparameter()
    {
        return $this->belongsTo(Tsparameter::class);
    }
}
