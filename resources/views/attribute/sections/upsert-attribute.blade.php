@extends('layouts.card')

@section('card')
    @if (isset($attributeDetails))
        <x-card-header :title="__('Edit Attribute Details')" />
    @else
        <x-card-header :title="__('Create New Attribute')" />
    @endif

    <div class="card-body">
        <form id="attributeForm" method="POST" action="{{ route('attributes.store') }}">
            @csrf
            <div class="grid gap-4 grid-cols-2">
                <div class="col-span-1 form-group">
                    <x-input-label for="name" :value="__('Attribute Name')" :required="true" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="isset($attributeDetails) ? $attributeDetails->name : old('name')"
                        autofocus autocomplete="attribute name" placeholder="Type attribute name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="col-span-1 form-group">
                    @include('layouts.common.categoryDropdown', [
                        'categories' => $categories,
                        'parentData' => isset($attributeDetails) ? $attributeDetails : null,
                        'optionWidth' => 'w-2/5',
                    ])
                </div>
            </div>
            <div class="flex justify-between items-center mt-4">
                <h4 class="font-semibold">Options:</h4>
                <button class="add-option-button" type="button" data-option-count="1">
                    @include('svg.plus')
                    {{ __('Add Option Attribute') }}
                </button>
            </div>
            <div id="optionFields" class="mt-2 grid grid-cols-2 gap-4">
                <div class="col-span-1 option-row">
                    <div class="grid grid-cols-12 gap-3">
                        <div class="form-group col-span-10">
                            <x-input-label for="option1" :value="__('Option Name')" :required="true" />
                            <input type="text" name="options[1][value]" id="option1" class="custom-input-text"
                                placeholder="e.g. Black">
                        </div>
                        <div class="hidden col-span-2 justify-center items-center remove-option mt-5">
                            <button type="button" class="remove-option-button">
                                remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <x-form-footer :cancelRoute="__('attributes.index')" />
        </form>
    </div>
@endsection
@push('page-script')
    @vite('resources/js/components/attribute-upsert.js')
@endpush
