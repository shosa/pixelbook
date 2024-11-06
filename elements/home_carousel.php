<style>
    .carousel {
        padding-right: 15%;
        /* Rimuovi padding predefinito */
        margin: 0 auto;
        /* Centra la slide */

    }

    @media (max-width: 768px) {
        .carousel {
            padding-right: 25%;
            /* Aggiungi padding per dispositivi mobili */
        }
    }

    .image-section {
        position: relative;
        height: 300px;
        /* Regola l'altezza come preferisci */
        width: 100%;
        overflow: visible;
        /* Permetti all'immagine di uscire dal contenitore */
        border-radius: 1rem;
    }

    .image-main img {
        object-fit: cover;
        width: 100%;
        height: 100%;
        height: 300px;
        max-height: 300px;
        /* Imposta un'altezza massima */
        border-radius: 1rem;
        /* Arrotondamento per un look più pulito */
        overflow: hidden;
        /* Previene lo sforamento */
    }

    .image-small {
        position: absolute;
        top: -20px;
        /* Sporgere sopra */
        right: -90px;
        /* Spostata a destra */
        width: 180px;
        /* Larghezza desiderata */
        height: 340px;
        /* Altezza maggiore per la sporgenza */
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 2px 8px 9px rgba(0, 0, 0, 0.5);
        border: 3px solid white;
        z-index: 10;
        /* Assicurati che sia sopra l'immagine principale */
    }

    @media (max-width: 768px) {
    .image-small {
        position: absolute;
        top: 50%;
        right: -60px;
        width: 120px;
        height: 230px;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 2px 8px 9px rgba(0, 0, 0, 0.5);
        border: 3px solid white;
        z-index: 10;
        transform: translateY(-50%);
        /* Centra verticalmente l'immagine piccola */
    }
}

    .image-small img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Assicura che l'immagine si adatti senza distorsioni */
        border-radius: 1rem;
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
        /* Larghezza rimanente dopo l'immagine piccola */
        margin-left: auto;
        margin-right: auto;
        transform: translateX(40px);
        /* Sposta leggermente a destra */
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
                <!-- Immagine secondaria sovrapposta in basso a destra -->
                <div class="image-small">
                    <img src="<?php echo $item['foto']; ?>" class="img-fluid">
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