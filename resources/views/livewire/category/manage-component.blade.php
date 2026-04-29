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
            <label for="search" class="sr-only">Search Category</label>
            <input type="text" id="search" wire:model.live.debounce.300ms="search" placeholder="Search by category name..."
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

    @if ($categories->isEmpty())
        <p class="text-gray-600">No categories found marked as sellable.</p>
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
                            Category Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status (Shop)
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Order No (Shop)
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Show on Home
                        </th>

                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sellable Products Count
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($category->image)
                                    <img src="{{ env('IMG_HOST') }}/uploads/thumbnails/{{ $category->image }}" style="height:120px;width: 120px;">
                                @else
                                    <span>No Image</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $category->type_id == 1 ? 'Pro Loudspeaker' : 'Home Loudspeaker' }}
                            </td>

                            {{-- Shop Status Field --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($editingCategoryId === $category->id && $editingField === 'shop_status')
                                    <select wire:model.blur="editedValue"
                                            wire:change="saveField({{ $category->id }})"
                                            wire:keydown.escape="cancelEdit"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        {{-- Define your status options here based on your tinyInteger mapping --}}
                                        <option value="1">Inactive</option>
                                        <option value="0">Active</option>
                                        {{-- Add more options as per your application's status logic --}}
                                    </select>
                                    <button wire:click="cancelEdit" class="mt-1 px-2 py-1 bg-gray-300 text-gray-700 rounded text-xs">Cancel</button>
                                @else
                                    <span wire:click="editField({{ $category->id }}, 'shop_status', '{{ $category->shop_status }}')" class="group inline-flex items-center gap-1 cursor-pointer hover:bg-gray-100 rounded px-1 py-0.5 transition-colors duration-200" title="Click to edit Shop Status">
                                        {{ $this->getShopStatusText($category->shop_status) }}
                                        <svg class="h-4 w-4 text-gray-400 group-hover:text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" />
                                        </svg>
                                    </span>
                                @endif
                            </td>

                            {{-- Shop Order No Field --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($editingCategoryId === $category->id && $editingField === 'shop_order_no')
                                    <input type="number" wire:model.blur="editedValue"
                                           wire:keydown.enter="saveField({{ $category->id }})"
                                           wire:keydown.escape="cancelEdit"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <button wire:click="saveField({{ $category->id }})" class="mt-1 mr-1 px-2 py-1 bg-blue-500 text-white rounded text-xs">Save</button>
                                    <button wire:click="cancelEdit" class="mt-1 px-2 py-1 bg-gray-300 text-gray-700 rounded text-xs">Cancel</button>
                                @else
                                    <span wire:click="editField({{ $category->id }}, 'shop_order_no', '{{ $category->shop_order_no }}')" class="group inline-flex items-center gap-1 cursor-pointer hover:bg-gray-100 rounded px-1 py-0.5 transition-colors duration-200" title="Click to edit Shop Order No">
                                        {{ $category->shop_order_no }}
                                        <svg class="h-4 w-4 text-gray-400 group-hover:text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" />
                                        </svg>
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($editingCategoryId === $category->id && $editingField === 'shop_show_on_home')
                                    <select wire:model.blur="editedValue"
                                            wire:change="saveField({{ $category->id }})"
                                            wire:keydown.escape="cancelEdit"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                    <button wire:click="cancelEdit" class="mt-1 px-2 py-1 bg-gray-300 text-gray-700 rounded text-xs">Cancel</button>
                                @else
                                    <span wire:click="editField({{ $category->id }}, 'shop_show_on_home', '{{ $category->shop_show_on_home }}')" 
                                          class="group inline-flex items-center gap-1 cursor-pointer hover:bg-gray-100 rounded px-1 py-0.5 transition-colors duration-200" 
                                          title="Click to edit Show on Home status">
                                        {{ $this->getShopShowOnHomeText($category->shop_show_on_home) }}
                                        <svg class="h-4 w-4 text-gray-400 group-hover:text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" />
                                        </svg>
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $category->products->where('is_sealable', 1)->count() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination Links for Livewire --}}
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    @endif
</div>
