@extends('layouts.app')

@section('content')
    <div class="w-full flex flex-row-reverse">
        @if (\Helper::hasPermissionToView('create-users'))
            <button class="custom-create-button open-user-modal" type="button" data-id="">
                @include('svg.plus')
                {{ __('Create User') }}
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
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Email
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Role
                        </th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                            Create At
                        </th>
                        @if (\Helper::hasPermissionToView('edit-users') || \Helper::hasPermissionToView('delete-users'))
                            <th class="py-4 px-4 font-medium text-black dark:text-white">
                                Actions
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody id="userTableBody">
                </tbody>
            </table>
        </div>
    </div>

    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
        @include('layouts.common.confirmationPopup', [
            'message' => 'Are you sure you want to delete this user?',
        ])
    </div>

    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="modal-title text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                        Create New User
                    </h3>
                    <button type="button" class="close-modal-icon">
                        <x-cross-svg />
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div>
                    <form class="p-4 md:p-5" id="userForm">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2 sm:col-span-1 form-group">
                                <label for="name" class="form-label">Name<span style="color:red"> *</span></label>
                                <input type="text" name="name" id="name" class="custom-input-text"
                                    placeholder="Type user name">
                            </div>
                            <div class="col-span-2 sm:col-span-1 form-group">
                                <label for="email" class="form-label">Email<span style="color:red"> *</span></label>
                                <input type="text" name="email" id="email" class="custom-input-text"
                                    placeholder="Type user email">
                            </div>
                            <div class="col-span-2 form-group">
                                <label for="role" class="form-label">Role<span style="color:red"> *</span></label>
                                <select id="role" class="custom-input-text" name="role_id">
                                    <option selected="">Select role</option>
                                </select>
                            </div>
                            <div class="col-span-2 form-group">
                                <label class="form-label" for="user_avatar">Profile Picture</label>
                                <input class="file-input" aria-describedby="user_avatar_help" id="user_avatar"
                                    type="file" name="profile_pic">
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
            getUserList();
        });

        $(document).on('click', '.open-user-modal', function(e) {
            e.preventDefault();
            const userId = $(this).data('id');
            if (userId) {
                getUserDetails(userId);
            } else {
                createUser();
            }
        });

        $(document).on('click', '.open-confirm-modal', function(e) {
            e.preventDefault();
            const userId = $(this).data('id');
            $('#popup-modal').attr('data-user-id', userId);
            openModel('#popup-modal');
        });

        $('.modal-submit-button').on('click', function(e) {
            e.preventDefault();
            $("#userForm").validate({
                rules: {
                    name: {
                        required: true,
                        normalizer: function(value) {
                            return $.trim(value);
                        }
                    },
                    email: {
                        required: true,
                        checkEmail: {
                            depends: function(element) {
                                return true;
                            }
                        },
                        normalizer: function(value) {
                            return $.trim(value);
                        }
                    },
                    role_id: {
                        required: true,
                        normalizer: function(value) {
                            return $.trim(value);
                        }
                    },
                    profile_pic: {
                        fileExtension: true
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

            if ($("#userForm").valid()) {
                const formData = objectifyForm($("#userForm").serializeArray());
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
            const userId = $('#popup-modal').data('user-id');

            let destroyUserUrl = "{{ route('users.destroy', ':id') }}";
            destroyUserUrl = destroyUserUrl.replace(':id', userId);
            $.ajax({
                url: destroyUserUrl,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    hideModal('confirm');
                    getUserList();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        function createUser() {
            const URL = "{{ route('users.create') }}";
            $.ajax({
                type: 'GET',
                url: URL,
                success: function(success) {
                    addOptionsToRoleDropdown(success.data.roles);
                    $('#modal-title').html('Create New User');
                    openModel('#crud-modal');
                },
                error: function(data) {
                    console.error('Custom Error', data);
                }
            });
        }

        function getUserDetails(id) {
            let URL = "{{ route('users.edit', ':id') }}";
            URL = URL.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: URL,
                success: function(success) {
                    addOptionsToRoleDropdown(success.data.roles);
                    const userData = success.data.user;
                    var inputs = $('#userForm [name]');

                    $.each(inputs, function(i, input) {
                        const inputName = $(input).attr('name');
                        if (inputName != 'profile_pic')
                            $(input).val(userData[inputName]);
                    });

                    $('#modal-title').html('Edit User Details');
                    openModel('#crud-modal');

                    $('#userForm').append(addHTMLForPut);
                    $('#userForm').attr('data-user-id', userData['id']);
                },
                error: function(data) {
                    console.error('Custom Error', data);
                }
            });
        }

        function addOptionsToRoleDropdown(optionsArray) {
            optionsArray.unshift({
                id: '',
                name: "Select a role"
            });
            $('#role').empty();
            $.each(optionsArray, function(i, item) {
                $('#role').append($('<option>', {
                    value: item.id ? item.id : '',
                    text: item.name
                }));
            });
        }

        function submitForm(data) {
            setupAjax();
            const userId = $('#userForm').data('user-id');
            let postURL = '';
            if (userId) {
                postURL = "{{ route('users.update', ':id') }}";
                postURL = postURL.replace(':id', userId);
            } else {
                postURL = '{{ route('users.store') }}';
            }
            var formData = new FormData();

            if ($('#user_avatar').prop('files').length)
                formData.append('profile_pic', $('#user_avatar').prop('files')[0]);
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
                    getUserList();
                    if (userId) {
                        $('#userForm').removeData("user-id");
                        $('#putMethod').remove();
                    }
                },
                error: function(data) {}
            });
        }

        function hideModal(modalType) {
            if (modalType === 'crud') {
                $('#userForm')[0].reset();
                closeModel('#crud-modal');
            } else {
                closeModel('#popup-modal');
            }
        }

        function getUserList() {
            let URL = "{{ route('users.index') }}";
            $.ajax({
                type: 'GET',
                url: URL,
                cache: false,
                success: function(success) {
                    $('#userTableBody').html(success.data.html);
                },
                error: function(data) {
                    console.error('Custom Error', data);
                }
            });
        }
    </script>
@endpush
