@props(['screens'])

<div class="w-2/3">
    <div class="flex justify-center items-center pt-3">
        <x-game.sliderScript/>
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
        @foreach($screens as $screenshot )
            <div class="mySlides fade max-w-screen-md"
                 style="display: {{ ($loop->index === 0) ? 'block' : 'none' }};"
            >
                <a href="{!! $screenshot['path_full'] !!}" target="_blank">
                    <img src="{!! $screenshot['path_full'] !!}" alt=""/>
                </a>
                <div class="numbertext text-center">{{ $loop->index + 1 }}/{{ $loop->count }}</div>
            </div>
        @endforeach
    </div>
    <br>
</div>
