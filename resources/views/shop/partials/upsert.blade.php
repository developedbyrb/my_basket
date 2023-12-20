@extends('layouts.app')

@section('content')
    <div
        class="grid mb-8 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 md:mb-12 bg-white dark:bg-gray-800">
        <form class="p-4 md:p-5" id="shopForm" method="POST" action="{{ route('shops.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 mb-4 md:grid-cols-2">
                <div class="col-span-2 md:col-span-1 form-group">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" name="name" id="name" class="custom-input-text"
                        placeholder="Type shop name" value="{{ isset($shop) ? $shop->name : '' }}">
                </div>
                <div class="col-span-2 md:col-span-1 form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        for="shop_image">Image</label>
                    <input class="file-input" aria-describedby="shop_image_help" id="shop_image" type="file"
                        name="image">
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg">
                <div class="p-4 md:p-5">
                    <div class="flex justify-between">
                        <h4 class="mb-2">Address:</h4>
                        <button class="add-address-button" type="button" data-address-count="0">
                            <x-plus-svg />
                            {{ __('Create More') }}
                        </button>
                    </div>
                    <div id="addressFields">
                        @if (isset($shop))
                            @foreach ($shop->address as $address)
                                <div class="grid grid-cols-5 gap-3 address-row">
                                    <div class="col-span-4">
                                        <div class="grid gap-4 mb-4 md:grid-cols-4">
                                            <div class="col-span-1 md:col-span form-group">
                                                <label for="house_no"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                    House Number</label>
                                                <input type="text" name="addresses[0][house_no]" id="house_no"
                                                    class="custom-input-text" placeholder="Type house number"
                                                    value="{{ $address->house_no }}">
                                            </div>
                                            <div class="col-span-1 md:col-span-1 form-group">
                                                <label for="area"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Area</label>
                                                <input type="text" name="addresses[0][area]" id="area"
                                                    class="custom-input-text" placeholder="Type area"
                                                    value="{{ $address->area }}">
                                            </div>
                                            <div class="col-span-1 md:col-span-1 form-group">
                                                <label for="city"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                                                <input type="text" name="addresses[0][city]" id="city"
                                                    class="custom-input-text" placeholder="Type city"
                                                    value="{{ $address->city }}">
                                            </div>
                                            <div class="col-span-1 md:col-span-1 form-group">
                                                <label for="state"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State</label>
                                                <select id="state" class="custom-input-text" name="addresses[0][state]">
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
                                                <label for="country"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country</label>
                                                <select id="country" class="custom-input-text"
                                                    name="addresses[0][country]">
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
                                                <label for="pincode"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pincode</label>
                                                <input type="text" name="addresses[0][pincode]" id="pincode"
                                                    class="custom-input-text" placeholder="Type pincode"
                                                    value="{{ $address->pincode }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hidden flex justify-center items-center remove-address">
                                        <button class="remove-address-button" type="button" data-current-address="0">
                                            {{ __('Remove') }}
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="grid grid-cols-5 gap-3 address-row">
                                <div class="col-span-4">
                                    <div class="grid gap-4 mb-4 md:grid-cols-4">
                                        <div class="col-span-1 md:col-span form-group">
                                            <label for="house_no"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                House Number</label>
                                            <input type="text" name="addresses[0][house_no]" id="house_no"
                                                class="custom-input-text" placeholder="Type house number">
                                        </div>
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="area"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Area</label>
                                            <input type="text" name="addresses[0][area]" id="area"
                                                class="custom-input-text" placeholder="Type area">
                                        </div>
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="city"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                                            <input type="text" name="addresses[0][city]" id="city"
                                                class="custom-input-text" placeholder="Type city">
                                        </div>
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="state"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State</label>
                                            <select id="state" class="custom-input-text" name="addresses[0][state]">
                                                <option selected value="">Select State</option>
                                                <option value="gujrat">Gujrat</option>
                                                <option value="rajsthan">Rajsthan</option>
                                                <option value="up">Uttar Pradesh</option>
                                                <option value="nj">New Jearsy</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid gap-4 mb-4 md:grid-cols-2">
                                        <div class="col-span-2 md:col-span-1 form-group">
                                            <label for="country"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country</label>
                                            <select id="country" class="custom-input-text"
                                                name="addresses[0][country]">
                                                <option selected value="">Select country</option>
                                                <option value="india">India</option>
                                                <option value="usa">USA</option>
                                            </select>
                                        </div>
                                        <div class="col-span-2 md:col-span-1 form-group">
                                            <label for="pincode"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pincode</label>
                                            <input type="text" name="addresses[0][pincode]" id="pincode"
                                                class="custom-input-text" placeholder="Type pincode">
                                        </div>
                                    </div>
                                </div>
                                <div class="hidden flex justify-center items-center remove-address">
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
                            <x-plus-svg />
                            {{ __('Create More') }}
                        </button>
                    </div>
                    <div id="productFields">
                        @if (isset($shop))
                            <div class="grid grid-cols-5 gap-3 product-row">
                                <div class="col-span-4">
                                    <div class="grid gap-4 mb-4 md:grid-cols-3">
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="product_id"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                Product</label>
                                            <select id="product_id" class="custom-input-text"
                                                name="products[0][product_id]">
                                                <option selected value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option {{ $shopProduct->id == $product['id'] ? 'selected' : '' }}
                                                        value="{{ $product['id'] }}">{{ $product['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="qty"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock
                                                Quantity</label>
                                            <input type="text" name="products[0][qty]" id="qty"
                                                class="custom-input-text" placeholder="Type qty"
                                                value="{{ $shopProduct->stock_qty }}">
                                        </div>
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="price"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price
                                            </label>
                                            <input type="text" name="products[0][price]" id="price"
                                                class="custom-input-text" placeholder="Type price"
                                                value="{{ $shopProduct->price }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="hidden flex justify-center items-center remove-product">
                                    <button class="remove-product-button" type="button" data-current-product="0">
                                        {{ __('Remove') }}
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="grid grid-cols-5 gap-3 product-row">
                                <div class="col-span-4">
                                    <div class="grid gap-4 mb-4 md:grid-cols-3">
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="product_id"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                Product</label>
                                            <select id="product_id" class="custom-input-text"
                                                name="products[0][product_id]">
                                                <option selected value="">Select Product</option>
                                                @foreach ($products as $products)
                                                    <option value="{{ $products['id'] }}">{{ $products['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="qty"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock
                                                Quantity</label>
                                            <input type="text" name="products[0][qty]" id="qty"
                                                class="custom-input-text" placeholder="Type qty">
                                        </div>
                                        <div class="col-span-1 md:col-span-1 form-group">
                                            <label for="price"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price
                                            </label>
                                            <input type="text" name="products[0][price]" id="price"
                                                class="custom-input-text" placeholder="Type price">
                                        </div>
                                    </div>
                                </div>
                                <div class="hidden flex justify-center items-center remove-product">
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
        let assignedAddress = 1;
        let assignedProduct = 1;
        @if (isset($shop))
            assignedAddress = @json($shop->address);
            assignedProduct = @json($shop->product);
        @endif

        $(document).ready(function() {
            totalAddressCount = assignedAddress.length;
            $('.add-address-button').data('address-count', (assignedAddress.length - 1));
            if (totalAddressCount > 1) {
                $('.remove-address').removeClass('hidden');
            } else {
                $('.remove-address').addClass('hidden');
            }

            totalProductCount = assignedProduct.length;
            $('.add-product-button').data('product-count', (assignedProduct.length - 1));
            if (totalProductCount > 1) {
                $('.remove-product').removeClass('hidden');
            } else {
                $('.remove-product').addClass('hidden');
            }
        });

        $(document).on('click', '.modal-submit-button', function(e) {
            $("#shopForm").validate({
                rules: {
                    name: {
                        required: true,
                        normalizer: function(value) {
                            return $.trim(value);
                        }
                    },
                    image: {
                        required: true,
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
                $(this).rules("add", {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value);
                    }
                });
            });
            $('input[name^="addresses"]').filter('input[name$="[area]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value);
                    }
                });
            });
            $('input[name^="addresses"]').filter('input[name$="[city]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value);
                    }
                });
            });
            $('input[name^="addresses"]').filter('input[name$="[pincode]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value);
                    }
                });
            });
            $('input[name^="products"]').filter('input[name$="[qty]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                    number: true,
                    min: 1,
                    normalizer: function(value) {
                        return $.trim(value);
                    }
                });
            });
            $('input[name^="products"]').filter('input[name$="[price]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                    number: true,
                    min: 1,
                    normalizer: function(value) {
                        return $.trim(value);
                    }
                });
            });
            $('select[name^="addresses"]').filter('select[name$="[state]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value);
                    }
                });
            });
            $('select[name^="addresses"]').filter('select[name$="[country]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value);
                    }
                });
            });
            $('select[name^="products"]').filter('select[name$="[product_id]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value);
                    }
                });
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
            html += 'class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">';
            html += 'House Number</label>';
            html += '<input type="text" name="addresses[' + currentAddressCount + '][house_no]" id="house_no"';
            html += 'class="custom-input-text" placeholder="Type house number">';
            html += '</div>';
            html += '<div class="col-span-1 md:col-span-1 form-group">';
            html += '<label for="area"';
            html += 'class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Area</label>';
            html += '<input type="text" name="addresses[' + currentAddressCount +
                '][area]" id="area" class="custom-input-text"';
            html += 'placeholder="Type area">';
            html += '</div>';
            html += '<div class="col-span-1 md:col-span-1 form-group">';
            html += '<label for="city"';
            html += 'class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>';
            html += '<input type="text" name="addresses[' + currentAddressCount +
                '][city]" id="city" class="custom-input-text"';
            html += 'placeholder="Type city">';
            html += '</div>';
            html += '<div class="col-span-1 md:col-span-1 form-group">';
            html += '<label for="state"';
            html += 'class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State</label>';
            html += '<select id="state" class="custom-input-text" name="addresses[' + currentAddressCount +
                '][state]">';
            html += '<option selected value="">Select State</option>';
            html += '<option value="gujrat">Gujrat</option>';
            html += '<option value="rajsthan">Rajsthan</option>';
            html += '<option value="up">Uttar Pradesh</option>';
            html += '<option value="nj">New Jearsy</option>';
            html += '</select>';
            html += '</div>';
            html += '</div>';
            html += '<div class="grid gap-4 mb-4 md:grid-cols-2">';
            html += '<div class="col-span-2 md:col-span-1 form-group">';
            html += '<label for="country"';
            html += 'class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country</label>';
            html += '<select id="country" class="custom-input-text" name="addresses[' + currentAddressCount +
                '][country]">';
            html += '<option selected value="">Select country</option>';
            html += '<option value="india">India</option>';
            html += '<option value="usa">USA</option>';
            html += '</select>';
            html += '</div>';
            html += '<div class="col-span-2 md:col-span-1 form-group">';
            html += '<label for="pincode"';
            html += 'class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pincode</label>';
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
            html += 'class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">';
            html += 'Product</label>';
            html += '<select id="product_id-' + currentProductCount +
                '" class="custom-input-text product-dropdown" name="products[' + currentProductCount +
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
            html += 'class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock';
            html += 'Quantity</label>';
            html += '<input type="text" name="products[' + currentProductCount + '][qty]" id="qty"';
            html += 'class="custom-input-text" placeholder="Type qty">';
            html += '</div>';
            html += '<div class="col-span-1 md:col-span-1 form-group">';
            html += '<label for="price"';
            html += 'class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price';
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
        });

        $(document).on('click', '.remove-product-button', function(e) {
            $(this).closest('.product-row').remove();
            totalProductCount = totalProductCount - 1;
            if (totalProductCount === 1) {
                $('.remove-product').addClass('hidden');
            }
        });
    </script>
@endpush
