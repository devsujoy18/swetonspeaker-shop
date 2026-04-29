<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutComponent extends Component
{
    public $cartItems;
    public $subtotal = 0;
    public $total = 0;

    public function mount(){
        $this->cartItems = Cart::getContent()->sortBy('id');
        $this->subtotal = Cart::getSubTotal();
        $this->total = Cart::getTotal();
    }

    public function render()
    {
        return view('livewire.cart.checkout-component');
    }
}
