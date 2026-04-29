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
            Edit User
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="POST"
                  action="<?php echo e(route('admin.users.update', $user->id)); ?>"
                  class="bg-white p-6 rounded-lg shadow space-y-4">

                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium">Name</label>
                    <input type="text" name="name"
                           value="<?php echo e(old('name', $user->name)); ?>"
                           class="w-full border-gray-300 rounded-md">
                    <?php $__errorArgs = ['name'];
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

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input type="email" name="email"
                           value="<?php echo e(old('email', $user->email)); ?>"
                           class="w-full border-gray-300 rounded-md">
                    <?php $__errorArgs = ['email'];
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

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium">Phone</label>
                    <input type="text" name="phone_number"
                           value="<?php echo e(old('phone_number', $user->phone_number)); ?>"
                           class="w-full border-gray-300 rounded-md">
                    <?php $__errorArgs = ['phone_number'];
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

                <!-- ZIP -->
                <div>
                    <label class="block text-sm font-medium">ZIP / Postal Code</label>
                    <input type="text" name="zip_postal_code"
                           value="<?php echo e(old('zip_postal_code', $user->zip_postal_code)); ?>"
                           class="w-full border-gray-300 rounded-md">
                    <?php $__errorArgs = ['zip_postal_code'];
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

                <!-- House / Locality -->
                <div>
                    <label class="block text-sm font-medium">House / Locality</label>
                    <input type="text" name="locality_house_no"
                           value="<?php echo e(old('locality_house_no', $user->locality_house_no)); ?>"
                           class="w-full border-gray-300 rounded-md">
                    <?php $__errorArgs = ['locality_house_no'];
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

                <!-- Street -->
                <div>
                    <label class="block text-sm font-medium">Street Address</label>
                    <input type="text" name="street_address"
                           value="<?php echo e(old('street_address', $user->street_address)); ?>"
                           class="w-full border-gray-300 rounded-md">
                    <?php $__errorArgs = ['street_address'];
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

                <!-- Landmark -->
                <div>
                    <label class="block text-sm font-medium">Landmark</label>
                    <input type="text" name="landmark"
                           value="<?php echo e(old('landmark', $user->landmark)); ?>"
                           class="w-full border-gray-300 rounded-md">
                    <?php $__errorArgs = ['landmark'];
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

                <!-- City -->
                <div>
                    <label class="block text-sm font-medium">City / District / Town</label>
                    <input type="text" name="city_district_town"
                           value="<?php echo e(old('city_district_town', $user->city_district_town)); ?>"
                           class="w-full border-gray-300 rounded-md">
                    <?php $__errorArgs = ['city_district_town'];
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

                <!-- State -->
                <div>
                    <label class="block text-sm font-medium">State</label>
                    <input type="text" name="state"
                           value="<?php echo e(old('state', $user->state)); ?>"
                           class="w-full border-gray-300 rounded-md">
                    <?php $__errorArgs = ['state'];
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

                <!-- Company -->
                <div>
                    <label class="block text-sm font-medium">Company Name</label>
                    <input type="text" name="company_name"
                           value="<?php echo e(old('company_name', $user->company_name)); ?>"
                           class="w-full border-gray-300 rounded-md">
                    <?php $__errorArgs = ['company_name'];
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

                <!-- GST -->
                <div>
                    <label class="block text-sm font-medium">GST Number</label>
                    <input type="text" name="gst_no"
                           value="<?php echo e(old('gst_no', $user->gst_no)); ?>"
                           class="w-full border-gray-300 rounded-md">
                    <?php $__errorArgs = ['gst_no'];
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

                <!-- User Type -->
                <div>
                    <label class="block text-sm font-medium">User Type</label>
                    <select name="user_type" class="w-full border-gray-300 rounded-md">
                        <option value="user" <?php echo e($user->user_type=='user'?'selected':''); ?>>User</option>
                        <option value="guest" <?php echo e($user->user_type=='guest'?'selected':''); ?>>Guest</option>
                    </select>
                    <?php $__errorArgs = ['user_type'];
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
                        Update User
                    </button>

                    <a href="<?php echo e(route('admin.users.index')); ?>"
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
<?php endif; ?>
<?php /**PATH /home/ace85084/public_html/shop.swetonspeakers.com/resources/views/users/edit.blade.php ENDPATH**/ ?>