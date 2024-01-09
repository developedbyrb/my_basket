@extends('layouts.table')

@section('table')
    <div class="warehouse-table">
        <div class="w-full flex flex-row-reverse">
            @if (\Helper::hasPermissionToView('create-warehouses'))
                <a href="{{ route('warehouses.create') }}" class="custom-create-button" type="button">
                    @include('svg.plus')
                    {{ __('Create Warehouse') }}
                </a>
            @endif
        </div>
        <hr class="w-full h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-left dark:bg-meta-4">
                        <th class="table-headers xl:pl-11">
                            #
                        </th>
                        <th class="table-headers">
                            Name
                        </th>
                        <th class="min-w-[150px] table-headers">
                            Default Address
                        </th>
                        <th class="min-w-[120px] table-headers">
                            Create At
                        </th>
                        @if (\Helper::hasPermissionToView('edit-warehouses') || \Helper::hasPermissionToView('delete-warehouses'))
                            <th class="table-headers">
                                Actions
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody id="wareHouseTable">
                    @forelse ($warehouses as $warehouse)
                        <tr>
                            <td class="custom-table-row pl-9">
                                <p class="plain-text">{{ $warehouse->id }}</p>
                            </td>
                            <td class="custom-table-row">
                                <p class="plain-text">{{ $warehouse->name }}</p>
                            </td>
                            <td class="custom-table-row">
                                <p class="plain-text">
                                    {{ $warehouse->categories->pluck('name')->implode(', ') }}
                                </p>
                            </td>
                            <td class="custom-table-row">
                                <p class="plain-text">{{ $warehouse->created_at->format('F j, Y') }}</p>
                            </td>
                            <td class="custom-table-row">
                                <div class="flex items-center space-x-3.5">
                                    @if (\Helper::hasPermissionToView('edit-warehouses'))
                                        <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="hover:text-primary">
                                            <x-edit-svg />
                                        </a>
                                    @endif
                                    @if (\Helper::hasPermissionToView('delete-warehouses'))
                                        <button class="hover:text-primary mt-1 open-confirm-modal"
                                            data-id="{{ $warehouse->id }}">
                                            <x-remove-svg />
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-b dark:border-neutral-500">
                            <td class="no-records" colspan="5">
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
            'message' => 'Are you sure you want to delete this warehouse?',
        ])
    </div>
@endsection

@push('page-script')
    <script type="module">
        $(document).on('click', '.open-confirm-modal', function(e) {
            e.preventDefault();
            const warehouseId = $(this).data('id');
            $('#popup-modal').attr("data-warehouse-id", warehouseId);
            openModel('#popup-modal');
        });

        $('.modal-confirm-cancel, .close-confirm-modal').on('click', function(e) {
            e.preventDefault();
            $('#popup-modal').attr('data-warehouse-id', '');
            closeModel('#popup-modal');
        });

        $('.modal-confirm-submit').on('click', function(e) {
            e.preventDefault();
            setupAjax();
            const warehouseId = $('#popup-modal').attr('data-warehouse-id');

            let destroyCatUrl = "{{ route('warehouses.destroy', ':id') }}";
            destroyCatUrl = destroyCatUrl.replace(':id', warehouseId);
            $.ajax({
                url: destroyCatUrl,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    $('#popup-modal').attr('data-warehouse-id', '');
                    closeModel('#popup-modal');
                    location.reload();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    </script>
@endpush
