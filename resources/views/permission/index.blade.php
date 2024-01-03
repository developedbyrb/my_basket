@extends('layouts.app')

@section('content')
    <div class="w-full flex flex-row-reverse">
        @if (\Helper::hasPermissionToView('create-permissions'))
            <button class="custom-create-button open-upsert-modal" type="button" data-id="">
                @include('svg.plus')
                {{ __('Create Permission') }}
            </button>
        @endif
    </div>
    <div class="table-wrapper">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-left dark:bg-meta-4">
                        <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                            Sr No.
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Name
                        </th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                            Create At
                        </th>
                        @if (\Helper::hasPermissionToView('edit-permissions') || \Helper::hasPermissionToView('delete-permissions'))
                            <th class="py-4 px-4 font-medium text-black dark:text-white">
                                Actions
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody id="permissionTableBody">
                </tbody>
            </table>
        </div>
    </div>

    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
        @include('layouts.common.confirmationPopup', [
            'message' => 'Are you sure you want to delete this permission?',
        ])
    </div>

    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
        <div class="relative p-4 w-full max-w-md     max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="modal-title text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                        Create New Permission
                    </h3>
                    <button type="button" class="close-modal-icon">
                        <x-cross-svg />
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div>
                    <form class="p-4 md:p-5" id="permissionForm">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2 form-group">
                                <label for="name" class="form-label">Name<span style="color:red"> *</span></label>
                                <input type="text" name="name" id="name" class="custom-input-text"
                                    placeholder="Type permission name">
                            </div>
                        </div>
                        <div class="flex flex-row-reverse mt-5">
                            <button type="button" class="modal-submit-button">
                                Save
                            </button>
                            <button type="button" class="modal-cancel-button">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-script')
    <script type="module">
        $(document).ready(function() {
            getPermissionList();
        });

        $(document).on('click', '.open-upsert-modal', function(e) {
            e.preventDefault();
            const permissionId = $(this).data('id');
            if (permissionId) {
                getPermissionDetails(permissionId);
            } else {
                $('#modal-title').html('Create New Permission');
                openModel('#crud-modal');
            }
        });

        $(document).on('click', '.open-confirm-modal', function(e) {
            e.preventDefault();
            const permissionId = $(this).data('id');
            $('#popup-modal').attr('data-permission-id', permissionId);
            openModel('#popup-modal');
        });

        $('.modal-submit-button').on('click', function(e) {
            e.preventDefault();
            $("#permissionForm").validate({
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

            if ($("#permissionForm").valid()) {
                const formData = objectifyForm($("#permissionForm").serializeArray());
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
            const permissionId = $('#popup-modal').attr('data-permission-id');

            let destroyPermissionUrl = "{{ route('permissions.destroy', ':id') }}";
            destroyPermissionUrl = destroyPermissionUrl.replace(':id', permissionId);
            $.ajax({
                url: destroyPermissionUrl,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    hideModal('confirm');
                    getPermissionList();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        function getPermissionDetails(id) {
            let URL = "{{ route('permissions.edit', ':id') }}";
            URL = URL.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: URL,
                success: function(success) {
                    const permissionData = success.data.permission;
                    var inputs = $('#permissionForm [name]');

                    $.each(inputs, function(i, input) {
                        const inputName = $(input).attr('name');
                        $(input).val(permissionData[inputName]);
                    });

                    $('#modal-title').html('Edit Permission Details');
                    openModel('#crud-modal');

                    $('#permissionForm').append(addHTMLForPut);
                    $('#permissionForm').attr('data-permission-id', permissionData['id']);
                },
                error: function(data) {
                    console.error('Permission Error', data);
                }
            });
        }

        function submitForm(data) {
            setupAjax();
            const permissionId = $('#permissionForm').attr('data-permission-id');
            let postURL = '';
            if (permissionId) {
                postURL = "{{ route('permissions.update', ':id') }}";
                postURL = postURL.replace(':id', permissionId);
            } else {
                postURL = "{{ route('permissions.store') }}";
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
                    getPermissionList();
                },
                error: function(data) {}
            });
        }

        function hideModal(modalType) {
            if (modalType === 'crud') {
                $('#permissionForm')[0].reset();
                $('#permissionForm').attr('data-permission-id', '');
                $('#putMethod').remove();
                closeModel('#crud-modal');
            } else {
                $('#popup-modal').attr('data-permission-id', '');
                closeModel('#popup-modal');
            }
        }

        function getPermissionList() {
            let URL = "{{ route('permissions.index') }}";
            $.ajax({
                type: 'GET',
                url: URL,
                cache: false,
                success: function(success) {
                    $('#permissionTableBody').html(success.data.html);
                },
                error: function(data) {
                    console.error('Permission Error', data);
                }
            });
        }
    </script>
@endpush
