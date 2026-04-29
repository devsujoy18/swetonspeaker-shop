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
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-gray-700" aria-label="breadcrumb">
                <ol class="flex space-x-2">
                    <li>
                        <a href="<?php echo e(route('home')); ?>" class="text-blue-600 hover:underline">Home</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li class="text-gray-800">Checkout</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4">
        <div class="bg-white p-1 mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
        </div>

        <div class="bg-blue-100 text-blue-800 p-4 rounded-lg mb-6 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            <span>All * Field are required.</span>
        </div>
        
        <?php if($errors->has('blocked')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                🚫 <?php echo e($errors->first('blocked')); ?>

            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('checkout.place')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left side: Forms -->
                <div>
                    <!-- Billing Details -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900">Billing details</h2>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="billing_name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                                    <input type="text" id="billing_name" name="billing_name" 
                                           value="<?php echo e(old('billing_name', $billingData['name'])); ?>" 
                                           placeholder="Enter Your Name" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['billing_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="billing_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                    <input type="email" id="billing_email" name="billing_email" 
                                           value="<?php echo e(old('billing_email', $billingData['email'])); ?>" 
                                           placeholder="Enter Your Email" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['billing_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="billing_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                                    <input type="text" id="billing_phone" name="billing_phone" 
                                           value="<?php echo e(old('billing_phone', $billingData['phone'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['billing_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="billing_zip" class="block text-sm font-medium text-gray-700 mb-1">Zip/Postal Code *</label>
                                    <input type="text" id="billing_zip" name="billing_zip" 
                                           value="<?php echo e(old('billing_zip', $billingData['zip'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['billing_zip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="billing_locality" class="block text-sm font-medium text-gray-700 mb-1">Locality/House No *</label>
                                    <input type="text" id="billing_locality" name="billing_locality" 
                                           value="<?php echo e(old('billing_locality', $billingData['locality'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['billing_locality'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="billing_street" class="block text-sm font-medium text-gray-700 mb-1">Street Address *</label>
                                    <input type="text" id="billing_street" name="billing_street" 
                                           value="<?php echo e(old('billing_street', $billingData['street'])); ?>" 
                                           placeholder="Address" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['billing_street'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-1">City/District/Town *</label>
                                    <input type="text" id="billing_city" name="billing_city" 
                                           value="<?php echo e(old('billing_city', $billingData['city'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['billing_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="billing_state" class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                                    <input type="text" id="billing_state" name="billing_state" 
                                           value="<?php echo e(old('billing_state', $billingData['state'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['billing_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="billing_landmark" class="block text-sm font-medium text-gray-700 mb-1">Landmark *</label>
                                    <input type="text" id="billing_landmark" name="billing_landmark" 
                                           value="<?php echo e(old('billing_landmark', $billingData['landmark'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['billing_landmark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="billing_alternate_phone" class="block text-sm font-medium text-gray-700 mb-1">Alternate Phone</label>
                                    <input type="text" id="billing_alternate_phone" name="billing_alternate_phone" 
                                           value="<?php echo e(old('billing_alternate_phone', $billingData['alternate_phone'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="billing_landmark" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                                    <input type="text" id="company_name" name="company_name" 
                                           value="<?php echo e(old('company_name', $billingData['company_name'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="gst_no" class="block text-sm font-medium text-gray-700 mb-1">GST Number</label>
                                    <input type="text" id="gst_no" name="gst_no" 
                                           value="<?php echo e(old('gst_no', $billingData['gst_no'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['gst_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Details -->
                    <!-- Shipping Details -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900">Shipping Details</h2>
                        <div class="space-y-4">
                            <div class="flex items-center mb-4">
                                <input id="sameAsBilling" name="shipping_same_as_billing" type="checkbox" 
                                       class="h-4 w-4 text-blue-600 rounded-md border-gray-300 focus:ring-blue-500"
                                       value="1" <?php echo e(old('shipping_same_as_billing') ? 'checked' : ''); ?>>
                                <label for="sameAsBilling" class="ml-2 block text-sm font-medium text-gray-700">Ship to same address?</label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                                    <input type="text" id="shipping_name" name="shipping_name" 
                                           value="<?php echo e(old('shipping_name', $shippingData['name'])); ?>" 
                                           placeholder="Enter Your Name" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['shipping_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="shipping_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                    <input type="email" id="shipping_email" name="shipping_email" 
                                           value="<?php echo e(old('shipping_email', $shippingData['email'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['shipping_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                                    <input type="text" id="shipping_phone" name="shipping_phone" 
                                           value="<?php echo e(old('shipping_phone', $shippingData['phone'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['shipping_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="shipping_zip" class="block text-sm font-medium text-gray-700 mb-1">Zip/Postal Code *</label>
                                    <input type="text" id="shipping_zip" name="shipping_zip" 
                                           value="<?php echo e(session('checkout_postcode')); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500" readonly>
                                    <?php $__errorArgs = ['shipping_zip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="shipping_locality" class="block text-sm font-medium text-gray-700 mb-1">Locality/House No *</label>
                                    <input type="text" id="shipping_locality" name="shipping_locality" 
                                           value="<?php echo e(old('shipping_locality', $shippingData['locality'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['shipping_locality'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="shipping_street" class="block text-sm font-medium text-gray-700 mb-1">Street Address *</label>
                                    <input type="text" id="shipping_street" name="shipping_street" 
                                           value="<?php echo e(old('shipping_street', $shippingData['street'])); ?>" 
                                           placeholder="Address (Area and Street)" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['shipping_street'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">City/District/Town *</label>
                                    <input type="text" id="shipping_city" name="shipping_city" 
                                           value="<?php echo e(old('shipping_city', $shippingData['city'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['shipping_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                                    <input type="text" id="shipping_state" name="shipping_state" 
                                           value="<?php echo e(old('shipping_state', $shippingData['state'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['shipping_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="shipping_landmark" class="block text-sm font-medium text-gray-700 mb-1">Landmark *</label>
                                    <input type="text" id="shipping_landmark" name="shipping_landmark" 
                                           value="<?php echo e(old('shipping_landmark', $shippingData['landmark'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['shipping_landmark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="shipping_alternate_phone" class="block text-sm font-medium text-gray-700 mb-1">Alternate Phone</label>
                                    <input type="text" id="shipping_alternate_phone" name="shipping_alternate_phone" 
                                           value="<?php echo e(old('shipping_alternate_phone', $shippingData['alternate_phone'])); ?>" 
                                           class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right side: Your Order -->
                <div class="h-fit">
                    <!-- Your Order -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900">Your Order</h2>
                        
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('cart.checkout-component', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2597595916-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

                        <div class="mt-6 space-y-4">
                            <!-- Razorpay Row with Image and Clickable Label -->
                            <div class="flex items-center cursor-pointer border p-3">
                                <input type="radio" name="paymentMethod" id="razorpay" class="h-4 w-4 text-blue-600 focus:ring-blue-500 rounded-md border-gray-300" value="razorpay" <?php echo e(old('paymentMethod') === 'razorpay' ? 'checked' : ''); ?>>
                                <label for="razorpay" class="flex items-center ml-2 text-sm font-medium text-gray-700 cursor-pointer">
                                    <img src="https://www.swetonspeakers.com/shop/assets/razorpay.jpg" alt="Razorpay Logo" class="h-6 mr-2">
                                    
                                </label>
                                
                            </div>
                            
                            <?php $__errorArgs = ['paymentMethod'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="flex items-start">
                                <input id="termsCheckbox" type="checkbox" name="termsCheckbox" class="h-4 w-4 text-blue-600 rounded-md border-gray-300 mt-1 focus:ring-blue-500">
                                <label for="termsCheckbox" class="ml-2 text-sm text-gray-700">
                                    I have read and agree to the website 
                                    <a href="#" class="text-blue-600 hover:underline">terms and conditions</a>*<br>
                                    <a href="#" class="text-blue-600 hover:underline special-font">Certificate of Appreciation from The Government of India (Ministry of Finance)</a>
                                </label>
                                <?php $__errorArgs = ['termsCheckbox'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="text-xs text-gray-600 space-y-2 mt-4">
                                <h3 class="font-bold text-gray-900 text-base md:text-lg text-red-600">Important Notice</h3>
                                <ul class="list-disc list-inside space-y-1 pl-4">
                                    <li>If the amount debited from your bank account but not updated in the Online Payment section, Please send your payment receipt received from your payment Gateway to email sales@swetsonspeakers.com and wait for 24 hours.</li>
                                    <li>Delivery Courier normally delivers the materials within 7-10 days from the date of despatch. But in some cases it may take upto 15 days, although we try to expediate delivery. swetsonspeakers & Delivery courier associations are beyond our control. We should not be held responsible for any delay by Delivery courier.</li>
                                    <li>All the required informations and specifications are given in the website, no further informations and specification will be shared later on.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<script>
    document.getElementById('sameAsBilling').addEventListener('change', function() {
        let checked = this.checked;
        let billingFields = ['name','email','phone','alternate_phone','locality','street','city','state','landmark'];
        billingFields.forEach(field => {
            let billingInput = document.querySelector(`[name="billing_${field}"]`);
            let shippingInput = document.querySelector(`[name="shipping_${field}"]`);
            if (checked && billingInput && shippingInput) {
                shippingInput.value = billingInput.value;
            } else if (!checked && shippingInput) {
                shippingInput.value = '';
            }
        });
    });
</script>
    
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9d41032d5dde91ab243771384dacb5df)): ?>
<?php $attributes = $__attributesOriginal9d41032d5dde91ab243771384dacb5df; ?>
<?php unset($__attributesOriginal9d41032d5dde91ab243771384dacb5df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9d41032d5dde91ab243771384dacb5df)): ?>
<?php $component = $__componentOriginal9d41032d5dde91ab243771384dacb5df; ?>
<?php unset($__componentOriginal9d41032d5dde91ab243771384dacb5df); ?>
<?php endif; ?><?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/checkout.blade.php ENDPATH**/ ?>