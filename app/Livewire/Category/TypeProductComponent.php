<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Livewire\Attributes\Computed;
use Livewire\Component;

class TypeProductComponent extends Component
{
    public $type;

    public $categories;

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

    public function mount($type)
    {
        $this->type = $type;
        $this->categoryService = new CategoryService;
        $this->loadCategoryAndProducts();
    }

    public function loadCategoryAndProducts()
    {
        $sellableCategories = $this->categoryService->getSellableCategoriesGroupedByType();
        if ($this->type === 'pro-loudspeaker') {
            $this->proloudSpeakers = $sellableCategories['pro'];
            $this->homeloudSpeakers = collect();
            $typeId = 1;
        } elseif ($this->type === 'home-loudspeaker') {
            $this->proloudSpeakers = collect();
            $this->homeloudSpeakers = $sellableCategories['home'];
            $typeId = 2;
        } else {
            $this->proloudSpeakers = $sellableCategories['pro'];
            $this->homeloudSpeakers = $sellableCategories['home'];
            $typeId = 0;
        }

        // Get all category IDs for this type
        $categoryIds = Category::when($typeId, function ($query) use ($typeId) {
            $query->where('type_id', $typeId);
        })
            ->pluck('id');

        $this->availableOhms = Product::whereIn('category_id', $categoryIds)
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
    }

    #[Computed]
    public function getProductsProperty()
    {
        $typeId = $this->getTypeIdFromSlug($this->type);

        $categories = Category::with([
            'products' => function ($q) {
                $q->where('is_sealable', 1)
                    ->where('shop_status', 0)
                    ->with(['priceAttributes', 'primaryImage']);

                if (! empty($this->selectedOhms) && $this->selectedOhms !== 'All Ohms') {
                    $q->whereHas('combinations', fn ($q2) => $q2->where('name', $this->selectedOhms)
                    );
                }

                if (! empty($this->search)) {
                    $q->where(fn ($q2) => $q2->where('products.name', 'like', "%{$this->search}%")
                        ->orWhere('products.shop_description', 'like', "%{$this->search}%")
                    );
                }

                $q->orderBy('products.shop_order_no', 'asc');
            },
        ])
            ->where('type_id', $typeId)
            ->where('shop_status', 0)
            ->orderBy('shop_order_no', 'asc') // category order
            ->get();

        // Post-process sorting
        foreach ($categories as $category) {
            $category->products = $category->products->map(function ($product) {
                $product->effective_price = $product->lowestPurchasablePrice() ?? $product->price;

                return $product;
            });

            switch ($this->sortBy) {
                case 'price_asc':
                    $category->products = $category->products->sortBy('effective_price')->values();
                    break;
                case 'price_desc':
                    $category->products = $category->products->sortByDesc('effective_price')->values();
                    break;
                case 'newest':
                    $category->products = $category->products->sortByDesc('created_at')->values();
                    break;
                case 'default':
                default:
                    // $category->products = $category->products->sortByDesc('id')->values();
                    break;
            }
        }

        return $categories;
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

    public function getTypeIdFromSlug($type)
    {
        return match ($type) {
            'pro-loudspeaker' => 1,  // Example
            'home-loudspeaker' => 2, // Example
            default => null,
        };
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
        return view('livewire.category.type-product-component');
    }
}
