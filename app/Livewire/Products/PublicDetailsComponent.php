<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Livewire\Component;

class PublicDetailsComponent extends Component
{
    public $type;

    public $categorySlug;

    public $productSlug;

    public $product;

    public $quantity = 1;

    public $selectedAttributeId;

    public $selectedAttribute;

    public $attributePriceError = false;

    public function mount($type, $categorySlug, $productSlug)
    {
        $this->type = $type;
        $this->categorySlug = $categorySlug;
        $this->productSlug = $productSlug;
        $this->loadProductdetails();
    }

    public function loadProductdetails()
    {
        $this->product = Product::with([
            'priceAttributes',
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

    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        try {

            $this->attributePriceError = false;

            if (! $this->product) {
                throw new \RuntimeException('Product not found.');
            }

            if ($this->product->hasPurchasablePriceAttributes() && ! $this->selectedAttributeId) {
                $this->attributePriceError = true;

                return;
            }

            $priceSelection = $this->product->resolvePurchasablePrice($this->selectedAttributeId ? (int) $this->selectedAttributeId : null);

            // Get the product details and image
            $productimg = $this->product->primaryImage;
            $productImgpath = $productimg ? env('IMG_HOST').'/uploads/'.$productimg->path : asset('image/buy.jpg');

            $name = $this->product->name;
            $mrp = $priceSelection['mrp'];
            $price = $priceSelection['price'];
            $cartId = $this->product->id;
            $shopDescription = $this->product->shop_description ?? null;
            $attributeName = $priceSelection['attribute_name'];
            $this->selectedAttribute = null;

            if ($this->selectedAttributeId) {
                $this->selectedAttribute = $this->product->validPriceAttributes()->firstWhere('id', $this->selectedAttributeId);

                if ($this->selectedAttribute) {
                    $name = $this->product->name.' ('.$this->selectedAttribute->name.')';
                    $cartId = $this->product->id.'-'.$this->selectedAttribute->id;
                    $attributeName = $this->selectedAttribute->name;
                }
            }

            Cart::add([
                'id' => $cartId,
                'name' => $name,
                'price' => $price,
                'quantity' => $this->quantity,
                'attributes' => [
                    'mrp' => $mrp,
                    'image' => $productImgpath,
                    'shop_description' => $shopDescription,
                    'attribute_name' => $attributeName, // Save the attribute name to the cart
                ],
            ]);

            if ($this->selectedAttribute) {
                $this->attributePriceError = false;
                $this->reset([
                    'selectedAttribute',
                    'selectedAttributeId',
                ]);
            }

            $this->dispatch('alert', message: $name.' added to cart!');

        } catch (\Exception $e) {
            $this->dispatch('alert', message: 'Error adding product to cart: '.$e->getMessage());
        }

        // Refresh cart related data
        $this->dispatch('cart-qty-changed-desktop');
        $this->dispatch('cart-qty-changed-mobile', ['currentQuantity' => Cart::getTotalQuantity()]);
    }

    public function render()
    {
        return view('livewire.products.public-details-component');
    }
}
