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
                                        <span class="yellow-badge">
                                            {{ config('globalConstant.ORDER_STATUSES')[$order->status] }}
                                        </span>
                                    @break

                                    @case(2)
                                        <span class="purple-badge">
                                            {{ config('globalConstant.ORDER_STATUSES')[$order->status] }}
                                        </span>
                                    @break

                                    @case(4)
                                        <span class="red-badge">
                                            {{ config('globalConstant.ORDER_STATUSES')[$order->status] }}
                                        </span>
                                    @break

                                    @default
                                        <span class="green-badge">
                                            {{ config('globalConstant.ORDER_STATUSES')[$order->status] }}
                                        </span>
                                @endswitch
                            </td>
                            <td>
                                @if ($order->status !== 3 && $order->status !== 4)
                                    <button title="remove-order" class="hover:text-primary mt-1 open-cancel-modal"
                                        data-id="{{ $order->id }}">
                                        <x-remove-svg />
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <tr class="border-b dark:border-neutral-500">
                                <td class="no-records" colspan="9">
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
                                        <textarea id="message" rows="4" name="reason" class="custom-text-area"
                                            placeholder="Write your thoughts here..."></textarea>
                                    </div>

                                    <div class="col-span-2 form-group">
                                        <label class="form-label" for="cancelled_reason_image">Image</label>
                                        <input class="file-input" id="cancelled_reason_image" type="file"
                                            name="cancelled_reason_image" aria-describedby="cancelled_reason_image">
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
                $('#cancelOrderForm').data('order-id', currentId);
                openModel('#crud-modal');
            });

            $('.modal-cancel-button, .close-modal-icon').on('click', function(e) {
                e.preventDefault();
                closeModel('#crud-modal');
            });

            $('.modal-submit-button').on('click', function(e) {
                e.preventDefault();
                $("#cancelOrderForm").validate({
                    rules: {
                        reason: {
                            required: true,
                            normalizer: function(value) {
                                return $.trim(value);
                            }
                        },
                        cancelled_reason_image: {
                            fileExtension: true
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

                if ($("#cancelOrderForm").valid()) {
                    const formData = objectifyForm($("#cancelOrderForm").serializeArray());
                    submitForm(formData);
                }

                function submitForm(data) {
                    setupAjax();
                    const orderId = $('#cancelOrderForm').data('order-id');
                    let postURL = "{{ route('orders.destroy', ':id') }}";
                    postURL = postURL.replace(':id', orderId);

                    let formData = new FormData();
                    for (var key in data) {
                        formData.append(key, data[key]);
                    }
                    $.ajax({
                        url: postURL,
                        type: 'POST',
                        data: formData,
                        async: false,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(data) {
                            closeModel('#crud-modal');
                            $('#cancelOrderForm').removeData("order-id");
                            location.reload();
                        },
                        error: function(data) {}
                    });
                }
            });
        </script>
    @endpush
