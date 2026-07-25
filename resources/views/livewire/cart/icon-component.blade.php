<div
  class="relative"
  x-data="{ cartCount: {{ $cartCount }} }"
  x-on:cart-qty-changed-mobile.window="cartCount = $event.detail.currentQuantity ?? $event.detail[0]?.currentQuantity ?? cartCount"
>
  <!-- Cart Button -->
  <button 
    id="cart-button" 
    type="button"
    class="relative hover:text-gray-400"
  >
    <i class="fas fa-cart-plus text-xl"></i>
    <span 
      id="cart_widget_count" 
      class="absolute -top-1 -right-2 bg-red-600 text-white text-xs rounded-full px-1"
    >
      <span x-text="cartCount">{{ $cartCount }}</span>
    </span>
  </button>

  <!-- Dropdown Panel -->
  <div 
    id="cart-dropdown" 
    class="hidden absolute right-0 mt-2 w-80 bg-white border shadow-lg z-50"
  >
    <!-- Cart Item -->
    @if ($cartItems->count() > 0)
      @foreach ($cartItems as $item)
      <div class="p-4 border-b">
        <div class="flex gap-4 items-center">
          <img 
            src="{{ $item->attributes->image }}" 
            alt="{{ $item->name }}" 
            class="w-16 h-16 object-contain"
          >
          <div>
            <h4 class="font-semibold text-sm text-gray-500">
              {{ $item->name }}
            </h4>
            @if($item->attributes->shop_description)
            <p class="text-xs text-gray-500">
              ( {{ $item->attributes->shop_description }} )
            </p>
            @endif
            <p class="text-sm font-medium mt-1 text-gray-500">
              ₹{{ $item->price }} X {{ $item->quantity }}
            </p>
          </div>
        </div>
      </div>
      @endforeach
      <div class="p-4 border-b">
        <div class="flex justify-between text-sm text-gray-500">
          <span class="text-black">Subtotal</span>
          <span>₹{{ number_format($cartSubTotal, 2) }} /-</span>
        </div>
        <div class="flex justify-between text-sm font-semibold text-gray-500">
          <span class="text-black">Total</span>
          <span>₹{{ number_format($cartTotal, 2) }} /-</span>
        </div>
      </div>
      <div class="p-4">
        <a 
          href="{{ route('cart' )}}" 
          class="block w-full text-center bg-black text-white py-2 rounded hover:bg-gray-800 transition"
        >
          View Cart
        </a>
      </div>
    @else
      <div class="p-4 text-center text-gray-500">
        Your cart is empty.
      </div>
    @endif
  </div>
</div>
