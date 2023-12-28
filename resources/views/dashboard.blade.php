@extends('layouts.app')

@section('content')
    <div class="card-wrapper md:grid-cols">
        <form>
            <label for="default-search" class="custom-label">
                Search
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <x-search-svg />
                </div>
                <input type="search" id="default-search" class="custom-search"
                    placeholder="search shops (by name, address or products)">
                <button type="button" class="search-button">Search</button>
            </div>
        </form>
    </div>

    <div id="searchedShops">
    </div>
@endsection
@push('page-script')
    <script type="module">
        $(document).on('click', '.search-button', function(e) {
            e.preventDefault();
            const searchedString = $('#default-search').val();
            const URL = "{{ route('shops.search') }}";
            $.ajax({
                type: 'GET',
                url: URL,
                data: {
                    search: searchedString,
                },
                success: function(success) {
                    $('#searchedShops').html(success.data.html);
                },
                error: function(data) {
                    console.error('Custom Error', data);
                }
            });
        });
    </script>
@endpush
