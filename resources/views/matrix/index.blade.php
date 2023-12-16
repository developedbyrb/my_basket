@extends('layouts.app')

@section('content')
    <div
        class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <form method="POST">
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
                                            value="{{ $permission->id }}">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="flex flex-row-reverse mt-5">
                    <button type="button" id="submit-permission"
                        class="text-white ml-2 inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4  me-2 mb-2 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-blue-800">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
