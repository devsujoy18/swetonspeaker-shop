<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="POST"
                  action="{{ route('admin.users.update', $user->id) }}"
                  class="bg-white p-6 rounded-lg shadow space-y-4">

                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium">Name</label>
                    <input type="text" name="name"
                           value="{{ old('name', $user->name) }}"
                           class="w-full border-gray-300 rounded-md">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input type="email" name="email"
                           value="{{ old('email', $user->email) }}"
                           class="w-full border-gray-300 rounded-md">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium">Phone</label>
                    <input type="text" name="phone_number"
                           value="{{ old('phone_number', $user->phone_number) }}"
                           class="w-full border-gray-300 rounded-md">
                    @error('phone_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ZIP -->
                <div>
                    <label class="block text-sm font-medium">ZIP / Postal Code</label>
                    <input type="text" name="zip_postal_code"
                           value="{{ old('zip_postal_code', $user->zip_postal_code) }}"
                           class="w-full border-gray-300 rounded-md">
                    @error('zip_postal_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- House / Locality -->
                <div>
                    <label class="block text-sm font-medium">House / Locality</label>
                    <input type="text" name="locality_house_no"
                           value="{{ old('locality_house_no', $user->locality_house_no) }}"
                           class="w-full border-gray-300 rounded-md">
                    @error('locality_house_no')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Street -->
                <div>
                    <label class="block text-sm font-medium">Street Address</label>
                    <input type="text" name="street_address"
                           value="{{ old('street_address', $user->street_address) }}"
                           class="w-full border-gray-300 rounded-md">
                    @error('street_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Landmark -->
                <div>
                    <label class="block text-sm font-medium">Landmark</label>
                    <input type="text" name="landmark"
                           value="{{ old('landmark', $user->landmark) }}"
                           class="w-full border-gray-300 rounded-md">
                    @error('landmark')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City -->
                <div>
                    <label class="block text-sm font-medium">City / District / Town</label>
                    <input type="text" name="city_district_town"
                           value="{{ old('city_district_town', $user->city_district_town) }}"
                           class="w-full border-gray-300 rounded-md">
                    @error('city_district_town')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- State -->
                <div>
                    <label class="block text-sm font-medium">State</label>
                    <input type="text" name="state"
                           value="{{ old('state', $user->state) }}"
                           class="w-full border-gray-300 rounded-md">
                    @error('state')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company -->
                <div>
                    <label class="block text-sm font-medium">Company Name</label>
                    <input type="text" name="company_name"
                           value="{{ old('company_name', $user->company_name) }}"
                           class="w-full border-gray-300 rounded-md">
                    @error('company_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- GST -->
                <div>
                    <label class="block text-sm font-medium">GST Number</label>
                    <input type="text" name="gst_no"
                           value="{{ old('gst_no', $user->gst_no) }}"
                           class="w-full border-gray-300 rounded-md">
                    @error('gst_no')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Type -->
                <div>
                    <label class="block text-sm font-medium">User Type</label>
                    <select name="user_type" class="w-full border-gray-300 rounded-md">
                        <option value="user" {{ $user->user_type=='user'?'selected':'' }}>User</option>
                        <option value="guest" {{ $user->user_type=='guest'?'selected':'' }}>Guest</option>
                    </select>
                    @error('user_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4">
                    <button class="px-5 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Update User
                    </button>

                    <a href="{{ route('admin.users.index') }}"
                       class="px-5 py-2 bg-gray-100 rounded hover:bg-gray-200">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
