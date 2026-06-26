<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product Analytics
        </h2>
    </x-slot>

    <div class="py-4 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="bg-white px-5 py-4 rounded-lg shadow-md">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Products Sold Report</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Track retained product sales by quantity, revenue, and daily movement for the selected order period.
                    </p>
                </div>

                <div class="rounded-md border border-sky-100 bg-sky-50 px-3 py-2 text-sm text-sky-900">
                    <div class="text-xs font-semibold uppercase tracking-wide text-sky-700">Period Range</div>
                    <div class="font-medium">{{ $periodLabel }}</div>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.orders.product-analytics') }}" class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-4">
                <div>
                    <label for="from_date" class="block text-sm font-medium text-gray-700">From Date</label>
                    <input
                        id="from_date"
                        type="date"
                        name="from_date"
                        value="{{ request('from_date') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                    />
                    @error('from_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="to_date" class="block text-sm font-medium text-gray-700">To Date</label>
                    <input
                        id="to_date"
                        type="date"
                        name="to_date"
                        value="{{ request('to_date') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                    />
                    @error('to_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2 flex items-end gap-2">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-md bg-sky-700 px-4 py-2 text-sm font-medium text-white hover:bg-sky-800"
                    >
                        Apply Filter
                    </button>

                    <a
                        href="{{ route('admin.orders.product-analytics') }}"
                        class="inline-flex items-center justify-center rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-lg bg-white p-4 shadow-md">
                <p class="text-sm text-gray-500">Units Sold</p>
                <h4 class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($summary['quantity_sold']) }}</h4>
                <p class="mt-2 text-sm text-gray-600">Quantity from successful, non-cancelled paid orders.</p>
            </div>

            <div class="rounded-lg bg-white p-4 shadow-md">
                <p class="text-sm text-gray-500">Product Revenue</p>
                <h4 class="mt-1 text-2xl font-bold text-gray-900">Rs. {{ number_format($summary['total_sales'], 2) }}</h4>
                <p class="mt-2 text-sm text-gray-600">Line item value before any order-level adjustments.</p>
            </div>

            <div class="rounded-lg bg-white p-4 shadow-md">
                <p class="text-sm text-gray-500">Active Variants</p>
                <h4 class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($summary['active_products']) }}</h4>
                <p class="mt-2 text-sm text-gray-600">Product and attribute combinations with retained sales.</p>
            </div>

            <div class="rounded-lg bg-white p-4 shadow-md">
                <p class="text-sm text-gray-500">Top Product</p>
                <h4 class="mt-1 text-lg font-bold text-gray-900">{{ $summary['top_product_name'] ?? 'No product yet' }}</h4>
                <p class="mt-2 text-sm text-gray-600">
                    {{ number_format($summary['top_product_quantity']) }} units sold at an average of Rs. {{ number_format($summary['average_unit_price'], 2) }}.
                </p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between mb-3">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Product Performance</h3>
                    <p class="text-sm text-gray-600">Ranked by sold quantity with refund quantity shown separately for context.</p>
                </div>

                <div class="rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-800">
                    Refunded units tracked: {{ number_format($summary['refunded_quantity']) }}
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3 text-right">Sold Qty</th>
                            <th class="px-4 py-3">Share</th>
                            <th class="px-4 py-3 text-right">Orders</th>
                            <th class="px-4 py-3 text-right">Revenue</th>
                            <th class="px-4 py-3 text-right">Avg Unit</th>
                            <th class="px-4 py-3 text-right">Refund Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($productReports as $report)
                            @php
                                $quantitySold = (int) $report->quantity_sold;
                                $totalSales = (float) $report->total_sales;
                                $shareWidth = min(100, round(($quantitySold / $maxProductQuantity) * 100));
                                $averageUnitPrice = $quantitySold > 0 ? $totalSales / $quantitySold : 0;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-gray-900">{{ $report->product_name }}</div>
                                    <div class="mt-1 flex flex-wrap items-center gap-2 text-xs">
                                        @if ($report->attribute_name)
                                            <span class="rounded-full bg-sky-50 px-2.5 py-1 font-medium text-sky-800">
                                                {{ $report->attribute_name }}
                                            </span>
                                        @endif
                                        <span class="text-gray-500">
                                            Product ID: {{ $report->product_id ?? 'Legacy item' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right text-base font-bold text-gray-900">
                                    {{ number_format($quantitySold) }}
                                </td>
                                <td class="px-4 py-3 min-w-44">
                                    <div class="h-2 rounded-full bg-gray-100">
                                        <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $shareWidth }}%"></div>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500">
                                        {{ $summary['quantity_sold'] > 0 ? number_format(($quantitySold / $summary['quantity_sold']) * 100, 1) : 0 }}% of units
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right font-medium text-gray-900">
                                    {{ number_format((int) $report->orders_count) }}
                                </td>
                                <td class="px-4 py-3 text-right font-semibold text-gray-900">
                                    Rs. {{ number_format($totalSales, 2) }}
                                </td>
                                <td class="px-4 py-3 text-right font-medium text-gray-700">
                                    Rs. {{ number_format($averageUnitPrice, 2) }}
                                </td>
                                <td class="px-4 py-3 text-right font-semibold {{ (int) $report->refunded_quantity > 0 ? 'text-amber-700' : 'text-gray-400' }}">
                                    {{ (int) $report->refunded_quantity > 0 ? number_format((int) $report->refunded_quantity) : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                    No product sales found for the selected period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="mb-3">
                <h3 class="text-base font-semibold text-gray-900">Date Wise Movement</h3>
                <p class="text-sm text-gray-600">Daily quantity, product revenue, and the leading product for each order date.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3 text-right">Sold Qty</th>
                            <th class="px-4 py-3">Daily Pace</th>
                            <th class="px-4 py-3 text-right">Orders</th>
                            <th class="px-4 py-3 text-right">Revenue</th>
                            <th class="px-4 py-3">Top Product</th>
                            <th class="px-4 py-3 text-right">Refund Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($dailyReports as $report)
                            @php
                                $quantitySold = (int) $report->quantity_sold;
                                $paceWidth = min(100, round(($quantitySold / $maxDailyQuantity) * 100));
                                $topProduct = $topProductsByDate->get($report->sold_on);
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($report->sold_on)->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-right text-base font-bold text-gray-900">
                                    {{ number_format($quantitySold) }}
                                </td>
                                <td class="px-4 py-3 min-w-44">
                                    <div class="h-2 rounded-full bg-gray-100">
                                        <div class="h-2 rounded-full bg-sky-500" style="width: {{ $paceWidth }}%"></div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right font-medium text-gray-900">
                                    {{ number_format((int) $report->orders_count) }}
                                </td>
                                <td class="px-4 py-3 text-right font-semibold text-gray-900">
                                    Rs. {{ number_format((float) $report->total_sales, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($topProduct)
                                        <div class="font-medium text-gray-900">{{ $topProduct->product_name }}</div>
                                        @if ($topProduct->attribute_name)
                                            <div class="text-xs font-medium text-sky-700">{{ $topProduct->attribute_name }}</div>
                                        @endif
                                        <div class="text-xs text-gray-500">{{ number_format((int) $topProduct->quantity_sold) }} units</div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right font-semibold {{ (int) $report->refunded_quantity > 0 ? 'text-amber-700' : 'text-gray-400' }}">
                                    {{ (int) $report->refunded_quantity > 0 ? number_format((int) $report->refunded_quantity) : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                    No daily product movement found for the selected period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
