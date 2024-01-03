@extends('layouts.app')

@section('content')
    @if (\Helper::hasPermissionToView('create-shops'))
        <div class="w-full flex flex-row-reverse">
            <a href="{{ route('shops.create') }}" class="custom-create-button">
                @include('svg.plus')
                {{ __('Create Shop') }}
            </a>
        </div>
    @endif
    <div class="table-wrapper">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-left dark:bg-meta-4">
                        <th class="min-w-[80px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                            #
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Name
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Address
                        </th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                            Create At
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody id="shopTableBody">
                    @forelse ($shops as $shop)
                        <tr>
                            <td class="custom-table-row pl-9">
                                @if ($shop->image)
                                    <img class="w-12 h-12 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                                        src="{{ asset('storage' . $shop->image) }}" alt="{{ $shop->name . '-image' }}"
                                        title="{{ $shop->name . '-image' }}">
                                @else
                                    <x-upload-svg />
                                @endif
                            </td>
                            <td class="custom-table-row">
                                <p class="text-black dark:text-white">{{ $shop->name }}</p>
                            </td>
                            <td class="custom-table-row">
                                @if ($shop->address && count($shop->address) > 0)
                                    <p class="text-black dark:text-white">{{ $shop->address[0]->city }}</p>
                                @else
                                    <p class="text-black dark:text-white">-</p>
                                @endif
                            </td>
                            <td class="custom-table-row">
                                <p class="text-black dark:text-white">{{ $shop->created_at->format('F j, Y') }}</p>
                            </td>
                            <td class="custom-table-row">
                                <div class="flex items-center space-x-3.5">
                                    <a href="{{ route('shops.show', $shop->id) }}" class="hover:text-primary mt-1">
                                        <x-view-svg />
                                    </a>
                                    @if (\Helper::hasPermissionToView('edit-shops') && (Auth::user()->hasRole('admin') || Auth::id() === $shop->created_by))
                                        <a href="{{ route('shops.edit', $shop->id) }}" class="hover:text-primary">
                                            <x-edit-svg />
                                        </a>
                                    @endif
                                    @if (
                                        \Helper::hasPermissionToView('delete-shops') &&
                                            (Auth::user()->hasRole('admin') || Auth::id() === $shop->created_by))
                                        <button class="hover:text-primary mt-1 open-confirm-modal"
                                            data-id="{{ $shop->id }}">
                                            <x-remove-svg />
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-b dark:border-neutral-500">
                            <td class="no-records" colspan="4">
                                No records
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="modal-title text-lg font-semibold text-gray-900 dark:text-white"></h3>
                    <button type="button" class="close-confirm-modal">
                        <x-cross-svg />
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 mt-5 text-center">
                    <div class="flex items-center">
                        <svg class="mx-auto mb-4 text-warning-400 w-10 h-10 dark:text-warning-200" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                            Are you sure you want to delete this shop?
                        </h3>
                    </div>
                </div>
                <div class="flex justify-end items-center">
                    <button type="button" class="modal-confirm-cancel">
                        No, cancel
                    </button>
                    <button type="button" class="modal-confirm-submit">
                        Yes, I'm sure
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-script')
    <script type="module">
        const modalOptions = {
            placement: 'top-center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: false,
        };

        $(document).on('click', '.open-confirm-modal', function(e) {
            e.preventDefault();
            const shopId = $(this).data('id');
            $('#popup-modal').attr('data-shop-id', shopId);
            openModel('#popup-modal');
        });

        $('.modal-cancel-button, .close-modal-icon').on('click', function(e) {
            e.preventDefault();
            closeModel('#popup-modal');
        });

        $('.modal-confirm-submit').on('click', function(e) {
            e.preventDefault();
            setupAjax();
            const shopId = $('#popup-modal').data('shop-id');

            let deleteShopUrl = "{{ route('shops.destroy', ':id') }}";
            deleteShopUrl = deleteShopUrl.replace(':id', shopId);
            $.ajax({
                url: deleteShopUrl,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
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
