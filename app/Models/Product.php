<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
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

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function productimages(){
        return $this->hasMany(Productimage::class);
    }

    public function combinations(){
        return $this->hasMany(Productcombination::class);
    }

    public function productreviews(){
        return $this->hasMany(Productreview::class);
    }

    // NEW: Accessor to get the product image with order_no = 1
    // Access it like $product->latest_order1_image
    public function getLatestOrder1ImageAttribute()
    {
        // Find the first image where order_no is 1
        // Assuming 'order_no' exists in productimages table
        return $this->productimages()->where('order_no', 1)->first();
    }

    public function priceAttributes()
    {
        return $this->hasMany(ProductPriceAttribute::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(Productimage::class)
                    ->orderBy('order_no', 'asc');
    }
    
    public function getOhmListAttribute()
    {
        return $this->combinations->pluck('name')->join(', ');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
    
    public function approvedReviews(){
        return $this->hasMany(Productreview::class)->approved();
    }
    
    public function getAverageRatingAttribute()
    {
        return round($this->approvedReviews()->avg('rating') ?? 0, 1);
    }
    
    public function getTotalReviewsAttribute()
    {
        return $this->approvedReviews()->count();
    }

}
