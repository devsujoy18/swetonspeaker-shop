<div>
    <!--[if BLOCK]><![endif]--><?php if(count($proloudSpeakers) > 0): ?>
        <div class="container mx-auto px-4 py-2">
            <h2 class="text-3xl font-bold mb-6">Pro Loudspeakers</h2>
            <div class="grid grid-cols-1 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $proloudSpeakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="group bg-white border border-gray-300 shadow-sm rounded overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl hover:border-red-600">
                        <div class="bg-red-600 text-white text-center py-2 font-semibold text-sm"><?php echo e($category->name); ?></div>
                        <h4 class="text-center text-red-600 uppercase font-semibold px-3">Buy Online</h4>
                        <a href="<?php echo e(route('category.products', ['pro-loudspeaker', $category->slug])); ?>">
                            <!--[if BLOCK]><![endif]--><?php if($category->image): ?>
                                <img src="<?php echo e(env('IMG_HOST')); ?>/uploads/thumbnails/<?php echo e($category->image); ?>" class="w-full p-2" />
                            <?php else: ?>
                                <img src="<?php echo e(asset('images/buy.jpg')); ?>" class="w-full p-2" />  
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if(count($homeloudSpeakers) > 0): ?>
        <div class="container mx-auto px-4 py-2">
            <h2 class="text-3xl font-bold md:mb-6">Home Loudspeakers</h2>
            <div class="grid grid-cols-1 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $homeloudSpeakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="group bg-white border border-gray-300 shadow-sm rounded overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl hover:border-red-600">
                        <div class="bg-red-600 text-white text-center py-2 font-semibold text-sm"><?php echo e($category->name); ?></div>
                        <h4 class="text-center text-red-600 uppercase font-semibold px-3">Buy Online</h4>
                        <a href="<?php echo e(route('category.products', ['home-loudspeaker', $category->slug])); ?>">
                            <!--[if BLOCK]><![endif]--><?php if($category->image): ?>
                                <img src="<?php echo e(env('IMG_HOST')); ?>/uploads/thumbnails/<?php echo e($category->image); ?>" class="w-full p-2" />
                            <?php else: ?>
                                <img src="<?php echo e(asset('images/buy.jpg')); ?>" class="w-full p-2" />  
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/livewire/category/home-component.blade.php ENDPATH**/ ?>