<header class="hidden lg:block">
<div class="bg-white shadow sticky top-0 z-50">
    <div class="container mx-auto px-8 py-4 flex items-center justify-between">
            <div class="flex-shrink-0 site-header__logo">
                <a href="<?php echo e(route('home')); ?>">
                    <img src="<?php echo e(asset('image/logonew1.png')); ?>" alt="Sweton Logo" class="w-[212px]">
                </a>
            </div>
            <div class="flex-grow mx-6">
                <div class="w-full"></div>
            </div>
            <div class="flex-shrink-0 site-header__phone">
                <img src="<?php echo e(asset('image/mainlogo1.png')); ?>" alt="Main Logo" class="w-[54%]" style="display: inline;">
            </div>
    </div>
</div>
</header>
    <!-- Navigation Panel -->
    <div class="hidden lg:block site-header__nav-panel sticky top-0 z-50">
        <div class="nav-panel nav-panel--sticky">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between">
                    
                    <!-- Shop By Category Button -->
                    <div class="relative bg-red-700" style="width: 256px;">
                        <input type="checkbox" id="toggleCategory" class="peer hidden">
                        <label for="toggleCategory" class="flex items-center justify-between w-full px-4 py-3 bg-red-700 text-white font-semibold cursor-pointer transition duration-300 hover:bg-red-800">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-align-justify"></i>Shop By Category
                            </div>
                            <i class="fas fa-angle-down transform transition-transform duration-300 peer-checked:rotate-180"></i>
                        </label>
                        <!-- Dropdown Menu (Visible when checkbox is checked) -->
                        <div id="categoryDropdown" class="absolute left-0 w-64 bg-red-600 text-white font-semibold shadow-lg z-50 hidden peer-checked:block transition-all duration-300 ease-in-out">
                            <ul class="divide-y divide-red-500">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($proCategories) && $proCategories->isNotEmpty()): ?>
                                    <li class="group relative">
                                        <a href="#" class="flex justify-between items-center px-4 py-3 hover:bg-red-700 transition-colors duration-200 hover:text-white-800">
                                            Pro Loudspeakers <i class="fas fa-angle-right transition-transform duration-200 group-hover:translate-x-1"></i>
                                        </a>
                                        <div class="absolute top-0 left-full w-[1000px] bg-white text-black shadow-lg border border-gray-300 rounded-md hidden group-hover:grid grid-cols-4 gap-4 p-4 z-50">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $proCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="border border-red-600 rounded-sm bg-white">
                                                    <div class="bg-red-600 text-white font-bold text-[15px] px-3 py-2 border-b border-white rounded-t-sm">
                                                        <?php echo e($category->name); ?>

                                                    </div>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($category->products) && $category->products->isNotEmpty()): ?>
                                                        <ul class="text-sm text-gray-800 px-3 py-2 space-y-1">
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $category->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li>
                                                                <a href="<?php echo e(route('product.details', ['pro-loudspeaker', $category->slug, $product->slug ])); ?>" class="block hover:bg-gray-100 px-2 py-1 rounded">
                                                                    <?php echo e($product->name); ?>

                                                                </a>
                                                            </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </ul>
                                                    <?php else: ?>
                                                        <ul class="text-sm text-gray-800 px-3 py-2 space-y-1">
                                                            <li>No products found!</li>
                                                        </ul>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </li>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($homeCategories) && $homeCategories->isNotEmpty()): ?>
                                    <li class="group relative">
                                        <a href="#" class="flex justify-between items-center px-4 py-3 hover:bg-red-700 transition-colors duration-200 hover:text-white-800">
                                            Home Loudspeakers <i class="fas fa-angle-right transition-transform duration-200 group-hover:translate-x-1"></i>
                                        </a>
                                        <div class="absolute scroll-need top-0 left-full w-[1000px] bg-white text-black shadow-lg border border-gray-300 rounded-md hidden group-hover:grid grid-cols-4 gap-4 p-4 z-50">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $homeCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="border border-red-600 rounded-sm bg-white">
                                                    <div class="bg-red-600 text-white font-bold text-[15px] px-3 py-2 border-b border-white rounded-t-sm">
                                                        <?php echo e($category->name); ?>

                                                    </div>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($category->products) && $category->products->isNotEmpty()): ?>
                                                        <ul class="text-sm text-gray-800 px-3 py-2 space-y-1">
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $category->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li>
                                                                <a href="<?php echo e(route('product.details', ['home-loudspeaker', $category->slug, $product->slug ])); ?>" class="block hover:bg-gray-100 px-2 py-1 rounded">
                                                                    <?php echo e($product->name); ?>

                                                                </a>
                                                            </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </ul>
                                                    <?php else: ?>
                                                        <ul class="text-sm text-gray-800 px-3 py-2 space-y-1">
                                                            <li>No products found!</li>
                                                        </ul>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </li>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </ul>
                        </div>
                    </div>     

                    <!-- Nav Links -->
                    <ul class="hidden md:flex space-x-6 font-medium text-white-700">
                        <li><a href="<?php echo e(route('home')); ?>" class="hover:text-gray-400">Home</a></li>
                        <li><a href="https://www.swetonspeakers.com/about-us" class="hover:text-gray-400">About</a></li>
                        <li><a href="https://www.swetonspeakers.com/events-and-blogs" class="hover:text-gray-400">Events &amp; Blog</a></li>
                        <li><a href="https://www.swetonspeakers.com/videos" class="hover:text-gray-400">Videos</a></li>
                        <li><a href="https://www.swetonspeakers.com/contact-us" class="hover:text-gray-400">Contact Us</a></li>
                        <li><a href="https://www.swetonspeakers.com/application-for-dealership" class="hover:text-gray-400">Application for Dealership</a></li>
                    </ul>

                    <!-- Indicators -->
                    <div class="flex items-center space-x-4">
                        <!-- Search Icon Button -->
                        <button onclick="openModal()" class="hover:text-gray-400">
                            <i class="fas fa-search text-xl"></i>
                        </button>

                        <!-- Cart Icon -->
                        
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('cart.icon-component', []);

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3805588803-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

                        <!-- User Icon -->
                        <a class="hover:text-gray-400" href="<?php echo e(route('login')); ?>">
                            <i class="far fa-user text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php /**PATH C:\xampp\htdocs\swetonspeaker-shop\resources\views/components/frontend/navbar.blade.php ENDPATH**/ ?>