@extends('layouts.app')

@section('content')
    <div class="shadow-md sm:rounded-lg bg-white dark:bg-gray-800">
        <div class="flex mx-auto lg:px-8 lg:py-6 md:px-6 px-4 md:py-6 py-4">
            <h2 class="text-2xl font-semibold plain-text">
                Shopping Cart
            </h2>
        </div>
        <form action="{{ route('cart.cartCheckout') }}" method="post" id="cartItems">
            <div class="grid grid-cols-3" id="cart">
                <div class="col-span-2 lg:px-8 lg:py-2 md:px-2 px-4 md:py-8 py-4" id="scroll">
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
                                <div class="flex items-center justify-between w-full pt-1">
                                    <p class="text-base font-black leading-none text-gray-800 dark:text-white">
                                        {{ $cartItem->sku->product->name }}
                                    </p>
                                    <div class="form-group">
                                        <div class="flex items-center justify-end">
                                            <button class="me-3 manage-cart-button remove-cart-sku" type="button"
                                                data-sku-price="{{ $cartItem->price }}">
                                                <span class="sr-only">Quantity button</span>
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 18 2">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                </svg>
                                            </button>
                                            <div class="w-14">
                                                <input type="number" name="cart[{{ $cartItem->id }}][qty]" id="first_sku"
                                                    class="cart-input" value="20" placeholder="20">
                                            </div>
                                            <button class="ms-3 manage-cart-button add-cart-sku" type="button"
                                                data-qty="{{ $cartItem->stock_qty }}"
                                                data-sku-price="{{ $cartItem->price }}">
                                                <span class="sr-only">Quantity button</span>
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 18 18">
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
                                    Price (per unit): @money($cartItem->sku->price)
                                </p>
                                <div class="flex items-center justify-between pt-3">
                                    <div class="flex items-center">
                                        <form action="{{ route('products.destroyFromCart', $cartItem->id) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit"
                                                class="text-xs leading-3 underline text-red-500">Remove</button>
                                        </form>
                                    </div>
                                    <p class="text-base font-black leading-none text-gray-800 dark:text-white">
                                        @php
                                            $total += 20 * $cartItem->sku->price;
                                        @endphp
                                        @money(20 * $cartItem->sku->price)
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
                <div class="col-span-1 w-full">
                    <div class="flex flex-col lg:px-8 md:px-7 px-4 lg:py-2 md:py-2 py-2 justify-between overflow-y-auto">
                        <div>
                            <p class="lg:text-xl font-semibold text-xl text-gray-800 dark:text-white">Summary</p>
                            <div class="flex items-center justify-between pt-4">
                                <p class="text-base leading-none text-gray-800 dark:text-white">Subtotal</p>
                                <p class="text-base leading-none text-gray-800 dark:text-white">@money($total)</p>
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
                                <p class="text-xl font-semibold leading-normal text-right text-gray-800 dark:text-white">
                                    @money($total)
                                </p>
                            </div>
                            <button type="submit" id="checkout"
                                class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-3 text-md font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Checkout</button>
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
    </script>
@endpush
