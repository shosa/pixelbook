<style>
    .carousel {
        padding-right: 15%;
        margin: 0 auto;
    }

    @media (max-width: 768px) {
       
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

    /* Media query per dispositivi mobili */
    @media (max-width: 768px) {
        .image-section {
            height: 50vw; /* Scala la sezione principale in base alla larghezza dello schermo */
        }

        .image-main {
            height: 100%;
        }

        .image-small {
            width: 25vw; /* Scala in base alla larghezza dello schermo */
            height: 50vw; /* Scala in modo proporzionale per mantenere le proporzioni dell'iPhone */
            top: -5vw;
            right: -8vw;
        }
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
                        <h2 class="text-white"><?php echo $item['nome']; ?></h2>
                        <p><?php echo nl2br($item['paragrafo']); ?></p>
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
    <div class="swiper business-swiper">
        <div class="swiper-wrapper">
            <?php renderCarousel($businessItems); ?>
        </div>

        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Sezione per PERSONAL -->
<section class="container py-2 mb-1">
    <h1 class="text-center">PERSONAL</h1>
    <div class="swiper personal-swiper">
        <div class="swiper-wrapper">
            <?php renderCarousel($personalItems); ?>
        </div>

        <div class="swiper-pagination"></div>
    </div>
</section>

<script>
    // Inizializza Swiper per BUSINESS
    const businessSwiper = new Swiper('.business-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
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
        spaceBetween: 20,
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
