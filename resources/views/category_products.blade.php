<x-front-layout>
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-gray-700" aria-label="breadcrumb">
                <ol class="flex space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Home</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li>
                        <a href="{{ route('type.category', $type) }}" class="text-blue-600 hover:underline">
                            {{ $type == 'pro-loudspeaker' ? 'Pro Loudspeaker' : 'Home Loudspeaker' }}
                        </a>
                        <span class="mx-2">/</span>
                    </li>
                    <li class="text-gray-800">{{ $categorySlug }}</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <livewire:category.category-products-component 
        :type="$type"
        :categorySlug="$categorySlug" 
    />
  </div>
</x-front-layout>