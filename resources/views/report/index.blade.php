<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Report Management
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">

            <h3 class="text-lg font-semibold mb-4">Download Reports</h3>

            <form action="{{ route('admin.reports.export') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">

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

                <!-- Delivery Partner -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Delivery Partner</label>
                    <select name="partner" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">All Partners</option>
                        @foreach ($deliveryPartners as $p)
                            <option value="{{ $p }}">{{ $p }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('partner')" class="mt-2 text-sm text-red-600"/>

                    
                </div>

                <!-- Button -->
                <div class="md:col-span-3">
                    <button type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Download Excel Report
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
