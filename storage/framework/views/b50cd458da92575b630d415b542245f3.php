<div 
x-data="{ cartCount: <?php echo e(\Darryldecode\Cart\Facades\CartFacade::getTotalQuantity()); ?> }" 
x-on:cart-qty-changed-mobile.window="cartCount = $event.detail[0].currentQuantity">
    <a href="<?php echo e(route('cart' )); ?>" class="text-white text-xl relative">
        <i class="fas fa-cart-plus"></i>
        <span class="absolute -top-1 -right-2 bg-red-500 text-xs rounded-full px-1" x-text="cartCount"></span>
    </a>
</div>
<?php /**PATH C:\xampp\htdocs\swetonspeaker-shop\resources\views/livewire/cart/mobile-icon-component.blade.php ENDPATH**/ ?>