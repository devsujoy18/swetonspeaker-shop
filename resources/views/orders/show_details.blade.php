<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-wrap justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Order #{{ $order->order_number }}
                </h1>
                <p class="text-sm text-gray-500">
                    Placed on {{ $order->order_date?->format('d M Y, h:i A') }}
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

        {{-- ORDER META --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-500">Order Serial No</p>
                <p class="font-semibold">{{ $order->order_sl_no ?? '—' }}</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-500">Payment Method</p>
                <p class="font-semibold uppercase">{{ $order->payment_method }}</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-500">Transaction ID</p>
                <p class="font-semibold break-all">{{ $order->transaction_id ?? '—' }}</p>
            </div>
        </div>

        {{-- CUSTOMER --}}
        <div class="bg-white p-5 rounded-lg shadow">
            <h2 class="font-semibold text-lg mb-3">👤 Customer Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <p><strong>Name:</strong> {{ $order->billing_name }}</p>
                <p><strong>Email:</strong> {{ $order->billing_email }}</p>
                <p><strong>Phone:</strong> {{ $order->billing_phone }}</p>

                @if($order->billing_alternate_phone)
                    <p><strong>Alt Phone:</strong> {{ $order->billing_alternate_phone }}</p>
                @endif

                @if($order->company_name)
                    <p><strong>Company:</strong> {{ $order->company_name }}</p>
                @endif

                @if($order->gst_no)
                    <p><strong>GST No:</strong> {{ $order->gst_no }}</p>
                @endif
            </div>
        </div>

        {{-- BILLING & SHIPPING --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Billing --}}
            <div class="bg-white p-5 rounded-lg shadow">
                <h2 class="font-semibold text-lg mb-3">🏠 Billing Address</h2>
                <p class="text-sm text-gray-700 leading-relaxed">
                    {{ $order->billing_street }}<br>
                    {{ $order->billing_locality }}<br>
                    {{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_zip }}<br>
                    @if($order->billing_landmark)
                        Landmark: {{ $order->billing_landmark }}
                    @endif
                </p>
            </div>

            {{-- Shipping --}}
            <div class="bg-white p-5 rounded-lg shadow">
                <h2 class="font-semibold text-lg mb-3">🚚 Shipping Address</h2>

                @if($order->shipping_same_as_billing)
                    <p class="text-sm text-gray-700 leading-relaxed">
                        {{ $order->billing_street }}<br>
                        {{ $order->billing_locality }}<br>
                        {{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_zip }}<br>
                        @if($order->billing_landmark)
                            Landmark: {{ $order->billing_landmark }}
                        @endif
                    </p>
                @else
                    <p class="text-sm text-gray-700 leading-relaxed">
                        {{ $order->shipping_street }}<br>
                        {{ $order->shipping_locality }}<br>
                        {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zip }}<br>
                        @if($order->shipping_landmark)
                            Landmark: {{ $order->shipping_landmark }}
                        @endif
                    </p>
                @endif
            </div>
        </div>

        {{-- ORDER ITEMS --}}
        <div class="bg-white p-5 rounded-lg shadow">
            <h2 class="font-semibold text-lg mb-4">🛒 Order Items</h2>

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
                            $image = $item->product?->primaryImage;
                        @endphp
                        <tr class="border-t">
                            <td class="p-3">
                                <div class="flex gap-3 items-center">
                                    <img src="{{ $image
                                            ? env('IMG_HOST').'uploads/'.$image->path
                                            : asset('images/buy.jpg') }}"
                                         class="h-14 w-14 rounded object-cover" height="60px" width="60px">
                                         
                                    <div class="font-medium">{{ $item->product_name }}</div>
                                    @if($item->shop_description)
                                        <div class="text-xs text-gray-500">{{ $item->shop_description }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="p-3 text-center">{{ $item->quantity }}</td>
                            <td class="p-3 text-right">₹{{ number_format($item->price, 2) }}</td>
                            <td class="p-3 text-right font-semibold">
                                ₹{{ number_format($item->total, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- AWB --}}
        <div class="bg-white p-5 rounded-lg shadow">
            <h2 class="font-semibold text-lg mb-2">📦 Shipping / AWB</h2>

            @if($order->awb_partner)
                <p class="text-sm">
                    <strong>Partner:</strong> {{ $order->awb_partner }} <br>
                    <strong>Tracking No:</strong> {{ $order->awb_number ?? '—' }}
                </p>
            @else
                <p class="text-sm text-gray-500 italic">AWB not assigned yet</p>
            @endif
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
