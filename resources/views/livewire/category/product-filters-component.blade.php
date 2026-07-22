<div>
    <!-- Mobile Filter Toggle -->
    <div class="bg-white px-4 py-4 rounded-lg shadow-md mb-4 border border-gray-200 md:hidden">
        <div class="py-4" x-data="{ open: false }">
            <div class="flex justify-between items-center">
                <button class="flex items-center px-4 py-2 bg-white border rounded shadow" @click="open = true">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 13.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 019 17v-3.586L3.293 6.707A1 1 0 013 6V4z"></path>
                    </svg>
                    Filters
                </button>
            </div>

            <!-- Mobile Filter Panel -->
            <div x-show="open" x-transition.opacity @click="open = false" class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>

            <div x-show="open" x-transition:enter="transition ease-in-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed top-0 left-0 w-4/5 max-w-xs h-full bg-white z-50 shadow-2xl p-6 overflow-y-auto transform rounded-tr-2xl rounded-br-2xl" @click.away="open = false">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Filters</h2>
                    <button @click="open = false" class="text-gray-500 hover:text-red-600 text-2xl leading-none">&times;</button>
                </div>

                <!-- Search -->
                <div class="mb-4">
                    <input type="text" wire:model.debounce.500ms="search" placeholder="Search products..." class="w-full px-3 py-2 border rounded">
                </div>

                <!-- Ohms Filter -->
                <div class="mb-6">
                    <h3 class="font-semibold text-base border-b pb-1 mb-2">Ohms</h3>
                    <div class="space-y-2">
                        @foreach($availableOhms as $ohm)
                            <div class="flex items-center">
                                <input wire:model="selectedOhms" type="checkbox" id="ohm-{{ $ohm }}" value="{{ $ohm }}" class="mr-2">
                                <label for="ohm-{{ $ohm }}">{!! \App\Models\Productcombination::formattedName($ohm) !!}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Sort By -->
                <div class="mb-6">
                    <h3 class="font-semibold text-base border-b pb-1 mb-2">Sort By</h3>
                    <select wire:model="sortBy" class="w-full px-3 py-2 border rounded">
                        @foreach($sortOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Reset Filters -->
                <button wire:click="resetFilters" class="w-full py-2 bg-gray-200 hover:bg-gray-300 rounded">
                    Reset Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Desktop Filters -->
    <div class="bg-white px-3 py-3 rounded-2xl shadow-md mb-8 border border-gray-200 hidden md:block">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <!-- Search -->
            <div class="flex-1">
                <input type="text" wire:model.debounce.500ms="search" placeholder="Search products..." class="w-full px-5 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm placeholder-gray-500">
            </div>

            <!-- Ohms Filter -->
            <div class="relative">
                <select wire:model="selectedOhms" multiple class="custom-select px-5 py-3 border rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-red-500 shadow-sm text-gray-700">
                    <option value="">All Ohms</option>
                    @foreach($availableOhms as $ohm)
                        <option value="{{ $ohm }}">{!! \App\Models\Productcombination::formattedName($ohm) !!}</option>
                    @endforeach
                </select>
            </div>

            <!-- Sort By -->
            <div class="relative">
                <select wire:model="sortBy" class="custom-select px-5 py-3 border rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-red-500 shadow-sm text-gray-700">
                    @foreach($sortOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
