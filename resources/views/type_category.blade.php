<x-front-layout>
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-gray-700" aria-label="breadcrumb">
                <ol class="flex space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Home</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li class="text-gray-800">{{ $type == 'pro-loudspeaker' ? 'Pro Loudspeaker' : 'Home Loudspeaker' }}</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <livewire:category.type-product-component 
        :type="$type"
    />
  </div>
</x-front-layout>