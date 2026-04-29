<div class="space-y-6">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="text-sm text-gray-500">Order Number</div>
                <div class="text-lg font-semibold text-gray-900">{{ $order->order_number }}</div>
            </div>
            <div class="flex gap-3">
                <div class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 border border-green-300">
                    Payment: {{ ucfirst($order->payment_status) }}
                </div>
                <div class="px-3 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700 border border-indigo-300">
                    Status: {{ ucfirst($order->order_status) }}
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="saveChanges" class="space-y-6">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-base font-semibold text-gray-900 mb-4">Billing Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" wire:model.live="billingName" class="mt-1 w-full border-gray-300 rounded-md">
                    @error('billingName') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input type="email" wire:model.live="billingEmail" class="mt-1 w-full border-gray-300 rounded-md">
                    @error('billingEmail') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" wire:model.live="billingPhone" class="mt-1 w-full border-gray-300 rounded-md">
                    @error('billingPhone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Alternate Phone</label>
                    <input type="text" wire:model.live="billingAlternatePhone" class="mt-1 w-full border-gray-300 rounded-md">
                    @error('billingAlternatePhone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Zip / Postal Code</label>
                    <input type="text" wire:model.live="billingZip" class="mt-1 w-full border-gray-300 rounded-md">
                    @error('billingZip') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Locality</label>
                    <input type="text" wire:model.live="billingLocality" class="mt-1 w-full border-gray-300 rounded-md">
                    @error('billingLocality') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Street</label>
                    <input type="text" wire:model.live="billingStreet" class="mt-1 w-full border-gray-300 rounded-md">
                    @error('billingStreet') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">City</label>
                    <input type="text" wire:model.live="billingCity" class="mt-1 w-full border-gray-300 rounded-md">
                    @error('billingCity') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">State</label>
                    <input type="text" wire:model.live="billingState" class="mt-1 w-full border-gray-300 rounded-md">
                    @error('billingState') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Landmark</label>
                    <input type="text" wire:model.live="billingLandmark" class="mt-1 w-full border-gray-300 rounded-md">
                    @error('billingLandmark') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" wire:model.live="companyName" class="mt-1 w-full border-gray-300 rounded-md">
                    @error('companyName') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">GST No</label>
                    <input type="text" wire:model.live="gstNo" class="mt-1 w-full border-gray-300 rounded-md">
                    @error('gstNo') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h3 class="text-base font-semibold text-gray-900">Shipping Details</h3>
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" wire:model.live="shippingSameAsBilling" class="rounded border-gray-300">
                    Same as billing
                </label>
            </div>

            @if(! $shippingSameAsBilling)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" wire:model.live="shippingName" class="mt-1 w-full border-gray-300 rounded-md">
                        @error('shippingName') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Email</label>
                        <input type="email" wire:model.live="shippingEmail" class="mt-1 w-full border-gray-300 rounded-md">
                        @error('shippingEmail') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" wire:model.live="shippingPhone" class="mt-1 w-full border-gray-300 rounded-md">
                        @error('shippingPhone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Alternate Phone</label>
                        <input type="text" wire:model.live="shippingAlternatePhone" class="mt-1 w-full border-gray-300 rounded-md">
                        @error('shippingAlternatePhone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Zip / Postal Code</label>
                        <input type="text" wire:model.live="shippingZip" class="mt-1 w-full border-gray-300 rounded-md">
                        @error('shippingZip') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Locality</label>
                        <input type="text" wire:model.live="shippingLocality" class="mt-1 w-full border-gray-300 rounded-md">
                        @error('shippingLocality') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Street</label>
                        <input type="text" wire:model.live="shippingStreet" class="mt-1 w-full border-gray-300 rounded-md">
                        @error('shippingStreet') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">City</label>
                        <input type="text" wire:model.live="shippingCity" class="mt-1 w-full border-gray-300 rounded-md">
                        @error('shippingCity') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">State</label>
                        <input type="text" wire:model.live="shippingState" class="mt-1 w-full border-gray-300 rounded-md">
                        @error('shippingState') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Landmark</label>
                        <input type="text" wire:model.live="shippingLandmark" class="mt-1 w-full border-gray-300 rounded-md">
                        @error('shippingLandmark') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-600">Shipping details will match billing details.</p>
            @endif
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Order Items</h3>

                @error('cart') <p class="text-xs text-red-600 mb-3">{{ $message }}</p> @enderror

                @if(empty($cartItems))
                    <div class="text-sm text-gray-500">No items in this order yet.</div>
                @else
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $item['name'] }}</div>
                                        <div class="text-xs text-gray-500">
                                            Price: {{ number_format($item['price'], 2) }}
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="number"
                                               min="1"
                                               wire:model.live.debounce.500ms="quantities.{{ $item['id'] }}"
                                               class="w-20 border-gray-300 rounded-md">
                                        <button type="button"
                                                wire:click="updateQuantity('{{ $item['id'] }}')"
                                                class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                                            Update
                                        </button>
                                        <button type="button"
                                                wire:click="removeItem('{{ $item['id'] }}')"
                                                class="px-3 py-1 text-xs bg-red-50 text-red-700 border border-red-200 rounded-md hover:bg-red-100">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500 mt-2">
                                    Line Total: {{ number_format($item['price'] * ($quantities[$item['id']] ?? $item['quantity']), 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-6 border-t pt-4 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-gray-900 mt-2">
                        <span>Total</span>
                        <span>{{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Add Products</h3>
                <div class="flex flex-wrap gap-3 mb-4">
                    <input type="text"
                           wire:model.live="search"
                           placeholder="Search by name or description"
                           class="flex-1 min-w-[200px] border-gray-300 rounded-md">
                    <select wire:model.live="categoryId" class="border-gray-300 rounded-md">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                @if($products->isEmpty())
                    <p class="text-sm text-gray-500">No products found with the selected filters.</p>
                @else
                    <div class="space-y-3 max-h-[460px] overflow-y-auto pr-2">
                        @foreach($products as $product)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-500">
                                            Base Price: {{ number_format($product->price, 2) }}
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if($product->priceAttributes->isNotEmpty())
                                            <select wire:model.live="selectedAttributes.{{ $product->id }}"
                                                    class="border-gray-300 rounded-md text-xs">
                                                <option value="">Select price option</option>
                                                @foreach($product->priceAttributes as $attribute)
                                                    <option value="{{ $attribute->id }}">
                                                        {{ $attribute->name }} - {{ number_format($attribute->price, 2) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <button type="button"
                                                wire:click="addProduct({{ $product->id }})"
                                                class="px-3 py-1 text-xs bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-md hover:bg-indigo-100">
                                            Add
                                        </button>
                                    </div>
                                </div>
                                @if(!empty($addErrors[$product->id]))
                                    <p class="text-xs text-red-600 mt-2">{{ $addErrors[$product->id] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.orders.index') }}"
               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                Cancel
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Save Changes
            </button>
        </div>
    </form>

    <div wire:loading.flex class="fixed inset-0 bg-white/60 items-center justify-center z-50">
        <div class="flex items-center gap-2 text-sm text-gray-700">
            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span>Saving...</span>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('notify', (event) => {
        alert(event[0].message);
    });
</script>
@endscript
