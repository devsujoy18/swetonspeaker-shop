<div>
    <div class="mb-4 flex flex-wrap gap-4 bg-gray-50 p-4 rounded-lg shadow">
        <input type="text" wire:model.live="search" class="border-gray-300 rounded-md" placeholder="Search SEO title or page...">
        <button wire:click="resetFilters" type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
            Reset
        </button>

        <button wire:click="openCreateModal" wire:loading.attr="disabled" wire:target="openCreateModal" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-70">
            <span wire:loading.remove wire:target="openCreateModal">Add SEO Data</span>
            <span wire:loading wire:target="openCreateModal">Opening...</span>
        </button>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="table-wrap p-6 text-gray-900">
            <table class="table-freeze w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Page Type</th>
                        <th class="px-4 py-2">Page</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($seoMetas as $seoMeta)
                        <tr class="border-b transition-colors duration-200" wire:key="seo-meta-{{ $seoMeta->id }}">
                            <td class="px-4 py-2 font-medium text-gray-900">{{ $seoMeta->title }}</td>
                            <td class="px-4 py-2">{{ str($seoMeta->page_type)->title() }}</td>
                            <td class="px-4 py-2">
                                {{ $this->targetLabel($seoMeta) }}
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-3 py-1 text-xs rounded-full font-medium {{ $seoMeta->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $seoMeta->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <button wire:click="toggleStatus({{ $seoMeta->id }})" wire:loading.attr="disabled" wire:target="toggleStatus({{ $seoMeta->id }})" class="inline-flex items-center gap-2 text-sm px-3 py-1.5 rounded-md border {{ $seoMeta->is_active ? 'border-green-300 text-green-700 hover:bg-green-50' : 'border-red-300 text-red-700 hover:bg-red-50' }} disabled:opacity-60">
                                    {{ $seoMeta->is_active ? 'Active' : 'Inactive' }}
                                </button>

                                <button wire:click="openModal({{ $seoMeta->id }})" class="text-indigo-600 hover:underline text-sm">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">No SEO data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $seoMetas->links() }}
            </div>
        </div>
    </div>

    @if($modalOpen)
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
            <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl p-6 max-h-[90vh] overflow-y-auto">
                <h2 class="text-lg font-semibold mb-4">
                    {{ $isEdit ? 'Edit SEO Data' : 'Add SEO Data' }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium">Page Type</label>
                        <select wire:model.change="targetType" class="w-full border rounded-md">
                            @foreach($targetTypeOptions as $targetTypeValue => $targetTypeLabel)
                                <option value="{{ $targetTypeValue }}">{{ $targetTypeLabel }}</option>
                            @endforeach
                        </select>
                        @error('targetType') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium">Select Page</label>
                        <select wire:model.defer="targetValue" class="w-full border rounded-md">
                            @foreach($pageOptions as $pageValue => $pageLabel)
                                <option value="{{ $pageValue }}">{{ $pageLabel }}</option>
                            @endforeach
                        </select>
                        @error('targetValue') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-medium">SEO Title</label>
                        <input wire:model.defer="title" class="w-full border rounded-md">
                        @error('title') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-medium">Keywords</label>
                        <textarea wire:model.defer="keywords" rows="2" class="w-full border rounded-md"></textarea>
                        @error('keywords') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-medium">Description</label>
                        <textarea wire:model.defer="description" rows="3" class="w-full border rounded-md"></textarea>
                        @error('description') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium">Canonical URL</label>
                        <input wire:model.defer="canonicalUrl" class="w-full border rounded-md" placeholder="https://example.com/page">
                        @error('canonicalUrl') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium">Robots</label>
                        <input wire:model.defer="robots" class="w-full border rounded-md">
                        @error('robots') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-2 md:col-span-2">
                        <input type="checkbox" wire:model.defer="isActive">
                        <span class="text-sm">Active</span>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button wire:click="$set('modalOpen', false)" class="px-4 py-2 bg-gray-200 rounded-md">
                        Cancel
                    </button>

                    <button wire:click="save" wire:loading.attr="disabled" wire:target="save" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-70">
                        <span wire:loading.remove wire:target="save">Save</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
