<div class="w-full">
    <div class="flex flex-col md:flex-row gap-4">
        <!-- Category Dropdown -->
        <select name="category" wire:model.live="category"
            class="border border-gray-300 rounded px-4 py-2 w-full md:w-[40%] focus:outline-none">
            <option value="">All Categories</option>
            @foreach($sellableCategories['pro'] as $cat)
                <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
            @endforeach

            @foreach($sellableCategories['home'] as $cat)
                <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
            @endforeach
        </select>

        <!-- Input with autocomplete -->
        <div class="relative w-full">
            <input type="text"
                name="search_query"
                wire:model.live="query"
                placeholder="Search products..."
                class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none" />

            <!-- Loader (shows when typing/searching) -->
            <div wire:loading wire:target="query"
                class="absolute right-3 top-3">
                <div class="animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-red-600"></div>
            </div>

            <!-- Results -->
            @if(strlen($query) > 2)
                <div class="absolute bg-white border rounded shadow mt-1 w-full z-50 max-h-60 overflow-y-auto">
                    
                    <!-- Loading message -->
                    <div wire:loading.flex wire:target="query" class="p-3 text-gray-500 text-sm">
                        Searching products...
                    </div>

                    <!-- Results list -->
                    <div wire:loading.remove wire:target="query">
                        @if($results->isEmpty())
                            <div class="p-3 text-gray-500 text-sm">
                                No products found for "<span class="font-semibold">{{ $query }}</span>"
                            </div>
                        @else
                            @foreach($results as $product)
                                @php
                                    $type_id = $product->category->type_id;
                                    $type = $type_id == 1 ? 'pro-loudspeaker' : 'home-loudspeaker';
                                    $categorySlug = $product->category->slug;
                                @endphp
                                <a href="{{ route('product.details', [$type, $categorySlug, $product->slug]) }}"
                                   class="flex items-center gap-2 px-3 py-2 hover:bg-gray-100 transition">
                                    <img src="{{ $product->primaryImage
                                                  ? env('IMG_HOST').'uploads/'.$product->primaryImage->path
                                                  : asset('image/buy.jpg') }}"
                                         class="w-10 h-10 object-cover rounded"
                                         alt="{{ $product->name }}">
                                    <span class="text-sm">{{ $product->name }}</span>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
