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
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-700 mb-6" aria-label="breadcrumb">
                <ol class="flex space-x-2">
                    <li>
                        <a href="<?php echo e(route('home')); ?>" class="text-blue-600 hover:underline">Home</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li>
                        <a href="<?php echo e(route('checkout.success', $order->order_number)); ?>" class="text-blue-600 hover:underline">Checkout</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li class="text-gray-800 font-medium">Success</li>
                </ol>
            </nav>

            <!-- Success Card -->
            <div class="bg-white shadow-lg rounded-2xl p-8 text-center">
                <div class="flex justify-center mb-4">
                    <div class="bg-green-100 text-green-600 w-16 h-16 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Thank you for your order!</h1>
                <p class="text-gray-600 mb-6">Your order has been placed successfully. A confirmation email has been sent to <span class="font-medium"><?php echo e($order->billing_email); ?></span>.</p>

                <!-- Order Summary -->
                <div class="border rounded-xl p-6 text-left max-w-2xl mx-auto bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h2>
                    <p><span class="font-medium">Order Number:</span> <?php echo e($order->order_number); ?></p>
                    <p><span class="font-medium">Order Date:</span> <?php echo e($order->order_date ? $order->order_date->format('d M Y, h:i A') : $order->created_at->format('d M Y, h:i A')); ?></p>
                    <p><span class="font-medium">Payment Method:</span> <?php echo e(strtoupper($order->payment_method)); ?></p>
                    <p><span class="font-medium">Payment Status:</span> 
                        <span class="px-2 py-1 text-xs rounded-full 
                            <?php if($order->payment_status === 'success'): ?> bg-green-200 text-green-800 
                            <?php elseif($order->payment_status === 'processing'): ?> bg-yellow-200 text-yellow-800 
                            <?php else: ?> bg-red-200 text-red-800 <?php endif; ?>">
                            <?php echo e(ucfirst($order->payment_status)); ?>

                        </span>
                    </p>
                    <p><span class="font-medium">Order Status:</span> <?php echo e(ucfirst($order->order_status)); ?></p>
                </div>

                <!-- Items List -->
                <div class="mt-6 border rounded-xl p-6 max-w-2xl mx-auto bg-white">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Items</h2>
                    <ul class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $order->orderitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="py-3 flex justify-between">
                                <div>
                                    <p class="font-medium text-gray-800"><?php echo e($item->product_name); ?> <?php if($item->shop_description): ?> ( <?php echo e($item->shop_description); ?> ) <?php endif; ?></p>
                                    <p class="text-sm text-gray-500">Qty: <?php echo e($item->quantity); ?> × <?php echo e(number_format($item->price, 2)); ?></p>
                                </div>
                                <p class="font-medium text-gray-800">₹<?php echo e(number_format($item->total, 2)); ?></p>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    <div class="border-t mt-4 pt-4 flex justify-between font-semibold text-lg">
                        <span>Total</span>
                        <span>₹<?php echo e(number_format($order->total, 2)); ?></span>
                    </div>
                </div>

                <!-- CTA -->
                <div class="mt-8 flex justify-center gap-4">
                    <a href="<?php echo e(route('home')); ?>" class="bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700 transition">
                        Continue Shopping
                    </a>
                    <a href="<?php echo e(route('orders.show', $order->order_number)); ?>" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-xl hover:bg-gray-200 transition">
                        View My Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9d41032d5dde91ab243771384dacb5df)): ?>
<?php $attributes = $__attributesOriginal9d41032d5dde91ab243771384dacb5df; ?>
<?php unset($__attributesOriginal9d41032d5dde91ab243771384dacb5df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9d41032d5dde91ab243771384dacb5df)): ?>
<?php $component = $__componentOriginal9d41032d5dde91ab243771384dacb5df; ?>
<?php unset($__componentOriginal9d41032d5dde91ab243771384dacb5df); ?>
<?php endif; ?>
<?php /**PATH /home/ace85084/public_html/shop.swetonspeakers.com/resources/views/checkout_success.blade.php ENDPATH**/ ?>