<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @canany(['isAdmin','isSubadmin'])
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <x-stat-card title="Total Orders" value="{{ $totalOrders }}" />
                <x-stat-card title="Revenue" value="₹{{ number_format($totalRevenue, 2) }}" />
                <x-stat-card title="Total Users" value="{{ $totalUsers }}" />
                <x-stat-card title="Pending Orders" value="{{ $pendingOrders }}" />
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-4 shadow rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Orders (Last 7 Days)</h3>
                    <canvas id="ordersChart"></canvas>
                </div>
                <div class="bg-white p-4 shadow rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Revenue (Last 7 Days)</h3>
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            {{-- Latest Orders + Users --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
                {{-- Latest Orders --}}
                <div class="bg-white p-4 shadow rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold">Latest Orders</h3>
                        <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:underline">
                            View All →
                        </a>
                    </div>
            
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="p-2 text-left">Order</th>
                                <th class="p-2 text-left">Customer</th>
                                <th class="p-2 text-center">Payment</th>
                                <th class="p-2 text-center">Status</th>
                                <th class="p-2 text-right">Total</th>
                                <th class="p-2 text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($latestOrders as $order)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-2 font-medium">{{ $order->order_number }}</td>
                                <td class="p-2">{{ $order->billing_name }}</td>
            
                                {{-- Payment Status Badge --}}
                                <td class="p-2 text-center">
                                    <span class="
                                        px-3 py-1 text-xs rounded-full font-semibold border 
                                        @if($order->payment_status === 'processing')
                                            bg-yellow-100 text-yellow-700 border-yellow-300
                                        @elseif($order->payment_status === 'success')
                                            bg-green-100 text-green-700 border-green-300
                                        @else
                                            bg-red-100 text-red-700 border-red-300
                                        @endif
                                    ">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
            
                                {{-- Order Status Badge --}}
                                <td class="p-2 text-center">
                                    @php
                                        $status = $order->order_status;

                                        $map = [
                                            'processing' => ['icon' => '⏳', 'bg' => 'bg-yellow-100 text-yellow-700 border-yellow-300'],
                                            'confirmed' => ['icon' => '✔️', 'bg' => 'bg-blue-100 text-blue-700 border-blue-300'],
                                            'dispatched' => ['icon' => '🚚', 'bg' => 'bg-purple-100 text-purple-700 border-purple-300'],
                                            'complete' => ['icon' => '📦', 'bg' => 'bg-green-100 text-green-700 border-green-300'],
                                            'cancelled' => ['icon' => '❌', 'bg' => 'bg-red-100 text-red-700 border-red-300'],
                                        ];

                                        $icon = $map[$status]['icon'] ?? '📄';
                                        $style = $map[$status]['bg'] ?? 'bg-gray-100 text-gray-700 border-gray-300';
                                    @endphp

                                    <span class="px-3 py-1 text-xs rounded-full font-semibold border {{ $style }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
            
                                <td class="p-2 text-right font-semibold">₹{{ number_format($order->total, 2) }}</td>
                                <td class="p-2 text-right text-gray-600 text-xs">
                                    {{ $order->order_date->format('d M, Y') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
    
                {{-- Latest Users --}}
                <div class="bg-white p-4 shadow rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold">Latest Registered Users</h3>
                        @can('isAdmin')
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:underline">
                            View All →
                        </a>
                        @endcan
                        
                    </div>
            
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="p-2 text-left">Name</th>
                                <th class="p-2 text-left">Email</th>
                                <th class="p-2 text-left">Phone</th>
                                <th class="p-2 text-right">Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($latestUsers as $user)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-2 font-medium">{{ $user->name }}</td>
                                <td class="p-2">{{ $user->email }}</td>
                                <td class="p-2">
                                    {{ $user->phone ?? '—' }}
                                </td>
                                <td class="p-2 text-right text-gray-600 text-xs">
                                    {{ $user->created_at->format('d M, Y') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        @endcanany
        @can('isUser')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">

                {{-- Greeting --}}
                <div class="bg-white p-6 shadow rounded-lg">
                    <h2 class="text-xl font-semibold">
                        Hello, {{ $user->name }} 👋
                    </h2>
                    <p class="text-gray-600 text-sm mt-1">
                        Welcome to your dashboard. Manage your orders & account here.
                    </p>
                </div>

                {{-- Summary Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="bg-white p-5 shadow rounded-lg">
                        <p class="text-gray-600 text-sm">Total Orders</p>
                        <h3 class="text-2xl font-bold mt-1">{{ $totalOrders }}</h3>
                    </div>

                    <div class="bg-white p-5 shadow rounded-lg">
                        <p class="text-gray-600 text-sm">Active Orders</p>
                        <h3 class="text-2xl font-bold mt-1">{{ $activeOrders }}</h3>
                    </div>

                    <div class="bg-white p-5 shadow rounded-lg">
                        <p class="text-gray-600 text-sm">Pending Payments</p>
                        <h3 class="text-2xl font-bold mt-1">{{ $pendingPayments }}</h3>
                    </div>

                </div>

                {{-- Quick Links --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <a href="{{ route('profile.edit') }}"
                        class="bg-white p-5 shadow rounded-lg text-center hover:bg-gray-50">
                        <p class="font-semibold">Profile</p>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                        class="bg-white p-5 shadow rounded-lg text-center hover:bg-gray-50">
                        <p class="font-semibold">Addresses</p>
                    </a>

                    <a href="{{ route('orders.index') }}"
                        class="bg-white p-5 shadow rounded-lg text-center hover:bg-gray-50">
                        <p class="font-semibold">My Orders</p>
                    </a>

                    <a href="https://swetonspeakers.com/contact-us" target="_blank"
                        class="bg-white p-5 shadow rounded-lg text-center hover:bg-gray-50">
                        <p class="font-semibold">Support</p>
                    </a>
                </div>

                {{-- Recent Orders --}}
                <div class="bg-white p-6 shadow rounded-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Recent Orders</h3>
                        <a href="{{ route('orders.index') }}" class="text-blue-600 text-sm hover:underline">
                            View All →
                        </a>
                    </div>

                    @if($recentOrders->count())
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="p-2 text-left">Order</th>
                                    <th class="p-2 text-center">Status</th>
                                    <th class="p-2 text-center">Payment</th>
                                    <th class="p-2 text-right">Total</th>
                                    <th class="p-2 text-right">Date</th>
                                    <th class="p-2 text-center">Track your order</th>
                                    <th class="p-2 text-right">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($recentOrders as $order)
                                    @php
                                        $hide = $order->order_status == 'processing'
                                                && $order->payment_status == 'processing'
                                                && $order->created_at->lt(now()->subHours(24));
                                    @endphp

                                    @if($hide)
                                        @continue
                                    @endif
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="p-2 font-semibold">{{ $order->order_number }}</td>

                                        <td class="p-2 text-center">
                                            <span class="px-2 py-1 text-xs rounded
                                                @if($order->order_status=='processing') bg-yellow-100 text-yellow-700
                                                @elseif($order->order_status=='confirmed') bg-blue-100 text-blue-700
                                                @elseif($order->order_status=='dispatched') bg-purple-100 text-purple-700
                                                @elseif($order->order_status=='complete') bg-green-100 text-green-700
                                                @elseif($order->order_status=='cancelled') bg-red-100 text-red-700
                                                @else bg-gray-100 text-gray-700 @endif">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>

                                        <td class="p-2 text-center">
                                            <span class="
                                                px-3 py-1 text-xs rounded-full font-semibold border 
                                                @if($order->payment_status === 'processing')
                                                    bg-yellow-100 text-yellow-700 border-yellow-300
                                                @elseif($order->payment_status === 'success')
                                                    bg-green-100 text-green-700 border-green-300
                                                @else
                                                    bg-red-100 text-red-700 border-red-300
                                                @endif
                                            ">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </td>

                                        <td class="p-2 text-right">₹{{ number_format($order->total, 2) }}</td>

                                        <td class="p-2 text-right text-gray-600 text-xs">
                                            {{ $order->created_at->format('d M Y') }}
                                        </td>

                                        <td class="p-2 text-left text-gray-600 text-xs">
                                            @if(!empty($order->awb_number) && $order->payment_status == 'success')
                                                @if($order->awb_partner == 'Delhivery')
                                                    <p>Your order has been despatched through Delhivery Courier. AWB number is <strong>{{ $order->awb_number }}</strong> . You can track your order at <a href="https://www.delhivery.com/" target="_blank">www.Delhivery.com</a>. This completes your order. Thank You for placing order with us.</p>
                                                @elseif($order->awb_partner == 'Bluedart')
                                                    <p>Your order has been despatched through Blue Dart Courier. Waybill number is <strong>{{ $order->awb_number }}</strong> .You can track your order at <a href="https://bluedart.com/tracking/" target="_blank">https://bluedart.com/tracking</a>. This completes your order. Thank You for placing order with us.</p>
                                                @endif
                                            @elseif($order->order_status == 'dispatched' && empty($order->awb_number))
                                                <p>Packed and ready to be shipped</p>
                                            @elseif($order->payment_status == 'success')
                                                <p>Within 5 working days it will be despatched, tracking code will be sent to your phone & email and it will be shown here also.</p>
                                            @else
                                                N/A
                                            @endif
                                        </td>

                                        <td class="p-2 text-right">
                                            <a href="{{ route('orders.show', $order->order_number) }}"
                                            class="text-blue-600 hover:underline">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-600 text-sm">No recent orders.</p>
                    @endif
                </div>

            </div>
        </div>
        @endcan
    </div>
    @canany(['isAdmin','isSubadmin'])
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('ordersChart'), {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: [{
                    label: 'Orders',
                    data: @json($ordersData),
                    borderWidth: 2
                }]
            }
        });

        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: @json($dates),
                datasets: [{
                    label: 'Revenue',
                    data: @json($revenueData),
                    borderWidth: 2
                }]
            }
        });
    </script>
    @endcanany
</x-app-layout>
