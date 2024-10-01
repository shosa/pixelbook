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
    <h1 class="my-5 text-success font-weight-bold text-uppercase">
        <?php echo htmlspecialchars($categoria['nome']); ?>
    </h1>
    <h5 class="my-4">
        <?php echo htmlspecialchars($categoria['descrizione']); ?>
    </h5>
    <a class="btn btn-success my-4 shadow-sm" style="border-radius:20px;"
        href="form?service=<?php echo $categoria['nome']; ?>">BOOK NOW</a>

    <?php if ($fotografie): ?>
        <div class="row">
            <?php foreach ($fotografie as $foto): ?>
                <div class="col-6 col-md-4 mb-4">
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

<!-- Modale personalizzato per visualizzare l'immagine a schermo intero -->
<div id="imageModal" class="modal-fullscreen" onclick="closeModal()">
    <span class="close-btn" onclick="closeModal()">×</span>
    <img id="modalImage" src="" alt="Immagine a schermo intero">
</div>

<script>
    // Funzione per aprire il modale con l'immagine selezionata
    // Funzione per aprire il modale con l'immagine selezionata
    function openModal(src) {
        const modal = document.getElementById('imageModal');
        document.getElementById('modalImage').src = src;
        modal.style.display = 'flex'; // Mostra il modale
        setTimeout(() => {
            modal.classList.add('show'); // Aggiunge l'animazione di apertura
        }, 10); // Delay per permettere al display:flex di essere applicato prima dell'animazione
    }

    // Funzione per chiudere il modale
    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.remove('show'); // Rimuove l'animazione di apertura
        setTimeout(() => {
            modal.style.display = 'none'; // Nasconde il modale dopo l'animazione
        }, 300); // Tempo di attesa per completare l'animazione
    }
</script>


<?php require 'components/footer.php'; ?>