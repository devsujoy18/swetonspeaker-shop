<?php

namespace App\Livewire\Cart;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class IconComponent extends Component
{
    public $cartCount = 0;

    public $cartItems;

    public $cartTotal;

    public $cartSubTotal;

    public function mount(): void
    {
        $this->refreshCart();
    }

    #[On('cart-qty-changed-mobile')]
    public function refreshCart(): void
    {
        $this->cartCount = Cart::getTotalQuantity();
        $this->cartItems = Cart::getContent();
        $this->cartTotal = Cart::getTotal();
        $this->cartSubTotal = Cart::getSubTotal();
    }

    public function render(): View
    {
        return view('livewire.cart.icon-component');
    }
}
