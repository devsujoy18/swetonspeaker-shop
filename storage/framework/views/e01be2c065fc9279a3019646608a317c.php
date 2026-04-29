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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Site Settings
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <?php if(session('success')): ?>
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <form method="POST"
                  action="<?php echo e(route('admin.settings.update')); ?>"
                  class="bg-white p-6 rounded-lg shadow space-y-4">

                <?php echo csrf_field(); ?>

                <!-- Cart Enabled -->
                <div>
                    <label class="block text-sm font-medium mb-2">Cart Enabled</label>

                    <div class="flex items-center gap-6">
                        <label class="inline-flex items-center gap-2">
                            <input type="radio"
                                   name="cart_enabled"
                                   value="1"
                                   <?php echo e(old('cart_enabled', $setting->cart_enabled) == 1 ? 'checked' : ''); ?>

                                   class="text-indigo-600 border-gray-300 focus:ring-indigo-500">
                            <span>Yes</span>
                        </label>

                        <label class="inline-flex items-center gap-2">
                            <input type="radio"
                                   name="cart_enabled"
                                   value="0"
                                   <?php echo e(old('cart_enabled', $setting->cart_enabled) == 0 ? 'checked' : ''); ?>

                                   class="text-indigo-600 border-gray-300 focus:ring-indigo-500">
                            <span>No</span>
                        </label>
                    </div>

                    <?php $__errorArgs = ['cart_enabled'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>


                <!-- Minimum Cart Amount -->
                <div>
                    <label class="block text-sm font-medium">Minimum Cart Amount</label>
                    <input type="number" step="0.01" name="minimum_cart_amount"
                           value="<?php echo e(old('minimum_cart_amount', $setting->minimum_cart_amount)); ?>"
                           class="w-full border-gray-300 rounded-md">
                    <?php $__errorArgs = ['minimum_cart_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Cart Disabled Message -->
                <div>
                    <label class="block text-sm font-medium">Cart Disabled Message</label>
                    <input type="text" name="cart_disabled_message"
                           value="<?php echo e(old('cart_disabled_message', $setting->cart_disabled_message)); ?>"
                           class="w-full border-gray-300 rounded-md">
                    <?php $__errorArgs = ['cart_disabled_message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Home Message -->
                <div>
                    <label class="block text-sm font-medium">Home Page Message</label>
                    <textarea name="home_message"
                              rows="3"
                              class="w-full border-gray-300 rounded-md"><?php echo e(old('home_message', $setting->home_message)); ?></textarea>
                    <?php $__errorArgs = ['home_message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4">
                    <button class="px-5 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Update Settings
                    </button>

                    <a href="<?php echo e(route('dashboard')); ?>"
                       class="px-5 py-2 bg-gray-100 rounded hover:bg-gray-200">
                        Cancel
                    </a>
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
<?php endif; ?><?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/settings/edit.blade.php ENDPATH**/ ?>