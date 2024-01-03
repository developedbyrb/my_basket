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
                    {{ $message }}
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
