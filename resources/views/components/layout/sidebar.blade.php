<div x-data>
    <aside :class="$store.showSidebar.on ? 'lg:w-64' : 'lg:w-0'"
        class="fixed top-0 left-0 z-50 lg:z-40 h-screen transition-all duration-500 ease-in-out lg:pt-14 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
        x-show="$store.showSidebar.on" x-transition:enter="transform transition-transform ease-out duration-1000"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition-transform ease-in duration-500" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full" aria-label="Sidenav" id="drawer-navigation">


        <div class="flex items-center bg-gray-100 px-5 pt-3 pb-2 border-b border-gray-200 lg:hidden">
            <h5 id="drawer-navigation-label"
                class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400 mr-auto">
                <a href="" class="flex items-center justify-between">
                    <img src="{{ asset('photo/logo-2.png') }}" class="mr-3 h-9" alt="Go Gym Logo" />
                    {{-- <span class="self-center text-lg font-semibold whitespace-nowrap dark:text-white">Go Gym</span> --}}
                </a>
            </h5>
            <button type="button" data-drawer-hide="drawer-navigation" aria-controls="drawer-navigation"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absollute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
        </div>

        <div :class="$store.showSidebar.on ? 'lg:block' : 'lg:hidden'"
            class="overflow-y-auto py-4 px-3 h-full bg-white dark:bg-gray-800">
            <ul class="space-y-2">

                <x-layout.sub.sidebar-item label="{{ __('Dashboard') }}" icon="fa-solid fa-gauge"
                    route="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" />

                @can('user_management_access')
                    <x-layout.sub.sidebar-collapse id="pages" label="{{ __('UserManagement') }}"
                        icon="fa-solid fa-pager" :active="request()->routeIs('admin.users', 'admin.permissions', 'admin.roles')">
                        <x-layout.sub.sidebar-collapse-item label="{{ __('Users') }}" route="{{ route('admin.users') }}"
                            :active="request()->routeIs('admin.users')" />
                        <x-layout.sub.sidebar-collapse-item label="{{ __('Permissions') }}"
                            route="{{ route('admin.permissions') }}" :active="request()->routeIs('admin.permissions')" />
                        <x-layout.sub.sidebar-collapse-item label="{{ __('Roles') }}" route="{{ route('admin.roles') }}"
                            :active="request()->routeIs('admin.roles')" />
                    </x-layout.sub.sidebar-collapse>
                @endcan

                <x-layout.sub.sidebar-collapse id="sa" label="{{ __('Classes') }}" icon="fa-solid fa-sack-dollar"
                    :active="request()->routeIs('admin.gymClasses') || request()->routeIs('admin.classSchedules') || request()->routeIs('admin.memberClasses')">
                    <x-layout.sub.sidebar-collapse-item label="{{ __('Gym Class') }}"
                        route="{{ route('admin.gymClasses') }}" :active="request()->routeIs('admin.gymClasses')" />
                    <x-layout.sub.sidebar-collapse-item label="{{ __('Class Schedule') }}"
                        route="{{ route('admin.classSchedules') }}" :active="request()->routeIs('admin.classSchedules')" />
                    <x-layout.sub.sidebar-collapse-item label="{{ __('Member Class') }}"
                        route="{{ route('admin.memberClasses') }}" :active="request()->routeIs('admin.memberClasses')" />

                </x-layout.sub.sidebar-collapse>

                <x-layout.sub.sidebar-item label="{{ __('Members') }}" icon="fa-solid fa-users"
                route="{{ route('admin.members') }}" :active="request()->routeIs('admin.members')" />

                <x-layout.sub.sidebar-item label="{{ __('Member Health') }}" icon="fa-solid fa-house-medical"
                route="{{ route('admin.memberHealthRecords') }}" :active="request()->routeIs('admin.memberHealthRecords')" />

                <x-layout.sub.sidebar-item label="{{ __('Trainers') }}" icon="fa-solid fa-person"
                route="{{ route('admin.trainers') }}" :active="request()->routeIs('admin.trainers')" />

                <x-layout.sub.sidebar-item label="{{ __('Staffs') }}" icon="fa-regular fa-user"
                route="{{ route('admin.staff') }}" :active="request()->routeIs('admin.staff')" />

                <x-layout.sub.sidebar-item label="{{ __('Promotions') }}" icon="fas fa-percentage"
                route="{{ route('admin.promotions') }}" :active="request()->routeIs('admin.promotions')"   />

                <x-layout.sub.sidebar-item label="{{ __('Health Article') }}" icon="far fa-newspaper"
                route="{{ route('admin.health_articles') }}" :active="request()->routeIs('admin.health_articles')"   />


            </ul>


            <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
                <x-layout.sub.sidebar-item icon="fa-regular fa-file-word"  label="{{ __('BarCode') }}" icon="fa-regular fa-user"
                route="{{ route('admin.userBarcode') }}" :active="request()->routeIs('admin.user_barcode')" />
                <x-layout.sub.sidebar-item label="{{ __('Docs') }}" icon="fa-regular fa-file-word" route="#" />
                <x-layout.sub.sidebar-item label="{{ __('Help') }}" icon="fa-solid fa-circle-question"
                    route="#" />
            </ul>
        </div>

    </aside>
</div>
