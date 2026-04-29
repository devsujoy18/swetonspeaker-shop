<x-front-layout>
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-gray-700" aria-label="breadcrumb">
                <ol class="flex space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Home</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li class="text-gray-800">Register</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="w-full max-w-2xl mx-auto mt-10 px-4 mb-10">
        <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">Register</h3>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Full Name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-600">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           placeholder="Full Name *"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-300">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600"/>
                </div>

                <!-- Two Column Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-600">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="Email Address *"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-300">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600"/>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-600">*</span></label>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}" required
                               placeholder="Phone Number *"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-300">
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2 text-sm text-red-600"/>
                    </div>

                    <!-- Zip -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Zip/Postal Code <span class="text-red-600">*</span></label>
                        <input type="text" name="zip_postal_code" value="{{ old('zip_postal_code') }}" required
                               placeholder="Zip/Postal Code *"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-300">
                        <x-input-error :messages="$errors->get('zip_postal_code')" class="mt-2 text-sm text-red-600"/>
                    </div>

                    <!-- Locality -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Locality/ House No. <span class="text-red-600">*</span></label>
                        <input type="text" name="locality_house_no" value="{{ old('locality_house_no') }}" required
                               placeholder="Locality/ House No. *"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-300">
                        <x-input-error :messages="$errors->get('locality_house_no')" class="mt-2 text-sm text-red-600"/>
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Street Address <span class="text-red-600">*</span></label>
                        <input type="text" name="street_address" value="{{ old('street_address') }}" required
                               placeholder="Street Address *"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-300">
                        <x-input-error :messages="$errors->get('street_address')" class="mt-2 text-sm text-red-600"/>
                    </div>

                    <!-- Landmark -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Landmark <span class="text-red-600">*</span></label>
                        <input type="text" name="landmark" value="{{ old('landmark') }}" required
                               placeholder="Landmark *"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-300">
                        <x-input-error :messages="$errors->get('landmark')" class="mt-2 text-sm text-red-600"/>
                    </div>

                    <!-- City -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City/District/Town <span class="text-red-600">*</span></label>
                        <input type="text" name="city_district_town" value="{{ old('city_district_town') }}" required
                               placeholder="City/District/Town *"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-300">
                        <x-input-error :messages="$errors->get('city_district_town')" class="mt-2 text-sm text-red-600"/>
                    </div>

                    <!-- State -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">State <span class="text-red-600">*</span></label>
                        <input type="text" name="state" value="{{ old('state') }}" required
                               placeholder="State *"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-300">
                        <x-input-error :messages="$errors->get('state')" class="mt-2 text-sm text-red-600"/>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-600">*</span></label>
                        <input type="password" name="password" required autocomplete="new-password"
                               placeholder="Password"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-300">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600"/>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Repeat Password <span class="text-red-600">*</span></label>
                        <input type="password" name="password_confirmation" required
                               placeholder="Repeat Password"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-300">
                    </div>
                </div>

                <!-- Submit -->
                <div class="mt-6">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded">
                        Signup
                    </button>
                </div>

                <p class="text-sm mt-4 text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
                </p>
            </form>
        </div>
    </div>
</x-front-layout>