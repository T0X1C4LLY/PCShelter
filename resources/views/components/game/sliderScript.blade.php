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
