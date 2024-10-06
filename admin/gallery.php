<?php
require '../config/db.php';
require 'components/header.php';

$pdo = Database::getInstance();

// Recupera tutte le categorie
$stmt = $pdo->query("SELECT * FROM categorie");
$categorie = $stmt->fetchAll();

// Gestisci il caricamento delle foto e l'eliminazione
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_photo'])) {
        $categoria_id = $_POST['categoria_id'];

        // Verifica che la categoria esista
        $stmt = $pdo->prepare("SELECT * FROM categorie WHERE id = ?");
        $stmt->execute([$categoria_id]);
        if ($stmt->rowCount() == 0) {
            echo "<p class='alert alert-danger'>Categoria non trovata!</p>";
            exit; // Esci per evitare ulteriori errori
        }

        // Verifica che ci siano file caricati
        if (!empty($_FILES['files']['name'][0])) {
            $files = $_FILES['files'];

            // Cicla attraverso i file caricati
            for ($i = 0; $i < count($files['name']); $i++) {
                $file_name = $files['name'][$i];
                $tmp_name = $files['tmp_name'][$i];

                // Sposta il file caricato nella cartella di destinazione
                if (move_uploaded_file($tmp_name, '../images/gallery/' . $file_name)) {
                    // Inserisci l'immagine nel database
                    $stmt = $pdo->prepare("INSERT INTO galleria (categoria_id, file) VALUES (?, ?)");
                    $stmt->execute([$categoria_id, $file_name]);
                }
            }

            echo "<p class='alert alert-success'>Foto aggiunte con successo!</p>";
        } else {
            echo "<p class='alert alert-danger'>Nessun file selezionato.</p>";
        }
    } elseif (isset($_POST['delete_photo'])) {
        // Elimina foto dalla galleria
        $id = $_POST['id'];
        $stmt = $pdo->prepare("SELECT file FROM galleria WHERE id = ?");
        $stmt->execute([$id]);
        $foto = $stmt->fetch();

        if ($foto) {
            // Rimuovi il file dalla cartella
            unlink('../images/gallery/' . $foto['file']);

            // Elimina il record dal database
            $stmt = $pdo->prepare("DELETE FROM galleria WHERE id = ?");
            $stmt->execute([$id]);
            echo "<p class='alert alert-success'>Foto eliminata con successo!</p>";
        } else {
            echo "<p class='alert alert-danger'>Foto non trovata.</p>";
        }
    }
}
?>
<style>
    .card-img-top {
        width: 100%;
        /* Assicura che l'immagine prenda tutta la larghezza della card */
        height: 200px;
        /* Imposta l'altezza fissa per i banner */
        object-fit: cover;
        /* Mantiene le proporzioni dell'immagine senza deformarla */
    }

    .modal-body img {
        width: 100%;
        /* Assicura che l'immagine prenda tutta la larghezza del contenitore */
        height: 200px;
        /* Imposta un'altezza fissa per le immagini della galleria */
        object-fit: cover;
        /* Mantiene le proporzioni dell'immagine senza deformarla */
    }
</style>
<div class="container">
    <h1>Galleria delle Categorie</h1>
    <p class='alert alert-info'>Premi su una categoria per modificarne la galleria</p>
    <div class="row">
        <?php foreach ($categorie as $categoria): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <a href="#" data-toggle="modal" data-target="#modal<?php echo $categoria['id']; ?>">
                        <img src="../images/categories/<?php echo htmlspecialchars($categoria['banner']); ?>"
                            class="card-img-top" alt="<?php echo htmlspecialchars($categoria['nome']); ?>">
                    </a>
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo htmlspecialchars($categoria['nome']); ?></h5>
                    </div>
                </div>

                <!-- Modale per la galleria -->
                <div class="modal fade" id="modal<?php echo $categoria['id']; ?>" tabindex="-1" role="dialog"
                    aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel"><?php echo htmlspecialchars($categoria['nome']); ?>
                                    - Galleria</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="gallery.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="categoria_id" value="<?php echo $categoria['id']; ?>">
                                    <div class="form-group">
                                        <label for="file">Aggiungi Foto</label>
                                        <input type="file" name="files[]" id="file" class="form-control-file" multiple
                                            required>
                                    </div>
                                    <button type="submit" name="add_photo" class="btn btn-success btn-block mb-5">Aggiungi
                                        Foto</button>
                                </form>
                                <div id="galleryImages<?php echo $categoria['id']; ?>" class="mb-3">
                                    <?php
                                    // Recupera le foto dalla galleria
                                    $stmt = $pdo->prepare("SELECT * FROM galleria WHERE categoria_id = ?");
                                    $stmt->execute([$categoria['id']]);
                                    $fotografie = $stmt->fetchAll();
                                    ?>
                                    <?php if (count($fotografie) > 0): ?>
                                        <div class="row">
                                            <?php foreach ($fotografie as $foto): ?>
                                                <div class="col-6">
                                                    <div class="position-relative">
                                                        <img src="../images/gallery/<?php echo htmlspecialchars($foto['file']); ?>"
                                                            class="img-fluid mb-2"
                                                            alt="<?php echo htmlspecialchars($foto['file']); ?>">
                                                        <form action="gallery.php" method="post"
                                                            style="position: absolute; top: 0; right: 0;">
                                                            <input type="hidden" name="id" value="<?php echo $foto['id']; ?>">
                                                            <button type="submit" name="delete_photo" class="btn btn-danger btn-sm"
                                                                title="Elimina Foto"><i class="fas fa-trash-alt"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <p>Nessuna foto disponibile.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- Includi jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Includi Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<?php require '../components/footer.php'; ?>