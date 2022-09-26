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
        <div class="flex items-start grid grid-cols-3 pt-4">
            @foreach($games as $game)
                <div class="px-2 py-2 transform transition duration-500 hover:scale-105">
                    <a href="/games/{{ $game->steam_appid }}">
                        <img src="{{ $game->header_image }}" alt="" title="{{ $game->name }}" class="w-full h-full"/>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-main-layout>

