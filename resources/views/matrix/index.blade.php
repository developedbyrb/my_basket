@extends('layouts.app')

@section('content')
    <div class="table-wrapper">
        <div class="max-w-full overflow-x-auto">
            <form method="POST" action="{{ route('access-management.store') }}">
                @csrf
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-2 text-left dark:bg-meta-4">
                            <th class="w-75 py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                                #
                            </th>
                            @foreach ($roles as $role)
                                <th>{{ $role->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <p class="text-black dark:text-white">{{ $permission->name }}</p>
                                </td>
                                @foreach ($roles as $role)
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <input type="checkbox" name="permissions[{{ $role->id }}][]"
                                            value="{{ $permission->id }}"
                                            {{ $role->permissions->contains($permission->id) ? ' checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="flex flex-row-reverse mt-5">
                    <button type="submit" id="submit-permission" class="modal-submit-button">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
