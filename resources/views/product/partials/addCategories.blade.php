@foreach ($categories as $category)
    <ul class="category-list-wrapper" aria-labelledby="dropdownSearchButton">
        <li>
            <div class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                <input id="checkbox-item-{{ $category->id }}" type="checkbox"
                    {{ isset($product) && $product->categories->contains($category->id) ? 'checked="checked"' : '' }}
                    name="categories[]" class="custom-check-box category-selection" value="{{ $category->id }}"
                    data-value="{{ $category->id }}">
                <label for="checkbox-item-{{ $category->id }}"
                    class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">
                    {{ $category->name }}
                </label>
            </div>
        </li>
    </ul>
@endforeach
