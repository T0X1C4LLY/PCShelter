<x-main-layout>
    <div>
        <div class="text-center pt-2 pb-2">
            <div class="inline-flex bg-gray-100 rounded-xl px-3 py-2">
                <form class="w-full" method="GET" action="{{ http_build_query(request()) }}">
                    <input type="text"
                           name="search"
                           placeholder="Search by title or steam ID"
                           class="bg-transparent placeholder-yellow-400 font-semibold text-sm text-yellow-500 w-full px-1"
                           value="{{ request('search') }}"
                    >
                </form>
            </div>
        </div>
        <div class="flex items-start grid grid-cols-3 pt-4" id="game"></div>
        <p class="text-center loading text-yellow-500">Loading...</p>
        <x-infinite-scroll id="game" loading="loading" name="games"/>
    </div>
</x-main-layout>

