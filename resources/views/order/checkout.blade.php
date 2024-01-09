@extends('layouts.app')

@section('content')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-16 py-3">
                        <span class="sr-only">Image</span>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Product
                    </th>
                    <th scope="col" class="px-6 py-3">
                        From
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Qty
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Expected Delivery Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0 @endphp
                @forelse ($cartItems as $id => $cartItem)
                    <tr class="table-rows">
                        <td class="p-4">
                            {{-- <img src="{{ asset('storage' . $cartItem->product->image) }}"
                                class="w-16 md:w-32 max-w-full max-h-full" alt="{{ $cartItem->product->name }}-image"
                                title="{{ $cartItem->product->name }}-image"> --}}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {{-- {{ $cartItem->product->name }} --}}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {{-- {{ $cartItem->shop->name }} --}}
                        </td>
                        <td class="px-6 py-4">
                            {{ $cartItem->qty }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {{ $cartItem->expected_delivery_date->format('F j, Y') }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {{-- @php
                                $total = $total + $cartItem->qty * $cartItem->product->shopProduct[0]->price;
                            @endphp
                            @money($cartItem->qty * $cartItem->product->shopProduct[0]->price) --}}
                        </td>
                    </tr>
                @empty
                    <tr class="table-rows">
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white text-end" colspan="5">
                            Please add items in cart to proceed
                        </td>
                    </tr>
                @endforelse
                <tr class="table-rows">
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white text-end" colspan="5">
                        Total Price:</td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">@money($total)</td>
                </tr>
            </tbody>
        </table>
    </div>

    <form action="{{ route('orders.store') }}" method="post" id="orderForm">
        @csrf
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-7">
            <div class="p-4 md:p-5 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <div>
                    <h5 class="font-semibold text-gray-900 dark:text-white">Delivering Address:</h5>
                    <hr class="w-full h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                </div>
                <div class="grid grid-cols-5 gap-3">
                    <div class="col-span-5">
                        <div class="grid gap-4 mb-4 md:grid-cols-4">
                            <div class="col-span-1 md:col-span form-group">
                                <label for="house_no" class="form-label">
                                    House Number</label>
                                <input type="text" name="addresses[0][house_no]" id="house_no" class="custom-input-text"
                                    placeholder="Type house number">
                            </div>
                            <div class="col-span-1 md:col-span-1 form-group">
                                <label for="area" class="form-label">Area</label>
                                <input type="text" name="addresses[0][area]" id="area" class="custom-input-text"
                                    placeholder="Type area">
                            </div>
                            <div class="col-span-1 md:col-span-1 form-group">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="addresses[0][city]" id="city" class="custom-input-text"
                                    placeholder="Type city">
                            </div>
                            <div class="col-span-1 md:col-span-1 form-group">
                                <label for="state" class="form-label">State</label>
                                <select id="state" class="custom-input-text" name="addresses[0][state]">
                                    <option selected value="">Select State</option>
                                    <option value="gujrat">
                                        Gujrat</option>
                                    <option value="rajsthan">
                                        Rajsthan</option>
                                    <option value="up">
                                        Uttar Pradesh</option>
                                    <option value="nj">
                                        New
                                        Jearsy</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid gap-4 mb-4 md:grid-cols-2">
                            <div class="col-span-2 md:col-span-1 form-group">
                                <label for="country" class="form-label">Country</label>
                                <select id="country" class="custom-input-text" name="addresses[0][country]">
                                    <option selected value="">Select country</option>
                                    <option value="india">
                                        India</option>
                                    <option value="usa">
                                        USA
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-2 md:col-span-1 form-group">
                                <label for="pincode" class="form-label">Pincode</label>
                                <input type="text" name="addresses[0][pincode]" id="pincode" class="custom-input-text"
                                    placeholder="Type pincode">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-7">
            <div class="p-4 md:p-5 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <div>
                    <h5 class="font-semibold text-gray-900 dark:text-white">Payment Type<span style="color:red"> *</span>:
                    </h5>
                    <hr class="w-full h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                </div>
                <div class="grid grid-cols-5 gap-3">
                    <div class="col-span-5 form-group">
                        <ul
                            class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input id="horizontal-list-radio-license" type="radio" value="1"
                                        name="payment_type"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="horizontal-list-radio-license"
                                        class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        Cash On Delivery
                                    </label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input disabled id="horizontal-list-radio-id" type="radio" value="2"
                                        name="payment_type"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="horizontal-list-radio-id"
                                        class="w-full py-3 ms-2 text-sm font-medium text-gray-400 dark:text-gray-500">
                                        Card
                                    </label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input disabled id="horizontal-list-radio-military" type="radio" value="3"
                                        name="payment_type"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="horizontal-list-radio-military"
                                        class="w-full py-3 ms-2 text-sm font-medium text-gray-400 dark:text-gray-500">
                                        Net Banking
                                    </label>
                                </div>
                            </li>
                            <li class="w-full dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input disabled id="horizontal-list-radio-passport" type="radio" value="4"
                                        name="payment_type"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="horizontal-list-radio-passport"
                                        class="w-full py-3 ms-2 text-sm font-medium text-gray-400 dark:text-gray-500">
                                        UPI
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="flex flex-row-reverse mt-3">
                    <button type="submit" class="round-success mt-2 order-now">
                        Order Now
                    </button>
                    <a href="{{ route('shops.index') }}" type="button" class="round-primary mt-2">
                        Continue to Shopping
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('page-script')
    <script type="module">
        $(document).on('click', '.order-now', function(e) {
            $('#orderForm').validate({
                rules: {
                    payment_type: {
                        required: true
                    }
                },
                messages: {
                    payment_type: {
                        required: "Please select one method for payment."
                    }
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
                    pinCode: true,
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
        });
    </script>
@endpush
