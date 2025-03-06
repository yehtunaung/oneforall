<div>
    <x-admin.pages-header title="Users" :breadcrumbs="[['label' => 'Users', 'url' => route('admin.user')], ['label' => 'List']]" :permission="true" />


    <!-- Table Container -->
    <div class="rounded-lg shadow-lg bg-primary-500 ">
        <!-- Search and Filters -->
        <div class="flex flex-wrap items-center justify-between p-4 bg-gray-100 dark:bg-gray-800 rounded-t-xl">
            <input type="text" wire:model.debounce.500ms="search" placeholder="Search users..."
                class="px-4 py-2 border rounded-lg text-sm focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-white dark:border-gray-600">

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg dark:text-white text-sm">
                    Filters
                    <i class="fa-solid fa-filter ml-2"></i>
                </button>
                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 shadow-lg rounded-lg p-4 z-10">
                    <label class="block text-sm text-gray-700 dark:text-gray-300">Role:</label>
                    <select wire:model="roleFilter"
                        class="w-full mt-1 border rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="">All</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Datatable --}}                                                         
        <x-admin.table>
            <!-- Header Slot -->
            <x-slot name="header">
                <tr class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-900 dark:text-gray-400">
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">
                        <button wire:click="sortBy('name')" class="flex items-center">
                            Name <i class="fa-solid fa-sort ml-1"></i>
                        </button>
                    </th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Role</th>
                    <th scope="col" class="px-6 py-3">Create Date</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </x-slot>

            <!-- Body Slot -->
            <x-slot name="body">
                @forelse($users as $index => $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">{{ ucfirst($user->role) }}</td>
                        <td class="px-6 py-4">{{ $user->created_at->format('d M, Y') }}</td>
                        <td class="px-6 py-4 relative">
                            <div x-data="{ open: false }">
                                <button @click="open = !open" class="text-gray-600 dark:text-gray-300">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-700 shadow-lg rounded-lg p-2 z-20">
                                    <button wire:click="edit({{ $user->id }})"
                                        class="block w-full px-4 py-2 text-sm hover:bg-gray-200 dark:hover:bg-gray-700">
                                        <i class="fa-solid fa-pen mr-2"></i> Edit
                                    </button>
                                    <button wire:click="delete({{ $user->id }})"
                                        class="block w-full px-4 py-2 text-sm text-red-600 hover:bg-red-100 dark:text-red-400 dark:hover:bg-gray-700">
                                        <i class="fa-solid fa-trash mr-2"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </x-slot>
        </x-admin.table>


    </div>

    <!-- Pagination -->
    <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded-b-xl">
        {{-- {{ $users->links() }} --}}
    </div>
</div>
