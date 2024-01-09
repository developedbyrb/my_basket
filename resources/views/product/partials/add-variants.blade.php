<div class="border border-gray-200 rounded-lg mt-4 option-row">
    <div class="p-4 md:p-5">
        <div class="grid grid-cols-12 gap-3">
            <div class="col-span-10">
                <div class="grid gap-4 mb-4 md:grid-cols-3">
                    @foreach ($variants as $variant)
                        <div class="col-span-1 md:col-span-1 form-group">
                            <label for="{{ $variant->name }}-0" class="form-label">{{ $variant->name }}
                                <span style="color:red"> *</span></label>
                            <select id="{{ $variant->name }}-0" class="custom-input-text variant-selector"
                                name="variants[0][{{ strtolower($variant->name) }}]">
                                @foreach ($variant->attributeOptions as $option)
                                    <option value="{{ $option->id }}">{{ $option->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                    <div class="col-span-1 md:col-span-1 form-group">
                        <x-input-label for="stock-0" :value="__('Available Stock')" :required="true" />
                        <x-text-input id="stock-0" class="block mt-1 w-full" type="text"
                            name="variants[0][avail_stock]" :value="0" autocomplete="stock" placeholder="0" />
                        <x-input-error :messages="$errors->get('avail_stock')" class="mt-2" />
                    </div>
                    <div class="col-span-1 md:col-span-1 form-group">
                        <x-input-label for="price-0" :value="__('Price')" :required="true" />
                        <x-text-input id="price-0" class="block mt-1 w-full" type="text" name="variants[0][price]"
                            :value="0" autocomplete="price" placeholder="0" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                    <div class="col-span-1 md:col-span-1 form-group">
                        <label class="form-label" for="image-0">Image</label>
                        <input class="file-input" aria-describedby="variant_image" id="image-0" type="file"
                            name="variants[0][image]">
                    </div>
                    <div class="col-span-2 md:col-span-2 flex items-center form-group mt-4">
                        <input type="checkbox" id="variant-0" value="1" name="variants[0][is_default]"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="variant-0" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
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
