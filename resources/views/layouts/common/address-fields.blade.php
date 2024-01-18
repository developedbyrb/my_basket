<div class="grid grid-cols-5 gap-3 address-row px-2 py-2">
    <div class="col-span-4">
        <div class="grid gap-4 mb-4 md:grid-cols-4">
            <div class="col-span-1 md:col-span form-group">
                <x-input-label for="house_no-0" :value="__('House Number')" :required="true" />
                <input type="text" name="addresses[0][house_no]" id="house_no-0" class="custom-input-text"
                    placeholder="Type house_no">
                <x-input-error :messages="$errors->get('addresses.*.house_no')" class="mt-2" />
            </div>
            <div class="col-span-1 md:col-span-1 form-group">
                <x-input-label for="area-0" :value="__('Area')" :required="true" />
                <input type="text" name="addresses[0][area]" id="area-0" class="custom-input-text"
                    placeholder="Type area">
                <x-input-error :messages="$errors->get('addresses.*.area')" class="mt-2" />
            </div>
            <div class="col-span-1 md:col-span-1 form-group">
                <x-input-label for="city-0" :value="__('City')" :required="true" />
                <input type="text" name="addresses[0][city]" id="city-0" class="custom-input-text"
                    placeholder="Type city">
                <x-input-error :messages="$errors->get('addresses.*.city')" class="mt-2" />
            </div>
            <div class="col-span-1 md:col-span-1 form-group">
                <x-input-label for="state-0" :value="__('State')" :required="true" />
                <select id="state-0" class="custom-input-text" name="addresses[0][state]">
                    <option selected value="">Select State</option>
                    @foreach (config('globalConstant.GEO_CONFIG_STATES') as $state)
                        <option value="{{ $state['id'] }}">{{ $state['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid gap-4 mb-4 md:grid-cols-3">
            <div class="col-span-1 md:col-span-1 form-group">
                <x-input-label for="country-0" :value="__('Country')" :required="true" />
                <select id="country-0" class="custom-input-text" name="addresses[0][country]">
                    <option selected value="">Select country</option>
                    @foreach (config('globalConstant.GEO_CONFIG_COUNTRIES') as $country)
                        <option value="{{ $country['id'] }}">{{ $country['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-1 md:col-span-1 form-group">
                <x-input-label for="address-pincode-0" :value="__('Address Pincode')" :required="true" />
                <input type="text" name="addresses[0][pincode]" id="address-pincode-0" class="custom-input-text"
                    placeholder="Type pincode">
                <x-input-error :messages="$errors->get('addresses.*.pincode')" class="mt-2" />
            </div>
            <div class="col-span-1 md:col-span-1 form-group">
                <x-input-label for="address-alias-0" :value="__('Address Alias')" :required="true" />
                <x-text-input id="address-alias-0" class="block mt-1 w-full" type="text" name="addresses[0][alias]"
                    :value="old('alias')" autocomplete="alias name" placeholder="Type address alias i.e. Warehouse" />
                <x-input-error :messages="$errors->get('addresses.*.alias')" class="mt-2" />
            </div>
        </div>
        <div class="col-span-2 md:col-span-2 flex items-center form-group mt-4">
            <input type="checkbox" id="variant-0" value="1" name="addresses[0][is_default]"
                class="make-default-checkbox">
            <label for="variant-0" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                Make this as default.</label>
        </div>
    </div>
    <div class="flex justify-center items-center remove-address">
        <button class="remove-address-button" type="button" data-current-address="0">
            {{ __('Remove') }}
        </button>
    </div>
</div>
