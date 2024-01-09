@extends('layouts.card')

@section('card')
    @if (isset($wareHouseDetails))
        <x-card-header :title="__('Edit Warehouse Details')" />
    @else
        <x-card-header :title="__('Create New Warehouse')" />
    @endif

    <div class="card-body">
        <form id="warehouseForm" method="POST" action="{{ route('warehouses.store') }}">
            @csrf
            <div class="grid gap-4 grid-cols-2">
                <div class="col-span-1 form-group">
                    <x-input-label for="name" :value="__('Warehouse Name')" :required="true" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="isset($wareHouseDetails) ? $wareHouseDetails->name : old('name')"
                        autofocus autocomplete="warehouse name" placeholder="Type warehouse name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>

            <div>
                @include('layouts.common.dynamic-address')
            </div>

            <x-form-footer :cancelRoute="__('warehouses.index')" />
        </form>
    </div>
@endsection
@push('page-script')
@endpush
