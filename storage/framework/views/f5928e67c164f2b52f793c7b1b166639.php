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
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Order Details
            </h2>

            <a href="<?php echo e(route('orders.index')); ?>"
               class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm hover:bg-gray-700">
                ← Back to My Orders
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto p-6 space-y-6">

        
        <div class="flex flex-wrap justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Order #<?php echo e($order->order_number ?? $order->id); ?>

                </h1>
                <p class="text-sm text-gray-500">
                    Placed on <?php echo e($order->created_at->format('d M Y, h:i A')); ?>

                </p>
            </div>

            <div class="flex gap-2">
                
                <span class="px-3 py-1 text-sm rounded-full font-semibold
                    <?php echo e($order->payment_status === 'success'
                        ? 'bg-green-100 text-green-700'
                        : ($order->payment_status === 'processing'
                            ? 'bg-yellow-100 text-yellow-700'
                            : 'bg-red-100 text-red-700')); ?>">
                    💳 <?php echo e(ucfirst($order->payment_status)); ?>

                </span>

                
                <span class="px-3 py-1 text-sm rounded-full font-semibold
                    <?php echo e($order->order_status === 'complete'
                        ? 'bg-green-100 text-green-700'
                        : ($order->order_status === 'dispatched'
                            ? 'bg-purple-100 text-purple-700'
                            : ($order->order_status === 'confirmed'
                                ? 'bg-blue-100 text-blue-700'
                                : 'bg-yellow-100 text-yellow-700'))); ?>">
                    📦 <?php echo e(ucfirst($order->order_status)); ?>

                </span>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            
            <div class="bg-white p-5 rounded-lg shadow">
                <h2 class="font-semibold text-lg mb-3">🏠 Billing Address</h2>
                <p class="text-sm text-gray-700 leading-relaxed">
                    <?php echo e($order->billing_name); ?> <br>
                    <?php echo e($order->billing_street); ?> <br>
                    <?php echo e($order->billing_locality); ?> <br>
                    <?php echo e($order->billing_city); ?>,
                    <?php echo e($order->billing_state); ?> - <?php echo e($order->billing_zip); ?> <br>
                    Phone: <?php echo e($order->billing_phone); ?>

                </p>
            </div>

            
            <div class="bg-white p-5 rounded-lg shadow">
                <h2 class="font-semibold text-lg mb-3">🚚 Shipping Address</h2>

                <?php if($order->shipping_same_as_billing): ?>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        <?php echo e($order->billing_street); ?><br>
                        <?php echo e($order->billing_locality); ?><br>
                        <?php echo e($order->billing_city); ?>, <?php echo e($order->billing_state); ?> - <?php echo e($order->billing_zip); ?><br>
                        <?php if($order->billing_landmark): ?>
                            Landmark: <?php echo e($order->billing_landmark); ?>

                        <?php endif; ?>
                    </p>
                <?php else: ?>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        <?php echo e($order->shipping_street); ?> <br>
                        <?php echo e($order->shipping_locality); ?> <br>
                        <?php echo e($order->shipping_city); ?>,
                        <?php echo e($order->shipping_state); ?> - <?php echo e($order->shipping_zip); ?>

                    </p>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="bg-white p-5 rounded-lg shadow">
            <h2 class="font-semibold text-lg mb-4">🛒 Ordered Items</h2>

            <table class="w-full text-sm border rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Product</th>
                        <th class="p-3 text-center">Qty</th>
                        <th class="p-3 text-right">Price</th>
                        <th class="p-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $order->orderitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $image = $item->product->primaryImage;
                        ?>
                        <tr class="border-t">
                            <td class="p-3">
                                <div class="flex gap-3 items-center">
                                    <img src="<?php echo e($image
                                            ? env('IMG_HOST').'uploads/'.$image->path
                                            : asset('images/buy.jpg')); ?>"
                                         class="h-14 w-14 rounded object-cover" height="60px" width="60px">

                                    <div>
                                        <div class="font-medium">
                                            <?php echo e($item->product->name); ?>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3 text-center"><?php echo e($item->quantity); ?></td>
                            <td class="p-3 text-right">₹<?php echo e(number_format($item->price, 2)); ?></td>
                            <td class="p-3 text-right font-semibold">
                                ₹<?php echo e(number_format($item->price * $item->quantity, 2)); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <div class="bg-white p-6 rounded-lg shadow text-right">
            <p class="text-sm text-gray-500">Subtotal</p>
            <p class="text-lg font-semibold mb-2">
                ₹<?php echo e(number_format($order->subtotal ?? $order->total, 2)); ?>

            </p>

            <p class="text-xl font-bold text-gray-800">
                Grand Total: ₹<?php echo e(number_format($order->total, 2)); ?>

            </p>
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
<?php /**PATH /home/ace85084/public_html/shop.swetonspeakers.com/resources/views/orders/show.blade.php ENDPATH**/ ?>