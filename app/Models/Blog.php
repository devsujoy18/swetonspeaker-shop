<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Blog extends Model
{
    use HasFactory, Sluggable;
    
    protected $casts = [
        'publish_date' => 'date',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title', // The field you want to use for generating the slug
            ],
        ];
    }

    public function blogimages(){
        return $this->hasMany(Blogimage::class);
    }
    
    public function blogreviews()
    {
        return $this->hasMany(Blogreview::class);
    }
}
