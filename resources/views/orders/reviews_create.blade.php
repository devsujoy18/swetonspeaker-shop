<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Write a Review - Order #{{ $order->order_number }}
            </h2>

            <a href="{{ route('orders.show', $order->order_number) }}"
               class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm hover:bg-gray-700">
                ← Back to Order
            </a>
        </div>
    </x-slot>
    <livewire:reviews.review-component :orderNumber="$order->order_number" />
</x-app-layout>