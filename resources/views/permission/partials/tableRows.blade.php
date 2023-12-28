@forelse ($permissions as $permission)
    <tr>
        <td class="custom-table-row pl-9">
            <p class="text-black dark:text-white">{{ $permission->id }}</p>
        </td>
        <td class="custom-table-row">
            <p class="text-black dark:text-white">{{ $permission->name }}</p>
        </td>
        <td class="custom-table-row">
            <p class="text-black dark:text-white">{{ $permission->created_at->format('F j, Y') }}</p>
        </td>
        @if (auth()->user()->role->id === 1)
            <td class="custom-table-row">
                <div class="flex items-center space-x-3.5">
                    @if (\Helper::hasPermissionToView('edit-permissions'))
                        <button class="hover:text-primary open-permission-modal" data-id="{{ $permission->id }}">
                            <x-edit-svg />
                        </button>
                    @endif
                    @if (\Helper::hasPermissionToView('delete-permissions'))
                        <button class="hover:text-primary mt-1 open-confirm-modal" data-id="{{ $permission->id }}">
                            <x-remove-svg />
                        </button>
                    @endif
                </div>
            </td>
        @endif
    </tr>
@empty
    <tr class="border-b dark:border-neutral-500">
        <td class="text-center py-4 px-4 font-medium text-black-700 dark:text-white-700 xl:pl-11" colspan="4">
            No records
        </td>
    </tr>
@endforelse
