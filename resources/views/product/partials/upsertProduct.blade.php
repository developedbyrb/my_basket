@extends('layouts.app')

@section('content')
    <div class="card-wrapper">
        <div class="card p-4 md:p-5">
            <div class="card-header">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add a new product</h2>
            </div>
            <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
            <div class="card-body">
                <form id="productForm" method="POST"
                    action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}"
                    enctype="multipart/form-data">
                    @if (isset($product))
                        @method('PUT')
                    @endif
                    @csrf
                    <div class="grid gap-4 mb-4 md:grid-cols-2">
                        <div class="col-span-2 md:col-span-1 form-group">
                            <x-input-label for="name" :value="__('Product Name')" :required="true" />
                            <input type="text" name="name" id="name" class="custom-input-text"
                                placeholder="Type product name">
                        </div>
                        <div class="col-span-2 md:col-span-1 form-group">
                            <x-input-label for="tags" :value="__('Tags')" :required="true" />
                            <input type="text" name="tags" id="tags" class="custom-input-text"
                                placeholder="e.g. PC, Computers">
                        </div>
                    </div>
                    <div class="grid gap-4 mb-4 md:grid-cols-4">
                        <div class="col-span-2 md:col-span-1 form-group">
                            <x-input-label for="brand" :value="__('Brand')" :required="true" />
                            <input type="text" name="brand" id="brand" class="custom-input-text"
                                placeholder="Product brand">
                        </div>
                        <div class="col-span-2 md:col-span-1 form-group">
                            <x-input-label for="product_price" :value="__('Price')" :required="true" />
                            <input type="number" name="price" id="product_price"
                                aria-describedby="helper-text-explanation" class="custom-number-input" placeholder="0">
                        </div>
                        <div class="col-span-2 md:col-span-2 form-group">
                            <x-input-label for="weight" :value="__('Item Weight (kg)')" :required="true" />
                            <input type="number" name="weight" id="weight" aria-describedby="helper-text-explanation"
                                class="custom-number-input" placeholder="12">
                        </div>
                    </div>
                    <div class="grid gap-4 mb-4 md:grid-cols-4">
                        <div class="col-span-2 md:col-span-1 form-group">
                            @include('layouts.common.categoryDropdown', [
                                'categories' => $categories,
                                'parentData' => isset($attributeDetails) ? $attributeDetails : null,
                                'optionWidth' => 'w-1/5',
                            ])
                        </div>
                        <div class="col-span-2 md:col-span-1 form-group">
                            <x-input-label for="return_policy" :value="__('Return Policy')" :required="true" />
                            <select id="return_policy" name="return_policy" class="product-dropdown custom-input-text">
                                <option selected value="">None</option>
                                @foreach (config('globalConstant.RETURN_POLICY') as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2 md:col-span-2 form-group">
                            <div class="grid gap-4 mb-4 md:grid-cols-3">
                                <div class="col-span-2 md:col-span-1 form-group">
                                    <x-input-label for="length" :value="__('Length (cm)')" :required="false" />
                                    <input type="number" name="length" id="length"
                                        aria-describedby="helper-text-explanation" class="custom-number-input"
                                        placeholder="105">
                                </div>
                                <div class="col-span-2 md:col-span-1 form-group">
                                    <x-input-label for="breadth" :value="__('Breadth (cm)')" :required="false" />
                                    <input type="number" name="breadth" id="breadth"
                                        aria-describedby="helper-text-explanation" class="custom-number-input"
                                        placeholder="15">
                                </div>
                                <div class="col-span-2 md:col-span-1 form-group">
                                    <x-input-label for="width" :value="__('Width (cm)')" :required="false" />
                                    <input type="number" name="width" id="width"
                                        aria-describedby="helper-text-explanation" class="custom-number-input"
                                        placeholder="23">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-4 mb-4 md:grid-cols-4">
                        <div class="col-span-2 md:col-span-2">
                            <div class="grid gap-4 mb-4 md:grid-cols-2">
                                <div class="col-span-2 md:col-span-1 form-group">
                                    <div class="col-span-2 md:col-span-1 form-group">
                                        <x-input-label for="ship_from" :value="__('Ships From')" :required="false" />
                                        <input type="text" name="ship_from" id="ship_from" class="custom-input-text"
                                            placeholder="Tata products Inc.">
                                    </div>
                                </div>
                                <div class="col-span-2 md:col-span-1 form-group">
                                    <x-input-label for="sold_by" :value="__('Sold By')" :required="false" />
                                    <input type="text" name="sold_by" id="sold_by" class="custom-input-text"
                                        placeholder="Hindustan unilever">
                                </div>
                                <div class="col-span-2 md:col-span-1 form-group">
                                    <x-input-label for="import_fees" :value="__('Import Fees')" :required="false" />
                                    <input type="number" id="import_fees" name="import_fees"
                                        aria-describedby="helper-text-explanation" class="custom-number-input"
                                        placeholder="0">
                                </div>
                                <div class="col-span-2 md:col-span-1 form-group">
                                    <x-input-label for="return_policy" :value="__('Product State')" :required="true" />
                                    <select id="return_policy" name="return_policy"
                                        class="product-dropdown custom-input-text">
                                        @foreach (config('globalConstant.PRODUCT_STATE') as $key => $state)
                                            <option value="{{ $key }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-2 md:col-span-2 form-group">
                                    <x-input-label for="description" :value="__('Description')" :required="false" />
                                    <textarea id="description" rows="4" name="description" class="custom-text-area"
                                        placeholder="Write product description here..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2 md:col-span-2 form-group">
                            <div class="col-span-2">
                                <x-input-label for="dropzone-file" :value="__('Product Image')" :required="true" />
                                <div class="flex items-center justify-center w-full">
                                    <label for="dropzone-file"
                                        class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                    class="font-semibold">Click
                                                    to upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX.
                                                800x400px)
                                            </p>
                                        </div>
                                        <input id="dropzone-file" name="image" type="file" class="hidden" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-2 hidden" id="previewImage">
                                <x-input-label for="uploadedImage" :value="__('Uploaded Image')" :required="false" />
                                <img id="uploadedImage" src="" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="link-checkbox" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="link-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Product has multiple options, like different colors or sizes</label>
                    </div>

                    <div class="product-variants mt-4 hidden">
                        <div class="select-category-error mt-2">
                            <x-info-alert :message="__('Please select at least one category to see available options.')" />
                        </div>

                        <div class="variant-header justify-between hidden">
                            <h4 class="mb-2">Variants:</h4>
                            <button class="add-option-button" type="button" data-variant-count="1">
                                @include('svg.plus')
                                {{ __('Create More') }}
                            </button>
                        </div>
                        <div id="variant-section"></div>
                    </div>

                    <div class="flex flex-row-reverse mt-5">
                        <button type="submit" class="modal-submit-button">
                            Save
                        </button>
                        <a href="{{ route('shops.index') }}" type="button" class="modal-cancel-button">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('page-script')
    <script type="module">
        $(document).on('change', '#link-checkbox', function() {
            const addVariants = $(this).prop('checked');
            if (addVariants) {
                const selectedCheckBoxes = $('.category-selection:checkbox:checked');
                if (selectedCheckBoxes.length === 0) {
                    $('.select-category-error').removeClass('hidden');
                } else {
                    $('.variant-header').removeClass('hidden');
                    $('.variant-header').addClass('flex');
                    $('.select-category-error').addClass('hidden');
                    getVariantOptions(selectedCheckBoxes);
                }
                $('.product-variants').removeClass('hidden');
            } else {
                $('.variant-header').addClass('hidden');
                $('.product-variants').addClass('hidden');
                $('.variant-header').removeClass('flex');
            }
        });

        $(document).on('click', '.add-option-button', function() {
            let count = $(this).attr('data-variant-count');
            const selectedCheckBoxes = $('.category-selection:checkbox:checked');
            if (selectedCheckBoxes.length > 0 && count) {
                count++;
                getVariantOptions(selectedCheckBoxes, count);
                if (count > 1) {
                    $('.remove-variant').addClass('flex');
                    $('.remove-variant').removeClass('hidden');
                }
                $(this).attr('data-variant-count', count);
            }
        });

        $(document).on('click', '.remove-option-button', function() {
            $(this).closest('.option-row').remove();
            const totalOption = $('.add-option-button').attr('data-variant-count');
            $('.add-option-button').attr('data-variant-count', totalOption - 1);
            if (Number($('.add-option-button').attr('data-variant-count')) === 1) {
                $('.remove-variant').removeClass('flex');
                $('.remove-variant').addClass('hidden');
            }
        });

        $(document).on('change', '#dropzone-file', function() {
            readURL($(this));
        });

        function getVariantOptions(selectedData, count = 1) {
            setupAjax();
            const data = selectedData.map(function() {
                return $(this).val();
            }).get();
            const postURL = "{{ route('categories.attributes') }}";

            let formData = new FormData();
            formData.append('variantCount', count);
            for (var i = 0; i < data.length; i++) {
                formData.append('categories[]', data[i]);
            }
            $.ajax({
                url: postURL,
                type: 'POST',
                data: formData,
                async: false,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(success) {
                    $('#variant-section').html(success.data.html);
                },
                error: function(data) {}
            });
        }

        function readURL(input) {
            if (input[0].files && input[0].files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage').removeClass('hidden');
                    $('#uploadedImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(input[0].files[0]);
            } else {
                $('#previewImage').addClass('hidden');
                $('#uploadedImage').attr('src', '');
            }
        }
    </script>
@endpush
