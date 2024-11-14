<style>
    .logo-carousel {
        background-color: #f5f5f5;
        padding: 20px 0;
    }

    .logo-swiper {
        width: 100%;
        overflow: hidden;
    }

    .logo-slide {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 150px;
        /* Altezza uniforme per le slide */
    }

    .logo-slide img {
        max-width: 100%;
        /* Assicura che l'immagine non esca dal contenitore */
        height: auto;
        max-height: 100%;
        /* Altezza massima per rendere tutte le immagini uniformi */
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }

    .logo-slide img:hover {
        opacity: 1;
    }
</style>

<section class="container pt-1">
    <h2 class="text-center mb-4 font-weight-bold">Trusted By</h2>

    <div class="swiper logo-swiper">
        <div class="swiper-wrapper mb-4">
            <div class="swiper-slide logo-slide">
                <img src="src/img/logos1.png" alt="Logo 1">
            </div>
            <div class="swiper-slide logo-slide">
                <img src="src/img/logos2.png" alt="Logo 2">
            </div>
            <div class="swiper-slide logo-slide">
                <img src="src/img/logos3.png" alt="Logo 3">
            </div>
            <div class="swiper-slide logo-slide">
                <img src="src/img/logos4.png" alt="Logo 4">
            </div>
            <div class="swiper-slide logo-slide">
                <img src="src/img/logos5.png" alt="Logo 5">
            </div>
        </div>
        <!-- Paginazione -->
        <div class="swiper-pagination"></div>
    </div>
</section>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    const logoSwiper = new Swiper('.logo-swiper', {
        slidesPerView: 1, // Mostra solo una slide per volta
        spaceBetween: 20, // Riduci lo spazio tra le slide
        centerSlides: true,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 2, // Aumenta le slide su schermi più grandi
                spaceBetween: 15
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            1280: {
                slidesPerView: 5,
                spaceBetween: 40
            }
        }
    });
</script>