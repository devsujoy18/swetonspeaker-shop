<div>
    <div class="space-y-4">
        <div class="flex justify-between items-center pb-2 border-b border-gray-200">
            <span class="text-gray-700">Product</span>
            <span class="text-gray-700">Total</span>
        </div>
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="flex justify-between items-center" wire:key="cart-item-<?php echo e($item->id); ?>">
            <span class="text-gray-900">
                 
                <?php echo e($item->name); ?> X <?php echo e($item->quantity); ?>

            </span>
            <span class="text-gray-900 font-medium">₹ <?php echo e(number_format(($item->price * $item->quantity), 2)); ?></span>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="flex justify-between items-center">
            No items found
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <div class="flex justify-between items-center py-2 border-t border-gray-200">
            <span class="text-gray-700">Subtotal</span>
            <span class="text-gray-900 font-medium">₹ <?php echo e(number_format($subtotal, 2)); ?></span>
        </div>
        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
            <span class="text-xl font-semibold text-gray-900">Total</span>
            <span class="text-xl font-semibold text-gray-900">₹ <?php echo e(number_format($total, 2)); ?></span>
        </div>
    </div>
</div>
<?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/livewire/cart/checkout-component.blade.php ENDPATH**/ ?>