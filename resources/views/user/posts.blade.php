<x-main-layout>
    <x-user-setting heading="My Posts">
        <div class="inline-flex bg-gray-100 rounded-xl px-3 py-2 float-right">
            <form class="w-full" method="GET" action="{{ http_build_query(request()) }}">
                <input type="text"
                       name="search"
                       placeholder="Search by post title"
                       class="bg-transparent placeholder-yellow-400 font-semibold text-sm text-yellow-500 w-full px-1"
                       value="{{ request('search') }}"
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
                                    <x-posts-anchor user="user" value="title"/>
                                    <x-posts-anchor user="user" value="comments"/>
                                    <x-posts-anchor user="user" value="created at"/>
                                </tr>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="/posts/{{ $post->slug }}">
                                                        {{ $post->title }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            {{ $post->comments }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            {{ $post->created_at }}
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
    </x-user-setting>
</x-main-layout>
