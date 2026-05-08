<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Success order report
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">

            <h3 class="text-lg font-semibold mb-4">Download Reports</h3>

            <form action="{{ route('admin.orders.report.success.export') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- From Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">From Date</label>
                    <input type="date" name="from_date" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                </div>

                <!-- To Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">To Date</label>
                    <input type="date" name="to_date" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                </div>
                <!-- Button -->
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full md:w-auto px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Download Excel Report
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
