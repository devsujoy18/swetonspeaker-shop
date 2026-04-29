<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Order Details
            </h2>

            <a href="{{ route('admin.orders.index') }}"
               class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm hover:bg-gray-700">
                ← Back to My Orders
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 space-y-6">
        @livewire('admin.edit-order-component', ['order' => $order])
    </div>
</x-app-layout>
