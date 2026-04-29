<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class ProductFiltersComponent extends Component
{
    public $categorySlug;
    public $category;

    // Filters
    public $search = '';
    public $selectedOhms = [];
    public $sortBy = 'default';
    
    // Available filter options
    public $availableOhms = [];
    public $sortOptions = [
        'default' => 'Default Sorting',
        'price_asc' => 'Price: Low to High',
        'price_desc' => 'Price: High to Low',
        'newest' => 'Newest First'
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedOhms' => ['except' => []],
        'sortBy' => ['except' => 'default']
    ];

    public function mount($categorySlug)
    {
        $this->categorySlug = $categorySlug;
        $this->category = Category::where('slug', $this->categorySlug)->first();
        
        // Load available ohms from product combinations in this category
        $this->availableOhms = Product::where('category_id', $this->category->id)
                                ->whereHas('combinations')
                                ->with('combinations')
                                ->get()
                                ->flatMap(function($product) {
                                    return $product->combinations->pluck('ohm')->unique();
                                })
                                ->unique()
                                ->sort()
                                ->values()
                                ->toArray();
    }

    public function updated($property)
    {
        // Only dispatch for filter-related properties
        if (in_array($property, ['search', 'selectedOhms', 'sortBy'])) {
            $this->dispatch('filters-updated', 
                search: $this->search,
                ohms: $this->selectedOhms,
                sortBy: $this->sortBy
            );
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'selectedOhms', 'sortBy']);
        $this->dispatch('filters-updated', 
            search: $this->search,
            ohms: $this->selectedOhms,
            sortBy: $this->sortBy
        );
    }

    public function render()
    {
        return view('livewire.category.product-filters-component');
    }
}
