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
            <p class="text-black dark:text-white break-words">{{ Str::limit($product->description, 80) ?? '-' }}</p>
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
                @if (
                    \Helper::hasPermissionToView('edit-products') &&
                        (Auth::user()->hasRole('admin') || Auth::id() === $product->created_by))
                    <button class="hover:text-primary open-product-modal" data-id="{{ $product->id }}">
                        <x-edit-svg />
                    </button>
                @endif
                @if (
                    \Helper::hasPermissionToView('delete-products') &&
                        (Auth::user()->hasRole('admin') || Auth::id() === $product->created_by))
                    <button class="hover:text-primary mt-1 open-confirm-modal" data-id="{{ $product->id }}">
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
