@forelse ($roles as $role)
    <tr>
        <td class="custom-table-row pl-9">
            <p class="text-black dark:text-white">{{ $role->id }}</p>
        </td>
        <td class="custom-table-row">
            <p class="text-black dark:text-white">{{ $role->name }}</p>
        </td>
        <td class="custom-table-row">
            <p class="text-black dark:text-white">{{ $role->created_at->format('F j, Y') }}</p>
        </td>
        @if (auth()->user()->role->id === 1)
            <td class="custom-table-row">
                <div class="flex items-center space-x-3.5">
                    <button class="hover:text-primary open-role-modal" data-id="{{ $role->id }}">
                        <x-edit-svg />
                    </button>
                    <button class="hover:text-primary mt-1 open-confirm-modal" data-id="{{ $role->id }}">
                        <x-remove-svg />
                    </button>
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
