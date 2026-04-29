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
    <div class="max-w-7xl mx-auto p-6 space-y-6">

        
        <div class="flex flex-wrap justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Order #<?php echo e($order->order_number); ?>

                </h1>
                <p class="text-sm text-gray-500">
                    Placed on <?php echo e($order->order_date?->format('d M Y, h:i A')); ?>

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

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-500">Order Serial No</p>
                <p class="font-semibold"><?php echo e($order->order_sl_no ?? '—'); ?></p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-500">Payment Method</p>
                <p class="font-semibold uppercase"><?php echo e($order->payment_method); ?></p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-500">Transaction ID</p>
                <p class="font-semibold break-all"><?php echo e($order->transaction_id ?? '—'); ?></p>
            </div>
        </div>

        
        <div class="bg-white p-5 rounded-lg shadow">
            <h2 class="font-semibold text-lg mb-3">👤 Customer Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <p><strong>Name:</strong> <?php echo e($order->billing_name); ?></p>
                <p><strong>Email:</strong> <?php echo e($order->billing_email); ?></p>
                <p><strong>Phone:</strong> <?php echo e($order->billing_phone); ?></p>

                <?php if($order->billing_alternate_phone): ?>
                    <p><strong>Alt Phone:</strong> <?php echo e($order->billing_alternate_phone); ?></p>
                <?php endif; ?>

                <?php if($order->company_name): ?>
                    <p><strong>Company:</strong> <?php echo e($order->company_name); ?></p>
                <?php endif; ?>

                <?php if($order->gst_no): ?>
                    <p><strong>GST No:</strong> <?php echo e($order->gst_no); ?></p>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            
            <div class="bg-white p-5 rounded-lg shadow">
                <h2 class="font-semibold text-lg mb-3">🏠 Billing Address</h2>
                <p class="text-sm text-gray-700 leading-relaxed">
                    <?php echo e($order->billing_street); ?><br>
                    <?php echo e($order->billing_locality); ?><br>
                    <?php echo e($order->billing_city); ?>, <?php echo e($order->billing_state); ?> - <?php echo e($order->billing_zip); ?><br>
                    <?php if($order->billing_landmark): ?>
                        Landmark: <?php echo e($order->billing_landmark); ?>

                    <?php endif; ?>
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
                        <?php echo e($order->shipping_street); ?><br>
                        <?php echo e($order->shipping_locality); ?><br>
                        <?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> - <?php echo e($order->shipping_zip); ?><br>
                        <?php if($order->shipping_landmark): ?>
                            Landmark: <?php echo e($order->shipping_landmark); ?>

                        <?php endif; ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="bg-white p-5 rounded-lg shadow">
            <h2 class="font-semibold text-lg mb-4">🛒 Order Items</h2>

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
                            $image = $item->product?->primaryImage;
                        ?>
                        <tr class="border-t">
                            <td class="p-3">
                                <div class="flex gap-3 items-center">
                                    <img src="<?php echo e($image
                                            ? env('IMG_HOST').'uploads/'.$image->path
                                            : asset('images/buy.jpg')); ?>"
                                         class="h-14 w-14 rounded object-cover" height="60px" width="60px">
                                         
                                    <div class="font-medium"><?php echo e($item->product_name); ?></div>
                                    <?php if($item->shop_description): ?>
                                        <div class="text-xs text-gray-500"><?php echo e($item->shop_description); ?></div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="p-3 text-center"><?php echo e($item->quantity); ?></td>
                            <td class="p-3 text-right">₹<?php echo e(number_format($item->price, 2)); ?></td>
                            <td class="p-3 text-right font-semibold">
                                ₹<?php echo e(number_format($item->total, 2)); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <div class="bg-white p-5 rounded-lg shadow">
            <h2 class="font-semibold text-lg mb-2">📦 Shipping / AWB</h2>

            <?php if($order->awb_partner): ?>
                <p class="text-sm">
                    <strong>Partner:</strong> <?php echo e($order->awb_partner); ?> <br>
                    <strong>Tracking No:</strong> <?php echo e($order->awb_number ?? '—'); ?>

                </p>
            <?php else: ?>
                <p class="text-sm text-gray-500 italic">AWB not assigned yet</p>
            <?php endif; ?>
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
<?php endif; ?><?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/orders/show_details.blade.php ENDPATH**/ ?>