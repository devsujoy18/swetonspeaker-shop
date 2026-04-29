<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Livewire\Attributes\On;

class IconComponent extends Component
{
    public $cartCount = 0;
    public $cartItems;
    public $cartTotal;
    public $cartSubTotal;

    public function mount(){
        $this->cartCount = Cart::getTotalQuantity();
        $this->cartItems = Cart::getContent();
        $this->cartTotal = Cart::getTotal();
        $this->cartSubTotal = Cart::getSubTotal();
    }

    #[On('cart-qty-changed-desktop')] 
    public function updateCartqty()
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
