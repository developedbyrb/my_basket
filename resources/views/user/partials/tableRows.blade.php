@forelse ($users as $user)
    <tr>
        <td class="custom-table-row pl-9">
            @if ($user->profile_pic)
                <img class="w-12 h-12 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                    src="{{ asset('storage' . $user->profile_pic) }}" alt="{{ $user->name . '-image' }}"
                    title="{{ $user->name . '-image' }}">
            @else
                <div
                    class="w-12 h-12 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500 flex justify-center items-center">
                    <x-user-svg class="text-lg" />
                </div>
            @endif
        </td>
        <td class="custom-table-row">
            <p class="text-black dark:text-white">{{ $user->name }}</p>
        </td>
        <td class="custom-table-row">
            <p class="text-black dark:text-white">{{ $user->email }}</p>
        </td>
        <td class="custom-table-row">
            <p class="text-black dark:text-white">{{ $user->role->name }}</p>
        </td>
        <td class="custom-table-row">
            <p class="text-black dark:text-white">{{ $user->created_at->format('F j, Y') }}</p>
        </td>
        @if (auth()->user()->role->id === 1)
            <td class="custom-table-row">
                <div class="flex items-center space-x-3.5">
                    @if (\Helper::hasPermissionToView('edit-users'))
                        <button class="hover:text-primary open-user-modal" data-id="{{ $user->id }}">
                            <x-edit-svg />
                        </button>
                    @endif
                    @if (\Helper::hasPermissionToView('delete-users'))
                        <button class="hover:text-primary mt-1 open-confirm-modal" data-id="{{ $user->id }}">
                            <x-remove-svg />
                        </button>
                    @endif
                </div>
            </td>
        @endif
    </tr>
@empty
    <tr class="border-b dark:border-neutral-500">
        <td class="no-records" colspan="4">
            No records
        </td>
    </tr>
@endforelse
