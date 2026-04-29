<div>
    <div class="space-y-4">
        <div class="flex justify-between items-center pb-2 border-b border-gray-200">
            <span class="text-gray-700">Product</span>
            <span class="text-gray-700">Total</span>
        </div>
        @forelse ($cartItems as $item)
        <div class="flex justify-between items-center" wire:key="cart-item-{{ $item->id }}">
            <span class="text-gray-900">
                {{--<img src="{{ $item->attributes->image }}" alt="{{ $item->name }}" class="w-20 h-20 object-contain">--}} 
                {{ $item->name }} X {{ $item->quantity }}
            </span>
            <span class="text-gray-900 font-medium">₹ {{ number_format(($item->price * $item->quantity), 2) }}</span>
        </div>
        @empty
        <div class="flex justify-between items-center">
            No items found
        </div>
        @endforelse
        <div class="flex justify-between items-center py-2 border-t border-gray-200">
            <span class="text-gray-700">Subtotal</span>
            <span class="text-gray-900 font-medium">₹ {{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
            <span class="text-xl font-semibold text-gray-900">Total</span>
            <span class="text-xl font-semibold text-gray-900">₹ {{ number_format($total, 2) }}</span>
        </div>
    </div>
</div>
