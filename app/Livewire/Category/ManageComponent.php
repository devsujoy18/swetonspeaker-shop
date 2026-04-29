<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use App\Services\CategoryService;

class ManageComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    // Public properties for inline editing
    public $editingCategoryId = null;
    public $editingField = null;
    public $editedValue = null;

    protected $rules = [
        'editedValue' => 'required',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function editField($categoryId, $field, $currentValue)
    {
        $this->editingCategoryId = $categoryId;
        $this->editingField = $field;
        $this->editedValue = $currentValue;
    }

    public function saveField($categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            session()->flash('error', 'Category not found!');
            $this->cancelEdit();
            return;
        }

        $field = $this->editingField;
        
        $fieldRules = [];
        switch ($field) {
            case 'shop_status':
                $fieldRules['editedValue'] = ['required', 'integer', 'in:0,1'];
                break;
            case 'shop_order_no':
                $fieldRules['editedValue'] = ['required', 'integer', 'min:0'];
                break;
            case 'shop_show_on_home':
                $fieldRules['editedValue'] = ['required', 'integer', 'in:0,1'];
                break;
            default:
                $fieldRules['editedValue'] = ['required'];
                break;
        }

        $this->validate($fieldRules);

        // Update the category field
        $category->{$field} = $this->editedValue;
        $category->save();

        //Clear service cache
        $categoryService = new CategoryService;
        $categoryService->clearSellableCategoriesforhome();

        session()->flash('message', 'Category ' . ucfirst($field) . ' updated successfully!');

        // Exit editing mode
        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->editingCategoryId = null;
        $this->editingField = null;
        $this->editedValue = null;
    }

    public function getShopStatusText($statusValue)
    {
        return $statusValue == 0 ? 'Active' : 'Inactive';
    }

    public function getShopShowOnHomeText($statusValue)
    {
        return $statusValue == 1 ? 'Yes' : 'No';
    }

    public function render()
    {
        $categoryQuery = Category::whereHas('products', function ($query) {
                            $query->where('is_sealable', 1);
                        });
        if ($this->search) {
            $categoryQuery->where('name', 'like', '%' . $this->search . '%');
        }

        $sellableCategories = $categoryQuery->paginate($this->perPage);
        return view('livewire.category.manage-component',[
            'categories' => $sellableCategories,
        ]);
    }
}
