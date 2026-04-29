<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Site Settings
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST"
                  action="{{ route('admin.settings.update') }}"
                  class="bg-white p-6 rounded-lg shadow space-y-4">

                @csrf

                <!-- Cart Enabled -->
                <div>
                    <label class="block text-sm font-medium mb-2">Cart Enabled</label>

                    <div class="flex items-center gap-6">
                        <label class="inline-flex items-center gap-2">
                            <input type="radio"
                                   name="cart_enabled"
                                   value="1"
                                   {{ old('cart_enabled', $setting->cart_enabled) == 1 ? 'checked' : '' }}
                                   class="text-indigo-600 border-gray-300 focus:ring-indigo-500">
                            <span>Yes</span>
                        </label>

                        <label class="inline-flex items-center gap-2">
                            <input type="radio"
                                   name="cart_enabled"
                                   value="0"
                                   {{ old('cart_enabled', $setting->cart_enabled) == 0 ? 'checked' : '' }}
                                   class="text-indigo-600 border-gray-300 focus:ring-indigo-500">
                            <span>No</span>
                        </label>
                    </div>

                    @error('cart_enabled')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Minimum Cart Amount -->
                <div>
                    <label class="block text-sm font-medium">Minimum Cart Amount</label>
                    <input type="number" step="0.01" name="minimum_cart_amount"
                           value="{{ old('minimum_cart_amount', $setting->minimum_cart_amount) }}"
                           class="w-full border-gray-300 rounded-md">
                    @error('minimum_cart_amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cart Disabled Message -->
                <div>
                    <label class="block text-sm font-medium">Cart Disabled Message</label>
                    <input type="text" name="cart_disabled_message"
                           value="{{ old('cart_disabled_message', $setting->cart_disabled_message) }}"
                           class="w-full border-gray-300 rounded-md">
                    @error('cart_disabled_message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Home Message -->
                <div>
                    <label class="block text-sm font-medium">Home Page Message</label>
                    <textarea name="home_message"
                              rows="3"
                              class="w-full border-gray-300 rounded-md">{{ old('home_message', $setting->home_message) }}</textarea>
                    @error('home_message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4">
                    <button class="px-5 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Update Settings
                    </button>

                    <a href="{{ route('dashboard') }}"
                       class="px-5 py-2 bg-gray-100 rounded hover:bg-gray-200">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>