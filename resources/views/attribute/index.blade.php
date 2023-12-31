@extends('layouts.table')

@section('table')
    <div class="attribute-table">
        <div class="w-full flex flex-row-reverse">
            @if (\Helper::hasPermissionToView('create-attributes'))
                <a href="{{ route('attributes.create') }}" class="custom-create-button" type="button">
                    @include('svg.plus')
                    {{ __('Create Attribute') }}
                </a>
            @endif
        </div>
        <hr class="w-full h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-left dark:bg-meta-4">
                        <th class="min-w-[70px] table-headers xl:pl-11">
                            Sr No.
                        </th>
                        <th class="min-w-[150px] table-headers">
                            Name
                        </th>
                        <th class="min-w-[150px] table-headers">
                            Categories
                        </th>
                        <th class="min-w-[150px] table-headers">
                            Options
                        </th>
                        <th class="min-w-[120px] table-headers">
                            Create At
                        </th>
                        @if (\Helper::hasPermissionToView('edit-attributes') || \Helper::hasPermissionToView('delete-attributes'))
                            <th class="table-headers">
                                Actions
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody id="attributeTableBody">
                    @forelse ($attributes as $attribute)
                        <tr>
                            <td class="custom-table-row pl-9">
                                <p class="plain-text">{{ $attribute->id }}</p>
                            </td>
                            <td class="custom-table-row">
                                <p class="plain-text">{{ $attribute->name }}</p>
                            </td>
                            <td class="custom-table-row">
                                <p class="plain-text">
                                    {{ $attribute->categories->pluck('name')->implode(', ') }}
                                </p>
                            </td>
                            <td class="custom-table-row">
                                <p class="plain-text">
                                    {{ $attribute->attributeOptions->pluck('value')->implode(', ') }}
                                </p>
                            </td>
                            <td class="custom-table-row">
                                <p class="plain-text">{{ $attribute->created_at->format('F j, Y') }}</p>
                            </td>
                            <td class="custom-table-row">
                                <div class="flex items-center space-x-3.5">
                                    @if (\Helper::hasPermissionToView('edit-attributes'))
                                        <a href="{{ route('attributes.edit', $attribute->id) }}" class="hover:text-primary">
                                            <x-edit-svg />
                                        </a>
                                    @endif
                                    @if (\Helper::hasPermissionToView('delete-attributes'))
                                        <button class="hover:text-primary mt-1 open-confirm-modal"
                                            data-id="{{ $attribute->id }}">
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
            'message' => 'Are you sure you want to delete this attribute?',
        ])
    </div>
@endsection

@push('page-script')
    <script type="module">
        $(document).on('click', '.open-confirm-modal', function(e) {
            e.preventDefault();
            const attributeId = $(this).data('id');
            $('#popup-modal').attr("data-attribute-id", attributeId);
            openModel('#popup-modal');
        });

        $('.modal-confirm-cancel, .close-confirm-modal').on('click', function(e) {
            e.preventDefault();
            $('#popup-modal').attr('data-attribute-id', '');
            closeModel('#popup-modal');
        });

        $('.modal-confirm-submit').on('click', function(e) {
            e.preventDefault();
            setupAjax();
            const attributeId = $('#popup-modal').attr('data-attribute-id');

            let destroyCatUrl = "{{ route('attributes.destroy', ':id') }}";
            destroyCatUrl = destroyCatUrl.replace(':id', attributeId);
            $.ajax({
                url: destroyCatUrl,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    $('#popup-modal').attr('data-attribute-id', '');
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
