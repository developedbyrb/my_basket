@forelse ($rowData as $data)
    <tr>
        <td class="custom-table-row pl-9">
            <p class="text-black dark:text-white">{{ $data->id }}</p>
        </td>
        <td class="custom-table-row">
            <p class="text-black dark:text-white">{{ $data->name }}</p>
        </td>
        @if ($page === 'attributes')
            <td class="custom-table-row">
                <p class="text-black dark:text-white">
                    {{ $data->attributeOptions->pluck('value')->implode(', ') }}
                </p>
            </td>
        @endif
        <td class="custom-table-row">
            <p class="text-black dark:text-white">{{ $data->created_at->format('F j, Y') }}</p>
        </td>
        <td class="custom-table-row">
            <div class="flex items-center space-x-3.5">
                @if (\Helper::hasPermissionToView('edit-' . $page))
                    <button class="hover:text-primary open-upsert-modal" data-id="{{ $data->id }}">
                        <x-edit-svg />
                    </button>
                @endif
                @if (\Helper::hasPermissionToView('delete-' . $page))
                    <button class="hover:text-primary mt-1 open-confirm-modal" data-id="{{ $data->id }}">
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
