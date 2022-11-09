<x-main-layout>
    <div>
        <p class="text-center loading text-yellow-500">Game propositions for You</p>
        <div class="flex items-start grid grid-cols-3 pt-4" id="game"></div>
        <div class="text-yellow-500 text-center font-xl">
            @foreach ($games as $game)
                <div>
                    <a href='/games/{{ $game['steam_appid'] }}' >{{ $loop->index + 1 }}. {{ $game['name'] }} </a>
                    @foreach ($reviews[$game['id']] as $key => $value)
                        {{ $key }}: {{ ($value['total']) }}
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</x-main-layout>
