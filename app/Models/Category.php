<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use HasFactory, Sluggable;
    
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name', // The field you want to use for generating the slug
            ],
        ];
    }

    public function keyfeatures()
    {
        return $this->belongsToMany(Keyfeature::class, 'category_keyfeature')
                    ->withPivot('id','category_id','keyfeature_id','keyfeature_value', 'order_no', 'status', 'created_at', 'updated_at')
                    ->orderBy('category_keyfeature.order_no');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
