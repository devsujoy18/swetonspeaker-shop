<?php

namespace App\Livewire\Cart;

use App\Models\Pincode;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Services\DelhiveryService;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class DetailsComponent extends Component
{
    public $cartItems;

    public $subtotal = 0;

    public $total = 0;

    public $postcode;

    // ðŸ”¹ Settings
    public $cartEnabled;

    public $minimumCartAmount;

    public $cartDisabledMessage;

    protected $rules = [
        'postcode' => 'required|numeric|digits:6',
    ];

    #[Computed]
    public function totalQuantity()
    {
        return Cart::getTotalQuantity();
    }

    public function mount()
    {
        // âœ… Load settings once
        $setting = SiteSetting::getSettings();

        $this->cartEnabled = $setting->cart_enabled;
        $this->minimumCartAmount = $setting->minimum_cart_amount;
        $this->cartDisabledMessage = $setting->cart_disabled_message;

        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cartItems = Cart::getContent()->sortBy('id');

        $activeProductIds = Product::query()
            ->whereIn('id', $this->cartItems->map(fn ($item): int => (int) Str::before($item->id, '-'))->unique())
            ->where('shop_status', 0)
            ->pluck('id')
            ->all();

        foreach ($this->cartItems as $item) {
            $productId = (int) Str::before($item->id, '-');

            if (! in_array($productId, $activeProductIds, true)) {
                Cart::remove($item->id);

                continue;
            }
        }

        $this->subtotal = Cart::getSubTotal();
        $this->total = Cart::getTotal();
    }

    public function removeItem($itemId)
    {
        Cart::remove($itemId);
        $this->loadCart();
        $this->dispatchCartUpdates();
    }

    public function clearCart()
    {
        Cart::clear();
        $this->loadCart();
        $this->dispatchCartUpdates();
    }

    public function incrementQuantity($itemId)
    {
        Cart::update($itemId, [
            'quantity' => [
                'relative' => true,
                'value' => 1,
            ],
        ]);

        $this->loadCart();
        $this->dispatchCartUpdates();
    }

    public function decrementQuantity($itemId)
    {
        $currentItem = Cart::get($itemId);
        if ($currentItem->quantity > 1) {
            $newQuantity = ($currentItem->quantity - 1);

            Cart::update($itemId, [
                'quantity' => [
                    'relative' => true,
                    'value' => -1,
                ],
            ]);
        }

        $this->loadCart();
        $this->dispatchCartUpdates();

    }

    protected function dispatchCartUpdates()
    {
        $currentCartQty = Cart::getTotalQuantity();
        $this->dispatch('cart-qty-changed-mobile', ['currentQuantity' => $currentCartQty]);
    }

    /**
     * Method: proceedToCheckout
     * Description: Postal code check and show option to proceed checkout
     */
    public function proceedToCheckout(DelhiveryService $delhivery)
    {
        $this->validate();

        // âœ… Check postcode via Delhivery API
        // $isServiceable = $delhivery->checkPostcode($this->postcode);
        // if (!$isServiceable) {
        //     $this->addError('postcode', 'Sorry, delivery is not available in this area.');
        //     return;
        // }

        $pincode = Pincode::where('pin_code', $this->postcode)
            ->where('is_active', true)
            ->first();

        if (! $pincode) {
            $this->addError('postcode', 'Sorry, delivery is not available for this pincode.');

            return;
        }

        // If validation passes, store the postcode in the session
        session(['checkout_postcode' => $this->postcode]);

        if (Auth::check()) {
            // User is logged in, redirect to the checkout page
            return redirect()->route('checkout'); // Make sure you have a route named 'checkout'
        } else {
            // User is a guest, open the checkout option modal
            $this->dispatch('show-checkout-options');
        }
    }

    public function render()
    {
        return view('livewire.cart.details-component');
    }
}
