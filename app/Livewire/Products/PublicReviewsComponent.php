<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;

class PublicReviewsComponent extends Component
{
    public $product;

    protected $listeners = ['reviewUpdated' => '$refresh'];

    public function mount($type, $categorySlug, $productSlug)
    {
        $this->product = Product::where("slug", $productSlug)->firstorfail();
    }

    public function getReviewsProperty()
    {
        return $this->product->approvedReviews()
            ->with('user')
            ->latest()
            ->get();
    }

    public function getAverageRatingProperty()
    {
        return $this->product->average_rating;
    }

    public function getTotalReviewsProperty()
    {
        return $this->product->total_reviews;
    }

    public function render()
    {
        return view('livewire.products.public-reviews-component', [
            'reviews' => $this->reviews,
            'averageRating' => $this->averageRating,
            'totalReviews' => $this->totalReviews,
        ]);
    }
}
