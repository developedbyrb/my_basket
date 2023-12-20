<aside :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'"
    class="absolute left-0 top-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-hidden bg-black duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0"
    @click.outside="sidebarToggle = false">
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5">
        <a href="{{ route('dashboard') }}" class="flex w-11/12"
            @click="selected = (selected === 'Dashboard' ? '':'Dashboard')">
            <x-application-logo class="block h-12 w-50" />
        </a>

        <button class="block lg:hidden" @click.stop="sidebarToggle = !sidebarToggle">
            <svg class="fill-current" width="20" height="18" viewBox="0 0 20 18" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z"
                    fill="" />
            </svg>
        </button>
    </div>
    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
        <nav class="py-4 px-4 lg:px-6" x-data="{ selected: $persist('Dashboard') }">
            <div>
                <ul class="mb-6 flex flex-col gap-1.5">
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="{{ route('dashboard') }}"
                            @click="selected = (selected === 'Dashboard' ? '':'Dashboard')"
                            :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Dashboard') && (page === 'dashboard') }">
                            <x-dashboard-svg />
                            Dashboard
                        </a>
                    </li>

                    @auth
                        <li>
                            <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                                href="{{ route('users.index') }}"
                                @click="selected = (selected === 'User Management' ? '':'User Management')"
                                :class="{
                                    'bg-graydark dark:bg-meta-4': (selected === 'User Management') && (
                                        page === 'dashboard')
                                }">
                                <x-users-svg />
                                User Management
                            </a>
                        </li>

                        @if (auth()->user()->role->id === 1)
                            <li>
                                <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                                    href="javascript:void(0)" @click.prevent="selected = (selected === 'RAP' ? '':'RAP')"
                                    :class="{
                                        'bg-graydark dark:bg-meta-4': (selected === 'RAP') || (
                                                page === 'roles') ||
                                            (page === 'access-management')
                                    }">
                                    <x-forms />
                                    Role Access Panel
                                    <x-aero />
                                </a>

                                <div class="overflow-hidden" :class="(selected === 'RAP') ? 'block' : 'hidden'">
                                    <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                                        <li>
                                            <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white {{ request()->routeIs('roles.index') ? 'text-white' : '' }}"
                                                href="{{ route('roles.index') }}">
                                                Role Management
                                            </a>
                                        </li>
                                        <li>
                                            <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white {{ request()->routeIs('permissions.index') ? 'text-white' : '' }}"
                                                href="{{ route('permissions.index') }}">
                                                Permission Management
                                            </a>
                                        </li>
                                        <li>
                                            <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white {{ request()->routeIs('access-management.index') ? 'text-white' : '' }}"
                                                href="{{ route('access-management.index') }}">
                                                AccessScope Matrix
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif

                        <li>
                            <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                                href="javascript:void(0)" @click.prevent="selected = (selected === 'Shop' ? '':'Shop')"
                                :class="{
                                    'bg-graydark dark:bg-meta-4': (selected === 'Shop')
                                }">
                                <x-shopping-svg />
                                E-Commerce Management
                                <x-aero />
                            </a>

                            <div class="overflow-hidden" :class="(selected === 'Shop') ? 'block' : 'hidden'">
                                <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                                    <li>
                                        <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white {{ request()->routeIs('categories.index') ? 'text-white' : '' }}"
                                            href="{{ route('categories.index') }}">
                                            Category Management
                                        </a>
                                    </li>
                                    <li>
                                        <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white {{ request()->routeIs('products.index') ? 'text-white' : '' }}"
                                            href="{{ route('products.index') }}">
                                            Product Management
                                        </a>
                                    </li>
                                    <li>
                                        <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white {{ request()->routeIs('shops.index') ? 'text-white' : '' }}"
                                            href="{{ route('shops.index') }}">
                                            Shop Management
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </div>
</aside>
