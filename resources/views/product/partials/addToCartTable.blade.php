<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-10 py-3">
                <span class="sr-only">Image</span>
            </th>
            <th scope="col" class="px-6 py-3">
                Product
            </th>
            <th scope="col" class="px-6 py-3">
                Qty
            </th>
            <th scope="col" class="px-6 py-3">
                Price
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class="table-rows">
            <td class="p-4">
                @if (isset($product) && $product->productDetails->image)
                    <img class="table-images" src="{{ asset('storage' . $product->productDetails->image) }}"
                        alt="{{ $product->productDetails->image . '-image' }}"
                        title="{{ $product->productDetails->image . '-image' }}">
                @else
                    <x-upload-svg />
                @endif
            </td>
            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{ $product->productDetails->name }}
            </td>
            <td class="px-6 py-4">
                <div class="flex items-center">
                    <button class="me-3 manage-cart-button remove-cart-product" type="button"
                        data-product-price="{{ $product->price }}">
                        <span class="sr-only">Quantity button</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 18 2">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1h16" />
                        </svg>
                    </button>
                    <div class="form-group">
                        <input type="number" name="added_qty" id="first_product" class="cart-input" value="1"
                            placeholder="1" required>
                    </div>
                    <button class="ms-3 manage-cart-button add-cart-product" type="button"
                        data-qty="{{ $product->stock_qty }}" data-product-price="{{ $product->price }}">
                        <span class="sr-only">Quantity button</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 1v16M1 9h16" />
                        </svg>
                    </button>
                </div>
                <span class="invalid-feedback"></span>
            </td>
            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white" id="price-cell">
                @money($product->price)
            </td>
        </tr>
    </tbody>
</table>
