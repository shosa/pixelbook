<style>
    .reviewer-name {
        font-weight: bold;
    }

    .card {
        border-radius: 10px;
        border: none;
        min-height: 230px;
        /* Imposta un'altezza minima */
        max-width: 400px;
        /* Limita la larghezza delle card */
        margin: auto;
        /* Centra la card */
    }

    .swiper {
        padding: 20px;
    }



    .swiper-pagination-bullet-active {
        background-color: #ff9800;
        /* Colore del puntino attivo */
    }

    .swiper-horizontal>.swiper-pagination-bullets,
    .swiper-pagination-bullets.swiper-pagination-horizontal,
    .swiper-pagination-custom,
    .swiper-pagination-fraction {
        bottom: 0 !important;
    }
</style>

<div class="custom-container w-80">
    <div class="row text-center">

       
        <div class="col-md-6">
            <div class="swiper">
                <div class="swiper-wrapper mb-4">
                    <div class="swiper-slide">
                        <div class="card shadow-sm p-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="reviewer-name"><strong>Emily Carter</strong></div>
                                <img src="src/img/google-logo.png" alt="Google Logo" style="width: 30px;">
                            </div>
                            <p>"Working with PixelShoot was an amazing experience! The photographer was professional and
                                captured my special moments perfectly. I can't wait to book again!"</p>
                            <span class="text-yellow text-center"><i class="fa fa-star fa-sm"></i><i
                                    class="fa fa-star fa-sm"></i><i class="fa fa-star fa-sm"></i><i
                                    class="fa fa-star fa-sm"></i><i class="fa fa-star fa-sm"></i></span>

                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card shadow-sm p-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="reviewer-name"><strong>James Wilson</strong></div>
                                <img src="src/img/google-logo.png" alt="Google Logo" style="width: 30px;">
                            </div>
                            <p>"The process was seamless from start to finish. Our photographer was fantastic and the
                                pictures
                                turned out beyond our expectations."</p>
                            <span class="text-yellow text-center"><i class="fa fa-star fa-sm"></i><i
                                    class="fa fa-star fa-sm"></i><i class="fa fa-star fa-sm"></i><i
                                    class="fa fa-star fa-sm"></i><i class="fa fa-star fa-sm"></i></span>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card shadow-sm p-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="reviewer-name"><strong>Sophie Martin</strong></div>
                                <img src="src/img/google-logo.png" alt="Google Logo" style="width: 30px;">
                            </div>
                            <p>"Highly recommend PixelShoot! They made my event memorable with stunning photos. The team
                                was
                                responsive and professional."</p>
                            <span class="text-yellow text-center"><i class="fa fa-star fa-sm"></i><i
                                    class="fa fa-star fa-sm"></i><i class="fa fa-star fa-sm"></i><i
                                    class="fa fa-star fa-sm"></i><i class="fa fa-star fa-sm"></i></span>

                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card shadow-sm p-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="reviewer-name"><strong>Daniel Lewis</strong></div>
                                <img src="src/img/google-logo.png" alt="Google Logo" style="width: 30px;">
                            </div>
                            <p>"I had a corporate shoot, and the quality was outstanding. The photographer was on point
                                with
                                direction and the final photos exceeded my expectations."</p>
                            <span class="text-yellow text-center"><i class="fa fa-star fa-sm"></i><i
                                    class="fa fa-star fa-sm"></i><i class="fa fa-star fa-sm"></i><i
                                    class="fa fa-star fa-sm"></i><i class="fa fa-star fa-sm"></i></span>

                        </div>
                    </div>
                    <!-- Aggiungi altre recensioni qui seguendo lo stesso formato -->
                </div>
                <!-- Aggiungi i controlli dello Swiper -->
                <div class="swiper-pagination"></div>

            </div>
        </div>
        <div class="col-md-6 text-right d-flex align-items-center">
            <div class="container p-4 ml-5">
                <span class="h1 text-white font-weight-bold text-gradient-custom ">Discover our
                    delighted clients
                </span>
                <br><br><i class="font-weight-normal">Real stories from those who trusted us. Explore their feedback and
                    see the impact we’ve made

                </i>
            </div>
        </div>
    </div>
</div>

<script>
    // Inizializza Swiper
    const swiper = new Swiper('.swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        loop: true,
    });
</script>