<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-4 mt-8">Shopping Cart</h1>
    
    @if(!$cartEnabled)
        <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded mb-4 text-sm">
            {{ $cartDisabledMessage }}
        </div>
    @endif
    
      <!-- MOBILE CARD VIEW (Visible below md breakpoint) -->
        <div id="mobile-card-view" class="md:hidden space-y-4 mb-5">

            <!-- Card for a single cart item -->
            {{-- Loop through cart items --}}
                            @forelse ($cartItems as $item)
            <div class="bg-white p-5 rounded-xl shadow-lg relative border border-gray-100">

                <!-- Close Button (X) - Trigger Modal -->
                <!--<button onclick="showDeleteModal('10')" class="absolute top-3 right-3 text-red-400 hover:text-red-500 text-2xl transition duration-150 rounded-full p-1 leading-none">&times;</button>-->
                <button wire:click="removeItem('{{ $item->id }}')" wire:confirm="Are you sure you want to delete this item?" class="absolute top-3 right-3 text-red-400 hover:text-red-500 text-2xl transition duration-150 rounded-full p-1 leading-none">
                    <i class="fas fa-times"></i>
                </button>

                <!-- Product Title and Options (Matching uploaded image) -->
                <div class="text-center pb-4 mb-4">
                    <img src="{{ $item->attributes->image }}" alt="{{ $item->name }}" style="margin:0 auto; display:table" class="w-80 object-contain mb-5">
                    <h3 class="font-bold text-gray-800 text-lg">{{ $item->name }}</h3>
                    @if ($item->attributes->shop_description)
                                                <p class="text-sm text-gray-500">({{ $item->attributes->shop_description }})</p>
                                            @endif
                </div>
                
               

                <div class="space-y-4">
                    <!-- Price Row -->
                    <div class="flex justify-between items-center text-base">
                        <span class="text-gray-600">Price:</span>
                        <!-- Using ₹ 915 to match the visual in the uploaded image -->
                        <span class="font-semibold text-gray-800">₹ {{ number_format($item->price, 2) }}</span>
                    </div>

                    <!-- Quantity Row -->
                    <div class="flex justify-between items-center text-base">
                        <span class="text-gray-600">Quantity (Pair):</span>
                        
                        <!-- Quantity Selector (Adjusted slightly for mobile design) -->
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                            <button 
                                                wire:click="decrementQuantity('{{ $item->id }}')" 
                                                wire:loading.attr="disabled"
                                                wire:target="decrementQuantity({{ $item->id }})"
                                                class="px-3 py-1 text-gray-600 hover:bg-gray-100 disabled:opacity-50"
                                                @if($item->quantity <= 1) disabled @endif
                                            >
                                                -
                                            </button>
                                            
                                            <span class="px-4 py-1 border-x border-gray-300">
                                                <span>
                                                    {{ $item->quantity }}
                                                </span>
                                                
                                            </span>
                                            
                                            <button 
                                                wire:click="incrementQuantity('{{ $item->id }}')" 
                                                wire:loading.attr="disabled"
                                                wire:target="incrementQuantity({{ $item->id }})"
                                                class="px-3 py-1 text-gray-600 hover:bg-gray-100 disabled:opacity-50"
                                            >
                                                +
                                            </button>
                        </div>
                    </div>

                    <!-- Total Row -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100 text-base">
                        <span class="text-gray-600 font-medium">Total:</span>
                        <!-- Using ₹ 915 to match the visual in the uploaded image -->
                        <span class="font-bold text-gray-800">₹ {{ number_format(($item->price * $item->quantity), 2) }}</span>
                    </div>
                </div>
  
            </div>
             @empty
                                <div>
                                    <p class="text-center py-8 text-gray-500">Your cart is empty.</p>
                                </div>
                            @endforelse

           <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ url('/') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-50 transition">
                    Continue Shopping
                </a>
                <button wire:click="clearCart" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                    Clear Cart
                </button>
            </div>
        </div>  
    
    
    
    
    
    
     <!-- DESKTOP TABLE VIEW (Hidden below md breakpoint) -->
     
     <div class="flex flex-col lg:flex-row gap-8">
        <div id="desktop-table-view" class="flex-1 hidden md:block overflow-x-auto">
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">Image</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">Product</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">Price</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">Quantity</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">Total</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            {{-- Loop through cart items --}}
                            @forelse ($cartItems as $item)
                                <tr wire:key="cart-item-{{ $item->id }}">
                                    <td class="px-6 py-4">
                                        <div class="relative">
                                            <img src="{{ $item->attributes->image }}" alt="{{ $item->name }}" class="w-20 h-20 object-contain">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <h4 class="font-semibold text-gray-800">{{ $item->name }}</h4>
                                            @if ($item->attributes->shop_description)
                                                <p class="text-sm text-gray-500">({{ $item->attributes->shop_description }})</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-gray-800">₹ {{ number_format($item->price, 2) }}</span>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-center border border-gray-300 rounded w-[108px]">
                                            <button 
                                                wire:click="decrementQuantity('{{ $item->id }}')" 
                                                wire:loading.attr="disabled"
                                                wire:target="decrementQuantity({{ $item->id }})"
                                                class="px-3 py-1 text-gray-600 hover:bg-gray-100 disabled:opacity-50"
                                                @if($item->quantity <= 1) disabled @endif
                                            >
                                                -
                                            </button>
                                            
                                            <span class="px-4 py-1 border-x border-gray-300">
                                                <span>
                                                    {{ $item->quantity }}
                                                </span>
                                                
                                            </span>
                                            
                                            <button 
                                                wire:click="incrementQuantity('{{ $item->id }}')" 
                                                wire:loading.attr="disabled"
                                                wire:target="incrementQuantity({{ $item->id }})"
                                                class="px-3 py-1 text-gray-600 hover:bg-gray-100 disabled:opacity-50"
                                            >
                                                +
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-gray-800">₹ {{ number_format(($item->price * $item->quantity), 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button wire:click="removeItem('{{ $item->id }}')" wire:confirm="Are you sure you want to delete this item?" class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-500">Your cart is empty.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ url('/') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-50 transition">
                    Continue Shopping
                </a>
                <button wire:click="clearCart" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                    Clear Cart
                </button>
            </div>
        </div>

        <div class="lg:w-80 mb-5">
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Cart Total</h3>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">₹ {{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm font-semibold">
                        <span class="text-gray-800">Total</span>
                        <span class="text-gray-800">₹ {{ number_format($total, 2) }}</span>
                    </div>
                </div>

                @if ($total < $minimumCartAmount)
                    <div class="bg-red-50 border border-red-200 rounded p-3 mb-4">
                        <p class="text-red-600 text-sm">Minimum Total Order Value should be Rs.{{ $minimumCartAmount }}</p>
                    </div>
                @endif
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Enter Your Postcode</label>
                    <input wire:model.live="postcode" type="text" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    @error('postcode') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{--<button 
                    wire:click="proceedToCheckout"
                    class="w-full bg-red-600 text-white py-3 rounded font-medium hover:bg-red-700 transition disabled:opacity-50"
                    @if (!$cartEnabled || $total < $minimumCartAmount) disabled @endif
                >
                    Proceed to checkout
                </button>--}}
                
                <button
                    wire:click="proceedToCheckout"
                    wire:loading.attr="disabled"
                    wire:target="proceedToCheckout"
                    class="w-full bg-red-600 text-white py-3 rounded font-medium
                           hover:bg-red-700 transition
                           flex items-center justify-center gap-2
                           disabled:opacity-60 disabled:cursor-not-allowed"
                    @if (!$cartEnabled || $total < $minimumCartAmount) disabled @endif
                >
                    {{-- Normal state --}}
                    <span wire:loading.remove wire:target="proceedToCheckout">
                        Proceed to checkout
                    </span>
                
                    {{-- Loading state --}}
                    <span wire:loading wire:target="proceedToCheckout" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        Checking delivery...
                    </span>
                </button>

            </div>
        </div>
    </div>
     
    {{-- Guest/Login Checkout Options Modal --}}
    <div 
    x-data="{ show: false }" 
    x-show="show" 
    x-on:show-checkout-options.window="show = true" 
    class="fixed z-10 inset-0 overflow-y-auto" 
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true" 
    style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            How would you like to proceed?
                        </h3>
                        <div class="mt-2 space-y-4">
                            <p class="text-sm text-gray-500">
                                Please choose how you would like to checkout.
                            </p>
                            <a href="{{ route('guest.checkout') }}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
                                Continue as Guest
                            </a>
                            <a href="{{ route('checkout') }}" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
                                Login or Register
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>