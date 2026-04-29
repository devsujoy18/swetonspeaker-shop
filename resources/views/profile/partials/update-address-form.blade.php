<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Address Information') }}
        </h2>

        <div class="mt-3 rounded-md bg-yellow-50 p-4 flex items-start">
            <svg class="h-5 w-5 text-yellow-400 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M8.257 3.099c.366-.756 1.42-.756 1.786 0l7.451 15.38A1 1 0 0 1 16.57 20H3.43a1 1 0 0 1-.924-1.521l7.75-15.38zM11 14a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm-1-8a.75.75 0 0 0-.75.75v4.5a.75.75 0 0 0 1.5 0v-4.5A.75.75 0 0 0 10 6z"
                    clip-rule="evenodd" />
            </svg>

            <div class="ml-3 text-sm text-yellow-800">
                <span class="font-semibold">Attention needed:</span>
                Please note that the modified address will be used for your <strong>future orders only</strong>. 
                For any changes to an address, phone number, or other details related to an already placed order, 
                contact us immediately at 
                <a href="tel:7044411800" class="font-semibold text-yellow-900 hover:underline">7044411800</a> 
                or email 
                <a href="mailto:sales@swetonspeakers.com" class="font-semibold text-yellow-900 hover:underline">sales@swetonspeakers.com</a>.
            </div>
        </div>



    </header>

    <form method="post" action="{{ route('profile.update.address') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full"
                :value="old('phone_number', $user->phone_number)" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <div>
            <x-input-label for="zip_postal_code" :value="__('ZIP / Postal Code')" />
            <x-text-input id="zip_postal_code" name="zip_postal_code" type="text" class="mt-1 block w-full"
                :value="old('zip_postal_code', $user->zip_postal_code)" />
            <x-input-error class="mt-2" :messages="$errors->get('zip_postal_code')" />
        </div>

        <div>
            <x-input-label for="locality_house_no" :value="__('House No / Locality')" />
            <x-text-input id="locality_house_no" name="locality_house_no" type="text" class="mt-1 block w-full"
                :value="old('locality_house_no', $user->locality_house_no)" />
            <x-input-error class="mt-2" :messages="$errors->get('locality_house_no')" />
        </div>

        <div>
            <x-input-label for="street_address" :value="__('Street Address')" />
            <x-text-input id="street_address" name="street_address" type="text" class="mt-1 block w-full"
                :value="old('street_address', $user->street_address)" />
            <x-input-error class="mt-2" :messages="$errors->get('street_address')" />
        </div>

        <div>
            <x-input-label for="landmark" :value="__('Landmark')" />
            <x-text-input id="landmark" name="landmark" type="text" class="mt-1 block w-full"
                :value="old('landmark', $user->landmark)" />
            <x-input-error class="mt-2" :messages="$errors->get('landmark')" />
        </div>

        <div>
            <x-input-label for="city_district_town" :value="__('City / District / Town')" />
            <x-text-input id="city_district_town" name="city_district_town" type="text" class="mt-1 block w-full"
                :value="old('city_district_town', $user->city_district_town)" />
            <x-input-error class="mt-2" :messages="$errors->get('city_district_town')" />
        </div>

        <div>
            <x-input-label for="state" :value="__('State')" />
            <x-text-input id="state" name="state" type="text" class="mt-1 block w-full"
                :value="old('state', $user->state)" />
            <x-input-error class="mt-2" :messages="$errors->get('state')" />
        </div>
        
        <div>
            <x-input-label for="company_name" :value="__('Company Name')" />
            <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full"
                :value="old('company_name', $user->company_name)" />
            <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
        </div>

        <div>
            <x-input-label for="gst_no" :value="__('GST Number')" />
            <x-text-input id="gst_no" name="gst_no" type="text" class="mt-1 block w-full"
                :value="old('gst_no', $user->gst_no)" />
            <x-input-error class="mt-2" :messages="$errors->get('gst_no')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Address') }}</x-primary-button>

            @if (session('status') === 'address-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
