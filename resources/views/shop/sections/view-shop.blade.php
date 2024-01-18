@extends('layouts.card')

@section('card')
    <div class="w-full flex">
        <a href="{{ route('shops.index') }}" class="custom-create-button" type="button">
            {{ __('Back') }}
        </a>
    </div>
    <div class="view-table-wrapper">
        <a href="javascript:void(0)">
            @if ($shop->image)
                <img src="{{ asset('storage' . $shop->image) }}" alt="{{ $shop->name . '-image' }}"
                    title="{{ $shop->name . '-image' }}" class="rounded-t-lg" title="{{ $shop->name . '-image' }}">
            @else
                <x-upload-svg />
            @endif
        </a>
        <div class="px-5 pb-5">
            <a href="javascript:void(0)">
                <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                    {{ $shop->name }}</h5>
            </a>

            @if ($shop->address)
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <caption class="table-caption">
                            Our Addresses
                            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">
                                Browse a list of addresses to visit our shops
                            </p>
                        </caption>
                        <thead class="table-header">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    House Number
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Area
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    City
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    State
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Country
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shop->address as $key => $address)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="table-custom-title">
                                        {{ $address->house_no }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $address->area }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $address->city }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $address->state }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $address->country }}
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        No Addresses found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($shop->skus)
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <caption class="table-caption">
                            Our Products
                            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">
                                Browse a list of products that we are selling with their price and images.
                            </p>
                        </caption>
                        <thead class="table-header">
                            <tr>
                                <th scope="col" class="px-10 py-3">
                                    <span class="sr-only">Image</span>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Product
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Available Qty
                                </th>
                                <th scope="col" class="px-10 py-3 w-40">
                                    Price
                                </th>
                                @if (\Helper::hasPermissionToView('create-cart-items', false))
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shop->skus as $skuKey => $sku)
                                <tr class="table-rows">
                                    <td class="p-4">
                                        @if ($sku->image)
                                            <img class="table-images" src="{{ asset('storage' . $sku->image) }}"
                                                alt="{{ $sku->code . '-image' }}" title="{{ $sku->code . '-image' }}">
                                        @else
                                            <x-upload-svg />
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        {{ $sku->product->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $sku->shopProduct->stock_qty }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        @money($sku->shopProduct->selling_price)
                                    </td>
                                    @if (\Helper::hasPermissionToView('create-cart-items', false))
                                        <td colspan="5" class="px-6 py-4">
                                            <form action="{{ route('cartItems.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="shopId" value="{{ $shop->id }}">
                                                <input type="hidden" name="skuId" value="{{ $sku->id }}">
                                                <button type="submit"
                                                    class="inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                                    @include('svg.add-cart-svg')
                                                    <span class="ml-3">Add To cart</span>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <div>No Products Available</div>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="modal-title text-lg font-semibold text-gray-900 dark:text-white">
                        Add To Cart
                    </h3>
                    <button type="button" class="close-modal-icon">
                        <x-cross-svg />
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div>
                    <form class="p-4 md:p-5" id='cartForm'>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg" id="cartTable">
                        </div>

                        <div class="flex flex-row-reverse mt-5">
                            <button type="button" class="modal-submit-button">
                                Proceed
                            </button>
                            <button type="button" class="modal-cancel-button">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-script')
    <script type="module">
        $(document).on('click', '.add-to-cart', function(e) {
            e.preventDefault();
            const productId = $(this).data('id');
            const shopId = $(this).data('shop-id');
            getProductDetails(productId, shopId);
        });

        $('.modal-cancel-button, .close-modal-icon').on('click', function(e) {
            e.preventDefault();
            closeModel('#crud-modal');
        });

        $(document).on('click', '.remove-cart-product', function(e) {
            $('.invalid-feedback').html('');
            $(this).siblings('.form-group').find('.cart-input').removeClass('.is-invalid');
            let currentQty = $(this).siblings('.form-group').find('.cart-input').val();
            const productPrice = $(this).data('product-price');
            if (currentQty <= 1) {
                $('.invalid-feedback').html('At lease one product required');
                $(this).siblings('.form-group').find('.cart-input').addClass('.is-invalid');
                return false;
            } else {
                currentQty--;
                const price = '₹ ' + (currentQty * productPrice).toFixed(2);
                $(this).siblings('.form-group').find('.cart-input').val(currentQty);
                $('#price-cell').html(price);
            }
        });

        $(document).on('click', '.add-cart-product', function(e) {
            $('.invalid-feedback').html('');
            $(this).siblings('.form-group').find('.cart-input').removeClass('.is-invalid');
            const availableQty = $(this).data('qty');
            const productPrice = $(this).data('product-price');
            let currentQty = $(this).siblings('.form-group').find('.cart-input').val();
            if (currentQty >= availableQty) {
                if (currentQty === availableQty) {
                    $(this).addAttr('disabled');
                }
                $('.invalid-feedback').html('Please add quantity less than or equal to available quantity.');
                $(this).siblings('.form-group').find('.cart-input').addClass('.is-invalid');
                return false;
            } else {
                currentQty++;
                const price = '₹ ' + (currentQty * productPrice).toFixed(2);
                $(this).siblings('.form-group').find('.cart-input').val(currentQty);
                $('#price-cell').html(price);
            }
        });

        $('.modal-submit-button').on('click', function(e) {
            e.preventDefault();
            const formData = objectifyForm($("#cartForm").serializeArray());
            submitForm(formData);
        });

        function getProductDetails(id, shopId) {
            $('#cartForm').data('product-id', id);
            $('#cartForm').data('shop-id', shopId);
            setupAjax();
            let URL = "{{ route('products.show', ':id') }}";
            URL = URL.replace(':id', id);
            $.ajax({
                type: 'POST',
                url: URL,
                data: {
                    'shop_id': shopId
                },
                success: function(success) {
                    $('#cartTable').html(success.data.html);
                    openModel('#crud-modal');
                },
                error: function(data) {
                    console.error('Custom Error', data);
                }
            });
        }
    </script>
@endpush
