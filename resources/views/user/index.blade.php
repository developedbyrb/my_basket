@extends('layouts.app')

@section('content')
    <div class="w-full flex flex-row-reverse">
        @if (auth()->user()->role->id === 1)
            <button class="custom-create-button open-user-modal" type="button" data-id="">
                <x-plus-svg />
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
                        @if (auth()->user()->role->id === 1)
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
                            Are you sure you want to delete this user?
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
    </div>

    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="modal-title text-lg font-semibold text-gray-900 dark:text-white">
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
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" name="name" id="name" class="custom-input-text"
                                    placeholder="Type user name">
                            </div>
                            <div class="col-span-2 sm:col-span-1 form-group">
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="text" name="email" id="email" class="custom-input-text"
                                    placeholder="Type user email">
                            </div>
                            <div class="col-span-2 form-group">
                                <label for="role"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                                <select id="role" class="custom-input-text" name="role_id">
                                    <option selected="">Select role</option>
                                </select>
                            </div>
                            <div class="col-span-2 form-group">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="user_avatar">Profile Picture</label>
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
        // Define JS varibales
        const addHTMLForPut = '<input type="hidden" name="_method" id="putMethod" value="PUT">';

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
            const $modalElement = document.querySelector('#popup-modal');
            $('#popup-modal').attr('data-user-id', userId);
            const modal = new Modal($modalElement);
            modal.show();
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
                    const $modalElement = document.querySelector('#crud-modal');
                    const modal = new Modal($modalElement);
                    modal.show();
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
                    const $modalElement = document.querySelector('#crud-modal');
                    const modal = new Modal($modalElement);
                    modal.show();

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
            let $modalElement;
            if (modalType === 'crud') {
                $('#userForm')[0].reset();
                $modalElement = document.querySelector('#crud-modal');
            } else {
                $modalElement = document.querySelector('#popup-modal');
            }
            const modal = new Modal($modalElement);
            modal.hide();
        }

        function setupAjax() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        function objectifyForm(formArray) {
            let returnArray = {};
            for (let i = 0; i < formArray.length; i++) {
                returnArray[formArray[i]['name']] = formArray[i]['value'];
            }
            return returnArray;
        }

        function getUserList() {
            let URL = "{{ route('users.index') }}";
            $.ajax({
                type: 'GET',
                url: URL,
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
