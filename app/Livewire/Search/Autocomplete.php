<?php

namespace App\Livewire\Search;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Support\Collection;



class Autocomplete extends Component
{
    public $query = '';
    public Collection $results;
    public $category = '';
    protected $categoryService;
    public $sellableCategories;


    public function mount(){
        $this->results = collect();
        $this->categoryService = new CategoryService();
        $this->sellableCategories = $this->categoryService->getSellableCategoriesGroupedByType();
    }

    public function updatedQuery()
    {
        if (strlen($this->query) > 2) {
            $this->results = Product::with(['primaryImage','category'])
                ->where('is_sealable', 1)
                ->where('shop_status', 0)
                ->when($this->category, function ($q) {
                    $q->whereHas('category', function ($sub) {
                        $sub->where('slug', $this->category);
                    });
                })
                ->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->query . '%')
                      ->orWhere('shop_description', 'like', '%' . $this->query . '%');
                })
                ->take(10)
                ->get();
        } else {
            $this->results = collect();
        }
    }

    public function selectCategory($categorySlug)
    {
        $this->category = $categorySlug;
        $this->updatedQuery();
    }

    public function render()
    {
        return view('livewire.search.autocomplete');
    }
}
