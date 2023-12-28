@extends('layouts.app')

@section('content')
    <div class="table-wrapper">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-left dark:bg-meta-4">
                        <th class="min-w-[80px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                            #
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Product Name
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Product From
                        </th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                            Quantity
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Price
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Expected Delivery Date
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Address
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Status
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody id="shopTableBody">
                    @forelse ($orders as $order)
                        <tr class="table-rows">
                            <td class="p-4">
                                <img src="{{ asset('storage' . $order->product->image) }}"
                                    class="w-16 md:w-32 max-w-full max-h-full" alt="{{ $order->product->name }}-image"
                                    title="{{ $order->product->name }}-image" />
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ $order->product->name }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ $order->shop->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $order->qty }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                @money($order->qty * $order->product->shopProduct[0]->price)
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($order->expected_delivery_date)->format('F j, Y') }}
                            </td>
                            <td>-</td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                @switch($order->status)
                                    @case(1)
                                        <span class="bg-yellow-100 text-yellow-800 badge dark:bg-yellow-900 dark:text-yellow-300">
                                            {{ config('globalConstant.ORDER_STATUSES')[$order->status] }}
                                        </span>
                                    @break

                                    @case(2)
                                        <span class="bg-purple-100 text-purple-800 badge dark:bg-purple-900 dark:text-purple-300">
                                            {{ config('globalConstant.ORDER_STATUSES')[$order->status] }}
                                        </span>
                                    @break

                                    @default
                                        <span class="bg-green-100 text-green-800 badge dark:bg-green-900 dark:text-green-300">
                                            {{ config('globalConstant.ORDER_STATUSES')[$order->status] }}
                                        </span>
                                @endswitch
                            </td>
                            <td>
                                @if ($order->status !== 3)
                                    <button title="remove-order" class="hover:text-primary mt-1 open-cancel-modal"
                                        data-id="{{ $order->id }}">
                                        <x-remove-svg />
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <tr class="border-b dark:border-neutral-500">
                                <td class="text-center py-4 px-4 font-medium text-black-700 dark:text-white-700 xl:pl-11"
                                    colspan="9">
                                    No records
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="crud-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
            <div class="relative p-4 w-full max-w-lg max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="modal-title text-lg font-semibold text-gray-900 dark:text-white">
                            Are you sure?
                        </h3>
                        <button type="button" class="close-modal-icon">
                            <x-cross-svg />
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div>
                        <form class="p-4 md:p-5" id="cancelOrderForm">
                            <p class="font-semibold">You want to cancel this order.</p>
                            <div class="mt-3">
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div class="col-span-2 form-group">
                                        <label for="message"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                            Reason <span style="color:red"> *</span></label>
                                        <textarea id="message" rows="4"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Write your thoughts here..."></textarea>
                                    </div>

                                    <div class="flex items-center justify-center w-full col-span-2">
                                        <label for="dropzone-file"
                                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                        class="font-semibold">Click to upload an image if required</span> or
                                                    drag and drop</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG or JPG</p>
                                            </div>
                                            <input id="dropzone-file" type="file" class="hidden" />
                                        </label>
                                    </div>

                                </div>
                                <div class="flex flex-row-reverse mt-5">
                                    <button type="button" class="modal-submit-button">
                                        Save
                                    </button>
                                    <button type="button" class="modal-cancel-button">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('page-script')
        <script type="module">
            $(document).on('click', '.open-cancel-modal', function(e) {
                const currentId = $(this).data('id');
                const $modalElement = document.querySelector('#crud-modal');
                const modal = new Modal($modalElement);
                modal.show();
            });

            $('.modal-cancel-button, .close-modal-icon').on('click', function(e) {
                e.preventDefault();
                hideModal();
            });

            function hideModal() {
                const $modalElement = document.querySelector('#crud-modal');
                const modal = new Modal($modalElement);
                modal.hide();
            }
        </script>
    @endpush
