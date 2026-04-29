<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Computed;

class RelatedProductComponent extends Component
{
    public $type;
    public $categorySlug;
    public $productSlug;
    public $product;

    public function mount($type, $categorySlug, $productSlug){
        $this->type = $type;
        $this->categorySlug = $categorySlug;
        $this->productSlug = $productSlug;
        
        // Find the current product to get its category ID
        $this->product = Product::with('category')->where('slug', $this->productSlug)->first();
    }

    #[Computed]
    public function relatedProducts()
    {
        if ($this->product) {
            return Product::with('productimages')
                ->where('category_id', $this->product->category_id)
                ->where('id', '!=', $this->product->id)
                ->inRandomOrder() // Optional: Show a random selection of related products
                ->take(10) // Limit to a manageable number of related products
                ->get();
        }
        return collect();
    }

    public function render()
    {
        return view('livewire.products.related-product-component', [
            'relatedProducts' => $this->relatedProducts
        ]);
    }
}
