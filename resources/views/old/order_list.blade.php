<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Old Orders') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                @if($orders->count())
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2">Order #</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2">Order Status</th>
                                <th class="px-4 py-2">Payment Status</th>
                                <th class="p-4 py-2">Track your order</th>
                                {{--<th class="px-4 py-2">Action</th>--}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                @php
                                    $hide = $order->status == 0
                                            && $order->payment_status == 0
                                            && $order->order_date < now()->subDays(2);
                                @endphp

                                @if($hide)
                                    @continue
                                @endif
                                
                                
                                @php
                                    $dt = date_create($order->order_date);
				                    $order_date = date_format($dt, 'g:ia \o\n l jS F Y');
                                @endphp
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $order->unique_order_id }}</td>
                                    <td class="px-4 py-2">{{ $order_date }}</td>
                                    <td class="px-4 py-2">
                                        ₹{{ number_format(
                                            $order->details->sum(function ($item) {
                                                return $item->price * $item->qty;
                                            }),
                                            2
                                        ) }}
                                    </td>
                                    <td class="px-4 py-2">
                                        @php
                                            $orderStatusMap = [
                                                0 => ['Not Applicable', 'bg-yellow-100 text-yellow-700 border-yellow-300'],
                                                1 => ['Cancelled', 'bg-red-100 text-red-700 border-red-300'],
                                                2 => ['Despatched', 'bg-purple-100 text-purple-700 border-purple-300'],
                                                3 => ['Confirmed', 'bg-blue-100 text-blue-700 border-blue-300'],
                                                4 => ['Completed', 'bg-green-100 text-green-700 border-green-300'],
                                            ];
                                    
                                            [$label, $classes] = $orderStatusMap[$order->status] ?? ['Unknown', 'bg-gray-100 text-gray-700 border-gray-300'];
                                        @endphp
                                    
                                        <span class="px-3 py-1 text-xs rounded-full font-semibold border {{ $classes }}">
                                            {{ $label }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-2">
                                        @php
                                            $statusMap = [
                                                0 => ['Cancelled', 'bg-red-100 text-red-700 border-red-300'],
                                                1 => ['Incomplete', 'bg-yellow-100 text-yellow-700 border-yellow-300'],
                                                2 => ['Success', 'bg-green-100 text-green-700 border-green-300'],
                                                3 => ['Failed', 'bg-red-100 text-red-700 border-red-300'],
                                            ];
                                    
                                            [$label, $classes] = $statusMap[$order->payment_status] ?? ['Unknown', 'bg-gray-100 text-gray-700 border-gray-300'];
                                        @endphp
                                    
                                        <span class="px-3 py-1 text-xs rounded-full font-semibold border {{ $classes }}">
                                            {{ $label }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-2 text-sm text-gray-700 space-y-2">

                                        {{-- Payment success but NOT dispatched yet --}}
                                        @if(
                                            empty($order->awb_number) &&
                                            empty($order->waybill_number) &&
                                            $order->payment_status == 2 &&
                                            $order->status != 2
                                        )
                                            <p><strong>Track your order:</strong></p>
                                            <p>
                                                Within 5 working days it will be despatched, tracking code will be sent to your
                                                phone & email and it will be shown here also.
                                            </p>
                                    
                                        {{-- Packed & ready to ship --}}
                                        @elseif(
                                            empty($order->awb_number) &&
                                            empty($order->waybill_number) &&
                                            $order->payment_status == 2 &&
                                            $order->status == 2
                                        )
                                            <p><strong>Track your order:</strong></p>
                                            <p>Your order is packed and ready to be shipped.</p>
                                    
                                        {{-- Delhivery tracking --}}
                                        @elseif(
                                            !empty($order->awb_number) &&
                                            $order->payment_status == 2
                                        )
                                            <p><strong>Track your order:</strong></p>
                                            <p>
                                                Your order id <strong>{{ $order->unique_order_id }}</strong> has been despatched
                                                through <strong>Delhivery Courier</strong>.  
                                                AWB number is <strong>{{ $order->awb_number }}</strong>.
                                                You can track your order at
                                                <a href="https://www.delhivery.com/" target="_blank" class="text-blue-600 underline">
                                                    www.delhivery.com
                                                </a>.  
                                                This completes your order. Thank you for placing an order with us.
                                            </p>
                                    
                                        {{-- Blue Dart tracking --}}
                                        @elseif(
                                            !empty($order->waybill_number) &&
                                            $order->payment_status == 2
                                        )
                                            <p><strong>Track your order:</strong></p>
                                            <p>
                                                Your order id <strong>{{ $order->unique_order_id }}</strong> has been despatched
                                                through <strong>Blue Dart Courier</strong>.  
                                                Waybill number is <strong>{{ $order->waybill_number }}</strong>.
                                                You can track your order at
                                                <a href="https://bluedart.com/tracking/" target="_blank" class="text-blue-600 underline">
                                                    https://bluedart.com/tracking
                                                </a>.  
                                                This completes your order. Thank you for placing an order with us.
                                            </p>
                                    
                                        @else
                                            <span class="px-3 py-1 text-xs rounded-full font-semibold
                                                         bg-gray-100 text-gray-700 border border-gray-300">
                                                N/A
                                            </span>
                                        @endif
                                    
                                    </td>


                                    {{--<td class="px-4 py-2">
                                        <a href="{{ route('orders.show', $order->order_number) }}" 
                                           class="text-indigo-600 hover:underline">View</a>
                                    </td>--}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500">You haven’t placed any orders yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>