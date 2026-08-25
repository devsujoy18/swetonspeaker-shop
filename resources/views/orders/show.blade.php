<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Order Details
            </h2>

            <a href="{{ route('orders.index') }}"
               class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm hover:bg-gray-700">
                ← Back to My Orders
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-wrap justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Order #{{ $order->order_number ?? $order->id }}
                </h1>
                <p class="text-sm text-gray-500">
                    Placed on {{ $order->created_at->format('d M Y, h:i A') }}
                </p>
            </div>

            <div class="flex gap-2">
                {{-- Payment Status --}}
                @php
                    $paymentStyle = $order->paymentStatusStyle();
                @endphp
                <span class="px-3 py-1 text-sm rounded-full font-semibold border
                    {{ $paymentStyle['bg'] }}">
                    💳 {{ ucfirst($order->payment_status) }}
                </span>

                {{-- Order Status --}}
                <span class="px-3 py-1 text-sm rounded-full font-semibold
                    {{ $order->order_status === 'complete'
                        ? 'bg-green-100 text-green-700'
                        : ($order->order_status === 'dispatched'
                            ? 'bg-purple-100 text-purple-700'
                            : ($order->order_status === 'confirmed'
                                ? 'bg-blue-100 text-blue-700'
                                : 'bg-yellow-100 text-yellow-700')) }}">
                    📦 {{ ucfirst($order->order_status) }}
                </span>
            </div>
        </div>

        {{-- ADDRESS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Billing --}}
            <div class="bg-white p-5 rounded-lg shadow">
                <h2 class="font-semibold text-lg mb-3">🏠 Billing Address</h2>
                <p class="text-sm text-gray-700 leading-relaxed">
                    {{ $order->billing_name }} <br>
                    {{ $order->billing_street }} <br>
                    {{ $order->billing_locality }} <br>
                    {{ $order->billing_city }},
                    {{ $order->billing_state }} - {{ $order->billing_zip }} <br>
                    Phone: {{ $order->billing_phone }}
                </p>
            </div>

            {{-- Shipping --}}
            <div class="bg-white p-5 rounded-lg shadow">
                <h2 class="font-semibold text-lg mb-3">🚚 Shipping Address</h2>

                <p class="text-sm text-gray-700 leading-relaxed">
                    {{ $order->shipping_name }}<br>
                    {{ $order->shipping_email }} - {{ $order->shipping_phone }}<br>
                    {{ $order->shipping_street }} <br>
                    {{ $order->shipping_locality }} <br>
                    {{ $order->shipping_city }},
                    {{ $order->shipping_state }} - {{ $order->shipping_zip }}<br>
                    @if($order->shipping_landmark)
                        Landmark: {{ $order->shipping_landmark }}
                    @endif
                </p>
            </div>
        </div>

        {{-- ORDER ITEMS --}}
        <div class="bg-white p-5 rounded-lg shadow">
            <h2 class="font-semibold text-lg mb-4">🛒 Ordered Items</h2>

            <table class="w-full text-sm border rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Product</th>
                        <th class="p-3 text-center">Qty</th>
                        <th class="p-3 text-right">Price</th>
                        <th class="p-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderitems as $item)
                        @php
                            $image = $item->product->primaryImage;
                        @endphp
                        <tr class="border-t">
                            <td class="p-3">
                                <div class="flex gap-3 items-center">
                                    <img src="{{ $image
                                            ? \App\Support\ImageUrl::upload($image->path)
                                            : \App\Support\ImageUrl::placeholder() }}"
                                         class="h-14 w-14 rounded object-cover" height="60px" width="60px">

                                    <div>
                                        <div class="font-medium">
                                            {{ $item->product->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3 text-center">{{ $item->quantity }}</td>
                            <td class="p-3 text-right">₹{{ number_format($item->price, 2) }}</td>
                            <td class="p-3 text-right font-semibold">
                                ₹{{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- TOTAL --}}
        <div class="bg-white p-6 rounded-lg shadow text-right">
            <p class="text-sm text-gray-500">Subtotal</p>
            <p class="text-lg font-semibold mb-2">
                ₹{{ number_format($order->subtotal ?? $order->total, 2) }}
            </p>

            <p class="text-xl font-bold text-gray-800">
                Grand Total: ₹{{ number_format($order->total, 2) }}
            </p>
        </div>

    </div>
</x-app-layout>
