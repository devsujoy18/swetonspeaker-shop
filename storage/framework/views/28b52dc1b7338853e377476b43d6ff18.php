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
            <?php echo e(__('My Orders')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div
        class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8"
        x-data="{
            reviewModalOpen: false,
            selectedOrderNumber: '',
            selectedReviews: [],
            openReviewModal(orderNumber, reviews) {
                this.selectedOrderNumber = orderNumber;
                this.selectedReviews = reviews;
                this.reviewModalOpen = true;
            },
            closeReviewModal() {
                this.reviewModalOpen = false;
                this.selectedOrderNumber = '';
                this.selectedReviews = [];
            }
        }"
        @keydown.escape.window="closeReviewModal()"
    >
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <?php if($orders->count()): ?>
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2">Order #</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2">Order Status</th>
                                <th class="px-4 py-2">Payment Status</th>
                                <th class="p-4 py-2">Track your order</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $hide = $order->order_status == 'processing'
                                            && $order->payment_status == 'processing'
                                            && $order->created_at->lt(now()->subHours(24));
                                    $reviewPayload = $order->reviews->map(function ($review) {
                                        return [
                                            'product_name' => $review->product->name ?? 'Product',
                                            'rating' => (int) $review->rating,
                                            'status' => ucfirst($review->status),
                                            'comment' => $review->comment ?? '',
                                        ];
                                    })->values();
                                ?>

                                <?php if($hide): ?>
                                    <?php continue; ?>
                                <?php endif; ?>

                                <tr class="border-t">
                                    <td class="px-4 py-2"><?php echo e($order->order_number); ?></td>
                                    <td class="px-4 py-2"><?php echo e($order->order_date->format('d M Y')); ?></td>
                                    <td class="px-4 py-2">Rs. <?php echo e(number_format($order->total, 2)); ?></td>
                                    <td class="px-4 py-2">
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
                                    <td class="px-4 py-2">
                                        <span class="px-3 py-1 text-xs rounded-full font-semibold border
                                                <?php if($order->payment_status === 'processing'): ?>
                                                    bg-yellow-100 text-yellow-700 border-yellow-300
                                                <?php elseif($order->payment_status === 'success'): ?>
                                                    bg-green-100 text-green-700 border-green-300
                                                <?php else: ?>
                                                    bg-red-100 text-red-700 border-red-300
                                                <?php endif; ?>">
                                            <?php echo e(ucfirst($order->payment_status)); ?>

                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <?php if(!empty($order->awb_number) && $order->payment_status == 'success'): ?>
                                            <?php if($order->awb_partner == 'Delhivery'): ?>
                                                <p>Your order has been despatched through Delhivery Courier. AWB number is <strong><?php echo e($order->awb_number); ?></strong>. You can track your order at <a href="https://www.delhivery.com/" target="_blank">www.Delhivery.com</a>. This completes your order. Thank you for placing order with us.</p>
                                            <?php elseif($order->awb_partner == 'Bluedart'): ?>
                                                <p>Your order has been despatched through Blue Dart Courier. Waybill number is <strong><?php echo e($order->awb_number); ?></strong>. You can track your order at <a href="https://bluedart.com/tracking/" target="_blank">https://bluedart.com/tracking</a>. This completes your order. Thank you for placing order with us.</p>
                                            <?php endif; ?>
                                        <?php elseif($order->order_status == 'dispatched' && empty($order->awb_number)): ?>
                                            <p>Packed and ready to be shipped</p>
                                        <?php elseif($order->payment_status == 'success'): ?>
                                            <p>Within 5 working days it will be despatched, tracking code will be sent to your phone and email and it will be shown here also.</p>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-2 align-top min-w-[180px]">
                                        <div class="space-y-3">
                                            <a
                                                href="<?php echo e(route('orders.show', $order->order_number)); ?>"
                                                class="inline-flex items-center text-indigo-600 hover:text-indigo-700 hover:underline font-medium"
                                            >
                                                View
                                            </a>

                                            <?php if($order->order_status === 'complete'): ?>
                                                <?php if(($order->user_reviews_count ?? 0) > 0): ?>
                                                    <button
                                                        type="button"
                                                        class="inline-flex items-center px-3 py-1.5 rounded-md border border-emerald-200 bg-emerald-50 text-emerald-700 text-xs font-semibold hover:bg-emerald-100 transition"
                                                        @click="openReviewModal(<?php echo \Illuminate\Support\Js::from($order->order_number)->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($reviewPayload)->toHtml() ?>)"
                                                    >
                                                        Reviewed
                                                    </button>
                                                <?php else: ?>
                                                    <a
                                                        href="<?php echo e(route('reviews.create', $order->order_number)); ?>"
                                                        class="inline-flex items-center text-green-700 hover:text-green-800 hover:underline font-medium"
                                                    >
                                                        Write Review
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-gray-500">You have not placed any orders yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <div
            x-show="reviewModalOpen"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            role="dialog"
            aria-modal="true"
            aria-labelledby="review-modal-title"
        >
            <div class="absolute inset-0 bg-black/40" @click="closeReviewModal()"></div>

            <div class="relative z-10 w-full max-w-2xl rounded-xl bg-white shadow-2xl border border-gray-200">
                <div class="flex items-start justify-between px-6 py-4 border-b border-gray-100">
                    <div>
                        <h3 id="review-modal-title" class="text-lg font-semibold text-gray-900">Submitted Reviews</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Order: <span class="font-medium text-gray-700" x-text="selectedOrderNumber"></span>
                        </p>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center justify-center w-8 h-8 rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                        @click="closeReviewModal()"
                    >
                        &#10005;
                    </button>
                </div>

                <div class="px-6 py-5 max-h-[70vh] overflow-y-auto">
                    <template x-if="selectedReviews.length === 0">
                        <p class="text-sm text-gray-500">No reviews found for this order.</p>
                    </template>

                    <div class="space-y-4" x-show="selectedReviews.length > 0">
                        <template x-for="(review, index) in selectedReviews" :key="index">
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <p class="text-base font-semibold text-gray-900" x-text="review.product_name"></p>
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium"
                                        :class="
                                            review.status === 'Approved'
                                                ? 'bg-emerald-100 text-emerald-700'
                                                : (review.status === 'Pending'
                                                    ? 'bg-amber-100 text-amber-700'
                                                    : 'bg-red-100 text-red-700')
                                        "
                                        x-text="review.status"
                                    ></span>
                                </div>

                                <div class="mt-2 flex items-center gap-1">
                                    <template x-for="star in 5" :key="star">
                                        <span class="text-lg" :class="star <= review.rating ? 'text-amber-400' : 'text-gray-300'">&#9733;</span>
                                    </template>
                                    <span class="ml-1 text-sm text-gray-600" x-text="review.rating + '/5'"></span>
                                </div>

                                <p class="mt-3 text-sm text-gray-700 leading-relaxed" x-text="review.comment || 'No comment provided.'"></p>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 flex justify-end">
                    <button
                        type="button"
                        class="inline-flex items-center px-4 py-2 rounded-md bg-gray-900 text-white text-sm font-medium hover:bg-gray-800"
                        @click="closeReviewModal()"
                    >
                        Close
                    </button>
                </div>
            </div>
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
<?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/orders/index.blade.php ENDPATH**/ ?>