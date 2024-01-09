@props(['cancelRoute'])

<hr class="h-px my-6 bg-gray-200 border-0 dark:bg-gray-700">
<div class="flex flex-row-reverse mt-5">
    <button type="submit" class="custom-submit-button">Submit</button>
    <a href="{{ route($cancelRoute) }}" type="button"
        class="text-gray-900 w-1/5 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-center text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Cancel</a>
</div>
