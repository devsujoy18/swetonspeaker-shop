<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;

class PublicOtherDetailsComponent extends Component
{
    public $type;
    public $categorySlug;
    public $productSlug;
    public $product;

    public function mount($type, $categorySlug, $productSlug){
        $this->type = $type;
        $this->categorySlug = $categorySlug;
        $this->productSlug = $productSlug;
        $this->loadProductdetails();
    }

    public function loadProductdetails(){
        $this->product = Product::with([
                        'category',
                        'productimages' => function ($query) {
                            $query->where('status', 0)
                                ->orderBy('order_no');
                        },
                        'combinations.productkeyfeatures' => function ($query) {
                            $query->where('status', 0)
                                ->orderBy('order_no');
                        },
                        'combinations.productmountinginfos' => function ($query) {
                            $query->where('status', 0)
                                ->orderBy('order_no');
                        },
                        'combinations.productspecifications' => function ($query) {
                            $query->where('status', 0)
                                ->orderBy('order_no');
                        },
                        'combinations.producttsparameters' => function ($query) {
                            $query->where('status', 0)
                                ->orderBy('order_no');
                        },
                        'combinations.productreconkits' => function ($query) {
                            $query->where('status', 0)
                                ->orderBy('order_no');
                        },
                    ])->where('slug', $this->productSlug)->first();
    }

    public function render()
    {
        return view('livewire.products.public-other-details-component');
    }
}
