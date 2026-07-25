<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CategoryProductsComponent extends Component
{
    public $categorySlug;

    public $category;

    public $type;

    protected $categoryService;

    public $availableOhms = [];

    public $sortOptions = [
        'default' => 'Default Sorting',
        'price_asc' => 'Price: Low to High',
        'price_desc' => 'Price: High to Low',
        'newest' => 'Newest First',
    ];

    public $selectedOhms;

    public $sortBy = 'default';

    public $search = '';

    public $homeloudSpeakers;

    public $proloudSpeakers;

    public $alertMessage = '';

    public $showAttributeModal = false;

    public $selectedProduct;

    public $selectedAction;

    public $selectedAttributeId;

    public $attributeCarterror = false;

    public function mount($type, $categorySlug)
    {
        $this->categorySlug = $categorySlug;
        $this->categoryService = new CategoryService;
        $this->loadCategoryAndProducts();
    }

    public function loadCategoryAndProducts()
    {
        $this->category = $this->categoryService->getCategoryWithProducts($this->categorySlug);
        // $this->products = $this->category->products;

        $this->availableOhms = Product::where('category_id', $this->category->id)
            ->whereHas('combinations')
            ->with('combinations')
            ->get()
            ->flatMap(function ($product) {
                return $product->combinations->pluck('name')->unique();
            })
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        $sellableCategories = $this->categoryService->getSellableCategoriesGroupedByType();
        $this->proloudSpeakers = $sellableCategories['pro'];
        $this->homeloudSpeakers = $sellableCategories['home'];

        $this->type = $this->category->type_id == 1 ? 'pro-loudspeaker' : 'home-loudspeaker';
    }

    #[Computed]
    public function getProductsProperty()
    {
        $query = Product::query()
            ->where('category_id', $this->category->id)
            ->where('is_sealable', 1)
            ->where('shop_status', 0);

        // Ohm filter
        if (! empty($this->selectedOhms) && $this->selectedOhms !== 'All Ohms') {
            $query->whereHas('combinations', function ($q) {
                $q->where('name', $this->selectedOhms);
            });
        }

        // Search filter
        if (! empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('shop_description', 'like', '%'.$this->search.'%');
            });
        }

        // Sorting
        switch ($this->sortBy) {
            case 'price_asc':
            case 'price_desc':
                $direction = $this->sortBy === 'price_asc' ? 'asc' : 'desc';

                $query->addSelect([
                    'effective_price' => \DB::table('product_price_attributes')
                        ->selectRaw('COALESCE(MIN(CASE WHEN price > 0 THEN price END), products.price)')
                        ->whereColumn('product_id', 'products.id'),
                ])->orderBy('effective_price', $direction);
                break;

            case 'newest':
                $query->orderBy('products.created_at', 'desc');
                break;

            case 'default':
            default:
                // $query->orderBy('products.id', 'desc');
                break;
        }

        // Always respect shop_order_no as the secondary sort
        $query->orderBy('shop_order_no', 'asc');

        return $query->with(['priceAttributes', 'primaryImage'])->get();
    }

    /**
     * Show attribute modal
     */
    public function openAttributeModal($productId, $action)
    {
        $this->selectedProduct = Product::with('priceAttributes')->find($productId);
        if (! $this->selectedProduct || ! $this->selectedProduct->hasPurchasablePriceAttributes()) {
            $this->dispatch('alert', message: 'This product has no selectable price options.');

            return;
        }

        $this->selectedAction = $action;
        $this->showAttributeModal = true;
        $this->attributeCarterror = false;
        $this->selectedAttributeId = null;
    }

    public function confirmAction()
    {
        if ($this->selectedAttributeId) {
            if ($this->selectedAction === 'buy-now') {
                $this->buyNow($this->selectedProduct->id, $this->selectedAttributeId);
            } elseif ($this->selectedAction === 'add-to-cart') {
                $this->addTocart($this->selectedProduct->id, $this->selectedAttributeId);
            }
        } else {
            $this->attributeCarterror = true;
        }
    }

    public function closeAttributeModal()
    {
        $this->showAttributeModal = false;
        $this->reset([
            'selectedProduct',
            'selectedAction',
            'selectedAttributeId',
        ]);
    }

    /**
     * Add to cart with attributes
     */
    public function addTocart($productId, $priceAttributeId = null)
    {
        try {
            $product = Product::with(['priceAttributes', 'primaryImage'])->find($productId);
            if (! $product) {
                throw new \RuntimeException('Product not found.');
            }

            $priceSelection = $product->resolvePurchasablePrice($priceAttributeId);

            $productimg = $product->primaryImage;
            if ($productimg) {
                $productImgpath = env('IMG_HOST').'uploads/'.$productimg->path;
            } else {
                $productImgpath = asset('image/buy.jpg');
            }

            $cartId = $priceAttributeId ? $productId.'-'.$priceAttributeId : $productId;

            Cart::add([
                'id' => $cartId,
                'name' => $product->name.($priceSelection['attribute_name'] ? ' ('.$priceSelection['attribute_name'].')' : ''),
                'price' => $priceSelection['price'],
                'quantity' => 1,
                'attributes' => [
                    'mrp' => $priceSelection['mrp'],
                    'image' => $productImgpath,
                    'shop_description' => $product->shop_description ?? null,
                    'product_id' => $productId,
                    'price_attribute_id' => $priceSelection['price_attribute_id'],
                    'attribute_name' => $priceSelection['attribute_name'],
                ],
            ]);

            if ($priceAttributeId) {
                $this->showAttributeModal = false;
                $this->reset([
                    'selectedProduct',
                    'selectedAction',
                    'selectedAttributeId',
                ]);
            }

            $this->alertMessage = $product->name.' added to cart!';
            $this->dispatch('alert', message: $this->alertMessage);
        } catch (\Exception $e) {
            $this->alertMessage = 'Error adding product to cart: '.$e->getMessage();
            $this->dispatch('alert', message: $this->alertMessage);
        }

        $currentCartQty = Cart::getTotalQuantity();
        $this->dispatch('cart-qty-changed-mobile', currentQuantity: $currentCartQty);
    }

    // Buy Now
    public function buyNow($productId, $priceAttributeId = null)
    {
        try {
            $product = Product::with(['priceAttributes', 'primaryImage'])->find($productId);
            if (! $product) {
                throw new \RuntimeException('Product not found.');
            }

            $priceSelection = $product->resolvePurchasablePrice($priceAttributeId);

            $productimg = $product->primaryImage;
            if ($productimg) {
                $productImgpath = env('IMG_HOST').'uploads/'.$productimg->path;
            } else {
                $productImgpath = asset('image/buy.jpg');
            }

            $cartId = $priceAttributeId ? $productId.'-'.$priceAttributeId : $productId;

            Cart::add([
                'id' => $cartId,
                'name' => $product->name.($priceSelection['attribute_name'] ? ' ('.$priceSelection['attribute_name'].')' : ''),
                'price' => $priceSelection['price'],
                'quantity' => 1,
                'attributes' => [
                    'mrp' => $priceSelection['mrp'],
                    'image' => $productImgpath,
                    'shop_description' => $product->shop_description ?? null,
                    'product_id' => $productId,
                    'price_attribute_id' => $priceSelection['price_attribute_id'],
                    'attribute_name' => $priceSelection['attribute_name'],
                ],
            ]);

            if ($priceAttributeId) {
                $this->showAttributeModal = false;
                $this->reset([
                    'selectedProduct',
                    'selectedAction',
                    'selectedAttributeId',
                ]);
            }

            $this->alertMessage = $product->name.' added to cart!';
            $this->dispatch('alert', message: $this->alertMessage);
        } catch (\Exception $e) {
            $this->alertMessage = 'Error adding product to cart: '.$e->getMessage();
            $this->dispatch('alert', message: $this->alertMessage);
        }

        $currentCartQty = Cart::getTotalQuantity();
        $this->dispatch('cart-qty-changed-mobile', currentQuantity: $currentCartQty);

        return redirect()->route('cart')->with('message', $this->alertMessage.'. Please proceed to buy');
    }

    public function render()
    {
        return view('livewire.category.category-products-component');
    }
}
