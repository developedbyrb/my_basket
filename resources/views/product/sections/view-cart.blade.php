@extends('layouts.app')

@section('content')
    <div class="shadow-md sm:rounded-lg bg-white dark:bg-gray-800">
        <div class="flex mx-auto lg:px-8 lg:py-6 md:px-6 px-4 md:py-6 py-4">
            <h2 class="text-2xl font-semibold plain-text">
                Shopping Cart
            </h2>
        </div>
        <form action="{{ route('cartItems.update') }}" method="post" id="cartItems">
            @csrf
            @method('put')
            <div class="grid grid-cols-3" id="cart">
                <div class="col-span-2 lg:px-8 lg:py-2 md:px-2 px-4 md:py-8 py-4 mb-6" id="scroll">
                    @php
                        $total = 0;
                    @endphp
                    @forelse ($cartItems as $id => $cartItem)
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
                                <div class="flex items-center justify-between w-full pt-1 sku-details">
                                    <p class="text-base font-black leading-none text-gray-800 dark:text-white">
                                        {{ $cartItem->sku->product->name }}
                                    </p>
                                    <div class="form-group">
                                        <div class="flex items-center justify-end">
                                            <button disabled
                                                class="me-3 manage-cart-button remove-cart-sku cursor-not-allowed"
                                                type="button" data-qty="{{ $cartItem->qty }}"
                                                data-sku-price="{{ $cartItem->sku->shopProduct->selling_price }}">
                                                <span class="sr-only">Quantity button</span>
                                                <svg class="w-3 h-3" fill="none" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 2">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                </svg>
                                            </button>
                                            <div class="w-14 form-group-element">
                                                <input name="cart[{{ $cartItem->id }}][qty]" class="cart-input"
                                                    type="number" placeholder="1" value="1"
                                                    id="sku-{{ $cartItem->id }}-qty">
                                            </div>
                                            <button class="ms-3 manage-cart-button add-cart-sku" type="button"
                                                data-qty="{{ $cartItem->qty }}"
                                                data-sku-price="{{ $cartItem->sku->shopProduct->selling_price }}">
                                                <span class="sr-only">Quantity button</span>
                                                <svg class="w-3 h-3" fill="none" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs leading-3 text-gray-600 dark:text-white pt-2">
                                    Dimensions (cm): 10 inches
                                </p>
                                <p class="text-xs leading-3 text-gray-600 dark:text-white py-2">
                                    Color: Black
                                </p>
                                <p class="text-xs leading-3 text-gray-600 dark:text-white">
                                    Price (per unit): @money($cartItem->sku->shopProduct->selling_price)
                                </p>
                                <div class="flex items-center justify-between pt-3 price-section">
                                    <div class="flex items-center">
                                        <button type="button" data-cart-id="{{ $cartItem->id }}"
                                            class="text-xs remove-cart-item leading-3 underline text-red-500">
                                            Remove</button>
                                    </div>
                                    <p class="text-base font-black leading-none text-gray-800 dark:text-white total-price"
                                        data-price="{{ $cartItem->sku->shopProduct->selling_price }}">
                                        @php
                                            $total += $cartItem->sku->shopProduct->selling_price;
                                        @endphp
                                        @money($cartItem->sku->shopProduct->selling_price)
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center text-center border rounded-lg h-96 dark:border-gray-700">
                            <div class="flex flex-col w-full max-w-sm px-4 mx-auto">
                                <div class="p-3 mx-auto text-blue-500 bg-blue-100 rounded-full dark:bg-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </div>
                                <h1 class="mt-3 text-lg text-gray-800 dark:text-white">No product found</h1>
                                <p class="mt-2 text-gray-500 dark:text-gray-400">
                                    Please visit product list page to add products</p>
                                <div class="flex items-center mt-4 sm:mx-auto gap-x-3">
                                    <a href="{{ route('products.index') }}"
                                        class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                                        <svg class="fill-content mt-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" width="20" height="20" viewBox="0 0 20 20">
                                            <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1">
                                                <path d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                <path d="M10 13c4.97 0 9-2.686 9-6s-4.03-6-9-6-9 2.686-9 6 4.03 6 9 6Z" />
                                            </g>
                                        </svg>

                                        <span>View Products</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="col-span-1 w-full mb-6">
                    <div class="flex flex-col lg:px-8 md:px-7 px-4 lg:py-2 md:py-2 py-2 justify-between overflow-y-auto">
                        <div>
                            <p class="lg:text-xl font-semibold text-xl text-gray-800 dark:text-white">Summary</p>
                            <div class="flex items-center justify-between pt-4">
                                <p class="text-base leading-none text-gray-800 dark:text-white">Subtotal</p>
                                <p id="subTotal" class="text-base leading-none text-gray-800 dark:text-white">
                                    @money($total)</p>
                            </div>
                            <div class="flex items-center justify-between pt-5">
                                <p class="text-base leading-none text-gray-800 dark:text-white">Shipping estimate</p>
                                <p class="text-base leading-none text-gray-800 dark:text-white">@money(0)</p>
                            </div>
                            <div class="flex items-center justify-between pt-5">
                                <p class="text-base leading-none text-gray-800 dark:text-white">Tax estimate</p>
                                <p class="text-base leading-none text-gray-800 dark:text-white">@money(0)</p>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center pb-6 justify-between lg:pt-5 pt-20">
                                <p class="text-xl font-semibold leading-normal text-gray-800 dark:text-white">Order total
                                </p>
                                <p id="total"
                                    class="text-xl font-semibold leading-normal text-right text-gray-800 dark:text-white">
                                    @money($total)
                                </p>
                            </div>
                            <button type="submit" id="checkout" class="checkout-button">
                                Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('page-script')
    <script type="module">
        $('#checkout').on('click', function() {
            $("#cartItems").validate({
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
            $('input[name^="cart"]').filter('input[name$="[added_qty]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                    min: 20,
                    normalizer: function(value) {
                        return $.trim(value);
                    }
                });
            });
        });

        $('.remove-cart-item').on('click', function(e) {
            e.preventDefault();
            setupAjax();
            const cartID = $(this).data('cart-id');

            let destroyCatUrl = "{{ route('cartItems.destroy', ':id') }}";
            destroyCatUrl = destroyCatUrl.replace(':id', cartID);
            $.ajax({
                url: destroyCatUrl,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    location.reload();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $('.add-cart-sku').on('click', function(e) {
            e.preventDefault();
            let quantityCount = $(this).data('qty');
            let price = $(this).data('sku-price');
            quantityCount++;
            const total = quantityCount * price;
            const amount = total.toLocaleString('en-IN', {
                maximumFractionDigits: 2,
                style: 'currency',
                currency: 'INR'
            });
            $(this).data('qty', quantityCount);
            $(this).siblings('.form-group-element').find('.cart-input').val(quantityCount);
            $(this).siblings('.remove-cart-sku').removeAttr('disabled');
            $(this).siblings('.remove-cart-sku').removeClass('cursor-not-allowed');
            $(this).siblings('.remove-cart-sku').addClass('cursor-pointer');
            $(this).siblings('.remove-cart-sku').data('qty', quantityCount);
            $(this).parent().parent().parent().siblings('.price-section').find('.total-price').data('price', total);
            $(this).parent().parent().parent().siblings('.price-section').find('.total-price').html(amount);
            updateSummary();
        });

        $('.remove-cart-sku').on('click', function(e) {
            e.preventDefault();
            let quantityCount = $(this).data('qty');
            if (quantityCount == 1) {
                $(this).attr('disabled');
                $(this).addClass('cursor-not-allowed');
                $(this).removeClass('cursor-pointer');
            } else {
                let price = $(this).data('sku-price');
                quantityCount--;
                const total = quantityCount * price;
                const amount = total.toLocaleString('en-IN', {
                    maximumFractionDigits: 2,
                    style: 'currency',
                    currency: 'INR'
                });
                $(this).data('qty', quantityCount);
                $(this).siblings('.form-group-element').find('.cart-input').val(quantityCount);
                $(this).siblings('.add-cart-sku').data('qty', quantityCount);
                $(this).parent().parent().parent().siblings('.price-section').find('.total-price').data('price',
                    total);
                $(this).parent().parent().parent().siblings('.price-section').find('.total-price').html(amount);
                updateSummary();
                if (quantityCount === 1) {
                    $(this).attr('disabled');
                    $(this).addClass('cursor-not-allowed');
                    $(this).removeClass('cursor-pointer');
                }
            }
        })

        function updateSummary() {
            let subTotal = 0;
            $('.total-price').each(function() {
                subTotal += $(this).data('price');
            });
            const amount = subTotal.toLocaleString('en-IN', {
                maximumFractionDigits: 2,
                style: 'currency',
                currency: 'INR'
            });
            $('#subTotal').html(amount);
            $('#total').html(amount);
        }
    </script>
@endpush
