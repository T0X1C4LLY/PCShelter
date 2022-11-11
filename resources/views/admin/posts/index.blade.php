<x-main-layout>
    <x-setting heading="Manage Posts">
        <div class="inline-flex bg-gray-100 rounded-xl px-3 py-2 float-right">
            <form class="w-full" method="GET" action="{{ http_build_query(request()) }}">
                <input type="text"
                       name="admin_search"
                       placeholder="Search by post title"
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
                                <x-posts-anchor user="admin" value="title"/>
                                <x-posts-anchor user="admin" value="comments"/>
                                <x-posts-anchor user="admin" value="created at"/>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-base font-medium text-yellow-600" />
                                <td class="px-6 py-4 whitespace-nowrap text-center text-base font-medium text-yellow-600" />
                            </tr>
                            @foreach ($posts as $post)
                                <tr>
                                    <x-post-table-element>
                                        <a href="/posts/{{ $post['slug'] }}">
                                            {{ $post['title'] }}
                                        </a>
                                    </x-post-table-element>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="max-w-xl truncate text-center">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $post['comments'] }}
                                            </div>
                                        </div>
                                    </td>
                                    <x-post-table-element>
                                        {{ $post['created_at'] }}
                                    </x-post-table-element>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="/admin/posts/{{ $post['id'] }}/edit"
                                           class="text-yellow-500 hover:text-yellow-600"
                                        >
                                            Edit
                                        </a>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form method="POST" action="/admin/posts/{{ $post['id'] }}">
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
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </x-setting>
</x-main-layout>
