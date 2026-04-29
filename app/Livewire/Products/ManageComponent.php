<?php

namespace App\Livewire\Products;

use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Tag;
use App\Models\ProductPriceAttribute;
use App\Services\CategoryService;

class ManageComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    // Public properties for inline editing
    public $editingProductId = null;
    public $editingField = null;
    public $editedValue = null;

    // Properties for the attribute modal
    public $showAttributeModal = false;
    public $editingAttributeId = null;
    public $productForAttributeId = null;
    public $attributeName = '';
    public $attributeMrp = 0.0;
    public $attributePrice = 0.0;

    // Properties for tag mapping modal
    public $showTagModal = false;
    public $productForTagId = null;
    public $selectedTags = [];

    // Validation rules (adjust as needed)
    protected $rules = [
        'editedValue' => 'required', // General rule, will be more specific per field
    ];

    // Validation rules for the attribute modal
    protected function attributeRules()
    {
        return [
            'attributeName' => 'required|string|max:255',
            'attributeMrp' => 'nullable|numeric|min:0',
            'attributePrice' => 'required|numeric|min:0',
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage(); // This is the line that resets the page!
    }

    public function updatedPerPage()
    {
        $this->resetPage(); // This also resets the page when perPage changes!
    }

    // Method to set a field into editing mode
    public function editField($productId, $field, $currentValue)
    {
        $this->editingProductId = $productId;
        $this->editingField = $field;
        $this->editedValue = $currentValue;
    }

    // Method to save the edited field
    public function saveField($productId)
    {
        // First, find the product
        $product = Product::find($productId);

        if (!$product) {
            session()->flash('error', 'Product not found!');
            $this->cancelEdit();
            return;
        }

        // Validate the specific field
        $field = $this->editingField;
        
        // Define specific validation rules based on the field
        $fieldRules = [];
        switch ($field) {
            case 'mrp':
            case 'price':
                $fieldRules['editedValue'] = ['required', 'numeric', 'min:0'];
                break;
            case 'shop_status':
                // Assuming shop_status is a tinyInteger (0 or 1, or more states)
                $fieldRules['editedValue'] = ['required', 'integer', 'between:0,255']; // Adjust range as per your tinyInteger max value
                break;
            case 'shop_order_no':
                $fieldRules['editedValue'] = ['required', 'integer', 'min:0'];
                break;
            case 'shop_description':
                $fieldRules['editedValue'] = ['nullable', 'string'];
                break;
            default:
                // Fallback for unknown fields or general validation
                $fieldRules['editedValue'] = ['required'];
                break;
        }

        $this->validate($fieldRules);

        // Update the product field
        $product->{$field} = $this->editedValue;
        $product->save();

        //Clear service cache
        $categoryService = new CategoryService;
        $categoryService->clearSellableCategoriesGroupedByType();

        if ($product->category) {
            $categoryService->clearCategoryWithProducts($product->category->slug);
        }

        session()->flash('message', 'Product ' . ucfirst($field) . ' updated successfully!');

        // Exit editing mode
        $this->cancelEdit();
    }

    // Method to cancel editing
    public function cancelEdit()
    {
        $this->editingProductId = null;
        $this->editingField = null;
        $this->editedValue = null;
    }


    // ATTRIBUTE MODAL METHODS
    public function openAttributeModal($attributeId = null, $productId = null)
    {
        $this->resetValidation();
        $this->editingAttributeId = $attributeId;
        
        if ($attributeId) {
            $attribute = ProductPriceAttribute::find($attributeId);
            if ($attribute) {
                $this->productForAttributeId = $attribute->product_id;
                $this->attributeName = $attribute->name;
                $this->attributeMrp = $attribute->mrp;
                $this->attributePrice = $attribute->price;
            }
        } elseif ($productId) {
            $this->productForAttributeId = $productId;
            $this->attributeName = '';
            $this->attributeMrp = 0.0;
            $this->attributePrice = 0.0;
        }

        $this->showAttributeModal = true;
    }

    public function closeAttributeModal()
    {
        $this->showAttributeModal = false;
        $this->reset([
            'editingAttributeId',
            'productForAttributeId',
            'attributeName',
            'attributeMrp',
            'attributePrice'
        ]);
    }

    public function saveAttribute()
    {
        $this->validate($this->attributeRules());

        try {
            if ($this->editingAttributeId) {
                // Update existing attribute
                $attribute = ProductPriceAttribute::find($this->editingAttributeId);
                if ($attribute) {
                    $attribute->update([
                        'name' => $this->attributeName,
                        'mrp' => $this->attributeMrp,
                        'price' => $this->attributePrice,
                    ]);
                    session()->flash('message', 'Attribute updated successfully!');
                }
            } else {
                // Create new attribute
                ProductPriceAttribute::create([
                    'product_id' => $this->productForAttributeId,
                    'name' => $this->attributeName,
                    'mrp' => $this->attributeMrp,
                    'price' => $this->attributePrice,
                ]);
                session()->flash('message', 'Attribute added successfully!');
            }
            $this->closeAttributeModal();
        } catch (Exception $e) {
            session()->flash('error', 'An error occurred while saving the attribute.');
        }
    }

    public function deleteAttribute()
    {
        try {
            if ($this->editingAttributeId) {
                ProductPriceAttribute::find($this->editingAttributeId)->delete();
                session()->flash('message', 'Attribute deleted successfully!');
            }
            $this->closeAttributeModal();
        } catch (Exception $e) {
            session()->flash('error', 'An error occurred while deleting the attribute.');
        }
    }

    public function openTagModal($productId)
    {
        $this->resetValidation();

        $product = Product::with('tags')->findOrFail($productId);

        $this->productForTagId = $product->id;
        $this->selectedTags = $product->tags->pluck('id')->map(fn ($id) => (string) $id)->all();
        $this->showTagModal = true;
    }

    public function closeTagModal()
    {
        $this->showTagModal = false;
        $this->reset(['productForTagId', 'selectedTags']);
    }

    public function saveTagMapping()
    {
        $this->validate([
            'productForTagId' => 'required|exists:products,id',
            'selectedTags' => 'nullable|array',
            'selectedTags.*' => 'exists:tags,id',
        ]);

        $product = Product::findOrFail($this->productForTagId);
        $product->tags()->sync($this->selectedTags);

        session()->flash('message', 'Product tags updated successfully!');
        $this->closeTagModal();
    }


    // You might also want to display a readable status for shop_status
    public function getShopStatusText($statusValue)
    {
        return $statusValue == 0 ? 'Active' : 'Inactive';
    }


    public function render()
    {
        $productsQuery = Product::with(['category','combinations','priceAttributes','tags'])
                                ->where('is_sealable', 1);
        if ($this->search) {
            $productsQuery->where('name', 'like', '%' . $this->search . '%');
        }

        $sellableProducts = $productsQuery->paginate($this->perPage);
        $availableTags = Tag::active()->orderBy('title')->get(['id', 'title']);

        return view('livewire.products.manage-component', [
            'products' => $sellableProducts,
            'availableTags' => $availableTags,
        ]);
    }
}
