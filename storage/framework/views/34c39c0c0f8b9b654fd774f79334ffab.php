<div class="relative">
  <!-- Cart Button -->
  <button 
    id="cart-button" 
    class="relative hover:text-gray-400"
  >
    <i class="fas fa-cart-plus text-xl"></i>
    <span 
      id="cart_widget_count" 
      class="absolute -top-1 -right-2 bg-red-600 text-white text-xs rounded-full px-1"
    >
      <?php echo e($cartCount); ?>

    </span>
  </button>

  <!-- Dropdown Panel -->
  <div 
    id="cart-dropdown" 
    class="hidden absolute right-0 mt-2 w-80 bg-white border shadow-lg z-50"
  >
    <!-- Cart Item -->
    <!--[if BLOCK]><![endif]--><?php if($cartItems->count() > 0): ?>
      <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="p-4 border-b">
        <div class="flex gap-4 items-center">
          <img 
            src="<?php echo e($item->attributes->image); ?>" 
            alt="<?php echo e($item->name); ?>" 
            class="w-16 h-16 object-contain"
          >
          <div>
            <h4 class="font-semibold text-sm text-gray-500">
              <?php echo e($item->name); ?>

            </h4>
            <!--[if BLOCK]><![endif]--><?php if($item->attributes->shop_description): ?>
            <p class="text-xs text-gray-500">
              ( <?php echo e($item->attributes->shop_description); ?> )
            </p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <p class="text-sm font-medium mt-1 text-gray-500">
              ₹<?php echo e($item->price); ?> X <?php echo e($item->quantity); ?>

            </p>
          </div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
      <div class="p-4 border-b">
        <div class="flex justify-between text-sm text-gray-500">
          <span class="text-black">Subtotal</span>
          <span>₹<?php echo e(number_format($cartSubTotal, 2)); ?> /-</span>
        </div>
        <div class="flex justify-between text-sm font-semibold text-gray-500">
          <span class="text-black">Total</span>
          <span>₹<?php echo e(number_format($cartTotal, 2)); ?> /-</span>
        </div>
      </div>
      <div class="p-4">
        <a 
          href="<?php echo e(route('cart' )); ?>" 
          class="block w-full text-center bg-black text-white py-2 rounded hover:bg-gray-800 transition"
        >
          View Cart
        </a>
      </div>
    <?php else: ?>
      <div class="p-4 text-center text-gray-500">
        Your cart is empty.
      </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
  </div>
</div>
<?php /**PATH /home/ace85084/public_html/shop.swetonspeakers.com/resources/views/livewire/cart/icon-component.blade.php ENDPATH**/ ?>