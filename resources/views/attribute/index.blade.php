@extends('layouts.app')

@section('content')
    <div class="table-wrapper">
        <div class="w-full flex flex-row-reverse">
            @if (\Helper::hasPermissionToView('create-attributes'))
                <a href="{{ route('attributes.create') }}" class="custom-create-button" type="button">
                    @include('svg.plus')
                    {{ __('Create Attribute') }}
                </a>
            @endif
        </div>
        <hr class="w-full h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-left dark:bg-meta-4">
                        <th class="min-w-[70px] table-headers xl:pl-11">
                            Sr No.
                        </th>
                        <th class="min-w-[150px] table-headers">
                            Name
                        </th>
                        <th class="min-w-[150px] table-headers">
                            Categories
                        </th>
                        <th class="min-w-[150px] table-headers">
                            Options
                        </th>
                        <th class="min-w-[120px] table-headers">
                            Create At
                        </th>
                        @if (\Helper::hasPermissionToView('edit-attributes') || \Helper::hasPermissionToView('delete-attributes'))
                            <th class="table-headers">
                                Actions
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody id="attributeTableBody">
                    @forelse ($attributes as $attribute)
                        <tr>
                            <td class="custom-table-row pl-9">
                                <p class="plain-text">{{ $attribute->id }}</p>
                            </td>
                            <td class="custom-table-row">
                                <p class="plain-text">{{ $attribute->name }}</p>
                            </td>
                            <td class="custom-table-row">
                                <p class="plain-text">
                                    {{ $attribute->categories->pluck('name')->implode(', ') }}
                                </p>
                            </td>
                            <td class="custom-table-row">
                                <p class="plain-text">
                                    {{ $attribute->attributeOptions->pluck('value')->implode(', ') }}
                                </p>
                            </td>
                            <td class="custom-table-row">
                                <p class="plain-text">{{ $attribute->created_at->format('F j, Y') }}</p>
                            </td>
                            <td class="custom-table-row">
                                <div class="flex items-center space-x-3.5">
                                    @if (\Helper::hasPermissionToView('edit-attributes'))
                                        <a href="{{ route('attributes.edit', $attribute->id) }}" class="hover:text-primary">
                                            <x-edit-svg />
                                        </a>
                                    @endif
                                    @if (\Helper::hasPermissionToView('delete-attributes'))
                                        <button class="hover:text-primary mt-1 open-confirm-modal"
                                            data-id="{{ $attribute->id }}">
                                            <x-remove-svg />
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-b dark:border-neutral-500">
                            <td class="no-records" colspan="5">
                                No records
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
        @include('layouts.common.confirmationPopup', [
            'message' => 'Are you sure you want to delete this attribute?',
        ])
    </div>
@endsection

@push('page-script')
    <script type="module">
        let validator;
        // $(document).ready(function() {
        //     getAttributeList();
        // });

        $(document).on('click', '.open-upsert-modal', function(e) {
            e.preventDefault();
            const attributeId = $(this).data('id');
            if (attributeId) {
                getAttributeDetails(attributeId);
            } else {
                $('#modal-title').html('Create New Attribute');
                openModel('#crud-modal');
            }
        });

        $(document).on('click', '.open-confirm-modal', function(e) {
            e.preventDefault();
            const attributeId = $(this).data('id');
            $('#popup-modal').attr("data-attribute-id", attributeId);
            openModel('#popup-modal');
        });

        $('.modal-submit-button').on('click', function(e) {
            e.preventDefault();
            validator = $("#attributeForm").validate({
                rules: {
                    name: {
                        required: true,
                        normalizer: function(value) {
                            return $.trim(value);
                        }
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('input[name^="options"]').each(function() {
                $(this).rules("add", {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value);
                    }
                });
            });

            if ($("#attributeForm").valid()) {
                const formData = objectifyForm($("#attributeForm").serializeArray());
                submitForm(formData);
            }
        });

        $('.modal-cancel-button, .close-modal-icon').on('click', function(e) {
            e.preventDefault();
            hideModal('crud');
        });

        $('.modal-confirm-cancel, .close-confirm-modal').on('click', function(e) {
            e.preventDefault();
            hideModal('confirm');
        });

        $('.modal-confirm-submit').on('click', function(e) {
            e.preventDefault();
            setupAjax();
            const attributeId = $('#popup-modal').attr('data-attribute-id');

            let destroyCatUrl = "{{ route('attributes.destroy', ':id') }}";
            destroyCatUrl = destroyCatUrl.replace(':id', attributeId);
            $.ajax({
                url: destroyCatUrl,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    hideModal('confirm');
                    getAttributeList();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        function getAttributeList() {
            let URL = "{{ route('attributes.index') }}";
            $.ajax({
                type: 'GET',
                url: URL,
                cache: false,
                success: function(success) {
                    $('#attributeTableBody').html(success.data.html);
                },
                error: function(data) {
                    console.error('Attribute Error', data);
                }
            });
        }

        function getAttributeDetails(id) {
            let URL = "{{ route('attributes.edit', ':id') }}";
            URL = URL.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: URL,
                success: function(success) {
                    const attributeData = success.data.attribute;
                    var inputs = $('#attributeForm [name]');

                    $.each(inputs, function(i, input) {
                        const inputName = $(input).attr('name');
                        $(input).val(attributeData[inputName]);
                    });

                    $('#modal-title').html('Edit Attribute Details');

                    openModel('#crud-modal');

                    $('#attributeForm').append(addHTMLForPut);
                    $('#attributeForm').attr('data-attribute-id', attributeData['id']);
                },
                error: function(data) {
                    console.error('Attribute Error', data);
                }
            });
        }

        function submitForm(data) {
            setupAjax();
            let attributeId = $('#attributeForm').attr('data-attribute-id');
            let postURL = '';
            if (attributeId) {
                postURL = "{{ route('attributes.update', ':id') }}";
                postURL = postURL.replace(':id', attributeId);
            } else {
                postURL = "{{ route('attributes.store') }}";
            }

            let formData = new FormData();
            for (var key in data) {
                formData.append(key, data[key]);
            }
            $.ajax({
                url: postURL,
                type: 'POST',
                data: formData,
                async: false,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    hideModal('crud');
                    getAttributeList();
                },
                error: function(data) {}
            });
        }

        function hideModal(modalType) {
            if (modalType === 'crud') {
                $('#attributeForm').attr('data-attribute-id', '');
                $('#putMethod').remove();
                $('.dynamic-options').remove();
                $('.add-option-button').data('option-count', 1);
                $('.remove-option').removeClass('flex');
                $('.remove-option').addClass('hidden');
                $('#attributeForm')[0].reset();
                validator.resetForm();
                closeModel('#crud-modal');
            } else {
                $('#popup-modal').attr('data-attribute-id', '');
                closeModel('#popup-modal');
            }
        }
    </script>
@endpush
