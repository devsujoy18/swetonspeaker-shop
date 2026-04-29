<div>
    <style>
        table-wrap:overflow-x: auto;
    </style>
     
    <div class="mb-4 flex flex-wrap gap-4 bg-gray-50 p-4 rounded-lg shadow">
        <input type="text" wire:model.live="search" placeholder="SEARCH BY ORDER NO." class="border-gray-300 rounded-md">
        
        <select wire:model.live="orderStatus" wire:loading.attr="disabled" class="border-gray-300 rounded-md">
            <option value="" selected>Order Status</option>
            <option value="processing">Processing</option>
            <option value="confirmed">Confirmed</option>
            <option value="dispatched">Despatched</option>
            <option value="complete">Delivered</option>
        </select>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAdmin')): ?>
        <select wire:model.live="paymentStatus" wire:loading.attr="disabled" class="border-gray-300 rounded-md">
            <option value="" selected>Payment Status</option>
            <option value="success">Success</option>
            <option value="processing">Processing</option>
            <option value="cancelled">Cancelled</option>
        </select>
        <?php endif; ?>
        <select wire:model.live="deliveryPartner" wire:loading.attr="disabled" class="border-gray-300 rounded-md">
            <option value="" selected>Delivery Partner</option>
            <option value="none">Not Set</option>
            <option value="Delhivery">Delhivery</option>
            <option value="Bluedart">Bluedart</option>
        </select>
        <input type="date" wire:model.live="dateFrom" class="border-gray-300 rounded-md">
        <input type="date" wire:model.live="dateTo" class="border-gray-300 rounded-md">
        
        <select wire:model.live="isModified" class="border-gray-300 rounded-md">
            <option value="">All Orders</option>
            <option value="1">Modified Only</option>
        </select>
        
        <button wire:click="resetFilters" type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
            Reset
        </button>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="table-wrap p-6 text-gray-900">
            <table class="table-freeze w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Order #</th>
                        <th class="px-4 py-2">Customer</th>
                        <th class="px-4 py-2">Type</th>
                        
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Payment</th>
                        <th class="px-4 py-2">Delivery Partner</th>
                        <th class="px-4 py-2">Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php
                        $tooltip = '';
                        if ($order->awb_partner === 'Delhivery') {
                            $tooltip = 'Delhivery';
                        } elseif ($order->awb_partner === 'Bluedart') {
                            $tooltip = 'Bluedart';
                        }
                    ?>
                    
                    <tr class="border-b hover:bg-gray-50 
                    <?php if($order->awb_partner === 'Delhivery'): ?>
                        bg-indigo-50 hover:bg-indigo-100
                    <?php elseif($order->awb_partner === 'Bluedart'): ?>
                        bg-gray-100 hover:bg-gray-200
                    <?php endif; ?>
                    " 
                    <?php if($tooltip): ?>
                        title="Delivery Partner: <?php echo e($tooltip); ?>"
                    <?php endif; ?>
                    wire:key="order-<?php echo e($order->id); ?>">
                        <td class="px-4 py-2">
                            <?php echo e($order->order_number); ?>

                            
                            <!--[if BLOCK]><![endif]--><?php if($order->is_modified == 1): ?>
                                <span class="ml-2 px-2 py-0.5 text-[10px] font-semibold 
                                    bg-yellow-100 text-yellow-800 border border-yellow-300 rounded-full">
                                    ✏️ Modified
                                </span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <div class="text-xs text-gray-500">
                                <?php echo e($order->order_date->diffForHumans()); ?>

                                <button 
                                    wire:click="toggleExpand(<?php echo e($order->id); ?>)"
                                    class="ml-2 flex items-center gap-1 transition-all duration-200
                                        <?php echo e($expandedOrderId === $order->id 
                                            ? 'text-indigo-600 scale-110' 
                                            : 'text-gray-500 hover:text-indigo-600'); ?>"
                                    title="Toggle details"
                                >
                                    <!-- Arrow icon -->
                                    <span 
                                        class="transition-transform duration-300"
                                        style="display:inline-block;"
                                    >
                                        <!--[if BLOCK]><![endif]--><?php if($expandedOrderId === $order->id): ?>
                                            ▲  
                                        <?php else: ?>
                                            ▼  
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </button>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium"><?php echo e($order->billing_name); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($order->billing_phone); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($order->billing_email); ?></div>
                        </td>
                        <!-- Type -->
                        <td class="px-4 py-3">
                            <!--[if BLOCK]><![endif]--><?php if($order->user): ?>
                                <!--[if BLOCK]><![endif]--><?php if($order->user->user_type === 'guest'): ?>
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Guest</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                        <?php echo e(ucfirst($order->user->user_type)); ?>

                                    </span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php else: ?>
                                <span class="px-2 py-1 text-xs bg-gray-200 text-gray-700 rounded-full">Unknown</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                        <!-- Phone -->
                        

                        <!-- Email -->
                        

                        <!-- Date -->
                        <td class="px-4 py-3">
                            <?php echo e($order->order_date->format('d M Y')); ?>

                        </td>

                        <!-- Total -->
                        <td class="px-4 py-3 font-bold text-gray-800">
                            ₹<?php echo e(number_format($order->total, 2)); ?>

                        </td>
                        <!-- Payment Status -->
                        <td class="px-4 py-3" x-data="{ paymentActionopen:false }" x-cloak>
                            
                            <div class="mb-1">
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
                                 <!--[if BLOCK]><![endif]--><?php if($order->payment_status == 'processing'): ?>
                                <button 
                                    @click="paymentActionopen = !paymentActionopen"
                                    class="p-1.5 rounded-md hover:bg-gray-100 text-gray-500 focus:outline-none"
                                    title="View payment actions"
                                >
                                    <span
                                        x-show="!paymentActionopen"
                                        class="inline-block text-sm transition-transform duration-200"
                                    >
                                        ▼
                                    </span>
                                    <span
                                        x-show="paymentActionopen"
                                        class="inline-block text-sm transition-transform duration-200"
                                    >
                                        ▲
                                    </span>
                                </button>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            
                            <!--[if BLOCK]><![endif]--><?php if($order->payment_status === 'processing'): ?>
                                <div class="flex items-center gap-2 mt-1" x-show="paymentActionopen">

                                    <!-- Mark as Success -->
                                    <button
                                        wire:click="updatePaymentStatus(<?php echo e($order->id); ?>, 'success')"
                                        wire:confirm="Mark payment as SUCCESS?"
                                        class="px-2 py-1 text-xs bg-green-100 text-green-700 
                                               border border-green-300 rounded-md hover:bg-green-200 transition">
                                        ✅ Success
                                    </button>

                                    <!-- Mark as Cancelled -->
                                    <button
                                        wire:click="updatePaymentStatus(<?php echo e($order->id); ?>, 'cancelled')"
                                        wire:confirm="Mark payment as CANCELLED?"
                                        class="px-2 py-1 text-xs bg-red-100 text-red-700 
                                               border border-red-300 rounded-md hover:bg-red-200 transition">
                                        ❌ Cancel
                                    </button>

                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>

                        <td class="px-4 py-3 font-bold text-gray-800">
                           <!--[if BLOCK]><![endif]--><?php if($order->awb_partner === 'Delhivery'): ?>
                                <div class="font-medium">Shipping Partner: Delhivery</div>
                                <div class="text-xs text-gray-500">Reference Number: <?php echo e($order->awb_number ?? 'Not Set'); ?></div>
                            <?php elseif($order->awb_partner === 'Bluedart'): ?>
                                <div class="font-medium">Shipping Partner: Bluedart</div>
                                <div class="text-xs text-gray-500">Tracking Number: <?php echo e($order->awb_number ?? 'Not Set'); ?></div>
                            <?php else: ?>
                                <div class="font-medium">Not Set</div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]--> 
                        </td>
                        
                        <!-- Order Status -->
                        <td class="px-4 py-3" x-data="{ statusActionopen:false }" x-cloak>
                            
                            <?php
                                $style = $this->getStatusStyle($order->order_status);
                            ?>
                             <div class="mb-2">
                                <span class="px-3 py-1 text-xs rounded-full font-semibold border <?php echo e($style['bg']); ?>">
                                    <?php echo e($style['icon']); ?> <?php echo e(ucfirst($order->order_status)); ?>

                                </span>
                                
                                <!--[if BLOCK]><![endif]--><?php if($order->order_status !== 'cancelled' && $order->order_status !== 'complete'): ?>
                                <button 
                                    @click="statusActionopen = !statusActionopen"
                                    class="p-1.5 rounded-md hover:bg-gray-100 text-gray-500 focus:outline-none"
                                    title="View payment actions"
                                >
                                    <span
                                        x-show="!statusActionopen"
                                        class="inline-block text-sm transition-transform duration-200"
                                    >
                                        ▼
                                    </span>
                                    <span
                                        x-show="statusActionopen"
                                        class="inline-block text-sm transition-transform duration-200"
                                    >
                                        ▲
                                    </span>
                                </button>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            
                            <!--[if BLOCK]><![endif]--><?php if($order->order_status === 'processing'): ?>
                                <div class="flex gap-2" x-show="statusActionopen">

                                    <button
                                        wire:click="updateOrderStatus(<?php echo e($order->id); ?>, 'confirmed')"
                                        wire:confirm="Mark order as CONFIRMED?"
                                        class="px-2 py-1 text-xs bg-blue-100 text-blue-700 border border-blue-300
                                               rounded-md hover:bg-blue-200 transition">
                                        ✔ Confirm?
                                    </button>

                                    <button
                                        wire:click="updateOrderStatus(<?php echo e($order->id); ?>, 'cancelled')"
                                        wire:confirm="Cancel this order?"
                                        class="px-2 py-1 text-xs bg-red-100 text-red-700 border border-red-300
                                               rounded-md hover:bg-red-200 transition">
                                        ❌ Cancel?
                                    </button>

                                </div>

                            <?php elseif($order->order_status === 'confirmed'): ?>
                                <button
                                    x-show="statusActionopen"
                                    wire:click="updateOrderStatus(<?php echo e($order->id); ?>, 'dispatched')"
                                    wire:confirm="Mark as DISPATCHED?"
                                    class="px-2 py-1 text-xs bg-purple-100 text-purple-700 border border-purple-300
                                           rounded-md hover:bg-purple-200 transition">
                                    🚚 Dispatch?
                                </button>

                            <?php elseif($order->order_status === 'dispatched'): ?>
                                <button
                                    x-show="statusActionopen"
                                    wire:click="updateOrderStatus(<?php echo e($order->id); ?>, 'complete')"
                                    wire:confirm="Mark order as COMPLETE?"
                                    class="px-2 py-1 text-xs bg-green-100 text-green-700 border border-green-300
                                           rounded-md hover:bg-green-200 transition">
                                    📦 Complete?
                                </button>

                            <?php else: ?>
                                <span class="text-xs text-gray-500 italic">No actions available</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>

                        <!-- Payment Method -->
                        
                        
                    </tr>

                    <!--[if BLOCK]><![endif]--><?php if($expandedOrderId === $order->id): ?>
                        <tr class="bg-gray-50">
                            <td colspan="8" class="p-3">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="col-span-2">
                                        <!--[if BLOCK]><![endif]--><?php if($order->payment_status === 'success' && ($order->order_status === 'confirmed' || $order->order_status === 'dispatched' || $order->order_status === 'complete')): ?>

                                            
                                            <!--[if BLOCK]><![endif]--><?php if($order->awb_partner): ?>
                                                <div class="bg-white border shadow-sm rounded-lg p-4">
                                                    <div class="text-sm text-gray-700">
                                                        <strong>Shipping Partner:</strong> <?php echo e(ucfirst($order->awb_partner)); ?> <br>
                                                        <strong>Reference / Tracking Number:</strong> <?php echo e($order->awb_number ?? 'Not Set'); ?> <br>
                                                        <!--[if BLOCK]><![endif]--><?php if($order->awb_message): ?>
                                                            <strong>Message:</strong> <?php echo e($order->awb_message); ?>

                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>

                                                    <button 
                                                        wire:click="openAwbModal(<?php echo e($order->id); ?>)"
                                                        class="mt-2 text-indigo-600 hover:underline text-sm"
                                                    >
                                                        ✏️ Edit AWB
                                                    </button>
                                                </div>
                                            <?php else: ?>
                                                <button 
                                                    wire:click="openAwbModal(<?php echo e($order->id); ?>)"
                                                    class="px-3 py-2 bg-indigo-50 text-indigo-700 rounded-md hover:bg-indigo-100 font-semibold shadow-sm border border-indigo-200"
                                                >
                                                    🚚 AWB & Message
                                                </button>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]--> 
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAdmin')): ?>
                                                 
                                                <button 
                                                    wire:click="resendUserEmail(<?php echo e($order->id); ?>)"
                                                    wire:confirm="Are you sure?"
                                                    class="px-3 py-2 bg-blue-50 text-blue-700 rounded border border-blue-200 text-xs font-medium hover:bg-blue-100 flex items-center gap-1"
                                                >
                                                    <!--[if BLOCK]><![endif]--><?php if($order->is_modified == 1): ?> 
                                                        📧 Resend Modified User Email 
                                                    <?php else: ?> 
                                                         📧 Resend User Email 
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </button>
                                                <button 
                                                    wire:click="resendAdminEmail(<?php echo e($order->id); ?>)"
                                                    wire:confirm="Are you sure?"
                                                    class="px-2 py-1 bg-blue-50 text-blue-700 rounded border border-blue-200 text-xs font-medium hover:bg-blue-100 flex items-center gap-1"
                                                >
                                                    <!--[if BLOCK]><![endif]--><?php if($order->is_modified == 1): ?> 
                                                        📧 Resend Modified Admin Email 
                                                    <?php else: ?> 
                                                         📧 Resend Admin Email 
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <button 
                                                class="px-3 py-2 bg-gray-100 text-gray-400 rounded-md cursor-not-allowed border border-gray-200"
                                                disabled
                                                title="Available only after payment = paid & status = confirmed"
                                            >
                                                🚫 AWB Locked
                                            </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        
                                        <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>"
                                            target="_blank"
                                            class="px-3 py-1 text-xs font-semibold
                                                   bg-indigo-100 text-indigo-700
                                                   border border-indigo-300 rounded-md
                                                   hover:bg-indigo-200 transition"
                                        >
                                            👁 View
                                        </a>
                                        
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAdmin')): ?>
                                            
                                                <a href="<?php echo e(route('admin.orders.modify', $order->id)); ?>"
                                                    target="_blank"
                                                    class="px-3 py-1 text-xs font-semibold
                                                   bg-indigo-100 text-indigo-700
                                                   border border-indigo-300 rounded-md
                                                   hover:bg-indigo-200 transition"
                                                >
                                                    ✏️ Modify Order
                                                </a>
                                            
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
            <div class="mt-4">
                <?php echo e($orders->links()); ?> <!-- Pagination links -->
            </div>
            
            <div wire:loading.flex class="absolute inset-0 items-center justify-center bg-white/60 z-50">
                <div class="flex items-center space-x-3">
                    <!-- spinner (SVG) -->
                    <svg class="animate-spin h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>

                    <div class="text-sm text-gray-700">Loading…</div>
                </div>
            </div>
        </div>
    </div>

    <!--[if BLOCK]><![endif]--><?php if($awbModalOpen): ?>
    <div class="fixed inset-0 bg-black/50 z-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Add AWB & Send Message</h2>

            <!-- Shipping Partner Selection -->
            <label class="font-medium text-sm">Shipping Partner *</label>
            <select wire:model="awbPartner"
                    class="w-full mt-1 mb-4 border-gray-300 rounded-md">
                <option value="">Select Partner</option>
                <option value="Delhivery">Delhivery</option>
                <option value="Bluedart">Bluedart</option>
            </select>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['awbPartner'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

            <!-- AWB Input -->
            <label class="font-medium text-sm">Reference / Tracking Number</label>
            <input type="text"
                wire:model="awbRefNo"
                class="w-full mt-1 mb-4 border-gray-300 rounded-md"
                placeholder="Enter AWB / Tracking Number" required>

            <!-- Buttons -->
            <div class="flex justify-end gap-3">
                <button wire:click="$set('awbModalOpen', false)"
                        class="px-4 py-2 bg-gray-200 rounded-md">
                    Cancel
                </button>

                <button 
                    wire:click="saveAwb"
                    wire:loading.attr="disabled"
                    wire:target="saveAwb"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="saveAwb">Save AWB</span>
                    <span wire:loading wire:target="saveAwb">Saving...</span>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

</div>
    <?php
        $__scriptKey = '3926530461-0';
        ob_start();
    ?>
<script>
    $wire.on('notify', (event) => {
        //console.log('Notification received:', event[0].message);
        alert(event[0].message);
    });
</script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/livewire/admin/order-list.blade.php ENDPATH**/ ?>