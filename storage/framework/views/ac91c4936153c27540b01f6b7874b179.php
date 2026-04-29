<div class="container mx-auto px-4">
    <div class="mt-8">
        <div class="w-full">
            <!-- Reviews Header -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">
                        Customer Reviews (<?php echo e($totalReviews); ?>)
                    </h3>
                    
                    <!--[if BLOCK]><![endif]--><?php if($totalReviews > 0): ?>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-sm text-gray-600">Average Rating:</span>
                            <div class="flex items-center gap-1">
                                <div class="text-yellow-400">
                                    <!--[if BLOCK]><![endif]--><?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php echo e($i <= round($averageRating) ? '★' : '☆'); ?>

                                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <span class="font-semibold text-gray-800">
                                    <?php echo e(number_format($averageRating, 1)); ?>/5.0
                                </span>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
            
            <!-- Reviews List -->
            <div class="space-y-6">
                <!--[if BLOCK]><![endif]--><?php if($reviews->count() > 0): ?>
                    <div class="space-y-6">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex gap-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-12 h-12 flex-shrink-0">
                                    <img 
                                        class="rounded-full w-full h-full object-cover" 
                                        src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($review->user->name)); ?>&background=4f46e5&color=ffffff&size=48"
                                        alt="<?php echo e($review->user->name); ?>"
                                    >
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        <div class="font-semibold text-gray-700">
                                            <?php echo e($review->user->name); ?>

                                        </div>
                                        <div class="text-yellow-400 text-sm">
                                            <!--[if BLOCK]><![endif]--><?php for($i = 1; $i <= 5; $i++): ?>
                                                <?php echo e($i <= $review->rating ? '★' : '☆'); ?>

                                            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                    
                                    <!--[if BLOCK]><![endif]--><?php if($review->comment): ?>
                                        <div class="mt-2 text-gray-600">
                                            <?php echo e($review->comment); ?>

                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <div class="text-sm text-gray-400 mt-2">
                                        <?php echo e($review->created_at->format('M d, Y')); ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php else: ?>
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <div class="text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <p class="text-lg font-medium mb-1">No Reviews Available</p>
                            <p class="text-sm">This product hasn’t received any reviews yet. Purchase the product and share your valuable feedback.</p>

                        </div>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>
          
          
</div>
</div>
</div>
<?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/livewire/products/public-reviews-component.blade.php ENDPATH**/ ?>