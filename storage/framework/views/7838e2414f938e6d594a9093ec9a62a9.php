<div>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!--[if BLOCK]><![endif]--><?php if(session('success')): ?>
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div class="grid grid-cols-1 lg:grid-cols-6 gap-6">
            <!-- Main Review Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Product Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Product Information</h3>
                    <div class="flex gap-4">
                        <!--[if BLOCK]><![endif]--><?php if($review->product->primaryImage): ?>
                            <img src="<?php echo e(env('IMG_HOST').'uploads/'.$review->product->primaryImage->path); ?>" 
                                 alt="<?php echo e($review->product->name); ?>"
                                 class="w-24 h-24 object-cover rounded">
                        <?php else: ?>
                            <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900"><?php echo e($review->product->name); ?></h4>
                            <p class="text-sm text-gray-600 mt-1">SKU: <?php echo e($review->product->slug); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Review Content -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Review Content</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <div class="flex items-center gap-2">
                            <div class="text-yellow-400 text-2xl">
                                <!--[if BLOCK]><![endif]--><?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php echo e($i <= $review->rating ? '★' : '☆'); ?>

                                <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <span class="text-gray-600 font-medium"><?php echo e($review->rating); ?>/5</span>
                        </div>
                    </div>

                    <!--[if BLOCK]><![endif]--><?php if($review->comment): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Customer Comment</label>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <p class="text-gray-700 leading-relaxed"><?php echo e($review->comment); ?></p>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-gray-500 italic">No comment provided</p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <div class="mt-4 text-sm text-gray-600">
                        <p><strong>Submitted:</strong> <?php echo e($review->created_at->format('d M Y, h:i A')); ?></p>
                        <!--[if BLOCK]><![endif]--><?php if($review->updated_at != $review->created_at): ?>
                            <p><strong>Last Updated:</strong> <?php echo e($review->updated_at->format('d M Y, h:i A')); ?></p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Order Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Order Information</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Order Number</label>
                            <p class="text-gray-900 font-mono"><?php echo e($review->order->order_number); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Order Date</label>
                            <p class="text-gray-900"><?php echo e($review->order->order_date->format('d M Y')); ?></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Order Total</label>
                            <p class="text-gray-900">Rs. <?php echo e(number_format($review->order->total, 2)); ?></p>
                        </div>

                        <!--[if BLOCK]><![endif]--><?php if($review->orderItem): ?>
                            <div class="mt-4 pt-4 border-t">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Reviewed Item</label>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-sm"><strong>Quantity:</strong> <?php echo e($review->orderItem->quantity); ?></p>
                                    <p class="text-sm"><strong>Price:</strong> Rs. <?php echo e(number_format($review->orderItem->price, 2)); ?></p>
                                    <!--[if BLOCK]><![endif]--><?php if($review->orderItem->combination): ?>
                                        <p class="text-sm"><strong>Variant:</strong> <?php echo e($review->orderItem->combination); ?></p>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>

            <!-- Sidebar: Customer & Status Management -->
            <div class="space-y-6">
                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Customer Details</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <p class="text-gray-900"><?php echo e($review->user->name); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="text-gray-900"><?php echo e($review->user->email); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Status Management -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Status Management</h3>
                    
                    <form wire:submit.prevent="updateStatus">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Status</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                <?php if($review->status === 'approved'): ?> bg-green-100 text-green-800
                                <?php elseif($review->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                <?php echo e(ucfirst($review->status)); ?>

                            </span>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Change Status</label>
                            <select wire:model="newStatus" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Admin Note (Optional)</label>
                            <textarea wire:model="adminNote" 
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                      placeholder="Add internal notes about this review..."></textarea>
                            <p class="text-xs text-gray-500 mt-1">This note is only visible to admins</p>
                        </div>

                        <!--[if BLOCK]><![endif]--><?php if($review->admin_note && $review->admin_note != $adminNote): ?>
                            <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded">
                                <p class="text-xs font-medium text-yellow-800 mb-1">Previous Admin Note:</p>
                                <p class="text-sm text-yellow-700"><?php echo e($review->admin_note); ?></p>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <div class="space-y-2">
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                                Update Status
                            </button>
                            
                            <button type="button"
                                    wire:click="deleteReview"
                                    wire:confirm="Are you sure you want to delete this review? This action cannot be undone."
                                    class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-medium">
                                Delete Review
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Quick Actions -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="font-medium text-blue-900 mb-2">Quick Actions</h4>
                    <div class="space-y-2 text-sm">
                        <!--[if BLOCK]><![endif]--><?php if($review->status === 'pending'): ?>
                            <button wire:click="$set('newStatus', 'approved')" 
                                    class="w-full text-left px-3 py-2 bg-white rounded hover:bg-green-50 text-green-700 border border-green-200">
                                ✓ Approve Review
                            </button>
                            <button wire:click="$set('newStatus', 'rejected')" 
                                    class="w-full text-left px-3 py-2 bg-white rounded hover:bg-red-50 text-red-700 border border-red-200">
                                ✗ Reject Review
                            </button>
                        <?php elseif($review->status === 'approved'): ?>
                            <button wire:click="$set('newStatus', 'pending')" 
                                    class="w-full text-left px-3 py-2 bg-white rounded hover:bg-yellow-50 text-yellow-700 border border-yellow-200">
                                ↺ Reset to Pending
                            </button>
                        <?php else: ?>
                            <button wire:click="$set('newStatus', 'approved')" 
                                    class="w-full text-left px-3 py-2 bg-white rounded hover:bg-green-50 text-green-700 border border-green-200">
                                ✓ Approve Review
                            </button>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/livewire/admin/review-detail-component.blade.php ENDPATH**/ ?>