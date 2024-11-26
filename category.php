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
    echo "<div class='container'><p>Nothing found here.</p></div>";
    require 'templates/footer.php';
    exit();
}

// Recupera le foto per la categoria
$stmt = $pdo->prepare("SELECT * FROM galleria WHERE categoria_id = ?");
$stmt->execute([$categoria_id]);
$fotografie = $stmt->fetchAll();
?>
<style>
    /* Griglia Masonry per la galleria */
    .gallery {
        column-count: 3;
        column-gap: 10px;
    }

    .gallery-item {
        margin-bottom: 10px;
        break-inside: avoid;

        overflow: hidden;
        display: inline-block;
        width: 100%;
    }

    .gallery-img {
        width: 100%;
        height: auto;
        object-fit: cover;
        transition: transform 0.3s ease;
        cursor: pointer;
    }

    .gallery-item:hover .gallery-img {
        transform: scale(1.05);
    }

    /* Stile per il modale a schermo intero */
    .modal-fullscreen {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(10px);
        opacity: 0;
        transform: scale(0.9);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .modal-fullscreen.show {
        display: flex;
        opacity: 1;
        transform: scale(1);
    }

    .close-btn {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 30px;
        color: white;
        cursor: pointer;
        z-index: 10000;
        /* Assicurati che il pulsante sia sopra gli altri elementi */
    }

    /* Regole responsive per la griglia */
    @media (max-width: 768px) {
        .gallery {
            column-count: 3;
        }
    }

    @media (max-width: 576px) {
        .gallery {
            column-count: 2;
        }
    }
</style>

<div class="container text-center mt-5">
    <h1 class="text-gradient-custom font-weight-bold text-uppercase" style=" font-size: 3rem;">
        <?php echo htmlspecialchars($categoria['nome']); ?>
    </h1>
    <i class="h5 my-4 ">
        "<?php echo htmlspecialchars($categoria['descrizione']); ?>"

    </i><br>
   
    <hr>
    <a class="btn btn-gradient-custom mb-4 mt-4 shadow-lg btn-lg rounded-pill" style="font-size: 1rem;"
        href="form?category=<?php echo $categoria_id; ?>">BOOK NOW</a>



    <?php if ($fotografie): ?>
        <div class="gallery mt-4">
            <?php foreach ($fotografie as $index => $foto): ?>
                <div class="gallery-item shadow-sm">
                    <img src="images/gallery/<?php echo htmlspecialchars($foto['file']); ?>" class="gallery-img"
                        alt="<?php echo htmlspecialchars($foto['descrizione']); ?>" onclick="openModal(<?php echo $index; ?>)">
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Nothing found here.</p>
    <?php endif; ?>
    <a class="btn btn-gradient-custom mb-4 mt-4 shadow-lg btn-lg rounded-pill" style="font-size: 1rem;"
        href="form?category=<?php echo $categoria_id; ?>">BOOK NOW</a>
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
        padding: 5%;
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
    <a class="btn btn-gradient-custom mb-4 shadow-lg floating-button rounded-pill"
        style="font-size: 1rem; position: absolute; bottom: 5%;" href="form?category=<?php echo $categoria_id; ?>">BOOK
        NOW</a>
</div>

<script>
    let swiper;
    let currentIndex = 0;

    function openModal(index) {
        currentIndex = index;
        const modal = document.getElementById('imageModal');

        if (swiper) {
            swiper.slideToLoop(currentIndex, 0);
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
        swiper = new Swiper('.swiper-container', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            loop: true,
        });

        const images = document.querySelectorAll('.gallery-img');
        images.forEach((img, index) => {
            img.addEventListener('click', () => openModal(index));
        });
    });
</script>
<?php include("elements/support.php"); ?>
<?php require 'components/footer.php'; ?>