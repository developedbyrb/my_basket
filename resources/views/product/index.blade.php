@extends('layouts.table')

@section('table')
    <div class="product-table">
        @if (\Helper::hasPermissionToView('create-products'))
            <div class="w-full flex flex-row-reverse">
                <a href="{{ route('products.create') }}" class="custom-create-button" type="button">
                    @include('svg.plus')
                    {{ __('Create Product') }}
                </a>
            </div>
        @endif
        <hr class="w-full h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="h-16">
                    <tr class="bg-gray-200 text-left dark:bg-meta-4">
                        <th class="min-w-[100px] table-headers xl:pl-11">
                            #
                        </th>
                        <th class="min-w-[150px] table-headers">
                            Name
                        </th>
                        <th class="min-w-[150px] table-headers">
                            Categories
                        </th>
                        <th class="min-w-[150px] table-headers">
                            Created By
                        </th>
                        <th class="min-w-[150px] max-w-90 table-headers">
                            Create At
                        </th>
                        @if (\Helper::hasPermissionToView('edit-products') || \Helper::hasPermissionToView('delete-products'))
                            <th class="table-headers">
                                Actions
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    @forelse ($products as $product)
                        <tr>
                            <td class="custom-table-row pl-9">
                                @if ($product->image)
                                    <img class="w-12 h-12 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                                        src="{{ asset('storage' . $product->image) }}" alt="{{ $product->name . '-image' }}"
                                        title="{{ $product->name . '-image' }}">
                                @else
                                    <x-upload-svg />
                                @endif
                            </td>
                            <td class="custom-table-row">
                                <p class="text-black dark:text-white">{{ $product->name }}</p>
                            </td>
                            <td class="custom-table-row">
                                <p class="text-black dark:text-white break-words">
                                    {{ $product->categories->pluck('name')->implode(', ') }}
                                </p>
                            </td>
                            <td class="custom-table-row">
                                <p class="text-black dark:text-white">
                                    {{ $product->createdBy->name }}
                                </p>
                            </td>
                            <td class="custom-table-row">
                                <p class="text-black dark:text-white">{{ $product->created_at->format('F j, Y') }}</p>
                            </td>
                            <td class="custom-table-row">
                                <div class="flex items-center space-x-3.5">
                                    @if (\Helper::hasPermissionToView('get-products'))
                                        <a href="{{ route('products.show', $product->id) }}"
                                            class="hover:text-primary mt-1">
                                            <x-view-svg />
                                        </a>
                                    @endif
                                    @if (\Helper::hasPermissionToView('edit-products') && Auth::id() === $product->created_by)
                                        <a href="{{ route('products.edit', $product->id) }}" class="hover:text-primary">
                                            <x-edit-svg />
                                        </a>
                                    @endif
                                    @if (\Helper::hasPermissionToView('delete-products') && Auth::id() === $product->created_by)
                                        <button class="hover:text-primary mt-1 open-confirm-modal"
                                            data-id="{{ $product->id }}">
                                            <x-remove-svg />
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-b dark:border-neutral-500">
                            <td class="no-records" colspan="6">
                                No records
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
        @include('layouts.common.confirmationPopup', [
            'message' => 'Are you sure you want to delete this product?',
        ])
    </div>
@endsection

@push('page-script')
    <script type="module">
        $(document).on('click', '.open-confirm-modal', function(e) {
            e.preventDefault();
            const productId = $(this).data('id');
            $('#popup-modal').data('product-id', productId);
            openModel('#popup-modal');
        });

        $('.modal-confirm-cancel, .close-confirm-modal').on('click', function(e) {
            e.preventDefault();
            hideModal('confirm');
        });

        $('.modal-confirm-submit').on('click', function(e) {
            e.preventDefault();
            setupAjax();
            const productId = $('#popup-modal').data('product-id');

            let destroyProductUrl = "{{ route('products.destroy', ':id') }}";
            destroyProductUrl = destroyProductUrl.replace(':id', productId);
            $.ajax({
                url: destroyProductUrl,
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
    </script>
@endpush
