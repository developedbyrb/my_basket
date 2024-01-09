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
                        @if (\Helper::hasPermissionToView('get-users'))
                            <li>
                                <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                                    href="{{ route('users.index') }}"
                                    @click="selected = (selected === 'Users' ? '':'Users')"
                                    :class="{
                                        'bg-graydark dark:bg-meta-4': (selected === 'Users')
                                    }">
                                    <x-users-svg />
                                    Users
                                </a>
                            </li>
                        @endif

                        @if (\Helper::hasPermissionToView('get-products') || \Helper::hasPermissionToView('get-attributes'))
                            <li>
                                <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                                    href="javascript:void(0)"
                                    @click.prevent="selected = (selected === 'Inventory' ? '':'Inventory')"
                                    :class="{
                                        'bg-graydark dark:bg-meta-4': (selected === 'Inventory') || (
                                            page === 'roles')
                                    }">
                                    <svg width="18" height="18" class="text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 21">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                            d="M7.24 7.194a24.16 24.16 0 0 1 3.72-3.062m0 0c3.443-2.277 6.732-2.969 8.24-1.46 2.054 2.053.03 7.407-4.522 11.959-4.552 4.551-9.906 6.576-11.96 4.522C1.223 17.658 1.89 14.412 4.121 11m6.838-6.868c-3.443-2.277-6.732-2.969-8.24-1.46-2.054 2.053-.03 7.407 4.522 11.959m3.718-10.499a24.16 24.16 0 0 1 3.719 3.062M17.798 11c2.23 3.412 2.898 6.658 1.402 8.153-1.502 1.503-4.771.822-8.2-1.433m1-6.808a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" />
                                    </svg>
                                    Inventory
                                    <x-aero />
                                </a>

                                <div class="overflow-hidden" :class="(selected === 'Inventory') ? 'block' : 'hidden'">
                                    <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                                        @if (\Helper::hasPermissionToView('get-attributes'))
                                            <li>
                                                <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white {{ request()->routeIs('attributes.index') ? 'text-white' : '' }}"
                                                    href="{{ route('attributes.index') }}">
                                                    Products Attributes
                                                </a>
                                            </li>
                                        @endif
                                        @if (\Helper::hasPermissionToView('get-products'))
                                            <li>
                                                <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white {{ request()->routeIs('products.index') ? 'text-white' : '' }}"
                                                    href="{{ route('products.index') }}">
                                                    All Products
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endif

                        @if (\Helper::hasPermissionToView('get-categories') || \Helper::hasPermissionToView('get-shops'))
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
                                        @if (\Helper::hasPermissionToView('get-categories'))
                                            <li>
                                                <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white {{ request()->routeIs('categories.index') ? 'text-white' : '' }}"
                                                    href="{{ route('categories.index') }}">
                                                    Categories
                                                </a>
                                            </li>
                                        @endif
                                        @if (\Helper::hasPermissionToView('get-shops'))
                                            <li>
                                                <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white {{ request()->routeIs('shops.index') ? 'text-white' : '' }}"
                                                    href="{{ route('shops.index') }}">
                                                    Shops
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endif

                        @if (\Helper::hasPermissionToView('get-orders', false))
                            <li>
                                <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                                    href="{{ route('orders.index') }}"
                                    @click="selected = (selected === 'orders' ? '':'orders')"
                                    :class="{
                                        'bg-graydark dark:bg-meta-4': (selected === 'orders')
                                    }">
                                    <x-shop-svg />
                                    My Orders
                                </a>
                            </li>
                        @endif

                        @if (
                            \Helper::hasPermissionToView('get-roles') ||
                                \Helper::hasPermissionToView('get-permissions') ||
                                \Helper::hasPermissionToView('get-access'))
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
                                        @if (\Helper::hasPermissionToView('get-roles'))
                                            <li>
                                                <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white {{ request()->routeIs('roles.index') ? 'text-white' : '' }}"
                                                    href="{{ route('roles.index') }}">
                                                    Roles
                                                </a>
                                            </li>
                                        @endif
                                        @if (\Helper::hasPermissionToView('get-permissions'))
                                            <li>
                                                <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white {{ request()->routeIs('permissions.index') ? 'text-white' : '' }}"
                                                    href="{{ route('permissions.index') }}">
                                                    Permissions
                                                </a>
                                            </li>
                                        @endif
                                        @if (\Helper::hasPermissionToView('get-access'))
                                            <li>
                                                <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white {{ request()->routeIs('access-management.index') ? 'text-white' : '' }}"
                                                    href="{{ route('access-management.index') }}">
                                                    AccessScope Matrix
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endif

                        @if (\Helper::hasPermissionToView('get-warehouses', false))
                            <li>
                                <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                                    href="{{ route('warehouses.index') }}"
                                    @click="selected = (selected === 'Warehouse' ? '':'Warehouse')"
                                    :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Warehouse') }">
                                    <svg width="18" height="18" class="text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 21">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 8v10a1 1 0 0 0 1 1h4v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5h4a1 1 0 0 0 1-1V8M1 10l9-9 9 9" />
                                    </svg>
                                    My Warehouses
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </nav>
    </div>
</aside>
