<div class="space-y-6">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="text-sm text-gray-500">Order Number</div>
                <div class="text-lg font-semibold text-gray-900"><?php echo e($order->order_number); ?></div>
            </div>
            <div class="flex gap-3">
                <div class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 border border-green-300">
                    Payment: <?php echo e(ucfirst($order->payment_status)); ?>

                </div>
                <div class="px-3 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700 border border-indigo-300">
                    Status: <?php echo e(ucfirst($order->order_status)); ?>

                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="saveChanges" class="space-y-6">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-base font-semibold text-gray-900 mb-4">Billing Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" wire:model.live="billingName" class="mt-1 w-full border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['billingName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input type="email" wire:model.live="billingEmail" class="mt-1 w-full border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['billingEmail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" wire:model.live="billingPhone" class="mt-1 w-full border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['billingPhone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Alternate Phone</label>
                    <input type="text" wire:model.live="billingAlternatePhone" class="mt-1 w-full border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['billingAlternatePhone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Zip / Postal Code</label>
                    <input type="text" wire:model.live="billingZip" class="mt-1 w-full border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['billingZip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Locality</label>
                    <input type="text" wire:model.live="billingLocality" class="mt-1 w-full border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['billingLocality'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Street</label>
                    <input type="text" wire:model.live="billingStreet" class="mt-1 w-full border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['billingStreet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">City</label>
                    <input type="text" wire:model.live="billingCity" class="mt-1 w-full border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['billingCity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">State</label>
                    <input type="text" wire:model.live="billingState" class="mt-1 w-full border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['billingState'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Landmark</label>
                    <input type="text" wire:model.live="billingLandmark" class="mt-1 w-full border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['billingLandmark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" wire:model.live="companyName" class="mt-1 w-full border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['companyName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">GST No</label>
                    <input type="text" wire:model.live="gstNo" class="mt-1 w-full border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['gstNo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h3 class="text-base font-semibold text-gray-900">Shipping Details</h3>
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" wire:model.live="shippingSameAsBilling" class="rounded border-gray-300">
                    Same as billing
                </label>
            </div>

            <!--[if BLOCK]><![endif]--><?php if(! $shippingSameAsBilling): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" wire:model.live="shippingName" class="mt-1 w-full border-gray-300 rounded-md">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['shippingName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Email</label>
                        <input type="email" wire:model.live="shippingEmail" class="mt-1 w-full border-gray-300 rounded-md">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['shippingEmail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" wire:model.live="shippingPhone" class="mt-1 w-full border-gray-300 rounded-md">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['shippingPhone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Alternate Phone</label>
                        <input type="text" wire:model.live="shippingAlternatePhone" class="mt-1 w-full border-gray-300 rounded-md">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['shippingAlternatePhone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Zip / Postal Code</label>
                        <input type="text" wire:model.live="shippingZip" class="mt-1 w-full border-gray-300 rounded-md">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['shippingZip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Locality</label>
                        <input type="text" wire:model.live="shippingLocality" class="mt-1 w-full border-gray-300 rounded-md">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['shippingLocality'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Street</label>
                        <input type="text" wire:model.live="shippingStreet" class="mt-1 w-full border-gray-300 rounded-md">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['shippingStreet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">City</label>
                        <input type="text" wire:model.live="shippingCity" class="mt-1 w-full border-gray-300 rounded-md">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['shippingCity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">State</label>
                        <input type="text" wire:model.live="shippingState" class="mt-1 w-full border-gray-300 rounded-md">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['shippingState'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Landmark</label>
                        <input type="text" wire:model.live="shippingLandmark" class="mt-1 w-full border-gray-300 rounded-md">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['shippingLandmark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            <?php else: ?>
                <p class="text-sm text-gray-600">Shipping details will match billing details.</p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Order Items</h3>

                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['cart'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mb-3"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if(empty($cartItems)): ?>
                    <div class="text-sm text-gray-500">No items in this order yet.</div>
                <?php else: ?>
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <div class="font-medium text-gray-900"><?php echo e($item['name']); ?></div>
                                        <div class="text-xs text-gray-500">
                                            Price: <?php echo e(number_format($item['price'], 2)); ?>

                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="number"
                                               min="1"
                                               wire:model.live.debounce.500ms="quantities.<?php echo e($item['id']); ?>"
                                               class="w-20 border-gray-300 rounded-md">
                                        <button type="button"
                                                wire:click="updateQuantity('<?php echo e($item['id']); ?>')"
                                                class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                                            Update
                                        </button>
                                        <button type="button"
                                                wire:click="removeItem('<?php echo e($item['id']); ?>')"
                                                class="px-3 py-1 text-xs bg-red-50 text-red-700 border border-red-200 rounded-md hover:bg-red-100">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500 mt-2">
                                    Line Total: <?php echo e(number_format($item['price'] * ($quantities[$item['id']] ?? $item['quantity']), 2)); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <div class="mt-6 border-t pt-4 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span><?php echo e(number_format($subtotal, 2)); ?></span>
                    </div>
                    <div class="flex justify-between font-semibold text-gray-900 mt-2">
                        <span>Total</span>
                        <span><?php echo e(number_format($total, 2)); ?></span>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Add Products</h3>
                <div class="flex flex-wrap gap-3 mb-4">
                    <input type="text"
                           wire:model.live="search"
                           placeholder="Search by name or description"
                           class="flex-1 min-w-[200px] border-gray-300 rounded-md">
                    <select wire:model.live="categoryId" class="border-gray-300 rounded-md">
                        <option value="">All Categories</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>

                <!--[if BLOCK]><![endif]--><?php if($products->isEmpty()): ?>
                    <p class="text-sm text-gray-500">No products found with the selected filters.</p>
                <?php else: ?>
                    <div class="space-y-3 max-h-[460px] overflow-y-auto pr-2">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <div class="font-medium text-gray-900"><?php echo e($product->name); ?></div>
                                        <div class="text-xs text-gray-500">
                                            Base Price: <?php echo e(number_format($product->price, 2)); ?>

                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <!--[if BLOCK]><![endif]--><?php if($product->priceAttributes->isNotEmpty()): ?>
                                            <select wire:model.live="selectedAttributes.<?php echo e($product->id); ?>"
                                                    class="border-gray-300 rounded-md text-xs">
                                                <option value="">Select price option</option>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $product->priceAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($attribute->id); ?>">
                                                        <?php echo e($attribute->name); ?> - <?php echo e(number_format($attribute->price, 2)); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <button type="button"
                                                wire:click="addProduct(<?php echo e($product->id); ?>)"
                                                class="px-3 py-1 text-xs bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-md hover:bg-indigo-100">
                                            Add
                                        </button>
                                    </div>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if(!empty($addErrors[$product->id])): ?>
                                    <p class="text-xs text-red-600 mt-2"><?php echo e($addErrors[$product->id]); ?></p>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="<?php echo e(route('admin.orders.index')); ?>"
               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                Cancel
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Save Changes
            </button>
        </div>
    </form>

    <div wire:loading.flex class="fixed inset-0 bg-white/60 items-center justify-center z-50">
        <div class="flex items-center gap-2 text-sm text-gray-700">
            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span>Saving...</span>
        </div>
    </div>
</div>

    <?php
        $__scriptKey = '2834287603-0';
        ob_start();
    ?>
<script>
    $wire.on('notify', (event) => {
        alert(event[0].message);
    });
</script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/livewire/admin/edit-order-component.blade.php ENDPATH**/ ?>