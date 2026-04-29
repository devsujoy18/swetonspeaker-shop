<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800">
            Report Management
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">

            <h3 class="text-lg font-semibold mb-4">Download Reports</h3>

            <form action="<?php echo e(route('admin.reports.export')); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- From Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">From Date</label>
                    <input type="date" name="from_date" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                </div>

                <!-- To Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">To Date</label>
                    <input type="date" name="to_date" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                </div>

                <!-- Delivery Partner -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Delivery Partner</label>
                    <select name="partner" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">All Partners</option>
                        <?php $__currentLoopData = $deliveryPartners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($p); ?>"><?php echo e($p); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('partner'),'class' => 'mt-2 text-sm text-red-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('partner')),'class' => 'mt-2 text-sm text-red-600']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>

                    
                </div>

                <!-- Button -->
                <div class="md:col-span-3">
                    <button type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Download Excel Report
                    </button>
                </div>
            </form>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/report/index.blade.php ENDPATH**/ ?>