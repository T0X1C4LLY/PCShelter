@props(['screens'])

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
