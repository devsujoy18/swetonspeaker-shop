<x-front-layout>
	<!--breadcrumb-->
	<div class="bg-gray-100 py-4">
	    <div class="container mx-auto px-4">
	      	<nav class="text-sm text-gray-600">
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
	          		<li>
	          			<a href="{{ route('category.products', [$type, $categorySlug])}}" class="text-blue-600 hover:underline">
	          				{{ $categorySlug }}
	          			</a>
	          			<span class="mx-2">/</span>
	          		</li>
	          		<li class="text-gray-800">{{ $productSlug }}</li>
	        	</ol>
	      	</nav>
	    </div>
  	</div>

  	<!-- Product Section -->
  	<livewire:products.public-details-component 
        :type="$type"
        :categorySlug="$categorySlug" 
        :productSlug="$productSlug"
    />
	
    <!--Product other details-->
    <style>
        /* Custom styles for active tab */
        .tab-btn.active {
            border-bottom-color: #fff; /* Indigo color for active border */
            color: #fff;
        }
    </style>
    <livewire:products.public-other-details-component 
        :type="$type"
        :categorySlug="$categorySlug" 
        :productSlug="$productSlug"
    />

    <!--Product Review Component-->
    <livewire:products.public-reviews-component 
        :type="$type"
        :categorySlug="$categorySlug" 
        :productSlug="$productSlug"
    />

    <!--Related Product Component-->
    <livewire:products.related-product-component 
        :type="$type"
        :categorySlug="$categorySlug" 
        :productSlug="$productSlug"
    />
</x-front-layout>