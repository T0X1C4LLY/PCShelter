<x-main-layout>
    <x-user-setting heading="My Posts">
        <div class="inline-flex bg-gray-100 rounded-xl px-3 py-2 float-right">
            <form class="w-full" method="GET" action="{{ http_build_query(request()) }}">
                <input type="text"
                       name="search"
                       placeholder="Find Your comment"
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
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-base font-medium text-yellow-600 text-center">
                                        <a href="/user/comments?sort={{ request()->fullUrlIs("*&sort=DESC") ? 'ASC' : 'DESC' }}&by=body&{{ http_build_query(request()->except(['by', 'sort'])) }}">
                                            Comment
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-base font-medium text-yellow-600">
                                    <a href="/user/comments?sort={{ request()->fullUrlIs("*&sort=DESC") ? 'ASC' : 'DESC' }}&by=created_at&{{ http_build_query(request()->except(['by', 'sort'])) }}">
                                        Created at
                                    </a>
                                </td>
                            </tr>
                            @foreach ($comments as $comment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900 max-w-lg truncate">
                                                <a href="/posts/{{ (DB::table('posts')->where('id', $comment->post_id)->get('slug'))[0]->slug }}">
                                                    {{ $comment->body }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        {{ $comment->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="py-1">
                        {{ $comments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </x-user-setting>
</x-main-layout>
