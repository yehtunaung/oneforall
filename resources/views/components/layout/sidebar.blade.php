<div>
    <aside
        class="fixed top-0 left-0 lg:z-40 w-64 h-screen pt-14 transition-transform duration-500 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
        :class="{ '-translate-x-full': !$store.sidebar.isSidebarOpen, 'translate-x-0': $store.sidebar.isSidebarOpen }">
        <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
            <ul class="space-y-2">
            <form action="#" method="GET" class=" mb-2">
                <label for="sidebar-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-gray-500"></i>
                    </div>
                    <input type="text" name="search" id="sidebar-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Search" />
                </div>
            </form>
            <x-layout.sub.sidebar-item label="{{ __('Dashboard') }}" icon="fa-solid fa-house"
                route="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" />
            <x-layout.sub.sidebar-item label="{{ __('Members') }}" icon="fa-solid fa-users"
                route="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" />
            <x-layout.sub.sidebar-group id="" label="{{ __('User Management') }}"
                icon="fa-solid fa-sack-dollar" :active="request()->routeIs('admin.dashboard') || request()->routeIs('admin.classSchedules')">
                <x-layout.sub.sidebar-group-item label="{{ __('User') }}" route="{{ route('admin.dashboard') }}"
                    :active="request()->routeIs('admin.dashboard')" />

            </x-layout.sub.sidebar-group>
            </ul>
        </div>
    </aside>
</div>
