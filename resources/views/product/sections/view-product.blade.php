@extends('layouts.card')

@section('card')
    <div class="py-8 px-4 mx-auto">
        <h2 class="mb-2 text-xl font-semibold leading-none text-gray-900 md:text-2xl dark:text-white">
            {{ $productDetails->name }}
        </h2>
        <p class="mb-4 text-xl font-extrabold leading-none text-gray-900 md:text-2xl dark:text-white">
            @money($productDetails->details->price)
        </p>
        <div class="grid gap-4 mb-4 md:grid-cols-3">
            <div class="col-span-2 md:col-span-2">
                <div id="default-carousel" class="relative w-full" data-carousel="slide">
                    <!-- Carousel wrapper -->
                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                        <!-- Item 1 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('storage' . $productDetails->image) }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 2 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('storage' . $productDetails->image) }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 3 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('storage' . $productDetails->image) }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 4 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('storage' . $productDetails->image) }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 5 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('storage' . $productDetails->image) }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                    </div>
                    <!-- Slider indicators -->
                    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
                            data-carousel-slide-to="0"></button>
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                            data-carousel-slide-to="1"></button>
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                            data-carousel-slide-to="2"></button>
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
                            data-carousel-slide-to="3"></button>
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5"
                            data-carousel-slide-to="4"></button>
                    </div>
                    <!-- Slider controls -->
                    <button type="button"
                        class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-prev>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 1 1 5l4 4" />
                            </svg>
                            <span class="sr-only">Previous</span>
                        </span>
                    </button>
                    <button type="button"
                        class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-next>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="sr-only">Next</span>
                        </span>
                    </button>
                </div>

            </div>
            <div class="col-span-1 ml-4">
                <dl class="max-w-md text-gray-900 dark:text-white">
                    <div class="flex flex-col">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Product State</dt>
                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                            <span
                                class="bg-blue-800 text-blue-100 text-md font-medium inline-flex items-center px-2.5 py-0.5 rounded me-2 dark:bg-blue-900 dark:text-blue-300 border border-gray-500 ">
                                <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 22 20">
                                    <path
                                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                </svg>
                                Default
                            </span>
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Sold by</dt>
                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                            {{ $productDetails->details->ship_by ? $productDetails->details->ship_by : 'In House' }}
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Ships from</dt>
                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                            {{ $productDetails->details->ships_from ? $productDetails->details->ships_from : 'In House' }}
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Brand</dt>
                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                            {{ $productDetails->details->brand ? $productDetails->details->brand : 'In House brand' }}
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Dimensions (cm)</dt>
                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                            {{ $productDetails->details->length . ' x ' . $productDetails->details->width . ' x ' . $productDetails->details->breadth }}
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Item weight (kg)</dt>
                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                            {{ $productDetails->details->weight ? $productDetails->details->weight : '0.0' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
        <dl class="flex items-center space-x-6">
            <div>
                <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Category</dt>
                <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                    {{ $productDetails->categories->pluck('name')->implode(', ') }}
                </dd>
            </div>
        </dl>
        <dl>
            <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Details</dt>
            <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                {{ $productDetails->description }}
            </dd>
        </dl>
        <dl>
            <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Variants</dt>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3">
                                SKU
                            </th>
                            @foreach ($fields as $field)
                                <th scope="col" class="px-6 py-3">
                                    {{ $field }}
                                </th>
                            @endforeach
                            <th scope="col" class="px-6 py-3">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Stock
                            </th>
                            @if (\Helper::hasPermissionToView('buy-bulk-products'))
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productDetails->skus as $sku)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="custom-table-row pl-9">
                                    @if ($sku->image)
                                        <img class="w-12 h-12 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                                            src="{{ asset('storage' . $sku->image) }}" alt="{{ $sku->name . '-image' }}"
                                            title="{{ $sku->name . '-image' }}">
                                    @else
                                        <x-upload-svg />
                                    @endif
                                </td>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $sku->code }} {{ $sku->is_default == 1 ? '(Default)' : '' }}
                                </th>
                                @foreach ($sku->attributeOptions as $optionValue)
                                    <td class="px-6 py-4">
                                        {{ $optionValue->value }}
                                    </td>
                                @endforeach
                                <td class="px-6 py-4">
                                    @money($sku->price) / Unit
                                </td>
                                <td class="px-6 py-4">
                                    {{ $sku->avail_stock ? $sku->avail_stock . ' pieces' : 'Out of stock' }}
                                </td>
                                @if (\Helper::hasPermissionToView('buy-bulk-products'))
                                    <td colspan="5" class="px-6 py-4">
                                        <form action="{{ route('products.addToCart', $sku->id) }}" method="post">
                                            @csrf
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
                            <tr class="table-rows">
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white text-center"
                                    colspan="{{ count($fields) + 4 }}">
                                    Please add items in cart to proceed
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </dl>
        @if (\Helper::hasPermissionToView('edit-products') || \Helper::hasPermissionToView('delete-products'))
            <div class="flex items-center mt-5 space-x-4">
                <a href="{{ route('products.edit', $productDetails->id) }}" type="button"
                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg aria-hidden="true" class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                        <path fill-rule="evenodd"
                            d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Edit
                </a>
                <button type="button"
                    class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                    <svg aria-hidden="true" class="w-5 h-5 mr-1.5 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Delete
                </button>
            </div>
        @endif
    </div>
@endsection
