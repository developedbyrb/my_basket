@for ($i = 0; $i < $variantCount; $i++)
    <div class="border border-gray-200 rounded-lg mt-4 option-row">
        <div class="p-4 md:p-5">
            <div class="grid grid-cols-12 gap-3">
                <div class="col-span-10">
                    <div class="grid gap-4 mb-4 md:grid-cols-3">
                        @foreach ($variants as $variant)
                            <div class="col-span-1 md:col-span-1 form-group">
                                <label for="state" class="form-label">{{ $variant->name }}
                                    <span style="color:red"> *</span></label>
                                <select id="state" class="custom-input-text" name="variants[0][state]">
                                    @foreach ($variant->attributeOptions as $option)
                                        <option value="{{ $option->id }}">{{ $option->value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                        <div class="col-span-1 md:col-span-1 form-group">
                            <x-input-label for="price" :value="__('Price')" :required="true" />
                            <x-text-input id="price" class="block mt-1 w-full" type="text" name="price"
                                :value="0" autofocus autocomplete="price" placeholder="0" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div class="col-span-3 md:col-span-3 form-group">
                            <input id="variant-{{ $variant->id }}" type="checkbox" value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="variant-{{ $variant->id }}"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Make this variant as default.</label>
                        </div>
                    </div>
                </div>
                <div class="col-span-2 hidden justify-center items-center remove-variant">
                    <button type="button" class="remove-option-button">
                        {{ __('Remove') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endfor
