<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Account & Ledger
        </h2>
    </x-slot>

    <div class="py-4 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="max-w-6xl mx-auto bg-white px-5 py-4 rounded-lg shadow-md">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Filter Ledger</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        This report shows all money-moving orders in the selected period.
                        Successful payments count as sales, refunded orders reduce the retained amount.
                    </p>
                </div>

                <div class="rounded-md border border-indigo-100 bg-indigo-50 px-3 py-2 text-sm text-indigo-900">
                    <div class="text-xs font-semibold uppercase tracking-wide text-indigo-700">Period Range</div>
                    <div class="font-medium">{{ $periodLabel }}</div>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.orders.ledger') }}" class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-4">
                <div>
                    <label for="from_date" class="block text-sm font-medium text-gray-700">From Date</label>
                    <input
                        id="from_date"
                        type="date"
                        name="from_date"
                        value="{{ request('from_date') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    @error('to_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2 flex items-end gap-2">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                    >
                        Apply Filter
                    </button>

                    <a
                        href="{{ route('admin.orders.ledger') }}"
                        class="inline-flex items-center justify-center rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-lg bg-white p-4 shadow-md">
                <p class="text-sm text-gray-500">Ledger Entries</p>
                <h4 class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($summary['entries_count']) }}</h4>
                <p class="mt-2 text-sm text-gray-600">Successful and refunded orders in the selected period.</p>
            </div>

            <div class="rounded-lg bg-white p-4 shadow-md">
                <p class="text-sm text-gray-500">Gross Sales</p>
                <h4 class="mt-1 text-2xl font-bold text-gray-900">₹{{ number_format($summary['gross_sales'], 2) }}</h4>
                <p class="mt-2 text-sm text-gray-600">Total order value before refunds.</p>
            </div>

            <div class="rounded-lg bg-white p-4 shadow-md">
                <p class="text-sm text-gray-500">Refund Amount</p>
                <h4 class="mt-1 text-2xl font-bold text-gray-900">₹{{ number_format($summary['refund_amount'], 2) }}</h4>
                <p class="mt-2 text-sm text-gray-600">Refunded money during the selected period.</p>
            </div>

            <div class="rounded-lg bg-white p-4 shadow-md">
                <p class="text-sm text-gray-500">Net Collection</p>
                <h4 class="mt-1 text-2xl font-bold text-gray-900">₹{{ number_format($summary['net_collection'], 2) }}</h4>
                <p class="mt-2 text-sm text-gray-600">Gross sales minus refunds.</p>
            </div>
        </div>

        <div class="max-w-6xl mx-auto bg-white p-4 rounded-lg shadow-md">
            <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between mb-3">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Ledger Entries</h3>
                    <p class="text-sm text-gray-600">Review order value, refund amount, and net retained amount.</p>
                </div>

                <div class="flex flex-wrap gap-2 text-xs font-medium text-gray-600">
                    <span class="rounded-full bg-gray-100 px-3 py-1">Success orders: {{ number_format($summary['successful_orders']) }}</span>
                    <span class="rounded-full bg-gray-100 px-3 py-1">Refunded orders: {{ number_format($summary['refunded_orders']) }}</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Order</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3 text-right">Gross</th>
                            <th class="px-4 py-3 text-right">Refund</th>
                            <th class="px-4 py-3 text-right">Net</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($ledgerEntries as $entry)
                            <tr class="{{ $entry->payment_status === 'refunded' ? 'bg-amber-50' : 'bg-white' }} hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">
                                        {{ $entry->order_date?->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $entry->order_date?->format('h:i A') }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-gray-900">{{ $entry->order_number }}</div>
                                    <div class="mt-1 flex flex-wrap gap-2 text-xs">
                                        <span class="rounded-full bg-gray-100 px-2.5 py-1 font-medium text-gray-700">
                                            {{ $entry->paymentStatusLabel() }}
                                        </span>
                                        <span class="rounded-full bg-gray-100 px-2.5 py-1 font-medium text-gray-700">
                                            Order: {{ ucfirst($entry->order_status) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">
                                        {{ $entry->billing_name ?: $entry->user?->name ?: 'Customer' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $entry->billing_email ?: $entry->user?->email ?: 'No email available' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right font-semibold text-gray-900">
                                    ₹{{ number_format((float) $entry->total, 2) }}
                                </td>
                                <td class="px-4 py-3 text-right font-semibold text-amber-700">
                                    @if ((float) $entry->refunded_amount > 0)
                                        ₹{{ number_format((float) $entry->refunded_amount, 2) }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right font-semibold text-emerald-700">
                                    ₹{{ number_format((float) $entry->netAmount(), 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $entry->payment_status === 'refunded' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                        {{ ucfirst($entry->payment_status) }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                    No ledger entries found for the selected period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $ledgerEntries->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
