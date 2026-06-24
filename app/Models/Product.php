<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Product extends Model
{
    use HasFactory, Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name', // The field you want to use for generating the slug
            ],
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productimages()
    {
        return $this->hasMany(Productimage::class);
    }

    public function combinations()
    {
        return $this->hasMany(Productcombination::class);
    }

    public function productreviews()
    {
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

    public function validPriceAttributes(): Collection
    {
        return $this->priceAttributes
            ->filter(function (ProductPriceAttribute $attribute): bool {
                return $this->hasPositivePrice($attribute->price);
            })
            ->values();
    }

    public function hasPurchasableBasePrice(): bool
    {
        return $this->hasPositivePrice($this->price);
    }

    public function hasPurchasablePriceAttributes(): bool
    {
        return $this->validPriceAttributes()->isNotEmpty();
    }

    public function hasPurchasablePricing(): bool
    {
        return $this->hasPurchasableBasePrice() || $this->hasPurchasablePriceAttributes();
    }

    /**
     * Resolve the price details that can safely be added to the cart.
     *
     * @return array{price: float, mrp: float|null, attribute_name: string|null, price_attribute_id: int|null}
     */
    public function resolvePurchasablePrice(?int $priceAttributeId = null): array
    {
        if ($priceAttributeId !== null) {
            $attribute = $this->validPriceAttributes()->firstWhere('id', $priceAttributeId);

            if (! $attribute) {
                throw new \RuntimeException('Selected price option is unavailable.');
            }

            return [
                'price' => (float) $attribute->price,
                'mrp' => $attribute->mrp !== null ? (float) $attribute->mrp : null,
                'attribute_name' => $attribute->name,
                'price_attribute_id' => $attribute->id,
            ];
        }

        if ($this->hasPurchasablePriceAttributes()) {
            throw new \RuntimeException('Please choose a price option.');
        }

        if (! $this->hasPurchasableBasePrice()) {
            throw new \RuntimeException('This product is not available to add to cart.');
        }

        return [
            'price' => (float) $this->price,
            'mrp' => $this->mrp !== null ? (float) $this->mrp : null,
            'attribute_name' => null,
            'price_attribute_id' => null,
        ];
    }

    public function lowestPurchasablePrice(): ?float
    {
        $attributePrice = $this->validPriceAttributes()->min('price');

        if ($attributePrice !== null) {
            return (float) $attributePrice;
        }

        if ($this->hasPurchasableBasePrice()) {
            return (float) $this->price;
        }

        return null;
    }

    public function primaryImage()
    {
        return $this->hasOne(Productimage::class)
            ->orderBy('order_no', 'asc');
    }

    protected function hasPositivePrice(mixed $price): bool
    {
        return is_numeric($price) && (float) $price > 0;
    }

    public function getOhmListAttribute()
    {
        return $this->combinations->pluck('name')->join(', ');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function approvedReviews()
    {
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
