<div 
x-data="{ cartCount: {{ \Darryldecode\Cart\Facades\CartFacade::getTotalQuantity() }} }" 
x-on:cart-qty-changed-mobile.window="cartCount = $event.detail.currentQuantity ?? $event.detail[0]?.currentQuantity ?? cartCount">
    <a href="{{ route('cart' )}}" class="text-white text-xl relative">
        <i class="fas fa-cart-plus"></i>
        <span class="absolute -top-1 -right-2 bg-red-500 text-xs rounded-full px-1" x-text="cartCount"></span>
    </a>
</div>
