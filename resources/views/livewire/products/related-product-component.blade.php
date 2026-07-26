<div class="container mx-auto px-4 mt-4 mb-8" x-data="{
    swiper: null,
    init() {
        this.swiper = new Swiper(this.$refs.relatedSwiper, {
            slidesPerView: 2, // Default: 2 products per view
            spaceBetween: 20,
            navigation: {
                nextEl: this.$refs.nextBtn,
                prevEl: this.$refs.prevBtn,
            },
            breakpoints: {
                // When window width is >= 768px (for md)
                768: {
                    slidesPerView: 3,
                },
                // When window width is >= 1024px (for lg)
                1024: {
                    slidesPerView: 4,
                },
            },
        });
    }
}" x-init="init()">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-semibold">Related Products</h3>
        <div class="space-x-2 hidden lg:block">
            <button x-ref="prevBtn" class="p-2 bg-gray-200 rounded hover:bg-gray-300">
                <i class="fas fa-arrow-left"></i>
            </button>
            <button x-ref="nextBtn" class="p-2 bg-gray-200 rounded hover:bg-gray-300">
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </div>

    <div class="swiper" x-ref="relatedSwiper">
        <div class="swiper-wrapper">
            @forelse($relatedProducts as $relatedProduct)
                <div class="swiper-slide">
                    <div class="border rounded-lg p-4 flex flex-col items-center">
                        <a href="{{ route('product.details', [
                            'type' => $type,
                            'categorySlug' => $relatedProduct->category->slug,
                            'productSlug' => $relatedProduct->slug
                        ]) }}">
                            @php
                                $productImage = $relatedProduct->productimages->first();
                                $imageUrl = \App\Support\ImageUrl::upload($productImage?->path);
                            @endphp
                            <img
                                src="{{ $imageUrl }}"
                                class="w-full h-40 object-contain mb-2"
                                alt="{{ $relatedProduct->name }}"
                            >
                            <h4 class="text-sm font-semibold text-center">{{ $relatedProduct->name }}</h4>
                        </a>
                        <p class="text-sm text-gray-600 line-through">MRP ₹{{ number_format($relatedProduct->mrp, 2) }}/-</p>
                        <p class="text-red-600 font-bold">Offer Price ₹{{ number_format($relatedProduct->price, 2) }}/-</p>
                        <a
                            href="{{ route('product.details', [
                                'type' => $type,
                                'categorySlug' => $relatedProduct->category->slug,
                                'productSlug' => $relatedProduct->slug
                            ]) }}"
                            class="block mt-2 w-full text-center bg-red-600 hover:bg-red-700 text-white py-1.5 rounded"
                        >
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="swiper-slide text-center text-gray-500">
                    No related products found.
                </div>
            @endforelse
        </div>
    </div>
</div>
