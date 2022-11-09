<x-main-layout>
    <div class="bg-gray-800 rounded-3xl mt-2">
        <p class="text-center loading text-yellow-500 text-3xl py-2">
            Game propositions for You
        </p>
        <div class="flex items-start grid grid-cols-3 pt-4 text-yellow-500 text-center text-xl">
            @foreach ($games as $game)
                <div class="my-auto">
                    {{ $loop->index + 1 }}.
                </div>
                <div class="px-2 pt-2 transform transition duration-500 hover:scale-105 {{ $loop->last ? 'pb-5' : 'pb-2' }}">
                    <a href='/games/{{ $game['steam_appid'] }}' >
                        <img src="{{ $game['header_image'] }}" alt="" title="{{ $game['name'] }}" class="w-full h-full"/>
                    </a>
                </div>
                <div class="my-auto space-y-2">
                    @foreach ($reviews[$game['id']] as $key => $value)
                        <p>{{ $key }}: {{ ($value['total']) }}/10</p>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</x-main-layout>
