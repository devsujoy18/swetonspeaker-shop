<div>
    <div class="mb-4 flex flex-wrap gap-4 bg-gray-50 p-4 rounded-lg shadow">
     {{-- filter section --}}
        <input type="text" wire:model.live="search" class="border-gray-300 rounded-md">
        <button wire:click="resetFilters" type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
            Reset
        </button>

        <button
            wire:click="openModal"
            wire:loading.attr="disabled"
            wire:target="openModal"
            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700
                   flex items-center gap-2 disabled:opacity-70"
        >
            {{-- Normal state --}}
            <span wire:loading.remove wire:target="openModal">
                ➕ Add Pincode
            </span>

            {{-- Loading state --}}
            <span wire:loading wire:target="openModal" class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                Opening...
            </span>
        </button>

    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="table-wrap p-6 text-gray-900">
            <table class="table-freeze w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">SCRCD DESC</th>
                        <th class="px-4 py-2">REGION</th>
                        <th class="px-4 py-2">STATE</th>
                        <th class="px-4 py-2">PIN CODE</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pincodes as $pincode)
                    <tr class="border-b transition-colors duration-200" wire:key="pincode-{{ $pincode->id }}">
                        <td class="px-4 py-2">{{ $pincode->scrcd }}</td>
                        <td class="px-4 py-2">{{ $pincode->region }}</td>
                        <td class="px-4 py-2">{{ $pincode->state }}</td>
                        <td class="px-4 py-2">{{ $pincode->pin_code }}</td>
                        <td class="px-4 py-2">
                            <span class="px-3 py-1 text-xs rounded-full font-medium
                                {{ $pincode->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $pincode->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">

                            <button
                                wire:click="toggleStatus({{ $pincode->id }})"
                                wire:loading.attr="disabled"
                                wire:target="toggleStatus"
                                class="inline-flex items-center gap-2 text-sm px-3 py-1.5 rounded-md border
                                    {{ $pincode->is_active
                                        ? 'border-green-300 text-green-700 hover:bg-green-50'
                                        : 'border-red-300 text-red-700 hover:bg-red-50' }}
                                    disabled:opacity-60"
                            >
                                {{-- Normal state --}}
                                <span wire:loading.remove wire:target="toggleStatus" class="flex items-center gap-2">
                                    @if($pincode->is_active)
                                        {{-- Active icon --}}
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M5 13l4 4L19 7" />
                                        </svg>
                                        Active
                                    @else
                                        {{-- Inactive icon --}}
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Inactive
                                    @endif
                                </span>

                                {{-- Loading state --}}
                                <span wire:loading wire:target="toggleStatus" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    Updating...
                                </span>
                            </button>

                            <button
                                wire:click="openModal({{ $pincode->id }})"
                                class="text-indigo-600 hover:underline text-sm"
                            >
                                ✏ Edit
                            </button>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $pincodes->links() }} <!-- Pagination links -->
            </div>
        </div>
    </div>

    @if($modalOpen)
    <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white w-full max-w-xl rounded-xl shadow-xl p-6">
            <h2 class="text-lg font-semibold mb-4">
                {{ $isEdit ? 'Edit Pincode' : 'Add Pincode' }}
            </h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium">SCRCD</label>
                    <input wire:model.defer="scrcd" class="w-full border rounded-md">
                    @error('scrcd') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium">Region</label>
                    <input wire:model.defer="region" class="w-full border rounded-md">
                </div>

                <div>
                    <label class="text-sm font-medium">State</label>
                    <input wire:model.defer="state" class="w-full border rounded-md">
                </div>

                <div>
                    <label class="text-sm font-medium">PIN Code</label>
                    <input wire:model.defer="pin_code" class="w-full border rounded-md">
                    @error('pin_code') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="col-span-2 flex items-center gap-2">
                    <input type="checkbox" wire:model="is_active">
                    <span class="text-sm">Active</span>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button
                    wire:click="$set('modalOpen', false)"
                    class="px-4 py-2 bg-gray-200 rounded-md"
                >
                    Cancel
                </button>

                <button
                    wire:click="save"
                    wire:loading.attr="disabled"
                    wire:target="save"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700
                           flex items-center gap-2 disabled:opacity-70"
                >
                    {{-- Normal state --}}
                    <span wire:loading.remove wire:target="save">
                        Save
                    </span>

                    {{-- Loading state --}}
                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        Saving...
                    </span>
                </button>

            </div>
        </div>
    </div>
    @endif
</div>