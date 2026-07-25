<div
  class="relative"
  x-data="{ cartCount: {{ $cartCount }} }"
  x-on:cart-qty-changed-mobile.window="cartCount = $event.detail.currentQuantity ?? $event.detail[0]?.currentQuantity ?? cartCount"
>
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

  <div
    id="cart-dropdown"
    class="hidden absolute right-0 mt-2 w-80 max-w-[calc(100vw-1rem)] sm:w-96 bg-white border border-gray-200 shadow-lg z-50 overflow-hidden"
  >
    @if ($cartItems->count() > 0)
      <div class="max-h-[calc(100vh-11rem)] overflow-y-auto divide-y divide-gray-200">
        @foreach ($cartItems as $item)
          <div class="p-4">
            <div class="flex items-start gap-3">
              <img
                src="{{ $item->attributes->image }}"
                alt="{{ $item->name }}"
                class="w-16 h-16 flex-shrink-0 object-contain"
              >
              <div class="min-w-0 flex-1">
                <h4 class="text-sm font-semibold leading-5 text-gray-700 break-words">
                  {{ $item->name }}
                </h4>
                @if ($item->attributes->shop_description)
                  <p class="mt-1 text-xs leading-4 text-gray-500 break-words">
                    {{ $item->attributes->shop_description }}
                  </p>
                @endif
                <p class="mt-2 text-sm font-medium text-gray-700">
                  &#8377;{{ number_format($item->price, 0) }} x {{ $item->quantity }}
                </p>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="border-t border-gray-200 p-4">
        <div class="flex justify-between text-sm text-gray-500">
          <span class="text-black">Subtotal</span>
          <span>&#8377;{{ number_format($cartSubTotal, 2) }} /-</span>
        </div>
        <div class="flex justify-between text-sm font-semibold text-gray-500">
          <span class="text-black">Total</span>
          <span>&#8377;{{ number_format($cartTotal, 2) }} /-</span>
        </div>
      </div>

      <div class="border-t border-gray-200 p-4">
        <a
          href="{{ route('cart') }}"
          class="block w-full rounded bg-black py-2 text-center text-white transition hover:bg-gray-800"
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
