<?php
require 'config/db.php';
require 'components/header.php';

$pdo = Database::getInstance();

// Recupera l'ID della categoria dalla query string
$categoria_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Recupera i dettagli della categoria
$stmt = $pdo->prepare("SELECT * FROM categorie WHERE id = ?");
$stmt->execute([$categoria_id]);
$categoria = $stmt->fetch();

if (!$categoria) {
    echo "<div class='container'><p>Categoria non trovata.</p></div>";
    require 'templates/footer.php';
    exit();
}

// Recupera le foto per la categoria
$stmt = $pdo->prepare("SELECT * FROM galleria WHERE categoria_id = ?");
$stmt->execute([$categoria_id]);
$fotografie = $stmt->fetchAll();
?>
<style>
    .gallery-img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 5px;
        cursor: pointer;
        /* Aggiunge il cursore a mano quando si passa sopra l'immagine */
    }

    .card {
        overflow: hidden;
    }

    /* Stile per il modale a schermo intero */
    /* Stile per il modale a schermo intero */
    .modal-fullscreen {
        display: none;
        /* Inizialmente nascosto */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        /* Sfondo semitrasparente scuro */
        z-index: 9999;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(10px);
        /* Sfoca lo sfondo */
        opacity: 0;
        transform: scale(0.9);
        /* Riduzione iniziale per l'effetto zoom */
        transition: opacity 0.3s ease, transform 0.3s ease;
        /* Animazione su opacity e trasformazione */
    }

    .modal-fullscreen.show {
        display: flex;
        opacity: 1;
        transform: scale(1);
        /* Effetto zoom alla dimensione normale */
    }

    .modal-fullscreen img {
        max-width: 90%;
        max-height: 80%;
        border-radius: 10px;
        transition: opacity 0.3s ease;
        /* Animazione sul contenuto dell'immagine */
    }

    .close-btn {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 30px;
        color: white;
        cursor: pointer;
    }
</style>

<div class="container text-center">
    <h1 class="text-gradient-custom font-weight-bold text-uppercase" style=" font-size: 3rem;">
        <?php echo htmlspecialchars($categoria['nome']); ?>
    </h1>
    <h5 class="my-4">
        <?php echo htmlspecialchars($categoria['descrizione']); ?>
    </h5>
    <a class="btn btn-gradient-custom mb-4 shadow-lg floating-button" style="font-size: 1rem;"
        href="form?category=<?php echo $categoria_id; ?>">BOOK NOW</a>

    <?php if ($fotografie): ?>
        <div class="row">
            <?php foreach ($fotografie as $foto): ?>
                <div class="col-6 col-md-4 mb-3">
                    <!-- Modifica per il layout mobile -->
                    <div class="card shadow-sm">
                        <img src="images/gallery/<?php echo htmlspecialchars($foto['file']); ?>"
                            class="card-img-top gallery-img" alt="<?php echo htmlspecialchars($foto['descrizione']); ?>"
                            onclick="openModal('images/gallery/<?php echo htmlspecialchars($foto['file']); ?>')">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Non ci sono foto per questa categoria.</p>
    <?php endif; ?>
</div>
<style>
    .swiper-container {
        width: 90%;
        height: 80%;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
        padding:5%;
    }

    .swiper-slide img {
        max-width: 100%;
        max-height: 100%;
        border-radius: 10px;
    }
</style>
<div id="imageModal" class="modal-fullscreen">
    <span class="close-btn" onclick="closeModal()">×</span>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($fotografie as $foto): ?>
                <div class="swiper-slide">
                    <img src="images/gallery/<?php echo htmlspecialchars($foto['file']); ?>"
                        alt="<?php echo htmlspecialchars($foto['descrizione']); ?>" />
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Pulsanti di navigazione -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
    <!-- Pulsante Book Now nel modale -->
    <a class="btn btn-gradient-custom mb-4 shadow-lg floating-button"
        style="font-size: 1rem; position: absolute; bottom: 30px;"
        href="form?category=<?php echo $categoria_id; ?>">BOOK NOW</a>
</div>


<script>
    let swiper;
    let currentIndex = 0;

    function openModal(index) {
        currentIndex = index;
        const modal = document.getElementById('imageModal');

        // Imposta swiper su currentIndex
        if (swiper) {
            swiper.slideTo(currentIndex, 0);
        }

        modal.style.display = 'flex';
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Inizializza Swiper
        swiper = new Swiper('.swiper-container', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            loop: true, // Loop per consentire lo scorrimento continuo
        });

        // Associa l'evento click alle immagini della galleria
        const images = document.querySelectorAll('.gallery-img');
        images.forEach((img, index) => {
            img.addEventListener('click', () => openModal(index));
        });
    });
</script>

<?php require 'components/footer.php'; ?>