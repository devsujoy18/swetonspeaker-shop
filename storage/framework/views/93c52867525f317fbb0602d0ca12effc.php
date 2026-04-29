<div class="py-8">
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
      <div class="container mx-auto px-4">
        <div>
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Gallery -->
            <div>
              <div 
                x-data="{
                  open: false,
                  images: [
                    <?php $__currentLoopData = $product->productimages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productimg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        '<?php echo e(env('IMG_HOST')); ?>/uploads/<?php echo e($productimg->path); ?>',
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  ],
                  index: 0,
                  zoomed: false
                }" 
                class="relative w-full max-w-xl"
              >
                <!-- Main Image Display -->
                <div class="max-w-md mx-auto bg-white p-2 rounded-lg shadow-md border-2 border-gray-300">
                  <img 
                    :src="images[index]" 
                    @click="open = true" 
                    alt="Main product image" 
                    class="cursor-zoom-in w-full h-auto object-cover rounded" 
                  />
                </div>

                <!-- Thumbnail Images -->
                <div class="flex justify-center gap-2 mt-4">
                  <template x-for="(img, i) in images" :key="i">
                    <div class="p-1 bg-white rounded-md shadow-sm">
                      <img 
                        :src="img" 
                        @click="index = i" 
                        alt="Thumbnail image"
                        class="w-16 h-16 object-cover cursor-pointer rounded"
                        :class="{ 'ring-2 ring-red-500 ring-offset-2': index === i }"
                      >
                    </div>
                  </template>
                </div>

                <!-- Hint Text -->
                <div class="text-center text-sm text-gray-500 mt-4">
                  <span class="inline-flex items-center gap-1.5">
                    <svg 
                      xmlns="http://www.w3.org/2000/svg" 
                      class="h-4 w-4" 
                      fill="none" 
                      viewBox="0 0 24 24" 
                      stroke="currentColor" 
                      stroke-width="2"
                    >
                      <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 10l-2.5 2.5M10 10l2.5 2.5" 
                      />
                    </svg>
                    Click the main image to zoom
                  </span>
                </div>

                <!-- Modal -->
                <div 
                  x-show="open" 
                  x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100"
                  x-transition:leave="transition ease-in duration-200"
                  x-transition:leave-start="opacity-100"
                  x-transition:leave-end="opacity-0"
                  @keydown.escape.window="open = false; zoomed = false"
                  @click.self="open = false; zoomed = false"
                  class="fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center p-4"
                  style="display: none;"
                >
                  <div class="relative max-w-5xl w-full">
                    <!-- Close Button -->
                    <button 
                      @click="open = false; zoomed = false" 
                      class="absolute -top-8 right-0 md:top-2 md:right-2 text-white text-5xl leading-none hover:text-red-500 z-50"
                    >
                      &times;
                    </button>

                    <!-- Image Title -->
                    <div class="text-center mb-3">
                      <span class="inline-block bg-red-600 text-white px-4 py-1 rounded-full font-semibold text-sm shadow-lg">
                        WOOFER 4" 20 WT
                      </span>
                    </div>

                    <!-- Zoom Button -->
                    <button 
                      @click="zoomed = !zoomed" 
                      class="absolute top-2 left-1/2 -translate-x-1/2 text-white p-2 rounded-full bg-black bg-opacity-30 hover:bg-opacity-60 z-50"
                    >
                      <svg 
                        x-show="!zoomed" 
                        xmlns="http://www.w3.org/2000/svg" 
                        class="h-6 w-6" 
                        fill="none" 
                        viewBox="0 0 24 24" 
                        stroke="currentColor" 
                        stroke-width="2"
                      >
                        <path 
                          stroke-linecap="round" 
                          stroke-linejoin="round" 
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 8v4m-2-2h4" 
                        />
                      </svg>
                      <svg 
                        x-show="zoomed" 
                        xmlns="http://www.w3.org/2000/svg" 
                        class="h-6 w-6" 
                        fill="none" 
                        viewBox="0 0 24 24" 
                        stroke="currentColor" 
                        stroke-width="2" 
                        style="display: none;"
                      >
                        <path 
                          stroke-linecap="round" 
                          stroke-linejoin="round" 
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7" 
                        />
                      </svg>
                    </button>

                    <!-- Modal Content with Navigation -->
                    <div class="relative">
                      <!-- Main Modal Image Display -->
                      <div class="flex items-center justify-center">
                        <img 
                          :src="images[index]" 
                          alt="Enlarged product image" 
                          class="w-auto rounded-lg shadow-2xl transition-all duration-300 ease-in-out"
                          :class="{ 'max-h-[95vh]': zoomed, 'max-h-[80vh]': !zoomed }" 
                        />
                      </div>

                      <!-- Navigation Arrows -->
                      <button 
                        @click="index = (index - 1 + images.length) % images.length; zoomed = false" 
                        class="absolute left-0 sm:left-4 top-1/2 transform -translate-y-1/2 text-white text-4xl font-bold p-3 rounded-full bg-black bg-opacity-20 hover:bg-opacity-50 transition-colors"
                      >
                        &#10094;
                      </button>
                      <button 
                        @click="index = (index + 1) % images.length; zoomed = false" 
                        class="absolute right-0 sm:right-4 top-1/2 transform -translate-y-1/2 text-white text-4xl font-bold p-3 rounded-full bg-black bg-opacity-20 hover:bg-opacity-50 transition-colors"
                      >
                        &#10095;
                      </button>
                    </div>

                    <!-- Image Counter -->
                    <div class="absolute top-2 left-2 text-white text-sm bg-black bg-opacity-50 px-2.5 py-1 rounded-full">
                      <span x-text="(index + 1) + ' / ' + images.length"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Product Information -->
            <div>
              <h2 class="inline-block bg-red-600 text-white text-2xl font-bold px-3 py-1 rounded">
                <?php echo e($product->name); ?>

              </h2>

                <!-- Keyfeatures Section -->
                <!--[if BLOCK]><![endif]--><?php if($product->combinations->first()): ?>
                    <?php
                        $firstCombination = $product->combinations->first();
                    ?>
                    <!--[if BLOCK]><![endif]--><?php if($firstCombination->productkeyfeatures): ?>
                    <div class="mt-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Keyfeatures</h3>
                        <ul class="list-disc list-inside text-gray-800 space-y-1">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $firstCombination->productkeyfeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyfeature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($keyfeature->keyfeature->name); ?>: <?php echo e($keyfeature->value); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <!-- <li>Impedance: 4 Ohm</li>
                            <li>Program Power: 40 W</li>
                            <li>Voice Coil Diameter: 19.1 mm</li>
                            <li>Frequency Response: 231-13K Hz</li>
                            <li>Sensitivity (1W/1m): 86 db</li>
                            <li>Mounting Depth: 54 mm</li>
                            <li>Magnet Weight: 220 gm</li> -->
                        </ul>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

              <!-- Pricing Section -->

              <!--[if BLOCK]><![endif]--><?php if($product->priceAttributes->isNotEmpty()): ?>
                <div class="mt-4">
                    <h4 class="text-gray-700 font-medium mb-2">Available Options:</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $product->priceAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="block border rounded-lg p-4 cursor-pointer transition-colors duration-200"
                                wire:key="attribute-<?php echo e($attribute->id); ?>"
                                :class="{ 'border-red-500 ring-2 ring-red-500 bg-red-50': $wire.selectedAttributeId == <?php echo e($attribute->id); ?> }">
                                <input type="radio" wire:model.live="selectedAttributeId" value="<?php echo e($attribute->id); ?>" class="sr-only">
                                <div class="flex flex-col">
                                    <span class="text-lg font-semibold text-gray-700"
                                          :class="{ 'text-red-800': $wire.selectedAttributeId == <?php echo e($attribute->id); ?> }">
                                        <?php echo e($attribute->name); ?>

                                    </span>
                                    <span class="block text-sm text-gray-500">
                                        <span class="line-through">₹<?php echo e(number_format($attribute->mrp, 0)); ?></span>
                                        <span class="text-red-600 font-bold ml-2">₹<?php echo e(number_format($attribute->price, 0)); ?></span>
                                    </span>
                                </div>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!--[if BLOCK]><![endif]--><?php if($attributePriceError): ?>
                      <p class="mt-2 text-sm text-red-600 font-medium">Please choose one option</p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
              <?php else: ?>
                <div class="mt-4">
                  <p class="text-base font-medium text-gray-800">
                    MRP <span class="line-through text-gray-500">₹<?php echo e($product->mrp); ?></span> /-
                    <!--[if BLOCK]><![endif]--><?php if($product->shop_description): ?>
                    <span class="text-sm text-gray-600">(<?php echo e($product->shop_description); ?>)</span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                  </p>
                  <p class="text-2xl font-bold text-red-600 mt-1">
                    Offer Price ₹<?php echo e($product->price); ?> /-
                    <!--[if BLOCK]><![endif]--><?php if($product->shop_description): ?>
                    <span class="text-sm text-gray-600">(<?php echo e($product->shop_description); ?>)</span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                  </p>
                </div>
              <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

              <!-- Category Section -->
              <div class="mt-6">
                <h4 class="text-gray-700 font-medium mb-1">Category</h4>
                <div class="flex items-center space-x-4">
                    <a href="#" class="inline-block bg-gray-200 text-sm px-3 py-1 rounded">
                        <?php echo e($type == 'pro-loudspeaker' ? 'Pro Loudspeaker' : 'Home Loudspeaker'); ?>

                    </a>
                    <a href="#" class="inline-block bg-gray-200 text-sm px-3 py-1 rounded"><?php echo e($categorySlug); ?></a>
                </div>
              </div>
              
              <!-- Quantity and Button -->
              <div class="mt-6 flex items-center space-x-4">
                <div>
                  <label class="block font-medium text-gray-700 mb-1">Quantity</label>
                  <div class="flex items-center border rounded w-32">
                    <button class="w-10 h-10 text-gray-600 hover:text-black" wire:click="decrementQuantity">-</button>
                    <input type="number" wire:model="quantity" readonly class="w-12 text-center text-sm py-2" />
                    <button class="w-10 h-10 text-gray-600 hover:text-black" wire:click="incrementQuantity">+</button>
                  </div>
                </div>
                <button wire:click="addToCart" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded mt-6">
                  <span wire:loading.remove wire:target="addToCart">Add to Cart</span>
                  <span wire:loading wire:target="addToCart">Adding..</span>
                </button>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
<?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/livewire/products/public-details-component.blade.php ENDPATH**/ ?>