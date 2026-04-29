<div>
    <div class="mb-4 flex flex-wrap gap-4 bg-gray-50 p-4 rounded-lg shadow">
        <input type="text" wire:model.live="search" class="border-gray-300 rounded-md" placeholder="Search title...">
        <button wire:click="resetFilters" type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
            Reset
        </button>

        <button
            wire:click="openCreateModal"
            wire:loading.attr="disabled"
            wire:target="openCreateModal"
            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 flex items-center gap-2 disabled:opacity-70"
        >
            <span wire:loading.remove wire:target="openCreateModal">
                Add Tag
            </span>

            <span wire:loading wire:target="openCreateModal" class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                Opening...
            </span>
        </button>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="table-wrap p-6 text-gray-900">
            <table class="table-freeze w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-b transition-colors duration-200" wire:key="tag-<?php echo e($tag->id); ?>">
                            <td class="px-4 py-2"><?php echo e($tag->title); ?></td>
                            <td class="px-4 py-2">
                                <span class="px-3 py-1 text-xs rounded-full font-medium <?php echo e($tag->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                                    <?php echo e($tag->status ? 'Active' : 'Inactive'); ?>

                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <button
                                    wire:click="toggleStatus(<?php echo e($tag->id); ?>)"
                                    wire:loading.attr="disabled"
                                    wire:target="toggleStatus(<?php echo e($tag->id); ?>)"
                                    class="inline-flex items-center gap-2 text-sm px-3 py-1.5 rounded-md border <?php echo e($tag->status ? 'border-green-300 text-green-700 hover:bg-green-50' : 'border-red-300 text-red-700 hover:bg-red-50'); ?> disabled:opacity-60"
                                >
                                    <span wire:loading.remove wire:target="toggleStatus(<?php echo e($tag->id); ?>)" class="flex items-center gap-2">
                                        <!--[if BLOCK]><![endif]--><?php if($tag->status): ?>
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Active
                                        <?php else: ?>
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Inactive
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </span>

                                    <span wire:loading wire:target="toggleStatus(<?php echo e($tag->id); ?>)" class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                        </svg>
                                        Updating...
                                    </span>
                                </button>

                                <button wire:click="openModal(<?php echo e($tag->id); ?>)" class="text-indigo-600 hover:underline text-sm">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
            <div class="mt-4">
                <?php echo e($tags->links()); ?>

            </div>
        </div>
    </div>

    <!--[if BLOCK]><![endif]--><?php if($modalOpen): ?>
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
            <div class="bg-white w-full max-w-xl rounded-xl shadow-xl p-6">
                <h2 class="text-lg font-semibold mb-4">
                    <?php echo e($isEdit ? 'Edit Tag' : 'Add Tag'); ?>

                </h2>

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="text-sm font-medium">Title</label>
                        <input wire:model.defer="title" class="w-full border rounded-md">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <div class="col-span-2 flex items-center gap-2">
                        <input type="checkbox" wire:model="status">
                        <span class="text-sm">Active</span>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button wire:click="$set('modalOpen', false)" class="px-4 py-2 bg-gray-200 rounded-md">
                        Cancel
                    </button>

                    <button
                        wire:click="save"
                        wire:loading.attr="disabled"
                        wire:target="save"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 flex items-center gap-2 disabled:opacity-70"
                    >
                        <span wire:loading.remove wire:target="save">
                            Save
                        </span>

                        <span wire:loading wire:target="save" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/livewire/admin/tag-component.blade.php ENDPATH**/ ?>