<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productmountinginfo extends Model
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

    public function mountinginfo()
    {
        return $this->belongsTo(Mountinginfo::class);
    }
}
