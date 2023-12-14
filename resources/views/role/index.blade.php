@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full flex flex-row-reverse">
                    <x-primary-button class="openUpsertModal" data-current_role="">
                        {{ __('Create Role') }}
                    </x-primary-button>
                </div>

                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <table class="w-full border text-center text-sm font-light dark:border-neutral-500">
                                    <thead class="border-b font-bold dark:border-neutral-500">
                                        <tr>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Id
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Name
                                            </th>
                                            <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($roles as $role)
                                            <tr class="border-b dark:border-neutral-500">
                                                <td class="table-text font-medium">
                                                    {{ $role->id }}
                                                </td>
                                                <td class="table-text">
                                                    {{ $role->name }}
                                                </td>
                                                <td class="table-text w-1/3">
                                                    <div class="flex flex-row gap-x-3 justify-end content-end">
                                                        <x-secondary-button class="openUpsertModal"
                                                            data-current_role="{{ $role->id }}">
                                                            {{ __('Edit Role') }}
                                                        </x-secondary-button>
                                                        @if ($role->name !== 'Admin')
                                                            <x-danger-button class="openModal" data-id="{{ $role->id }}">
                                                                {{ __('Remove Role') }}
                                                            </x-danger-button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="border-b dark:border-neutral-500">
                                                <td class="table-text font-medium" colspan="3">
                                                    Please Add Roles
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-modal-wrapper invisible" aria-labelledby="modal-title" role="dialog" aria-modal="true"
        id="removeRole">
        @include('components.confirmation')
    </div>

    <div class="custom-modal-wrapper invisible" aria-labelledby="modal-title" role="dialog" aria-modal="true"
        id="upsertRole">
        @include('role.partials.upsert')
    </div>
@endsection

@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $('.openUpsertModal').on('click', function(e) {
                $('#roleForm')[0].reset();
                const roleId = $(this).data('current_role');
                if (roleId) {
                    getRoleDetails(roleId);
                } else {
                    $('#upsertRole #modal-title').html('Create Role');
                    $('#upsertRole').removeClass('invisible');
                }
            });

            $('#submitUpsert').on('click', function(e) {
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
                    upsertRole(formData);
                }
            });

            $('#confirmDelete').on('click', function(e) {
                const roleId = $(this).data('id');
                let getRoleURL = "{{ route('roles.destroy', ':id') }}";
                getRoleURL = getRoleURL.replace(':id', roleId);
                $.ajax({
                    url: getRoleURL,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        $("#removeRole .closeModal").click();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
        });

        function getRoleDetails(roleId) {
            let getRoleURL = "{{ route('roles.show', ':id') }}";
            getRoleURL = getRoleURL.replace(':id', roleId);
            setupAjax();

            $.ajax({
                type: 'GET',
                url: getRoleURL,
                success: function(data) {
                    $('#roleForm #role').val(data.name);
                    $('#upsertRole #modal-title').html('Edit Role');
                    $('#upsertRole').removeClass('invisible');
                },
                error: function(data) {
                    console.error('Custom Error', data);
                    $('#removeRole').addClass('invisible');
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

        function upsertRole(data) {
            setupAjax();
            $.ajax({
                url: "{{ route('roles.upsert') }}",
                type: 'POST',
                data: data,
                success: function(data) {
                    hideModal();
                },
                error: function(data) {
                }
            });
        }

        function hideModal() {
            $('#upsertRole #closeUpsert').click();
        }

        function setupAjax() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
    </script>
@endpush
