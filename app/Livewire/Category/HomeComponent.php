<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use App\Services\CategoryService;

class HomeComponent extends Component
{
    public $proloudSpeakers = [];
    public $homeloudSpeakers = [];

    public function render()
    {
        $categoryService = new CategoryService;
        $sellableCategories = $categoryService->getSellableCategoriesforhome();
        $this->proloudSpeakers = $sellableCategories['pro'];
        $this->homeloudSpeakers = $sellableCategories['home'];
        
        return view('livewire.category.home-component');
    }
}
