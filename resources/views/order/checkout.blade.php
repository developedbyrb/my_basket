@extends('layouts.card')

@section('card')
    <div class="grid grid-cols-4" id="cart">
        <div class="lg:col-span-2 md:col-span-2 col-span-4 w-full mb-6" id="scroll">
            <form action="{{ route('orders.store') }}" method="post" id="orderForm">
                @csrf
                <div
                    class="flex flex-col lg:px-8 md:px-6 px-4 lg:py-2 md:py-2 py-2 justify-between overflow-y-auto lg:border-r md:border-r border-gray-200">
                    <div>
                        <p class="lg:text-xl font-semibold mb-2 text-xl text-gray-800 dark:text-white">
                            Contact Information
                        </p>
                    </div>
                    <div class="py-4 md:py-6 lg:py-6">
                        <div class="form-group">
                            <x-input-label for="email" :value="__('Email Address')" :required="true" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="Auth::user()->email" autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>
                    <div class="mt-5">
                        <p class="lg:text-xl font-semibold mb-2 text-xl text-gray-800 dark:text-white">
                            Payment Method
                        </p>
                    </div>
                    <div class="form-group mb-5">
                        <ul
                            class="items-center lg:flex-nowrap flex-wrap w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input checked id="payment-list-radio-cod" type="radio" value="1"
                                        name="payment_type"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="payment-list-radio-cod"
                                        class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        Cash On Delivery
                                    </label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input disabled id="payment-list-radio-card" type="radio" value="2"
                                        name="payment_type"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="payment-list-radio-card"
                                        class="w-full py-3 ms-2 text-sm font-medium text-gray-400 dark:text-gray-500">
                                        Card
                                    </label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input disabled id="payment-list-radio-NB" type="radio" value="3"
                                        name="payment_type"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="payment-list-radio-NB"
                                        class="w-full py-3 ms-2 text-sm font-medium text-gray-400 dark:text-gray-500">
                                        Net Banking
                                    </label>
                                </div>
                            </li>
                            <li class="w-full dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input disabled id="payment-list-radio-UPI" type="radio" value="4"
                                        name="payment_type"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="payment-list-radio-UPI"
                                        class="w-full py-3 ms-2 text-sm font-medium text-gray-400 dark:text-gray-500">
                                        UPI
                                    </label>
                                </div>
                            </li>
                        </ul>
                        <x-input-error :messages="$errors->get('payment_type')" class="mt-2" />
                    </div>

                    <div class="mt-5">
                        <p class="lg:text-xl font-semibold mb-2 text-xl text-gray-800 dark:text-white">
                            Shipping Address
                        </p>
                        @if ($addresses)
                            <div class="form-group mb-5">
                                <ul
                                    class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @foreach ($addresses as $address)
                                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                            <div class="flex items-center ps-3">
                                                <input checked id="list-radio-address" type="radio"
                                                    value="{{ $address->address[0]->id }}" name="address"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="list-radio-address"
                                                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                    {{ $address->defaultAddress() }} <span class="ml-5">(Default
                                                        Address)</span>
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        @else
                            <div class="border border-gray-200 rounded-lg">
                                <div class="p-4 md:p-5">
                                    @include('layouts.common.dynamic-address', ['addMore' => false])
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <div class="lg:col-span-2 md:col-span-2 col-span-4 w-full mb-6">
            <div class="flex flex-col lg:px-8 md:px-6 px-4 lg:py-2 md:py-2 py-2 justify-between overflow-y-auto">
                <div>
                    <p class="lg:text-xl font-semibold mb-2 text-xl text-gray-800 dark:text-white">Order Summary</p>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($cartItems as $id => $cartItem)
                        <div class="md:flex items-stretch py-4 md:py-6 lg:py-6 border-t border-gray-200">
                            <div class="md:w-1/4 2xl:w-1/4 w-full">
                                <img src="{{ asset('storage' . $cartItem->sku->image) }}" alt="Black Leather Bag"
                                    class="h-full object-center object-cover md:block hidden" />
                                <img src="{{ asset('storage' . $cartItem->sku->image) }}" alt="Black Leather Bag"
                                    class="md:hidden w-full h-full object-center object-cover" />
                            </div>
                            <div class="md:w-8/12 2xl:w-3/4 flex flex-col justify-center">
                                <p class="text-xs leading-3 text-gray-800 dark:text-white md:pt-0 pt-4">
                                    {{ isset($cartItem) && isset($cartItem->sku) ? $cartItem->sku->code : '' }}
                                </p>
                                <div class="flex items-center justify-between w-full pt-1">
                                    <p class="text-base font-black leading-none text-gray-800 dark:text-white">
                                        {{ $cartItem->sku->product->name }}
                                    </p>
                                    <p class="text-base font-semibold leading-none text-gray-800 dark:text-white">
                                        {{ $cartItem->qty . ' x ' }} @money($cartItem->sku->shopProduct->selling_price)
                                    </p>
                                </div>
                                <p class="text-xs leading-3 text-gray-600 dark:text-white pt-2">
                                    Dimensions (cm): 10 inches
                                </p>
                                <p class="text-xs leading-3 text-gray-600 dark:text-white py-2">
                                    Color: Black
                                </p>
                                <div class="flex items-center justify-between pt-3">
                                    <div class="flex items-center">
                                        <form action="{{ route('cartItems.destroy', $cartItem->id) }}" method="post">
                                            @csrf
                                            <button type="submit"
                                                class="text-xs leading-3 underline text-red-500">Remove</button>
                                        </form>
                                    </div>
                                    <p class="text-base font-black leading-none text-gray-800 dark:text-white">
                                        @php
                                            $total += $cartItem->sku->shopProduct->selling_price;
                                        @endphp
                                        @money($cartItem->sku->shopProduct->selling_price)
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex items-center justify-between pt-4 my-4 border-t border-gray-300">
                        <p class="text-base leading-none text-gray-800 dark:text-white">Subtotal</p>
                        <p class="text-base leading-none text-gray-800 dark:text-white">@money($total)</p>
                    </div>
                    <div class="flex items-center justify-between pt-5 my-4 border-t border-gray-300">
                        <p class="text-base leading-none text-gray-800 dark:text-white">Shipping estimate</p>
                        <p class="text-base leading-none text-gray-800 dark:text-white">@money(0)</p>
                    </div>
                    <div class="flex items-center justify-between pt-5 mb-4 border-t border-gray-300">
                        <p class="text-base leading-none text-gray-800 dark:text-white">Tax estimate</p>
                        <p class="text-base leading-none text-gray-800 dark:text-white">@money(0)</p>
                    </div>
                </div>
                <div class="border-t border-gray-300">
                    <div class="flex items-center pb-6 justify-between lg:pt-5 pt-20">
                        <p class="text-xl font-semibold leading-normal text-gray-800 dark:text-white">Order total
                        </p>
                        <p class="text-xl font-semibold leading-normal text-right text-gray-800 dark:text-white">
                            @money($total)
                        </p>
                    </div>
                    <button type="submit" id="order-now"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-3 text-md font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Order Now</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('page-script')
    <script type="module">
        const addressArray = @json($addresses);

        $(document).on('click', '#order-now', function(e) {
            $('#orderForm').validate({
                rules: {
                    email: {
                        required: true,
                        checkEmail: {
                            depends: function(element) {
                                return true;
                            }
                        },
                        normalizer: function(value) {
                            return $.trim(value);
                        }
                    },
                    payment_type: {
                        required: true
                    },
                    address: {
                        required: addressArray ? true : false
                    }
                },
                messages: {
                    payment_type: {
                        required: "Please select one method for payment."
                    },
                    address: {
                        required: "Please select one address for shipment."
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

            @if (!$addresses)
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
                $('select[name^="addresses"]').filter('select[name$="[state]"]').each(function() {
                    $(this).rules("add", requiredAndTrimmed());
                });
                $('select[name^="addresses"]').filter('select[name$="[country]"]').each(function() {
                    $(this).rules("add", requiredAndTrimmed());
                });
            @endif


            $('form#orderForm').submit();
        });
    </script>
@endpush
