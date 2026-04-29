<aside class="w-full lg:w-1/4 hidden md:block">
    <div class="bg-white shadow rounded-lg">
        <div class="border-b p-4 flex justify-between items-center">
            <h2 class="font-semibold">Categories</h2>
        </div>
        <div class="p-4">
            
            <!--[if BLOCK]><![endif]--><?php if($proloudSpeakers->isNotEmpty()): ?>
            <div class="mb-4">
                <button class="w-full flex justify-between items-center text-left font-medium text-gray-700 hover:text-blue-600" onclick="toggleSubMenu('proLoudspeakersMenu')">
                    Pro Loudspeakers <i class="fas fa-angle-down"></i>
                </button>
                <ul class="ml-4 mt-2 space-y-1 <?php echo e($proloudSpeakers->pluck('slug')->contains($currentCategorySlug) || $typeSlug === 'pro-loudspeaker' ? '' : 'hidden'); ?>" id="proLoudspeakersMenu">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $proloudSpeakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="<?php echo e(route('category.products', ['pro-loudspeaker', $proCategory->slug])); ?>" 
                            class="text-gray-600 hover:underline <?php echo e($proCategory->slug === $currentCategorySlug ? 'text-red-600 font-bold' : ''); ?>">
                            <?php echo e($proCategory->name); ?>

                        </a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            
            <!--[if BLOCK]><![endif]--><?php if($homeloudSpeakers->isNotEmpty()): ?>
            <div class="mb-4">
                <button class="w-full flex justify-between items-center text-left font-medium text-gray-700 hover:text-blue-600" onclick="toggleSubMenu('homeLoudspeakersMenu')">
                    Home Loudspeakers <i class="fas fa-angle-down"></i>
                </button>
                <ul class="ml-4 mt-2 space-y-1 <?php echo e($homeloudSpeakers->pluck('slug')->contains($currentCategorySlug) || $typeSlug === 'home-loudspeaker' ? '' : 'hidden'); ?>" id="homeLoudspeakersMenu">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $homeloudSpeakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $homeCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="<?php echo e(route('category.products', ['home-loudspeaker', $homeCategory->slug])); ?>" 
                            class="text-gray-600 hover:underline <?php echo e($homeCategory->slug === $currentCategorySlug ? 'text-red-600 font-bold' : ''); ?>">
                            <?php echo e($homeCategory->name); ?>

                        </a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
    <script>
        function toggleSubMenu(menuId) {
            const menu = document.getElementById(menuId);
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        // Auto-open current category's submenu on page load
        document.addEventListener('livewire:initialized', () => {
            const currentCategoryLink = document.querySelector('.left-sidebar a.text-red-600');
            if (currentCategoryLink) {
                let parentUl = currentCategoryLink.closest('ul');
                if (parentUl && parentUl.id && (parentUl.id === 'homeLoudspeakersMenu' || parentUl.id === 'proLoudspeakersMenu')) {
                    parentUl.classList.remove('hidden');
                }
            }
        });
    </script>
</aside>
<?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/livewire/category/listsidebar-component.blade.php ENDPATH**/ ?>