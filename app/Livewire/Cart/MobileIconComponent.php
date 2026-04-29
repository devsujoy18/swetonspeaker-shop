<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Livewire\Attributes\On;

class MobileIconComponent extends Component
{
    public function render()
    {
        return view('livewire.cart.mobile-icon-component');
    }
}
