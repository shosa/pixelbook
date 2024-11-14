<style>
    .carousel {
        padding-right: 15%;
        margin: 0 auto;
    }


    .image-section {
        position: relative;
        height: 300px;
        width: 100%;
        overflow: visible;
        border-radius: 1rem;
    }

    .image-main {
        width: 100%;
        height: 100%;
        overflow: hidden;
        border-radius: 1rem;
    }

    .image-main img {
        object-fit: cover;
        width: 100%;
        height: 100%;
        border-radius: 1rem;
    }

    .image-small {
        position: absolute;
        top: -20px;
        right: -90px;
        width: 180px;
        height: 340px;
        overflow: hidden;
        z-index: 10;
    }

    /* Immagine cornice dell'iPhone */
    .iphone-frame {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    /* Immagine contenuta all'interno della cornice dell'iPhone */
    .content-image {
        position: absolute;
        width: 94%;
        height: 95%;
        top: 2%;
        left: 3%;
        object-fit: cover;
        border-radius: 1rem;
        z-index: 0;
    }

    .overlay-gradient {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        color: white;
        padding: 10px;
        border-bottom-left-radius: 1rem;
        border-bottom-right-radius: 1rem;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 35px;
        justify-content: center;
        align-items: center;
        width: calc(100% - 80px);
        margin-left: auto;
        margin-right: auto;
        transform: translateX(40px);
    }

    /* Media query per vari dispositivi */
    @media (min-width: 320px) and (max-width: 480px)
    /* smartphone */
        {
        /* tablet in landscape e laptop con bassa risoluzione */

        /* Rimozione dei margini dal contenitore principale */
        .container {
            padding: 0;
            margin: 0 !important;
            overflow: hidden;
        }

        /* Stile per Swiper */
        .swiper-wrapper {
            width: 80% !important;
        }

        .carousel {
            padding: 0 !important;
            margin: 0 auto;
        }

        .image-section {
            height: auto;
            aspect-ratio: 16 / 9;
            position: relative;
            overflow: visible;
            margin: 0;
            border-radius: 1rem;
        }

        .image-main {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .image-main img {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

        .image-small {
            width: 32%;
            height: auto;
            aspect-ratio: 9 / 18;
            position: absolute;
            top: 5%;
            right: -5%;
            transform: translate(0, -10%);
        }

        .overlay-gradient h2 {
            font-size: 1.5rem;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 35px;
            justify-content: center;
            align-items: center;
            width: calc(100% - 80px);
            margin-left: auto;
            margin-right: auto;
            transform: translateX(3px) !important;
        }
    }

    /* Stile per laptop e schermi di grandi dimensioni */
    @media (min-width: 1025px) {
        .button-group {
            width: calc(100% - 80px);
            transform: translateX(40px);
            /* Mantiene il layout specifico per desktop */
        }
    }

    /* Stile per schermi desktop */
    @media (min-width: 1025px) {
        .swiper-custom {
            width: 70% !important;
            margin: 0 auto;
        }
    }

    /* Stile per schermi desktop grandi (esclude laptop e schermi Mac più piccoli) */
    @media (min-width: 1600px) {
        .swiper-custom {
            width: 50% !important;
            margin: 0 auto;
        }
    }
</style>

<?php
// Connessione al database (usando $pdo)
$query = $pdo->query("SELECT * FROM home_carousel");
$carouselItems = $query->fetchAll(PDO::FETCH_ASSOC);

// Dividere gli elementi per tipo
$businessItems = array_filter($carouselItems, function ($item) {
    return $item['tipo'] === 'BUSINESS';
});

$personalItems = array_filter($carouselItems, function ($item) {
    return $item['tipo'] === 'PERSONAL';
});

function renderCarousel($items)
{
    foreach ($items as $item): ?>
        <div class="swiper-slide carousel">
            <div class="image-section position-relative">
                <!-- Immagine principale -->
                <div class="image-main">
                    <img src="<?php echo $item['foto_blur']; ?>" class="img-fluid">
                    <div class="overlay-gradient text-left">
                        <h2 class=" font-weight-bold text-white"><?php echo $item['nome']; ?></h2>
                    </div>
                </div>
                <!-- Immagine secondaria sovrapposta in basso a destra con cornice iPhone -->
                <div class="image-small">
                    <!-- Cornice PNG dell'iPhone -->
                    <img src="src/img/cornice.png" class="iphone-frame">
                    <!-- Immagine principale all'interno della cornice -->
                    <img src="<?php echo $item['foto']; ?>" class="img-fluid content-image">
                </div>
            </div>
            <div class="button-group">
                <a class="btn btn-light btn-outline-dark rounded-pill" href="book">Photographer</a>
                <a class="btn btn-light btn-outline-dark rounded-pill" href="book">Videographer</a>
            </div>
        </div>
    <?php endforeach;
}

?>

<!-- Sezione per BUSINESS -->
<section class="container py-2 mb-1">
    <h1 class="text-center">BUSINESS</h1>
    <div class="swiper business-swiper swiper-custom">
        <div class="swiper-wrapper mb-4">
            <?php renderCarousel($businessItems); ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Sezione per PERSONAL -->
<section class="container py-2 mb-1">
    <h1 class="text-center">PERSONAL</h1>
    <div class="swiper personal-swiper swiper-custom ">
        <div class="swiper-wrapper mb-4">
            <?php renderCarousel($personalItems); ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<script>
    // Inizializza Swiper per BUSINESS
    const businessSwiper = new Swiper('.business-swiper', {
        slidesPerView: 1,
        spaceBetween: 40,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        }
    });

    // Inizializza Swiper per PERSONAL
    const personalSwiper = new Swiper('.personal-swiper', {
        slidesPerView: 1,
        spaceBetween: 40,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        }
    });
</script>