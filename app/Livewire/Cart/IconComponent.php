<?php

namespace App\Livewire\Cart;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use Livewire\Component;

class IconComponent extends Component
{
    public $cartCount = 0;

    public $cartItems;

    public $cartTotal;

    public $cartSubTotal;

    public function mount(): void
    {
        $this->cartCount = Cart::getTotalQuantity();
        $this->cartItems = Cart::getContent();
        $this->cartTotal = Cart::getTotal();
        $this->cartSubTotal = Cart::getSubTotal();
    }

    public function render()
    {
        return view('livewire.cart.icon-component');
    }
}
