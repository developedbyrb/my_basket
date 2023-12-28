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
                        Price
                    </th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0 @endphp
                @forelse ($cartItems as $id => $cartItem)
                    <tr class="table-rows">
                        <td class="p-4">
                            <img src="{{ asset('storage' . $cartItem->product->image) }}"
                                class="w-16 md:w-32 max-w-full max-h-full" alt="{{ $cartItem->product->name }}-image"
                                title="{{ $cartItem->product->name }}-image">
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {{ $cartItem->product->name }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {{ $cartItem->shop->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $cartItem->qty }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            @php
                                $total = $total + $cartItem->qty * $cartItem->product->shopProduct[0]->price;
                            @endphp
                            @money($cartItem->qty * $cartItem->product->shopProduct[0]->price)
                        </td>
                    </tr>
                @empty
                    <tr class="table-rows">
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white text-center" colspan="5">
                            Please add items in cart to proceed
                        </td>
                    </tr>
                @endforelse
                <tr class="table-rows">
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white text-end" colspan="4">
                        Total Price:</td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">@money($total)</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right">
                        <a href="{{ route('shops.index') }}" type="button" class="round-primary mt-2">
                            Continue to Shopping</a>
                        <a href="{{ route('orders.create') }}" type="button" class="round-success mt-2">
                            Proceed to Checkout
                        </a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
