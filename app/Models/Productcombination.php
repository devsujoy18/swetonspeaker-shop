<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productcombination extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    
    public function productkeyfeatures(){
        return $this->hasMany(Productkeyfeature::class);
    }
    
    public function productmountinginfos(){
        return $this->hasMany(Productmountinginfo::class);
    }
    
    public function productspecifications(){
        return $this->hasMany(Productspecification::class);
    }
    
    public function producttsparameters(){
        return $this->hasMany(Producttsparameter::class);
    }
    
    public function productreconkits(){
        return $this->hasMany(Productreconkit::class);
    }
}
