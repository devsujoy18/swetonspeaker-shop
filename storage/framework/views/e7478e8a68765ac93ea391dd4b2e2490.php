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
            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="swiper-slide">
                    <div class="border rounded-lg p-4 flex flex-col items-center">
                        <a href="<?php echo e(route('product.details', [
                            'type' => $type,
                            'categorySlug' => $relatedProduct->category->slug,
                            'productSlug' => $relatedProduct->slug
                        ])); ?>">
                            <?php
                                $productImage = $relatedProduct->productimages->first();
                                $imageUrl = $productImage ? env('IMG_HOST') . '/uploads/' . $productImage->path : asset('image/buy.jpg');
                            ?>
                            <img
                                src="<?php echo e($imageUrl); ?>"
                                class="w-full h-40 object-contain mb-2"
                                alt="<?php echo e($relatedProduct->name); ?>"
                            >
                            <h4 class="text-sm font-semibold text-center"><?php echo e($relatedProduct->name); ?></h4>
                        </a>
                        <p class="text-sm text-gray-600 line-through">MRP ₹<?php echo e(number_format($relatedProduct->mrp, 2)); ?>/-</p>
                        <p class="text-red-600 font-bold">Offer Price ₹<?php echo e(number_format($relatedProduct->price, 2)); ?>/-</p>
                        <a
                            href="<?php echo e(route('product.details', [
                                'type' => $type,
                                'categorySlug' => $relatedProduct->category->slug,
                                'productSlug' => $relatedProduct->slug
                            ])); ?>"
                            class="block mt-2 w-full text-center bg-red-600 hover:bg-red-700 text-white py-1.5 rounded"
                        >
                            View Details
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="swiper-slide text-center text-gray-500">
                    No related products found.
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div><?php /**PATH /home/ace85084/public_html/shop.swetonspeakers.com/resources/views/livewire/products/related-product-component.blade.php ENDPATH**/ ?>