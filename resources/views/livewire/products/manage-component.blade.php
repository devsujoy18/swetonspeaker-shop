<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Validation Errors --}}
    @error('editedValue')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ $message }}</span>
        </div>
    @enderror

    <div class="mb-4 flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0 sm:space-x-4">
        {{-- Search Input --}}
        <div class="w-full sm:w-1/2">
            <label for="search" class="sr-only">Search Products</label>
            <input type="text" id="search" wire:model.live.debounce.300ms="search" placeholder="Search by product name..."
                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
        </div>

        {{-- Per Page Dropdown --}}
        <div class="w-full sm:w-auto flex items-center justify-end sm:justify-start">
            <label for="perPage" class="mr-2 text-gray-700 text-sm">Per page:</label>
            <select id="perPage" wire:model.live="perPage"
                    class="block w-full sm:w-auto pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>

    @if ($products->isEmpty())
        <p class="text-gray-600">No products found marked as sellable.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            SL No
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Image
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Product Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            MRP
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Attributes
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Combinations
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tags
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status (Shop)
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Order No (Shop)
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Short Description (Shop)
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($product->latest_order1_image)
                                    <img src="{{ env('IMG_HOST') }}uploads/{{ $product->latest_order1_image->path }}" style="height:120px;width: 120px;">
                                @else
                                    <span>No primary image</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->name }} {{-- Assuming a 'name' field --}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->category->name ?? 'N/A' }} {{-- Assuming a 'category' relationship --}}
                            </td>
                            {{-- MRP Field --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($editingProductId === $product->id && $editingField === 'mrp')
                                    <input type="number" step="0.01" wire:model.blur="editedValue"
                                           wire:keydown.enter="saveField({{ $product->id }})"
                                           wire:keydown.escape="cancelEdit"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <button wire:click="saveField({{ $product->id }})" class="mt-1 mr-1 px-2 py-1 bg-blue-500 text-white rounded text-xs">Save</button>
                                    <button wire:click="cancelEdit" class="mt-1 px-2 py-1 bg-gray-300 text-gray-700 rounded text-xs">Cancel</button>
                                @else
                                    <span wire:click="editField({{ $product->id }}, 'mrp', '{{ $product->mrp }}')"
                                          class="group inline-flex items-center gap-1 cursor-pointer hover:bg-gray-100 rounded px-1 py-0.5 transition-colors duration-200"
                                          title="Click to edit MRP">
                                        ₹{{ number_format($product->mrp, 2) }}
                                        <svg class="h-4 w-4 text-gray-400 group-hover:text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" />
                                        </svg>
                                    </span>
                                @endif
                            </td>

                            {{-- Price Field --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($editingProductId === $product->id && $editingField === 'price')
                                    <input type="number" step="0.01" wire:model.blur="editedValue"
                                           wire:keydown.enter="saveField({{ $product->id }})"
                                           wire:keydown.escape="cancelEdit"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <button wire:click="saveField({{ $product->id }})" class="mt-1 mr-1 px-2 py-1 bg-blue-500 text-white rounded text-xs">Save</button>
                                    <button wire:click="cancelEdit" class="mt-1 px-2 py-1 bg-gray-300 text-gray-700 rounded text-xs">Cancel</button>
                                @else
                                    <span wire:click="editField({{ $product->id }}, 'price', '{{ $product->price }}')" class="group inline-flex items-center gap-1 cursor-pointer hover:bg-gray-100 rounded px-1 py-0.5 transition-colors duration-200" title="Click to edit Price">
                                        ₹{{ number_format($product->price, 2) }}
                                        <svg class="h-4 w-4 text-gray-400 group-hover:text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" />
                                        </svg>
                                    </span>
                                @endif
                            </td>

                            {{-- Product Attributes --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($product->priceAttributes->isNotEmpty())
                                    <div class="space-y-2">
                                        @foreach($product->priceAttributes as $pattribute)
                                            <div class="flex items-center space-x-2">
                                                <span>
                                                    {{ $pattribute->name }} : ₹{{ number_format($pattribute->mrp, 2) }} / ₹{{ number_format($pattribute->price, 2) }}
                                                </span>
                                                <button wire:click="openAttributeModal({{ $pattribute->id }})" class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" /></svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <button wire:click="openAttributeModal(null, {{ $product->id }})" class="mt-2 px-3 py-1 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700 transition-colors duration-200">
                                    Add Attributes
                                </button>
                            </td>

                            {{-- Product Combinations --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($product->combinations)
                                    @foreach($product->combinations as $combination)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $combination->name }}
                                        </span>
                                    @endforeach
                                @endif
                            </td>

                            {{-- Product Tags --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex flex-wrap gap-1 mb-2">
                                    @forelse($product->tags as $tag)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            {{ $tag->title }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400">No tags mapped</span>
                                    @endforelse
                                </div>

                                <button
                                    wire:click="openTagModal({{ $product->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="openTagModal({{ $product->id }})"
                                    class="mt-1 px-3 py-1 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700 transition-colors duration-200 disabled:opacity-60"
                                >
                                    <span wire:loading.remove wire:target="openTagModal({{ $product->id }})">
                                        Map Tags
                                    </span>
                                    <span wire:loading wire:target="openTagModal({{ $product->id }})">
                                        Opening...
                                    </span>
                                </button>
                            </td>

                            {{-- Shop Status Field --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($editingProductId === $product->id && $editingField === 'shop_status')
                                    <select wire:model.blur="editedValue"
                                            wire:change="saveField({{ $product->id }})"
                                            wire:keydown.escape="cancelEdit"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        {{-- Define your status options here based on your tinyInteger mapping --}}
                                        <option value="1">Inactive</option>
                                        <option value="0">Active</option>
                                        {{-- Add more options as per your application's status logic --}}
                                    </select>
                                    <button wire:click="cancelEdit" class="mt-1 px-2 py-1 bg-gray-300 text-gray-700 rounded text-xs">Cancel</button>
                                @else
                                    <span wire:click="editField({{ $product->id }}, 'shop_status', '{{ $product->shop_status }}')" class="group inline-flex items-center gap-1 cursor-pointer hover:bg-gray-100 rounded px-1 py-0.5 transition-colors duration-200" title="Click to edit Shop Status">
                                        {{ $this->getShopStatusText($product->shop_status) }}
                                        <svg class="h-4 w-4 text-gray-400 group-hover:text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" />
                                        </svg>
                                    </span>
                                @endif
                            </td>

                            {{-- Shop Order No Field --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($editingProductId === $product->id && $editingField === 'shop_order_no')
                                    <input type="number" wire:model.blur="editedValue"
                                           wire:keydown.enter="saveField({{ $product->id }})"
                                           wire:keydown.escape="cancelEdit"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <button wire:click="saveField({{ $product->id }})" class="mt-1 mr-1 px-2 py-1 bg-blue-500 text-white rounded text-xs">Save</button>
                                    <button wire:click="cancelEdit" class="mt-1 px-2 py-1 bg-gray-300 text-gray-700 rounded text-xs">Cancel</button>
                                @else
                                    <span wire:click="editField({{ $product->id }}, 'shop_order_no', '{{ $product->shop_order_no }}')" class="group inline-flex items-center gap-1 cursor-pointer hover:bg-gray-100 rounded px-1 py-0.5 transition-colors duration-200" title="Click to edit Shop Order No">
                                        {{ $product->shop_order_no }}
                                        <svg class="h-4 w-4 text-gray-400 group-hover:text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" />
                                        </svg>
                                    </span>
                                @endif
                            </td>

                            {{-- Shop Description Field --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($editingProductId === $product->id && $editingField === 'shop_description')
                                    <input type="text" step="0.01" wire:model.blur="editedValue"
                                           wire:keydown.enter="saveField({{ $product->id }})"
                                           wire:keydown.escape="cancelEdit"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <button wire:click="saveField({{ $product->id }})" class="mt-1 mr-1 px-2 py-1 bg-blue-500 text-white rounded text-xs">Save</button>
                                    <button wire:click="cancelEdit" class="mt-1 px-2 py-1 bg-gray-300 text-gray-700 rounded text-xs">Cancel</button>
                                @else
                                    <span wire:click="editField({{ $product->id }}, 'shop_description', '{{ $product->shop_description }}')" class="group inline-flex items-center gap-1 cursor-pointer hover:bg-gray-100 rounded px-1 py-0.5 transition-colors duration-200" title="Click to edit Price">
                                        {{ $product->shop_description }}
                                        <svg class="h-4 w-4 text-gray-400 group-hover:text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" />
                                        </svg>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination Links for Livewire --}}
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif

    @if ($showAttributeModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    {{ $editingAttributeId ? 'Edit Attribute' : 'Add New Attribute' }}
                                </h3>
                                <div class="mt-2">
                                    <form wire:submit.prevent="saveAttribute">
                                        <div class="mb-4">
                                            <label for="attributeName" class="block text-sm font-medium text-gray-700">Attribute Name</label>
                                            <input type="text" id="attributeName" wire:model.blur="attributeName" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('attributeName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="mb-4">
                                            <label for="attributeMrp" class="block text-sm font-medium text-gray-700">MRP</label>
                                            <input type="number" step="0.01" id="attributeMrp" wire:model.blur="attributeMrp" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('attributeMrp') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="mb-4">
                                            <label for="attributePrice" class="block text-sm font-medium text-gray-700">Price</label>
                                            <input type="number" step="0.01" id="attributePrice" wire:model.blur="attributePrice" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('attributePrice') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                Save
                                            </button>
                                            <button type="button" wire:click="closeAttributeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                            @if ($editingAttributeId)
                                                <button type="button" wire:click="deleteAttribute" class="mt-3 w-full inline-flex justify-center rounded-md border border-red-300 shadow-sm px-4 py-2 bg-red-50 text-base font-medium text-red-700 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Delete
                                                </button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($showTagModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="tag-modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="tag-modal-title">
                            Map Product Tags
                        </h3>

                        <form wire:submit.prevent="saveTagMapping" class="mt-4">
                            <div class="max-h-72 overflow-y-auto border border-gray-200 rounded-md p-3 space-y-2">
                                @forelse ($availableTags as $tagOption)
                                    <label class="flex items-center gap-2">
                                        <input
                                            type="checkbox"
                                            wire:model="selectedTags"
                                            value="{{ $tagOption->id }}"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        >
                                        <span class="text-sm text-gray-700">{{ $tagOption->title }}</span>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-500">No active tags found.</p>
                                @endforelse
                            </div>

                            @error('selectedTags.*')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror

                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse mt-4">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                    Save
                                </button>
                                <button type="button" wire:click="closeTagModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
