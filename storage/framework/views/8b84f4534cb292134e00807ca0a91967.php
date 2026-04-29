<div>
        <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-2xl font-bold text-gray-900"><?php echo e($stats['total']); ?></div>
                    <div class="text-sm text-gray-600">Total Reviews</div>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg shadow border border-yellow-200">
                    <div class="text-2xl font-bold text-yellow-700"><?php echo e($stats['pending']); ?></div>
                    <div class="text-sm text-yellow-600">Pending</div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg shadow border border-green-200">
                    <div class="text-2xl font-bold text-green-700"><?php echo e($stats['approved']); ?></div>
                    <div class="text-sm text-green-600">Approved</div>
                </div>
                <div class="bg-red-50 p-4 rounded-lg shadow border border-red-200">
                    <div class="text-2xl font-bold text-red-700"><?php echo e($stats['rejected']); ?></div>
                    <div class="text-sm text-red-600">Rejected</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <input type="text" 
                               wire:model.live.debounce.300ms="search"
                               placeholder="Search by product, user, or comment..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <select wire:model.live="statusFilter" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="all">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div>
                        <select wire:model.live="ratingFilter"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="all">All Ratings</option>
                            <option value="5">5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Reviews List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!--[if BLOCK]><![endif]--><?php if($reviews->count() > 0): ?>
                        <div class="space-y-4">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900"><?php echo e($review->product->name); ?></div>
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="text-yellow-400 text-sm">
                                                    <!--[if BLOCK]><![endif]--><?php for($i = 1; $i <= 5; $i++): ?>
                                                        <?php echo e($i <= $review->rating ? '★' : '☆'); ?>

                                                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <span class="px-2 py-1 text-xs rounded-full font-medium
                                                    <?php if($review->status === 'approved'): ?> bg-green-100 text-green-800
                                                    <?php elseif($review->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                                    <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                                    <?php echo e(ucfirst($review->status)); ?>

                                                </span>
                                            </div>
                                            
                                            <div class="text-sm text-gray-600">
                                                <strong>User:</strong> <?php echo e($review->user->name); ?> (<?php echo e($review->user->email); ?>)<br>
                                                <strong>Order:</strong> <?php echo e($review->order->order_number); ?><br>
                                                <strong>Date:</strong> <?php echo e($review->created_at->format('d M Y, h:i A')); ?>

                                            </div>
                                            
                                            <!--[if BLOCK]><![endif]--><?php if($review->comment): ?>
                                                <div class="bg-gray-50 p-3 rounded text-sm mt-2">
                                                    <strong>Comment:</strong> <?php echo e($review->comment); ?>

                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            
                                            <!--[if BLOCK]><![endif]--><?php if($review->admin_note): ?>
                                                <div class="bg-yellow-50 p-3 rounded text-sm mt-2">
                                                    <strong>Admin Note:</strong> <?php echo e($review->admin_note); ?>

                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        
                                        <div class="flex gap-2 ml-4">
                                            <!--[if BLOCK]><![endif]--><?php if($review->status === 'pending'): ?>
                                                <button wire:click="approveReview(<?php echo e($review->id); ?>)"
                                                    wire:confirm="Are you sure?"
                                                        class="px-3 py-1 bg-green-100 text-green-700 border-green-300">
                                                    Approve
                                                </button>
                                                <button wire:click="selectReview(<?php echo e($review->id); ?>)"
                                                    wire:confirm="Are you sure?"
                                                        class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                                    Reject
                                                </button>
                                            <?php elseif($review->status === 'approved'): ?>
                                                <button wire:click="pendingReview(<?php echo e($review->id); ?>)"
                                                    wire:confirm="Are you sure?"
                                                        class="px-3 py-1 bg-blue-100 text-blue-700 border border-blue-300">
                                                    Reset
                                                </button>
                                            <?php elseif($review->status === 'rejected'): ?>
                                                <button wire:click="approveReview(<?php echo e($review->id); ?>)"
                                                    wire:confirm="Are you sure?"
                                                        class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                                                    Approve
                                                </button>
                                                <button wire:click="pendingReview(<?php echo e($review->id); ?>)"
                                                    wire:confirm="Are you sure?"
                                                        class="px-3 py-1 bg-yellow-600 text-white text-sm rounded hover:bg-yellow-700">
                                                    Reset
                                                </button>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            
                                            <a href="<?php echo e(route('admin.reviews.show', $review->id)); ?>"
                                                    class="px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                                                View Details
                                            </a>
                                            
                                            <button wire:click="deleteReview(<?php echo e($review->id); ?>)"
                                                    wire:confirm="Are you sure you want to delete this review?"
                                                    class="px-3 py-1 bg-red-100 text-red-700 border border-red-300">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Pagination -->
                        <?php echo e($reviews->links()); ?>

                    <?php else: ?>
                        <div class="text-center py-8 text-gray-500">
                            <div class="text-lg mb-2">No reviews found</div>
                            <div class="text-sm">Try adjusting your filters or search terms</div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Success Notification with Auto-dismiss -->
        <div x-data="{ show: <?php if ((object) ('showNotification') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showNotification'->value()); ?>')<?php echo e('showNotification'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showNotification'); ?>')<?php endif; ?> }" 
             x-show="show" 
             x-transition
             @click="show = false"
             x-init="$watch('show', value => { if(value) setTimeout(() => show = false, 3000) })"
             class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 cursor-pointer">
            <span x-text="$wire.notificationMessage"></span>
        </div>
</div><?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/livewire/admin/review-management-component.blade.php ENDPATH**/ ?>