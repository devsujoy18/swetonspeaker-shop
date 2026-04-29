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
            <?php echo e(__('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['isAdmin','isSubadmin'])): ?>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Total Orders','value' => ''.e($totalOrders).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Total Orders','value' => ''.e($totalOrders).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Revenue','value' => '₹'.e(number_format($totalRevenue, 2)).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Revenue','value' => '₹'.e(number_format($totalRevenue, 2)).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Total Users','value' => ''.e($totalUsers).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Total Users','value' => ''.e($totalUsers).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Pending Orders','value' => ''.e($pendingOrders).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Pending Orders','value' => ''.e($pendingOrders).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-4 shadow rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Orders (Last 7 Days)</h3>
                    <canvas id="ordersChart"></canvas>
                </div>
                <div class="bg-white p-4 shadow rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Revenue (Last 7 Days)</h3>
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
                
                <div class="bg-white p-4 shadow rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold">Latest Orders</h3>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-sm text-blue-600 hover:underline">
                            View All →
                        </a>
                    </div>
            
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="p-2 text-left">Order</th>
                                <th class="p-2 text-left">Customer</th>
                                <th class="p-2 text-center">Payment</th>
                                <th class="p-2 text-center">Status</th>
                                <th class="p-2 text-right">Total</th>
                                <th class="p-2 text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $latestOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-2 font-medium"><?php echo e($order->order_number); ?></td>
                                <td class="p-2"><?php echo e($order->billing_name); ?></td>
            
                                
                                <td class="p-2 text-center">
                                    <span class="
                                        px-3 py-1 text-xs rounded-full font-semibold border 
                                        <?php if($order->payment_status === 'processing'): ?>
                                            bg-yellow-100 text-yellow-700 border-yellow-300
                                        <?php elseif($order->payment_status === 'success'): ?>
                                            bg-green-100 text-green-700 border-green-300
                                        <?php else: ?>
                                            bg-red-100 text-red-700 border-red-300
                                        <?php endif; ?>
                                    ">
                                        <?php echo e(ucfirst($order->payment_status)); ?>

                                    </span>
                                </td>
            
                                
                                <td class="p-2 text-center">
                                    <?php
                                        $status = $order->order_status;

                                        $map = [
                                            'processing' => ['icon' => '⏳', 'bg' => 'bg-yellow-100 text-yellow-700 border-yellow-300'],
                                            'confirmed' => ['icon' => '✔️', 'bg' => 'bg-blue-100 text-blue-700 border-blue-300'],
                                            'dispatched' => ['icon' => '🚚', 'bg' => 'bg-purple-100 text-purple-700 border-purple-300'],
                                            'complete' => ['icon' => '📦', 'bg' => 'bg-green-100 text-green-700 border-green-300'],
                                            'cancelled' => ['icon' => '❌', 'bg' => 'bg-red-100 text-red-700 border-red-300'],
                                        ];

                                        $icon = $map[$status]['icon'] ?? '📄';
                                        $style = $map[$status]['bg'] ?? 'bg-gray-100 text-gray-700 border-gray-300';
                                    ?>

                                    <span class="px-3 py-1 text-xs rounded-full font-semibold border <?php echo e($style); ?>">
                                        <?php echo e(ucfirst($status)); ?>

                                    </span>
                                </td>
            
                                <td class="p-2 text-right font-semibold">₹<?php echo e(number_format($order->total, 2)); ?></td>
                                <td class="p-2 text-right text-gray-600 text-xs">
                                    <?php echo e($order->order_date->format('d M, Y')); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
    
                
                <div class="bg-white p-4 shadow rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold">Latest Registered Users</h3>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAdmin')): ?>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="text-sm text-blue-600 hover:underline">
                            View All →
                        </a>
                        <?php endif; ?>
                        
                    </div>
            
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="p-2 text-left">Name</th>
                                <th class="p-2 text-left">Email</th>
                                <th class="p-2 text-left">Phone</th>
                                <th class="p-2 text-right">Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $latestUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-2 font-medium"><?php echo e($user->name); ?></td>
                                <td class="p-2"><?php echo e($user->email); ?></td>
                                <td class="p-2">
                                    <?php echo e($user->phone ?? '—'); ?>

                                </td>
                                <td class="p-2 text-right text-gray-600 text-xs">
                                    <?php echo e($user->created_at->format('d M, Y')); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isUser')): ?>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">

                
                <div class="bg-white p-6 shadow rounded-lg">
                    <h2 class="text-xl font-semibold">
                        Hello, <?php echo e($user->name); ?> 👋
                    </h2>
                    <p class="text-gray-600 text-sm mt-1">
                        Welcome to your dashboard. Manage your orders & account here.
                    </p>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="bg-white p-5 shadow rounded-lg">
                        <p class="text-gray-600 text-sm">Total Orders</p>
                        <h3 class="text-2xl font-bold mt-1"><?php echo e($totalOrders); ?></h3>
                    </div>

                    <div class="bg-white p-5 shadow rounded-lg">
                        <p class="text-gray-600 text-sm">Active Orders</p>
                        <h3 class="text-2xl font-bold mt-1"><?php echo e($activeOrders); ?></h3>
                    </div>

                    <div class="bg-white p-5 shadow rounded-lg">
                        <p class="text-gray-600 text-sm">Pending Payments</p>
                        <h3 class="text-2xl font-bold mt-1"><?php echo e($pendingPayments); ?></h3>
                    </div>

                </div>

                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <a href="<?php echo e(route('profile.edit')); ?>"
                        class="bg-white p-5 shadow rounded-lg text-center hover:bg-gray-50">
                        <p class="font-semibold">Profile</p>
                    </a>

                    <a href="<?php echo e(route('profile.edit')); ?>"
                        class="bg-white p-5 shadow rounded-lg text-center hover:bg-gray-50">
                        <p class="font-semibold">Addresses</p>
                    </a>

                    <a href="<?php echo e(route('orders.index')); ?>"
                        class="bg-white p-5 shadow rounded-lg text-center hover:bg-gray-50">
                        <p class="font-semibold">My Orders</p>
                    </a>

                    <a href="https://swetonspeakers.com/contact-us" target="_blank"
                        class="bg-white p-5 shadow rounded-lg text-center hover:bg-gray-50">
                        <p class="font-semibold">Support</p>
                    </a>
                </div>

                
                <div class="bg-white p-6 shadow rounded-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Recent Orders</h3>
                        <a href="<?php echo e(route('orders.index')); ?>" class="text-blue-600 text-sm hover:underline">
                            View All →
                        </a>
                    </div>

                    <?php if($recentOrders->count()): ?>
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="p-2 text-left">Order</th>
                                    <th class="p-2 text-center">Status</th>
                                    <th class="p-2 text-center">Payment</th>
                                    <th class="p-2 text-right">Total</th>
                                    <th class="p-2 text-right">Date</th>
                                    <th class="p-2 text-center">Track your order</th>
                                    <th class="p-2 text-right">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $hide = $order->order_status == 'processing'
                                                && $order->payment_status == 'processing'
                                                && $order->created_at->lt(now()->subHours(24));
                                    ?>

                                    <?php if($hide): ?>
                                        <?php continue; ?>
                                    <?php endif; ?>
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="p-2 font-semibold"><?php echo e($order->order_number); ?></td>

                                        <td class="p-2 text-center">
                                            <span class="px-2 py-1 text-xs rounded
                                                <?php if($order->order_status=='processing'): ?> bg-yellow-100 text-yellow-700
                                                <?php elseif($order->order_status=='confirmed'): ?> bg-blue-100 text-blue-700
                                                <?php elseif($order->order_status=='dispatched'): ?> bg-purple-100 text-purple-700
                                                <?php elseif($order->order_status=='complete'): ?> bg-green-100 text-green-700
                                                <?php elseif($order->order_status=='cancelled'): ?> bg-red-100 text-red-700
                                                <?php else: ?> bg-gray-100 text-gray-700 <?php endif; ?>">
                                                <?php echo e(ucfirst($order->order_status)); ?>

                                            </span>
                                        </td>

                                        <td class="p-2 text-center">
                                            <span class="
                                                px-3 py-1 text-xs rounded-full font-semibold border 
                                                <?php if($order->payment_status === 'processing'): ?>
                                                    bg-yellow-100 text-yellow-700 border-yellow-300
                                                <?php elseif($order->payment_status === 'success'): ?>
                                                    bg-green-100 text-green-700 border-green-300
                                                <?php else: ?>
                                                    bg-red-100 text-red-700 border-red-300
                                                <?php endif; ?>
                                            ">
                                                <?php echo e(ucfirst($order->payment_status)); ?>

                                            </span>
                                        </td>

                                        <td class="p-2 text-right">₹<?php echo e(number_format($order->total, 2)); ?></td>

                                        <td class="p-2 text-right text-gray-600 text-xs">
                                            <?php echo e($order->created_at->format('d M Y')); ?>

                                        </td>

                                        <td class="p-2 text-left text-gray-600 text-xs">
                                            <?php if(!empty($order->awb_number) && $order->payment_status == 'success'): ?>
                                                <?php if($order->awb_partner == 'Delhivery'): ?>
                                                    <p>Your order has been despatched through Delhivery Courier. AWB number is <strong><?php echo e($order->awb_number); ?></strong> . You can track your order at <a href="https://www.delhivery.com/" target="_blank">www.Delhivery.com</a>. This completes your order. Thank You for placing order with us.</p>
                                                <?php elseif($order->awb_partner == 'Bluedart'): ?>
                                                    <p>Your order has been despatched through Blue Dart Courier. Waybill number is <strong><?php echo e($order->awb_number); ?></strong> .You can track your order at <a href="https://bluedart.com/tracking/" target="_blank">https://bluedart.com/tracking</a>. This completes your order. Thank You for placing order with us.</p>
                                                <?php endif; ?>
                                            <?php elseif($order->order_status == 'dispatched' && empty($order->awb_number)): ?>
                                                <p>Packed and ready to be shipped</p>
                                            <?php elseif($order->payment_status == 'success'): ?>
                                                <p>Within 5 working days it will be despatched, tracking code will be sent to your phone & email and it will be shown here also.</p>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>

                                        <td class="p-2 text-right">
                                            <a href="<?php echo e(route('orders.show', $order->order_number)); ?>"
                                            class="text-blue-600 hover:underline">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-gray-600 text-sm">No recent orders.</p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['isAdmin','isSubadmin'])): ?>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('ordersChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($dates, 15, 512) ?>,
                datasets: [{
                    label: 'Orders',
                    data: <?php echo json_encode($ordersData, 15, 512) ?>,
                    borderWidth: 2
                }]
            }
        });

        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($dates, 15, 512) ?>,
                datasets: [{
                    label: 'Revenue',
                    data: <?php echo json_encode($revenueData, 15, 512) ?>,
                    borderWidth: 2
                }]
            }
        });
    </script>
    <?php endif; ?>
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
<?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/dashboard.blade.php ENDPATH**/ ?>