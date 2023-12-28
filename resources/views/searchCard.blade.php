@foreach ($shops as $shop)
    <div class="card-wrapper md:grid-cols-3 p-4 md:p-5">
        <div
            class="max-w-sm m-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <a href="{{ route('shops.show', $shop->id) }}">
                @if ($shop->image)
                    <img class="rounded-t-lg" src="{{ asset('storage' . $shop->image) }}"
                        alt="{{ $shop->name . '-image' }}" title="{{ $shop->name . '-image' }}">
                @else
                    <x-upload-svg />
                @endif
            </a>
            <div class="p-5">
                <a href="{{ route('shops.show', $shop->id) }}">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $shop->name }}
                    </h5>
                </a>
                <a href="{{ route('shops.show', $shop->id) }}"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Read more
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endforeach
