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
    @media (max-width: 768px) {
                .didas {
                    border-radius: 0 50rem 50rem 0 !important;
                  
                }
            }
</style>


<div class="custom-container w-80 my-2 bg-gradient-custom-yellow p-4 shadow didas" style="border-radius:50rem;">
    <div class="row text-center">
        <div class="col-md-6 text-center d-flex align-items-center">
            <div class="container p-4 ml-5">
                <span class="h1 text-white font-weight-bold text-gradient-custom-green ">Trusted By
                </span>
                <br><br><i class="font-weight-bold">Here are some of the clients who believed in my vision and work

                </i>
            </div>
        </div>
        <div class="col-md-6">


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
        </div>

    </div>
</div>


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