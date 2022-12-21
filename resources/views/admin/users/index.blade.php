<x-main-layout>
    <x-setting heading="Manage Users">
        <div class="inline-flex bg-gray-100 rounded-xl px-3 py-2 float-right">
            <form class="w-full" method="GET" action="/admin/users">
                <input type="text"
                       name="admin_search"
                       placeholder="Search"
                       class="bg-transparent placeholder-yellow-400 font-semibold text-sm text-yellow-500 w-full px-1"
                       value="{{ request('admin_search') }}"
                >
            </form>
        </div>
        <div class="clear-both flex flex-col pt-1">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <x-admin-anchor url="admin/users" value="username"/>
                                <x-admin-anchor url="admin/users" value="name"/>
                                <x-admin-anchor url="admin/users" value="created at"/>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-base font-medium text-yellow-600">
                                        Role
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-base font-medium text-yellow-600">

                                </td>
                            </tr>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="max-w-xs truncate flex items-center">
                                            <div class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $user['username'] }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="max-w-xs truncate flex items-center">
                                            <div class="text-sm font-medium text-gray-900 truncate">
                                                {{ $user['name'] }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="max-w-xs truncate text-center">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $user['created_at'] }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="max-w-xs truncate text-center">
                                            <div class="text-sm font-medium text-gray-900">
                                                <x-panel-dropdown>
                                                    <x-slot name="trigger">
                                                        <button class="text-xs font-bold uppercase">
                                                            {{ $user['role'] }}
                                                        </button>
                                                    </x-slot>
                                                    @foreach ($roles as $role)
                                                        <form id="perfect-list-destroy" action="/admin/users/{{ $user['id'] }}/{{ $role['id'] }}" method="POST">
                                                            @method('PATCH')
                                                            @csrf
                                                            <button type="submit"
                                                                    class="block w-full text-left px-3 text-sm leading-6 hover:bg-yellow-500 focus:bg-yellow-500 hover:text-white focus:text-white {{ ($user['role'] === $role['name']) ? ' bg-yellow-500 text-white pointer-events-none' : ' text-yellow-500' }}"
                                                                    {{ ($user['role'] === $role['name']) ? 'disabled' : '' }}
                                                            >
                                                                {{ $role['name'] }}
                                                            </button>
                                                        </form>
                                                    @endforeach
                                                </x-panel-dropdown>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form method="POST" action="/admin/users/{{ $user['id'] }}">
                                            @csrf
                                            @method('DELETE')

                                            <button class="text-xs text-red-500 hover:text-red-600">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="py-1">
                        {{ $users->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </x-setting>
</x-main-layout>
