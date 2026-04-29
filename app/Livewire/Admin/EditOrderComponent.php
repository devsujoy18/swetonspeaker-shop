<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Category;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;

class EditOrderComponent extends Component
{
    public Order $order;
    public string $cartSession;

    public array $cartItems = [];
    public array $quantities = [];

    public float $subtotal = 0;
    public float $total = 0;

    public string $search = '';
    public string $categoryId = '';
    public $categories;

    public array $selectedAttributes = [];
    public array $addErrors = [];

    public bool $shippingSameAsBilling = false;

    public string $billingName = '';
    public string $billingEmail = '';
    public string $billingPhone = '';
    public string $billingZip = '';
    public string $billingLocality = '';
    public string $billingStreet = '';
    public string $billingCity = '';
    public string $billingState = '';
    public string $billingLandmark = '';
    public ?string $billingAlternatePhone = null;
    public ?string $companyName = null;
    public ?string $gstNo = null;

    public string $shippingName = '';
    public string $shippingEmail = '';
    public string $shippingPhone = '';
    public string $shippingZip = '';
    public string $shippingLocality = '';
    public string $shippingStreet = '';
    public string $shippingCity = '';
    public string $shippingState = '';
    public string $shippingLandmark = '';
    public ?string $shippingAlternatePhone = null;

    public function mount(Order $order): void
    {
        abort_unless(auth()->user()?->can('isAdmin'), 403);

        // if ($order->payment_status !== 'success') {
        //     abort(403);
        // }

        $this->order = $order->load('orderitems.product.priceAttributes');
        $this->cartSession = 'order-edit-' . $this->order->id;

        $this->categories = Category::orderBy('name')->get();

        $this->fillOrderDetails();
        $this->loadCartFromOrder();
    }

    protected function fillOrderDetails(): void
    {
        $this->shippingSameAsBilling = (bool) $this->order->shipping_same_as_billing;

        $this->billingName = (string) $this->order->billing_name;
        $this->billingEmail = (string) $this->order->billing_email;
        $this->billingPhone = (string) $this->order->billing_phone;
        $this->billingZip = (string) $this->order->billing_zip;
        $this->billingLocality = (string) $this->order->billing_locality;
        $this->billingStreet = (string) $this->order->billing_street;
        $this->billingCity = (string) $this->order->billing_city;
        $this->billingState = (string) $this->order->billing_state;
        $this->billingLandmark = (string) $this->order->billing_landmark;
        $this->billingAlternatePhone = $this->order->billing_alternate_phone;
        $this->companyName = $this->order->company_name;
        $this->gstNo = $this->order->gst_no;

        $this->shippingName = (string) ($this->order->shipping_name ?? '');
        $this->shippingEmail = (string) ($this->order->shipping_email ?? '');
        $this->shippingPhone = (string) ($this->order->shipping_phone ?? '');
        $this->shippingZip = (string) ($this->order->shipping_zip ?? '');
        $this->shippingLocality = (string) ($this->order->shipping_locality ?? '');
        $this->shippingStreet = (string) ($this->order->shipping_street ?? '');
        $this->shippingCity = (string) ($this->order->shipping_city ?? '');
        $this->shippingState = (string) ($this->order->shipping_state ?? '');
        $this->shippingLandmark = (string) ($this->order->shipping_landmark ?? '');
        $this->shippingAlternatePhone = $this->order->shipping_alternate_phone;
    }

    protected function rules(): array
    {
        $rules = [
            'billingName' => 'required|string|max:255',
            'billingEmail' => 'required|email',
            'billingPhone' => 'required|digits_between:8,15',
            'billingZip' => 'required|string|max:20',
            'billingLocality' => 'required|string|max:255',
            'billingStreet' => 'required|string|max:255',
            'billingCity' => 'required|string|max:255',
            'billingState' => 'required|string|max:255',
            'billingLandmark' => 'required|string|max:255',
            'billingAlternatePhone' => 'nullable|digits_between:8,15',
            'companyName' => 'nullable|string|max:255',
            'gstNo' => 'nullable|regex:/^[A-Z0-9]{15}$/',
        ];

        if (! $this->shippingSameAsBilling) {
            $rules = array_merge($rules, [
                'shippingName' => 'required|string|max:255',
                'shippingEmail' => 'required|email',
                'shippingPhone' => 'required|digits_between:8,15',
                'shippingZip' => 'required|string|max:20',
                'shippingLocality' => 'required|string|max:255',
                'shippingStreet' => 'required|string|max:255',
                'shippingCity' => 'required|string|max:255',
                'shippingState' => 'required|string|max:255',
                'shippingLandmark' => 'required|string|max:255',
                'shippingAlternatePhone' => 'nullable|digits_between:8,15',
            ]);
        }

        return $rules;
    }

    public function loadCartFromOrder(): void
    {
        $cart = Cart::session($this->cartSession);
        $cart->clear();

        foreach ($this->order->orderitems as $item) {
            $cart->add([
                'id' => $this->cartItemId($item->product_id, $item->price_attribute_id),
                'name' => $item->product_name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'attributes' => [
                    'product_id' => $item->product_id,
                    'price_attribute_id' => $item->price_attribute_id,
                    'shop_description' => $item->shop_description,
                ],
            ]);
        }

        $this->refreshCart();
    }

    protected function refreshCart(): void
    {
        $cart = Cart::session($this->cartSession);
        $this->cartItems = $cart->getContent()->sortBy('id')->values()->toArray();
        $this->subtotal = (float) $cart->getSubTotal();
        $this->total = (float) $cart->getTotal();

        $this->quantities = [];
        foreach ($this->cartItems as $item) {
            $this->quantities[$item['id']] = $item['quantity'];
        }
    }

    public function updateQuantity(string $itemId): void
    {
        $quantity = (int) ($this->quantities[$itemId] ?? 1);

        if ($quantity < 1) {
            $quantity = 1;
        }

        Cart::session($this->cartSession)->update($itemId, [
            'quantity' => [
                'relative' => false,
                'value' => $quantity,
            ],
        ]);

        $this->refreshCart();
    }

    public function updatedQuantities($value, $itemId): void
    {
        $this->quantities[$itemId] = (int) $value;
        $this->updateQuantity((string) $itemId);
    }

    public function removeItem(string $itemId): void
    {
        Cart::session($this->cartSession)->remove($itemId);
        unset($this->quantities[$itemId]);
        $this->refreshCart();
    }

    public function addProduct(int $productId): void
    {
        $this->addErrors[$productId] = '';
        $product = Product::with('priceAttributes')->findOrFail($productId);

        $priceAttributeId = $this->selectedAttributes[$productId] ?? null;
        $attribute = null;

        if ($product->priceAttributes->isNotEmpty()) {
            if (! $priceAttributeId) {
                $this->addErrors[$productId] = 'Select a price option.';
                return;
            }

            $attribute = $product->priceAttributes->firstWhere('id', (int) $priceAttributeId);
            if (! $attribute) {
                $this->addErrors[$productId] = 'Invalid price option.';
                return;
            }
        }

        $cartId = $this->cartItemId($product->id, $attribute?->id);
        $cart = Cart::session($this->cartSession);

        if ($cart->get($cartId)) {
            $cart->update($cartId, [
                'quantity' => [
                    'relative' => true,
                    'value' => 1,
                ],
            ]);
        } else {
            $cart->add([
                'id' => $cartId,
                'name' => $attribute ? ($product->name . ' (' . $attribute->name . ')') : $product->name,
                'price' => (float) ($attribute?->price ?? $product->price),
                'quantity' => 1,
                'attributes' => [
                    'product_id' => $product->id,
                    'price_attribute_id' => $attribute?->id,
                    'shop_description' => $product->shop_description,
                ],
            ]);
        }

        $this->selectedAttributes[$productId] = null;
        $this->refreshCart();
    }

    public function saveChanges(): void
    {
        $this->validate();

        $cart = Cart::session($this->cartSession);
        $cartItems = $cart->getContent();

        if ($cartItems->isEmpty()) {
            $this->addError('cart', 'At least one item is required.');
            return;
        }

        $shippingData = $this->shippingSameAsBilling ? [
            'shipping_name' => $this->billingName,
            'shipping_email' => $this->billingEmail,
            'shipping_phone' => $this->billingPhone,
            'shipping_zip' => $this->billingZip,
            'shipping_locality' => $this->billingLocality,
            'shipping_street' => $this->billingStreet,
            'shipping_city' => $this->billingCity,
            'shipping_state' => $this->billingState,
            'shipping_landmark' => $this->billingLandmark,
            'shipping_alternate_phone' => $this->billingAlternatePhone,
        ] : [
            'shipping_name' => $this->shippingName,
            'shipping_email' => $this->shippingEmail,
            'shipping_phone' => $this->shippingPhone,
            'shipping_zip' => $this->shippingZip,
            'shipping_locality' => $this->shippingLocality,
            'shipping_street' => $this->shippingStreet,
            'shipping_city' => $this->shippingCity,
            'shipping_state' => $this->shippingState,
            'shipping_landmark' => $this->shippingLandmark,
            'shipping_alternate_phone' => $this->shippingAlternatePhone,
        ];

        DB::transaction(function () use ($cart, $cartItems, $shippingData) {
            $this->order->update(array_merge([
                'billing_name' => $this->billingName,
                'billing_email' => $this->billingEmail,
                'billing_phone' => $this->billingPhone,
                'billing_zip' => $this->billingZip,
                'billing_locality' => $this->billingLocality,
                'billing_street' => $this->billingStreet,
                'billing_city' => $this->billingCity,
                'billing_state' => $this->billingState,
                'billing_landmark' => $this->billingLandmark,
                'billing_alternate_phone' => $this->billingAlternatePhone,
                'company_name' => $this->companyName,
                'gst_no' => $this->gstNo,
                'shipping_same_as_billing' => $this->shippingSameAsBilling,
                'subtotal' => (float) $cart->getSubTotal(),
                'total' => (float) $cart->getTotal(),
                'is_modified' => 1,
            ], $shippingData));

            $existingItems = $this->order->orderitems()
                ->get()
                ->keyBy(fn (OrderItem $item) => $this->itemKey($item->product_id, $item->price_attribute_id));

            $usedKeys = [];

            foreach ($cartItems as $cartItem) {
                $productId = (int) ($cartItem->attributes->product_id ?? $cartItem->id);
                $priceAttributeId = $cartItem->attributes->price_attribute_id ?? null;
                $key = $this->itemKey($productId, $priceAttributeId);
                $usedKeys[] = $key;

                $payload = [
                    'product_id' => $productId,
                    'price_attribute_id' => $priceAttributeId,
                    'shop_description' => $cartItem->attributes->shop_description ?? null,
                    'product_name' => $cartItem->name,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'total' => $cartItem->price * $cartItem->quantity,
                ];

                if ($existingItems->has($key)) {
                    $existingItems[$key]->update($payload);
                } else {
                    $this->order->orderitems()->create($payload);
                }
            }

            foreach ($existingItems as $key => $item) {
                if (! in_array($key, $usedKeys, true)) {
                    $item->delete();
                }
            }
        });

        $this->order->refresh();
        $this->refreshCart();

        $this->dispatch('notify', [
            'message' => 'Order updated successfully.',
        ]);
    }

    protected function cartItemId(int $productId, $priceAttributeId): string
    {
        return $priceAttributeId ? $productId . '-' . $priceAttributeId : (string) $productId;
    }

    protected function itemKey(int $productId, $priceAttributeId): string
    {
        return $productId . '|' . ($priceAttributeId ?? '');
    }

    #[Computed]
    public function products()
    {
        return Product::query()
            ->where('shop_status', 0)
            ->where('is_sealable', 1)
            ->when($this->categoryId, function ($query) {
                $query->where('category_id', $this->categoryId);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('shop_description', 'like', '%' . $this->search . '%');
                });
            })
            ->with('priceAttributes')
            ->orderBy('name')
            ->take(20)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.edit-order-component', [
            'products' => $this->products,
        ]);
    }
}
