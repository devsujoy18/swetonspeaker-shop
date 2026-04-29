<?php if (isset($component)) { $__componentOriginal9d41032d5dde91ab243771384dacb5df = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9d41032d5dde91ab243771384dacb5df = $attributes; } ?>
<?php $component = App\View\Components\FrontLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('front-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\FrontLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
	<!--breadcrumb-->
	<div class="bg-gray-100 py-4">
	    <div class="container mx-auto px-4">
	      	<nav class="text-sm text-gray-600">
	        	<ol class="flex space-x-2">
	          		<li>
	          			<a href="<?php echo e(route('home')); ?>" class="text-blue-600 hover:underline">Home</a>
	          			<span class="mx-2">/</span>
	          		</li>
	          		<li>
	          			<a href="<?php echo e(route('type.category', $type)); ?>" class="text-blue-600 hover:underline">
	          				<?php echo e($type == 'pro-loudspeaker' ? 'Pro Loudspeaker' : 'Home Loudspeaker'); ?>

	          			</a>
	          			<span class="mx-2">/</span>
	          		</li>
	          		<li>
	          			<a href="<?php echo e(route('category.products', [$type, $categorySlug])); ?>" class="text-blue-600 hover:underline">
	          				<?php echo e($categorySlug); ?>

	          			</a>
	          			<span class="mx-2">/</span>
	          		</li>
	          		<li class="text-gray-800"><?php echo e($productSlug); ?></li>
	        	</ol>
	      	</nav>
	    </div>
  	</div>

  	<!-- Product Section -->
  	<?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('products.public-details-component', ['type' => $type,'categorySlug' => $categorySlug,'productSlug' => $productSlug]);

$__html = app('livewire')->mount($__name, $__params, 'lw-186794586-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
	
    <!--Product other details-->
    <style>
        /* Custom styles for active tab */
        .tab-btn.active {
            border-bottom-color: #fff; /* Indigo color for active border */
            color: #fff;
        }
    </style>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('products.public-other-details-component', ['type' => $type,'categorySlug' => $categorySlug,'productSlug' => $productSlug]);

$__html = app('livewire')->mount($__name, $__params, 'lw-186794586-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

    <!--Product Review Component-->
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('products.public-reviews-component', ['type' => $type,'categorySlug' => $categorySlug,'productSlug' => $productSlug]);

$__html = app('livewire')->mount($__name, $__params, 'lw-186794586-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

    <!--Related Product Component-->
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('products.related-product-component', ['type' => $type,'categorySlug' => $categorySlug,'productSlug' => $productSlug]);

$__html = app('livewire')->mount($__name, $__params, 'lw-186794586-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9d41032d5dde91ab243771384dacb5df)): ?>
<?php $attributes = $__attributesOriginal9d41032d5dde91ab243771384dacb5df; ?>
<?php unset($__attributesOriginal9d41032d5dde91ab243771384dacb5df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9d41032d5dde91ab243771384dacb5df)): ?>
<?php $component = $__componentOriginal9d41032d5dde91ab243771384dacb5df; ?>
<?php unset($__componentOriginal9d41032d5dde91ab243771384dacb5df); ?>
<?php endif; ?><?php /**PATH /home/ace85084/public_html/shop.swetonspeakers.com/resources/views/product_details.blade.php ENDPATH**/ ?>