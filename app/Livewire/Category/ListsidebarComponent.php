<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use App\Services\CategoryService;

class ListsidebarComponent extends Component
{
    public $homeloudSpeakers;
    public $proloudSpeakers;
    public $currentCategorySlug;
    public $typeSlug;

    public function mount($typeSlug = null, $categorySlug = null){
        $this->typeSlug = $typeSlug;
        $this->currentCategorySlug = $categorySlug;
        
        $categoryService = new CategoryService;
        $sellableCategories = $categoryService->getSellableCategoriesGroupedByType();

        //$this->proloudSpeakers = $sellableCategories['pro'];
        //$this->homeloudSpeakers = $sellableCategories['home'];

        // Show only categories for the given type
        if ($typeSlug === 'pro-loudspeaker') {
            $this->proloudSpeakers = $sellableCategories['pro'];
            $this->homeloudSpeakers = collect(); // empty
        } elseif ($typeSlug === 'home-loudspeaker') {
            $this->homeloudSpeakers = $sellableCategories['home'];
            $this->proloudSpeakers = collect(); // empty
        } else {
            // If no type given, show all
            $this->proloudSpeakers = $sellableCategories['pro'];
            $this->homeloudSpeakers = $sellableCategories['home'];
        }

        
    }

    public function render()
    {
        return view('livewire.category.listsidebar-component');
    }
}
