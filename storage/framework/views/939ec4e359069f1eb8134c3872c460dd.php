<div class="container mx-auto">
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
        <!-- Tab navigation bar with a subtle gradient -->
        <div class="bg-gradient-to-r from-red-800 to-red-900">
            <div class="container mx-auto px-6">
                <div class="flex space-x-8 border-b border-gray-700">
                    <!-- Tab 1: Specification -->
                    <button data-tab-target="#tab-specification" class="tab-btn active text-white font-semibold py-4 px-1 border-b-2 border-transparent focus:outline-none transition-colors duration-300">Specification</button>
                    <!--[if BLOCK]><![endif]--><?php if(!empty($product->description)): ?>
                    <!-- Tab 2: Description -->
                    <button data-tab-target="#tab-description" class="tab-btn text-gray-400 hover:text-white font-semibold py-4 px-1 border-b-2 border-transparent focus:outline-none transition-colors duration-300">Description</button>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>

        <!-- Tab content area -->
        <!--[if BLOCK]><![endif]--><?php if($product->combinations->first()): ?>
                    <?php
                        $firstCombination = $product->combinations->first();
                    ?>
        <div class="p-6 md:p-8">
            <!-- Pane 1: Specification -->
            <div id="tab-specification" class="tab-pane active">
                <!-- Responsive grid for the spec columns -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!--[if BLOCK]><![endif]--><?php if($firstCombination->productspecifications): ?>
                    <div class="space-y-6">
                        <div class="bg-gray-50 rounded-lg overflow-hidden">
                            <h4 style="background-color: rgb(229 211 160);" class="text-gray-700 font-bold p-4 text-base flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                Specification
                            </h4>
                            <div class="p-5 space-y-2 text-sm">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $firstCombination->productspecifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500"><?php echo e($specification->specification->name); ?></span>
                                    <span class="font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded-md text-right"><?php echo e($specification->value); ?></span>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if($firstCombination->producttsparameters): ?>
                    <div class="space-y-6">
                        <div class="bg-gray-50 rounded-lg overflow-hidden">
                            <h4 style="background-color: rgb(229 211 160);" class="text-gray-700 text-gray-700 font-bold p-4 text-base flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                                T/S Parameters
                            </h4>
                            <div class="p-5 space-y-2 text-sm">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $firstCombination->producttsparameters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tsparameter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500"><?php echo e($tsparameter->tsparameter->name); ?></span>
                                    <span class="font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded-md text-right"><?php echo e($tsparameter->value); ?></span>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!-- Column 3: Mounting & Recone Info -->
                    <div class="space-y-8">
                        <!--[if BLOCK]><![endif]--><?php if($firstCombination->productmountinginfos): ?>
                         <div class="bg-gray-50 rounded-lg overflow-hidden">
                            <h4 style="background-color: rgb(229 211 160);" class="text-gray-700 text-gray-700 font-bold p-4 text-base flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5v4m5-4h-4" /></svg>
                                Mounting Info
                            </h4>
                            <div class="p-5 space-y-2 text-sm">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $firstCombination->productmountinginfos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mountinginfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500"><?php echo e($mountinginfo->mountinginfo->name); ?></span>
                                    <span class="font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded-md"><?php echo e($mountinginfo->value); ?></span>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($firstCombination->productreconkits): ?>
                        <div class="bg-gray-50 rounded-lg overflow-hidden">
                            <h4 style="background-color: rgb(229 211 160);" class="text-gray-700 text-gray-700 font-bold p-4 text-base flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                Recone Kit
                            </h4>
                            <div class="p-5 space-y-2 text-sm">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $firstCombination->productreconkits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reconkit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500"><?php echo e($reconkit->reconkit->name); ?></span>
                                    <span class="font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded-md"><?php echo e($reconkit->value); ?></span>
                                </div>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                </div>
            </div>

            <!-- Pane 2: Description -->
            <div id="tab-description" class="tab-pane hidden">
                <div class="prose max-w-none text-gray-600">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Product Description</h3>
                    <p><?php echo e($product->description); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div>
<?php /**PATH /home/ace85084/public_html/shop/resources/views/livewire/products/public-other-details-component.blade.php ENDPATH**/ ?>