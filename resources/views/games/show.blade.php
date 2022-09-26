<x-main-layout>
    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        // Thumbnail image controls
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slides[slideIndex-1].style.display = "block";
        }
    </script>

    <style>
        .fade {
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @keyframes fade {
            from {opacity: .4}
            to {opacity: 1}
        }
    </style>
    <div class="text-yellow-200 max-w-screen-xl mx-auto border-2 rounded-xl bg-gray-800">
        <div class="px-3 py-2 text-sm">
            <div class="text-center text-4xl flex flex-col pb-2">
                {{ $game['name'] }}
            </div>
            <hr>
            <div class="flex flex-row">
                <div class="w-2/3">
                    <div class="flex justify-center items-center pt-3">
                        <a class="cursor-pointer pr-2 hover:text-yellow-500" onclick="plusSlides(-1)">&#10094;</a>
                        @foreach($game['screenshots'] as $screenshot )
                            <div class="mySlides fade max-w-screen-md" style="display: {{ ($loop->index === 0) ? 'block' : 'none' }};">
                                <a href="{!! $screenshot['path_full'] !!}" target="_blank">
                                    <img src="{!! $screenshot['path_full'] !!}" alt=""/>
                                </a>
                                <div class="numbertext text-center">{{ $loop->index + 1 }}/{{ $loop->count }}</div>
                            </div>
                        @endforeach
                        <a class="cursor-pointer pl-2 hover:text-yellow-500" onclick="plusSlides(1)">&#10095;</a>
                    </div>
                    <br>
                </div>
                <div class="w-1/3">
                    <div class="text-yellow-500 p-1 pt-3">
                        <div class="grid place-items-center">
                            {!! $game['short_description'] !!}
                        </div>
                    </div>
                    <div class="text-yellow-500 p-1 text-xs">
                        @foreach($game['developers'] as $developer)
                            Developers: {!! $developer !!}
                        @endforeach
                    </div>
                    <div class="text-yellow-500 p-1 text-xs">
                        @foreach($game['publishers'] as $publisher)
                            Publisher: {!! $publisher !!}
                        @endforeach
                    </div>
                    <div class="text-yellow-500 p-1 text-xs">
                        Platforms:
                        @foreach($game['platforms'] as $platform => $isSupported)
                            @if($isSupported)
                                {!! $platform !!}
                            @endif
                        @endforeach
                    </div>
                    <div class="text-yellow-500 p-1 text-xs">
                        Release date: {!! $game['release_date'] !!}
                    </div>
                    <div class="text-yellow-500 p-1 text-xs">
                        Categories:
                        @foreach($game['categories'] as $category )
                            @if(!str_contains($category['description'], 'Steam') && !str_contains($category['description'], 'Remote'))
                                {!! $category['description'] !!}
                            @endif
                        @endforeach
                    </div>
                    <div class="text-yellow-500 p-1 text-xs">
                        Genres:
                        @foreach($game['genres'] as $genre )
                            {!! $genre['description'] !!}
                        @endforeach
                    </div>
                    <div class="text-yellow-500 p-1 text-xl">
                        ADD REVIEW
                    </div>
                </div>
            </div>
        </div>
        @if($game['about_the_game'])
            <div class="px-3 py-2">
                <div class="text-center text-2xl">
                    <h1>About the game</h1>
                    <hr>
                </div>
                <div class="text-yellow-500 p-1 ">
                    <div class="grid place-items-center">
                        {!! $game['about_the_game'] !!}
                    </div>
                </div>
            </div>
        @endif
        @if($game['pc_requirements'])
            <div class="px-3 py-2">
                <div class="text-center text-2xl">
                    <h1>PC requirements</h1>
                    <hr>
                </div>
                <div class="text-yellow-500 p-1 grid grid-cols-5">
                    <div></div>
                    @foreach($game['pc_requirements'] as $key => $value)
                        <div>
                            {!! $value !!}
                        </div>
                        <div></div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-main-layout>
