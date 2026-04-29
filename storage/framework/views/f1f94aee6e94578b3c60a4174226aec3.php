<div class="container mx-auto px-4">
    <script>
        document.addEventListener('scrollToTop', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
    <div class="flex flex-col lg:flex-row gap-8">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('category.listsidebar-component', ['typeSlug' => $type]);

$__html = app('livewire')->mount($__name, $__params, 'lw-3405185882-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        <main class="w-full lg:w-3/4">
            <!--Alert Message-->
            <div x-data="{ show: false, message: '' }"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 @alert.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 3000)"
                 style="display: none;"
                 class="fixed inset-0 z-50 overflow-y-auto"
                 aria-labelledby="modal-title" role="dialog" aria-modal="true">

                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                        <div class="absolute top-0 right-0 pt-4 pr-4">
                            <button type="button" @click="show = false" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Success!
                                </h3>
                                <div class="mt-2">
                                    <p x-text="message" class="text-sm text-gray-500"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Alert Message-->

            <!--Mobile Filter Area-->
            <div class="bg-white p-4 rounded shadow mb-4">
                <div class="bg-white px-4 py-4 rounded-lg shadow-md mb-4 border border-gray-200 md:hidden">
                    <div class="py-4" x-cloak x-data="{ open: false }">
                        <div class="flex justify-between items-center">
                            <button class="flex items-center px-4 py-2 bg-white border rounded shadow" @click="open = true">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 13.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 019 17v-3.586L3.293 6.707A1 1 0 013 6V4z"></path>
                                </svg>
                                  Filters
                            </button>
                            <div>Total Product Total Products <?php echo e($this->products->flatMap->products->count()); ?></div>
                        </div>
                        <div
                            x-show="open"
                            x-transition.opacity
                            @click="open = false"
                            class="fixed inset-0 bg-black bg-opacity-50 z-40"
                        ></div>
                        <div
                            x-show="open"
                            x-transition:enter="transition ease-in-out duration-300"
                            x-transition:enter-start="-translate-x-full"
                            x-transition:enter-end="translate-x-0"
                            x-transition:leave="transition ease-in-out duration-300"
                            x-transition:leave-start="translate-x-0"
                            x-transition:leave-end="-translate-x-full"
                            class="fixed top-0 left-0 w-4/5 max-w-xs h-full bg-white z-50 shadow-2xl p-6 overflow-y-auto transform rounded-tr-2xl rounded-br-2xl"
                            @click.away="open = false">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-xl font-bold text-gray-800">Filter Categories</h2>
                                <button @click="open = false" class="text-gray-500 hover:text-red-600 text-2xl leading-none">&times;</button>
                            </div>
                            <ul class="space-y-3 text-gray-700">
                                <!--[if BLOCK]><![endif]--><?php if($proloudSpeakers->isNotEmpty()): ?>
                                <li class="font-semibold text-base border-b pb-1">Pro Loudspeakers</li>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $proloudSpeakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="hover:bg-red-500 hover:text-white px-4 rounded-md cursor-pointer transition">
                                        <a href="<?php echo e(route('category.products', ['pro-loudspeaker', $proCategory->slug])); ?>">
                                            <?php echo e($proCategory->name); ?>

                                        </a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <!--[if BLOCK]><![endif]--><?php if($homeloudSpeakers->isNotEmpty()): ?>
                                <li class="font-semibold text-base border-b pb-1">Pro Loudspeakers</li>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $homeloudSpeakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $homeCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="hover:bg-red-500 hover:text-white px-4 rounded-md cursor-pointer transition">
                                        <a href="<?php echo e(route('category.products', ['home-loudspeaker', $homeCategory->slug])); ?>">
                                            <?php echo e($homeCategory->name); ?>

                                        </a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                
                            </ul>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <!-- Ohms Dropdown -->
                        <select class="px-4 py-2 border border-red-500 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-red-500 text-sm text-gray-700" wire:model.live="selectedOhms">
                            <option>All Ohms</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $availableOhms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ohm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($ohm); ?>"><?php echo e($ohm); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>

                        <!-- Sort By Dropdown -->
                        <select class="px-4 py-2 border border-red-500 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-red-500 text-sm text-gray-700" wire:model.live="sortBy">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sortOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>
                </div>
            </div>

            <!-- Desktop View Filter Area Start -->
            <div class="bg-white px-3 py-3 rounded-2xl shadow-md mb-8 border border-gray-200 hidden md:block">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                  <!-- Search Input + Total Products -->
                  <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <input type="text" placeholder="Search products..." class="px-5 py-3 border border-gray-300 rounded-lg w-72 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm placeholder-gray-500" wire:model.live="search">
                    <span class="text-gray-800 text-sm font-medium">Total Products: <strong class="text-blue-600">Total Products <?php echo e($this->products->flatMap->products->count()); ?></strong></span>
                  </div>

                    <!-- Ohms Dropdown -->
                    <div class="relative">
                      <select class="custom-select px-5 py-3 border rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-red-500 shadow-sm text-gray-700" wire:model.live="selectedOhms">
                        <option>All Ohms</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $availableOhms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ohm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($ohm); ?>"><?php echo e($ohm); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                      </select>
                    </div>

                    <!-- Sort By Dropdown -->
                    <div class="relative">
                      <select class="custom-select px-5 py-3 border rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-red-500 shadow-sm text-gray-700" wire:model.live="sortBy">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sortOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                      </select>
                    </div>
                </div>
            </div>
            <!-- Filter Area End -->

            <div class="relative min-h-[300px]">
                <div
                    wire:loading
                    wire:target="search, selectedOhms, sortBy"
                    class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10 rounded-lg">
                    <svg class="animate-spin h-10 w-10 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>


                <!--[if BLOCK]><![endif]--><?php if($this->products->flatMap->products->count() > 0): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-4">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $category->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                //$productimg = $product->productimages->first();
                                $productimg = $product->primaryImage;
                            ?>
                            <!-- Product Card -->
                            <div class="border-2 border-black-500 hover:border-red-500 hover:shadow-2xl transition duration-300 rounded p-4 relative" 
                            x-data="{ imgLoading: true }" 
                            x-init="$nextTick(() => { if ($refs.img?.complete) imgLoading = false })" >
                                <div class="w-full h-64 flex items-center justify-center relative bg-gray-50 rounded">
                                    <!-- Skeleton loader -->
                                    <div 
                                        x-show="imgLoading" 
                                        class="absolute inset-0 bg-gray-200 animate-pulse rounded flex items-center justify-center text-gray-600 font-medium">
                                        Loading...
                                    </div>
                                    <img 
                                        x-ref="img"
                                        loading="lazy"
                                        src="<?php echo e($productimg ? env('IMG_HOST').'uploads/'.$productimg->path : asset('images/buy.jpg')); ?>"
                                        alt="<?php echo e($product->name); ?>"
                                        class="w-full h-full object-contain transition-opacity duration-500"
                                        :class="imgLoading ? 'opacity-0' : 'opacity-100'"
                                        @load="imgLoading = false"
                                    >
                                </div>
                                

                                <div class="mt-3 text-center">
                                    <a href="<?php echo e(route('product.details', [ $type, $category->slug, $product->slug ] )); ?>" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2 rounded text-sm font-semibold whitespace-nowrap">
                                        View Details
                                    </a>
                                </div>
                                <div class="mt-2 text-center">
                                    <h3 class="text-lg font-semibold"><?php echo e($product->name); ?></h3>
                                    <p class="text-sm text-gray-600">( <?php echo e($product->combinations->pluck('name')->join(', ')); ?> )</p>
                                </div>

                                <div class="mt-2 flex flex-col items-center">
                                    <!--[if BLOCK]><![endif]--><?php if($product->priceAttributes->isNotEmpty()): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $product->priceAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="mt-1">
                                                <span class="text-sm text-gray-500 mr-2"><?php echo e($attribute->name); ?>:</span> 
                                                <span class="line-through text-sm text-gray-500 mr-1">₹ <?php echo e(number_format($attribute->mrp, 0)); ?></span>
                                                <span class="text-lg text-green-600 font-bold">₹ <?php echo e(number_format($attribute->price, 0)); ?></span>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php else: ?>
                                        <div class="mt-1">
                                            <!--[if BLOCK]><![endif]--><?php if($product->shop_description): ?>
                                            <span class="text-sm text-gray-500 mr-2"><?php echo e($product->shop_description); ?>:</span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <span class="line-through text-sm text-gray-500 mr-1">₹ <?php echo e(number_format($product->mrp, 0)); ?></span>
                                            <span class="text-lg text-green-600 font-bold">₹ <?php echo e(number_format($product->price, 0)); ?></span>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>


                                <div class="mt-2 flex gap-2">
                                    <!--[if BLOCK]><![endif]--><?php if($product->priceAttributes->isNotEmpty()): ?>
                                        <button 
                                            wire:click="openAttributeModal(<?php echo e($product->id); ?>, 'buy-now')"
                                            class="w-1/2 bg-red-600 hover:bg-red-700 text-white py-2 rounded text-sm font-semibold whitespace-nowrap">
                                            Buy Now
                                        </button>
                                        <button 
                                            wire:click="openAttributeModal(<?php echo e($product->id); ?>, 'add-to-cart')"
                                            class="w-1/2 bg-red-600 hover:bg-red-700 text-white py-2 rounded text-sm font-semibold whitespace-nowrap">
                                            Add to Cart
                                        </button>
                                    <?php else: ?>
                                        <button 
                                            wire:click="buyNow(<?php echo e($product->id); ?>)"
                                            wire:loading.attr="disabled"
                                            wire:target="buyNow(<?php echo e($product->id); ?>)"
                                            class="w-1/2 bg-red-600 hover:bg-red-700 text-white py-2 rounded text-sm font-semibold whitespace-nowrap relative">
                                                <span wire:loading.remove wire:target="buyNow(<?php echo e($product->id); ?>)">Buy Now</span>
                                                <span wire:loading wire:target="buyNow(<?php echo e($product->id); ?>)">
                                                    <svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                </span>
                                        </button>
                                        
                                        <button
                                            wire:click="addTocart(<?php echo e($product->id); ?>)"
                                            wire:loading.attr="disabled"
                                            wire:target="addTocart(<?php echo e($product->id); ?>)"
                                            class="w-1/2 bg-red-600 hover:bg-red-700 text-white py-2 rounded text-sm font-semibold whitespace-nowrap relative">
                                            <span wire:loading.remove wire:target="addTocart(<?php echo e($product->id); ?>)">Add to Cart</span>
                                            <span wire:loading wire:target="addTocart(<?php echo e($product->id); ?>)">
                                                <svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            <!-- End Product Card -->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <?php else: ?>
                    <p class="text-center text-gray-600 text-lg py-10">No products found in this category matching the selected filters.</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </main>
    </div>


    <!--[if BLOCK]><![endif]--><?php if($showAttributeModal): ?>
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <!--[if BLOCK]><![endif]--><?php if($selectedProduct): ?>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Choose your option for <?php echo e($selectedProduct->name); ?>

                                </h3>
                                <div class="mt-2">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedProduct->priceAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="flex items-center justify-between p-4 border border-gray-300 rounded-lg cursor-pointer transition-colors duration-200"
                                               :class="{ 'border-red-500 ring-2 ring-red-500 bg-red-50': $wire.selectedAttributeId == <?php echo e($attribute->id); ?> }">
                                            <input type="radio" 
                                                   wire:model.live="selectedAttributeId"
                                                   value="<?php echo e($attribute->id); ?>" 
                                                   class="form-radio h-5 w-5 text-red-600 transition-colors duration-200 focus:ring-red-500 focus:outline-none" />
                                            <div class="flex-grow ml-4">
                                                <span class="text-lg font-semibold text-gray-700"
                                                      :class="{ 'text-red-900': $wire.selectedAttributeId == <?php echo e($attribute->id); ?> }">
                                                    <?php echo e($attribute->name); ?>

                                                </span>
                                                <span class="text-sm text-green-500"
                                                      :class="{ 'text-red-900': $wire.selectedAttributeId == <?php echo e($attribute->id); ?> }">
                                                    ₹ <?php echo e(number_format($attribute->price, 0)); ?>

                                                </span>
                                            </div>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                                    <!--[if BLOCK]><![endif]--><?php if($attributeCarterror): ?>
                                    <p class="mt-2 text-sm text-red-600 font-medium">Please choose one option</p>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <div class="mt-8 flex justify-between gap-4">
                                    <button wire:click="closeAttributeModal" class="flex-1 bg-gray-300 text-gray-800 font-semibold py-3 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                                        Cancel
                                    </button>
                                    <button 
                                        wire:click="confirmAction" 
                                        wire:loading.attr="disabled"
                                        class="flex-1 bg-red-600 text-white font-semibold py-3 rounded-lg disabled:bg-red-400 disabled:cursor-not-allowed hover:bg-red-700 transition-colors duration-200">
                                        <span wire:loading.remove wire:target="confirmAction">
                                            <span x-text="$wire.selectedAction === 'buy-now' ? 'Buy Now' : 'Add to Cart'"></span>
                                        </span>
                                        <span wire:loading wire:target="confirmAction">
                                            <svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/ace85084/public_html/shop.swetonspeakers.com/resources/views/livewire/category/type-product-component.blade.php ENDPATH**/ ?>