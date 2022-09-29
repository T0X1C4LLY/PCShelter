<x-main-layout>
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
    <div class="text-yellow-300 max-w-screen-xl mx-auto border-2 rounded-xl bg-gray-800">
        <div class="px-3 py-2 text-sm">
            <div class="text-center text-4xl flex flex-col pb-2">
                {{ $game['name'] }}
            </div>
            <hr>
            <div class="flex flex-row">
                <div class="w-2/3">
                    <div class="flex justify-center items-center pt-3">
                        <script>
                            let slideIndex = 1;
                            window.onload = function() {
                                showSlides(slideIndex);
                            };

                            function showSlides(n) {
                                let i;
                                let slides = document.getElementsByClassName("mySlides");
                                if (slideIndex > slides.length) {slideIndex = 1}
                                if (n > slides.length) {slideIndex = 1}
                                if (n < 1) {slideIndex = slides.length}
                                for (i = 0; i < slides.length; i++) {
                                    slides[i].style.display = "none";
                                }
                                slides[slideIndex-1].style.display = "block";

                                setTimeout(showSlides, 3000, slideIndex++);
                            }
                        </script>
                        @foreach($game['screenshots'] as $screenshot )
                            <div class="mySlides fade max-w-screen-md" style="display: {{ ($loop->index === 0) ? 'block' : 'none' }};">
                                <a href="{!! $screenshot['path_full'] !!}" target="_blank">
                                    <img src="{!! $screenshot['path_full'] !!}" alt=""/>
                                </a>
                                <div class="numbertext text-center">{{ $loop->index + 1 }}/{{ $loop->count }}</div>
                            </div>
                        @endforeach
                    </div>
                    <br>
                </div>
                <div class="w-1/3 border-l-2 border-gray-600">
                    <div class="pb-3 pt-3 border-b-2 border-gray-600 pl-2">
                        <img src="{{ $game['header_image'] }}" alt=""/>
                    </div>
                    <div class="text-yellow-100 p-1 pt-3 border-b-2 border-gray-600 grid place-items-center pl-2">
                            {!! $game['short_description'] !!}
                    </div>
                    <div class="text-yellow-100 p-1 text-xs pl-2 mt-1">
                        @foreach($game['developers'] as $developer)
                            <strong>Developers</strong>:
                            {!! $developer !!}
                        @endforeach
                    </div>
                    <div class="text-yellow-100 p-1 text-xs pl-2">
                        @foreach($game['publishers'] as $publisher)
                            <strong>Publisher</strong>:
                            {!! $publisher !!}
                        @endforeach
                    </div>
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
                        <strong>Best reviews</strong>: </br>
                        <strong>General reviews</strong>: </br>
                    </div>
                    <div class="text-yellow-100 p-1 text-xl text-center border-t-2 border-gray-600">
                        ADD REVIEW
                    </div>
                </div>
            </div>
        </div>
        @if($game['about_the_game'])
            <div class="px-3 py-2">
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
        @endif
        @if($game['pc_requirements'])
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
        @endif
    </div>
</x-main-layout>
