<x-main-layout>
    <div class="text-yellow-300 max-w-screen-xl mx-auto border-2 rounded-xl bg-gray-800">
        <div class="px-3 py-2 text-sm">
            <div class="text-center text-4xl flex flex-col pb-2">
                {{ $game['name'] }}
            </div>
            <hr>
            <div class="flex flex-row">
                <x-game.slider :screens="$game['screenshots']" />
                <div class="w-1/3 ">
                    <div class="border-l-2 border-gray-600">
                        <div class="pb-3 pt-3 border-b-2 border-gray-600 pl-2">
                            <img src="{{ $game['header_image'] }}" alt=""/>
                        </div>
                        <div class="text-yellow-100 p-1 pt-3 border-b-2 border-gray-600 grid place-items-center pl-2">
                                {!! $game['short_description'] !!}
                        </div>
                        <x-game.arrayInfo :infos="$game['developers']" title="Developers" attribute="mt-1" />
                        <x-game.arrayInfo :infos="$game['publishers']" title="Publisher"/>
                        <div class="text-yellow-100 p-1 text-xs pl-2">
                            <strong>Platforms</strong>:
                            @foreach($game['platforms'] as $platform => $isSupported)
                                @if($isSupported)
                                    {!! $platform !!}
                                @endif
                            @endforeach
                        </div>
                        <div class="text-yellow-100 p-1 text-xs pl-2">
                            <strong>Release date</strong>:
                            {!! $game['release_date'] !!}
                        </div>
                        <div class="text-yellow-100 p-1 text-xs pl-2">
                            <strong>Categories</strong>:
                            @foreach($game['categories'] as $category )
                                @if(!str_contains($category['description'], 'Steam') && !str_contains($category['description'], 'Remote'))
                                    {!! $category['description'] !!}
                                @endif
                            @endforeach
                        </div>
                        <div class="text-yellow-100 p-1 text-xs pl-2">
                            <strong>Genres</strong>:
                            @foreach($game['genres'] as $genre )
                                {!! $genre['description'] !!}
                            @endforeach
                        </div>
                        <div class="text-yellow-100 p-1 text-xs pl-2 border-t-2 border-gray-600">
                            @if($game['reviews']['allReviews'] !== 0)
                                <strong>{{ ucfirst($game['reviews']['best']['name']) }}</strong>: {{ $game['reviews']['best']['score'] }}/10 </br>
                                <strong>General reviews</strong>: {{ $game['reviews']['general'] }}/10 based on {{ $game['reviews']['allReviews'] }} reviews</br>
                            @else
                                Not yet rated
                            @endif
                        </div>
                    </div>
                    <div class="text-green-500 p-1 text-xl text-center border-t-2 border-gray-600">
                        <form method="GET" action="/add-review/{{ $game['steam_appid'] }}" class="pt-2">
                            @csrf
                            <input id="name"
                                   name="name"
                                   type="hidden"
                                   value="{{ $game['name'] }}"
                            >
                            <button type="submit"
                                    class="transition-colors duration-300 bg-yellow-500 hover:bg-yellow-600 mt-4 lg:mt-0 lg:ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-8"
                            >
                                Add Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-3">
            <div class="text-center text-2xl pb-1">
                <h1>About the game</h1>
                <hr>
            </div>
            <div class="text-yellow-100 p-1 ">
                <div class="grid place-items-center">
                    {!! $game['about_the_game'] !!}
                </div>
            </div>
        </div>
        <div class="px-3 py-2">
            <div class="text-center text-2xl">
                <h1>PC requirements</h1>
                <hr>
            </div>
            <div class="text-yellow-100 p-1 grid grid-cols-5">
                <div></div>
                @foreach($game['pc_requirements'] as $key => $value)
                    <div>
                        {!! $value !!}
                    </div>
                    <div></div>
                @endforeach
            </div>
        </div>
    </div>
</x-main-layout>
