@extends('layouts.table')

@section('table')
    <div class="w-full flex flex-row-reverse">
        @if (\Helper::hasPermissionToView('create-roles'))
            <button class="custom-create-button open-upsert-modal" type="button" data-id="">
                @include('svg.plus')
                {{ __('Create Role') }}
            </button>
        @endif
    </div>
    <hr class="w-full h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
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
                    @if (\Helper::hasPermissionToView('edit-roles') || \Helper::hasPermissionToView('delete-roles'))
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Actions
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody id="roleTableBody">
            </tbody>
        </table>
    </div>

    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
        @include('layouts.common.confirmationPopup', [
            'message' => 'Are you sure you want to delete this role?',
        ])
    </div>

    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
        <div class="relative p-4 w-full max-w-md     max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="modal-title text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                        Create New Role
                    </h3>
                    <button type="button" class="close-modal-icon">
                        <x-cross-svg />
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div>
                    <form class="p-4 md:p-5" id="roleForm">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2 form-group">
                                <label for="name" class="form-label">Name<span style="color:red"> *</span></label>
                                <input type="text" name="name" id="name" class="custom-input-text"
                                    placeholder="Type role name">
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
            getRoleList();
        });

        $(document).on('click', '.open-upsert-modal', function(e) {
            e.preventDefault();
            const roleId = $(this).data('id');
            if (roleId) {
                getRoleDetails(roleId);
            } else {
                $('#modal-title').html('Create New Role');
                openModel('#crud-modal');
            }
        });

        $(document).on('click', '.open-confirm-modal', function(e) {
            e.preventDefault();
            const roleId = $(this).data('id');
            $('#popup-modal').attr('data-role-id', roleId);
            openModel('#popup-modal');
        });

        $('.modal-submit-button').on('click', function(e) {
            e.preventDefault();
            $("#roleForm").validate({
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

            if ($("#roleForm").valid()) {
                const formData = objectifyForm($("#roleForm").serializeArray());
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
            const roleId = $('#popup-modal').attr('data-role-id');
            let destroyRoleUrl = "{{ route('roles.destroy', ':id') }}";
            destroyRoleUrl = destroyRoleUrl.replace(':id', roleId);
            $.ajax({
                url: destroyRoleUrl,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    hideModal('confirm');
                    getRoleList();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        function getRoleDetails(id) {
            let URL = "{{ route('roles.edit', ':id') }}";
            URL = URL.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: URL,
                success: function(success) {
                    const roleData = success.data.role;
                    var inputs = $('#roleForm [name]');

                    $.each(inputs, function(i, input) {
                        const inputName = $(input).attr('name');
                        $(input).val(roleData[inputName]);
                    });

                    $('#modal-title').html('Edit Role Details');
                    openModel('#crud-modal');

                    $('#roleForm').append(addHTMLForPut);
                    $('#roleForm').attr('data-role-id', roleData['id']);
                },
                error: function(data) {
                    console.error('Role Error', data);
                }
            });
        }

        function submitForm(data) {
            setupAjax();
            const roleId = $('#roleForm').attr('data-role-id');
            let postURL = '';
            if (roleId) {
                postURL = "{{ route('roles.update', ':id') }}";
                postURL = postURL.replace(':id', roleId);
            } else {
                postURL = "{{ route('roles.store') }}";
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
                    getRoleList();
                },
                error: function(data) {}
            });
        }

        function hideModal(modalType) {
            if (modalType === 'crud') {
                $('#roleForm')[0].reset();
                $('#roleForm').attr('data-role-id', '');
                $('#putMethod').remove();
                closeModel('#crud-modal');
            } else {
                $('#popup-modal').attr('data-role-id', '');
                closeModel('#popup-modal');
            }
        }

        function getRoleList() {
            let URL = "{{ route('roles.index') }}";
            $.ajax({
                type: 'GET',
                url: URL,
                cache: false,
                success: function(success) {
                    $('#roleTableBody').html(success.data.html);
                },
                error: function(data) {
                    console.error('Role Error', data);
                }
            });
        }
    </script>
@endpush
