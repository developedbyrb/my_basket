@extends('layouts.card')

@section('card')
    @if (isset($shop))
        <x-card-header :title="__('Edit Shop Details')" />
    @else
        <x-card-header :title="__('Create New Shop')" />
    @endif
    <div class="card-body">
        <form class="p-4 md:p-5" id="shopForm" method="POST"
            action="{{ isset($shop) ? route('shops.update', $shop->id) : route('shops.store') }}"
            enctype="multipart/form-data">
            @if (isset($shop))
                @method('PUT')
            @endif
            @csrf
            <div class="grid gap-4 mb-4 md:grid-cols-2">
                <div class="col-span-2 md:col-span-1 form-group">
                    <label for="name" class="form-label">Name <span style="color:red"> *</span></label>
                    <input type="text" name="name" id="name" class="custom-input-text"
                        placeholder="Type shop name" value="{{ isset($shop) ? $shop->name : '' }}">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="col-span-2 md:col-span-1 form-group">
                    <label class="form-label" for="shop_image">Image <span style="color:red"> *</span></label>
                    <input class="file-input" aria-describedby="shop_image_help" id="shop_image" type="file"
                        name="image">
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg">
                <div class="p-4 md:p-5">
                    <div class="flex justify-between">
                        <h4 class="mb-2">Address:</h4>
                        <button class="add-address-button" type="button" data-address-count="0">
                            @include('svg.plus')
                            {{ __('Create More') }}
                        </button>
                    </div>
                    <div id="addressFields">
                        @if (isset($shop))
                            @foreach ($shop->address as $keyAddress => $address)
                                <div class="grid grid-cols-5 gap-3 address-row">
                                    <div class="col-span-4">
                                        <div class="grid gap-4 mb-4 md:grid-cols-4">
                                            <div class="col-span-1 md:col-span form-group">
                                                <label for="house_no" class="form-label">
                                                    House Number</label>
                                                <input type="text" name="addresses[{{ $keyAddress }}][house_no]"
                                                    value="{{ $address->house_no }}" id="house_no"
                                                    class="custom-input-text" placeholder="Type house number">
                                            </div>
                                            <div class="col-span-1 md:col-span-1 form-group">
                                                <label for="area" class="form-label">Area</label>
                                                <input type="text" name="addresses[{{ $keyAddress }}][area]"
                                                    id="area" class="custom-input-text" placeholder="Type area"
                                                    value="{{ $address->area }}">
                                            </div>
                                            <div class="col-span-1 md:col-span-1 form-group">
                                                <label for="city" class="form-label">City</label>
                                                <input type="text" name="addresses[{{ $keyAddress }}][city]"
                                                    id="city" class="custom-input-text" placeholder="Type city"
                                                    value="{{ $address->city }}">
                                            </div>
                                            <div class="col-span-1 md:col-span-1 form-group">
                                                <label for="state" class="form-label">State</label>
                                                <select id="state" class="custom-input-text"
                                                    name="addresses[{{ $keyAddress }}][state]">
                                                    <option selected value="">Select State</option>
                                                    <option {{ $address->state == 'gujrat' ? 'selected' : '' }}
                                                        value="gujrat">
                                                        Gujrat</option>
                                                    <option {{ $address->state == 'rajsthan' ? 'selected' : '' }}
                                                        value="rajsthan">
                                                        Rajsthan</option>
                                                    <option {{ $address->state == 'up' ? 'selected' : '' }} value="up">
                                                        Uttar Pradesh</option>
                                                    <option {{ $address->state == 'nj' ? 'selected' : '' }} value="nj">
                                                        New
                                                        Jearsy</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid gap-4 mb-4 md:grid-cols-2">
                                            <div class="col-span-2 md:col-span-1 form-group">
                                                <label for="country" class="form-label">Country</label>
                                                <select id="country" class="custom-input-text"
                                                    name="addresses[{{ $keyAddress }}][country]">
                                                    <option selected value="">Select country</option>
                                                    <option {{ $address->country == 'india' ? 'selected' : '' }}
                                                        value="india">
                                                        India</option>
                                                    <option {{ $address->country == 'usa' ? 'selected' : '' }}
                                                        value="usa">
                                                        USA
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-span-2 md:col-span-1 form-group">
                                                <label for="pincode" class="form-label">Pincode</label>
                                                <input type="text" name="addresses[{{ $keyAddress }}][pincode]"
                                                    id="pincode" class="custom-input-text" placeholder="Type pincode"
                                                    value="{{ $address->pincode }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hidden justify-center items-center remove-address">
                                        <button class="remove-address-button" type="button" data-current-address="0">
                                            {{ __('Remove') }}
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="grid grid-cols-5 gap-3 address-row px-2 py-2">
                                <div class="col-span-4">
                                    <div class="grid gap-4 mb-4 md:grid-cols-4">
                                        <div class="col-span-1 md:col-span form-group">
                                            <label for="house_no" class="form-label">
                                                House Number <span style="color:red"> *</span></label>
                                            <input type="text" name="addresses[0][house_no]" id="house_no"
                                                class="custom-input-text" placeholder="Type house number">
                                        </div>
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="area" class="form-label">Area <span style="color:red">
                                                    *</span></label>
                                            <input type="text" name="addresses[0][area]" id="area"
                                                class="custom-input-text" placeholder="Type area">
                                        </div>
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="city" class="form-label">City <span style="color:red">
                                                    *</span></label>
                                            <input type="text" name="addresses[0][city]" id="city"
                                                class="custom-input-text" placeholder="Type city">
                                        </div>
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="state" class="form-label">State <span style="color:red">
                                                    *</span></label>
                                            <select id="state" class="custom-input-text" name="addresses[0][state]">
                                                <option selected value="">Select State</option>
                                                <option value="gujarat">Gujarat</option>
                                                <option value="rajsthan">Rajsthan</option>
                                                <option value="up">Uttar Pradesh</option>
                                                <option value="nj">New Jearsy</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid gap-4 mb-4 md:grid-cols-3">
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="country" class="form-label">Country <span style="color:red">
                                                    *</span></label>
                                            <select id="country" class="custom-input-text"
                                                name="addresses[0][country]">
                                                <option selected value="">Select country</option>
                                                <option value="india">India</option>
                                                <option value="usa">USA</option>
                                            </select>
                                        </div>
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <x-input-label for="address-pincode-0" :value="__('Address Pincode')" :required="true" />
                                            <input type="text" name="addresses[0][pincode]" id="pincode"
                                                class="custom-input-text" placeholder="Type pincode">
                                            <x-input-error :messages="$errors->get('addresses.*.pincode')" class="mt-2" />
                                        </div>
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <x-input-label for="address-alias-0" :value="__('Address Alias')" :required="true" />
                                            <x-text-input id="address-alias-0" class="block mt-1 w-full" type="text"
                                                name="addresses[0][alias]" :value="old('alias')" autocomplete="attribute name"
                                                placeholder="Type address alias i.e. Warehouse" />
                                            <x-input-error :messages="$errors->get('addresses.*.alias')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-span-2 md:col-span-2 flex items-center form-group mt-4">
                                        <input type="checkbox" id="variant-0" value="1"
                                            name="addresses[0][is_default]"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="variant-0"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            Make this as default.</label>
                                    </div>
                                </div>
                                <div class="hidden justify-center items-center remove-address">
                                    <button class="remove-address-button" type="button" data-current-address="0">
                                        {{ __('Remove') }}
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg mt-3">
                <div class="p-4 md:p-5">
                    <div class="flex justify-between">
                        <h4 class="mb-2">Products:</h4>
                        <button class="add-product-button" type="button" data-product-count="0">
                            @include('svg.plus')
                            {{ __('Create More') }}
                        </button>
                    </div>
                    <div id="productFields">
                        @if (isset($shop))
                            @foreach ($shop->product as $key => $shopProduct)
                                <div class="grid grid-cols-5 gap-3 product-row">
                                    <div class="col-span-4">
                                        <div class="grid gap-4 mb-4 md:grid-cols-3">
                                            <div class="col-span-1 md:col-span-1 form-group">
                                                <label for="product_id" class="form-label">
                                                    Product</label>
                                                <select id="product_id" class="product-dropdown custom-input-text"
                                                    name="products[{{ $key }}][product_id]">
                                                    <option selected value="">Select Product</option>
                                                    @foreach ($products as $productDetails)
                                                        <option
                                                            {{ $shopProduct->product_id == $productDetails['id'] ? 'selected' : '' }}
                                                            value="{{ $productDetails['id'] }}">
                                                            {{ $productDetails['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-span-1 md:col-span-1 form-group">
                                                <label for="qty" class="form-label">Stock
                                                    Quantity</label>
                                                <input type="text" name="products[{{ $key }}][qty]"
                                                    id="qty" class="custom-input-text" placeholder="Type qty"
                                                    value="{{ $shopProduct->stock_qty }}">
                                            </div>
                                            <div class="col-span-1 md:col-span-1 form-group">
                                                <label for="price" class="form-label">Price
                                                </label>
                                                <input type="text" name="products[{{ $key }}][price]"
                                                    id="price" class="custom-input-text" placeholder="Type price"
                                                    value="{{ $shopProduct->price }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hidden justify-center items-center remove-product">
                                        <button class="remove-product-button" type="button" data-current-product="0">
                                            {{ __('Remove') }}
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="grid grid-cols-5 gap-3 product-row">
                                <div class="col-span-4">
                                    <div class="grid gap-4 mb-4 md:grid-cols-3">
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="product_id" class="form-label">
                                                Product <span style="color:red"> *</span></label>
                                            <select id="product_id" class="product-dropdown custom-input-text"
                                                name="products[0][product_id]">
                                                <option selected value="">Select Product</option>
                                                @foreach ($products as $productDetails)
                                                    <option value="{{ $productDetails['id'] }}">
                                                        {{ $productDetails['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="qty" class="form-label">Stock
                                                Quantity <span style="color:red"> *</span></label>
                                            <input type="text" name="products[0][qty]" id="qty"
                                                class="custom-input-text" placeholder="Type qty">
                                        </div>
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="price" class="form-label">Price<span style="color:red">
                                                    *</span>
                                            </label>
                                            <input type="text" name="products[0][price]" id="price"
                                                class="custom-input-text" placeholder="Type price">
                                        </div>
                                    </div>
                                </div>
                                <div class="hidden justify-center items-center remove-product">
                                    <button class="remove-product-button" type="button" data-current-product="0">
                                        {{ __('Remove') }}
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
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
@endsection

@push('page-script')
    <script type="module">
        let totalAddressCount = 1;
        let totalProductCount = 1;
        const productArray = @json($products);
        let assignedAddress = [];
        let assignedProduct = [];
        let isEdit = false;
        @if (isset($shop))
            isEdit = true;
            assignedAddress = @json($shop->address);
            assignedProduct = @json($shop->product);
        @endif

        $(document).ready(function() {
            if (isEdit) {
                totalAddressCount = assignedAddress.length;
                totalProductCount = assignedProduct.length;
                $('.add-address-button').data('address-count', (assignedAddress.length - 1));
                if (totalAddressCount > 1) {
                    $('.remove-address').removeClass('hidden');
                } else {
                    $('.remove-address').addClass('hidden');
                }

                $('.add-product-button').data('product-count', (assignedProduct.length - 1));
                if (totalProductCount > 1) {
                    $('.remove-product').removeClass('hidden');
                } else {
                    $('.remove-product').addClass('hidden');
                }
            }
        });

        $(document).on('click', '.modal-submit-button', function(e) {
            $("#shopForm").validate({
                rules: {
                    name: requiredAndTrimmed(),
                    image: {
                        required: isEdit ? false : true,
                        fileExtension: true
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            $('input[name^="addresses"]').filter('input[name$="[house_no]"]').each(function() {
                $(this).rules("add", requiredAndTrimmed());
            });
            $('input[name^="addresses"]').filter('input[name$="[area]"]').each(function() {
                $(this).rules("add", requiredAndTrimmed());
            });
            $('input[name^="addresses"]').filter('input[name$="[city]"]').each(function() {
                $(this).rules("add", requiredAndTrimmed());
            });
            $('input[name^="addresses"]').filter('input[name$="[pincode]"]').each(function() {
                $(this).rules("add", requiredAndTrimmed());
            });
            $('input[name^="addresses"]').filter('input[name$="[alias]"]').each(function() {
                $(this).rules("add", requiredAndTrimmed());
            });
            $('input[name^="products"]').filter('input[name$="[qty]"]').each(function() {
                $(this).rules("add", Object.assign(requiredAndTrimmed(), {
                    number: true,
                    min: 1,
                }));
            });
            $('input[name^="products"]').filter('input[name$="[price]"]').each(function() {
                $(this).rules("add", Object.assign(requiredAndTrimmed(), {
                    number: true,
                    min: 1,
                }));
            });
            $('select[name^="addresses"]').filter('select[name$="[state]"]').each(function() {
                $(this).rules("add", requiredAndTrimmed());
            });
            $('select[name^="addresses"]').filter('select[name$="[country]"]').each(function() {
                $(this).rules("add", requiredAndTrimmed());
            });
            $('select[name^="products"]').filter('select[name$="[product_id]"]').each(function() {
                $(this).rules("add", requiredAndTrimmed());
            });
        });

        $(document).on('click', '.add-address-button', function(e) {
            e.preventDefault();
            let currentAddressCount = $(this).data('address-count');
            currentAddressCount++;

            let html = '';
            html += '<div class="grid grid-cols-5 gap-3 address-row">';
            html += '<div class="col-span-4">';
            html += '<div class="grid gap-4 mb-4 md:grid-cols-4">';
            html += '<div class="col-span-1 md:col-span form-group">';
            html += '<label for="house_no"';
            html += 'class="form-label">';
            html += 'House Number</label>';
            html += '<input type="text" name="addresses[' + currentAddressCount + '][house_no]" id="house_no"';
            html += 'class="custom-input-text" placeholder="Type house number">';
            html += '</div>';
            html += '<div class="col-span-1 md:col-span-1 form-group">';
            html += '<label for="area"';
            html += 'class="form-label">Area</label>';
            html += '<input type="text" name="addresses[' + currentAddressCount +
                '][area]" id="area" class="custom-input-text"';
            html += 'placeholder="Type area">';
            html += '</div>';
            html += '<div class="col-span-1 md:col-span-1 form-group">';
            html += '<label for="city"';
            html += 'class="form-label">City</label>';
            html += '<input type="text" name="addresses[' + currentAddressCount +
                '][city]" id="city" class="custom-input-text"';
            html += 'placeholder="Type city">';
            html += '</div>';
            html += '<div class="col-span-1 md:col-span-1 form-group">';
            html += '<label for="state"';
            html += 'class="form-label">State</label>';
            html += '<select id="state" class="custom-input-text" name="addresses[' + currentAddressCount +
                '][state]">';
            html += '<option selected value="">Select State</option>';
            html += '<option value="gujarat">Gujarat</option>';
            html += '<option value="rajsthan">Rajsthan</option>';
            html += '<option value="up">Uttar Pradesh</option>';
            html += '<option value="nj">New Jearsy</option>';
            html += '</select>';
            html += '</div>';
            html += '</div>';
            html += '<div class="grid gap-4 mb-4 md:grid-cols-2">';
            html += '<div class="col-span-2 md:col-span-1 form-group">';
            html += '<label for="country"';
            html += 'class="form-label">Country</label>';
            html += '<select id="country" class="custom-input-text" name="addresses[' + currentAddressCount +
                '][country]">';
            html += '<option selected value="">Select country</option>';
            html += '<option value="india">India</option>';
            html += '<option value="usa">USA</option>';
            html += '</select>';
            html += '</div>';
            html += '<div class="col-span-2 md:col-span-1 form-group">';
            html += '<label for="pincode"';
            html += 'class="form-label">Pincode</label>';
            html += '<input type="text" name="addresses[' + currentAddressCount + '][pincode]" id="pincode"';
            html += 'class="custom-input-text" placeholder="Type pincode">';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="flex justify-center items-center remove-address">';
            html += '<button class="remove-address-button" type="button">';
            html += '{{ __('Remove') }}';
            html += '</button>';
            html += '</div>';
            html += '</div>';

            $(this).data('address-count', currentAddressCount);
            $('#addressFields').append(html);
            totalAddressCount = totalAddressCount + 1;
            if (totalAddressCount > 1) {
                $('.remove-address').removeClass('hidden');
            }
        });

        $(document).on('click', '.remove-address-button', function(e) {
            $(this).closest('.address-row').remove();
            totalAddressCount = totalAddressCount - 1;
            if (totalAddressCount === 1) {
                $('.remove-address').addClass('hidden');
            }
        });

        $(document).on('click', '.add-product-button', function(e) {
            e.preventDefault();
            let currentProductCount = $(this).data('product-count');
            currentProductCount++;
            let html = '';
            html += '<div class="grid grid-cols-5 gap-3 product-row">';
            html += '<div class="col-span-4">';
            html += '<div class="grid gap-4 mb-4 md:grid-cols-3">';
            html += '<div class="col-span-1 md:col-span-1 form-group">';
            html += '<label for="product_id-' + currentProductCount +
                '"';
            html += 'class="form-label">';
            html += 'Product</label>';
            html += '<select id="product_id-' + currentProductCount +
                '" class="product-dropdown custom-input-text" name="products[' +
                currentProductCount +
                '][product_id]">';
            html += '<option selected value="">Select Product</option>';
            productArray.forEach(element => {
                html += '<option value="' + element.id + '">' + element.name +
                    '</option>';
            });
            html += '</select>';
            html += '</div>';
            html += '<div class="col-span-1 md:col-span-1 form-group">';
            html += '<label for="qty"';
            html += 'class="form-label">Stock';
            html += 'Quantity</label>';
            html += '<input type="text" name="products[' + currentProductCount + '][qty]" id="qty"';
            html += 'class="custom-input-text" placeholder="Type qty">';
            html += '</div>';
            html += '<div class="col-span-1 md:col-span-1 form-group">';
            html += '<label for="price"';
            html += 'class="form-label">Price';
            html += '</label>';
            html += '<input type="text" name="products[' + currentProductCount + '][price]" id="price"';
            html += 'class="custom-input-text" placeholder="Type price">';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="hidden flex justify-center items-center remove-product">';
            html += '<button class="remove-product-button" type="button" data-current-product="0">';
            html += '{{ __('Remove') }}';
            html += '</button>';
            html += '</div>';
            html += '</div>';

            $(this).data('product-count', currentProductCount);
            $('#productFields').append(html);
            totalProductCount = totalProductCount + 1;
            if (totalProductCount > 1) {
                $('.remove-product').removeClass('hidden');
            }
            disableSelection();
        });

        $(document).on('click', '.remove-product-button', function(e) {
            $(this).closest('.product-row').remove();
            totalProductCount = totalProductCount - 1;
            if (totalProductCount === 1) {
                $('.remove-product').addClass('hidden');
            }
        });

        function disableSelection() {
            var all_selects = $(".product-dropdown");
            $(".product-dropdown option").prop("disabled",
                false);
            for (var x = 0; x < all_selects.length; x++) {
                var currentSelection = $(all_selects[x]).prop("id");
                for (var y = 0; y < all_selects.length; y++) {
                    if (currentSelection == $(all_selects[y]).prop("id")) continue;
                    console.log('test', currentSelection, $(all_selects[y]).prop("id"));
                    var selectedPerson = $(all_selects[x]).val();
                    if (selectedPerson !== "") {
                        $(all_selects[y]).find("option[value='" + selectedPerson + "']").attr("disabled",
                            "disabled");
                    }
                }
            }
        }

        $(document).on('change', '.product-dropdown', function(e) {
            disableSelection();
        });
    </script>
@endpush
