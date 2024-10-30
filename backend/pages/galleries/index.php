<?php
require("../../config/config.php");
include(BASE_PATH . "/components/header.php");

$pdo = Database::getInstance();
$stmt = $pdo->query("SELECT * FROM categorie");
$categorie = $stmt->fetchAll();

// Dashboard statistica
$totalCategories = count($categorie);
$stmt = $pdo->query("SELECT COUNT(*) as totalPhotos FROM galleria");
$totalPhotos = $stmt->fetch()['totalPhotos'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_photo'])) {
        $categoria_id = $_POST['categoria_id'];

        // Verifica che la categoria esista
        $stmt = $pdo->prepare("SELECT * FROM categorie WHERE id = ?");
        $stmt->execute([$categoria_id]);
        if ($stmt->rowCount() == 0) {
            $_SESSION["danger"] = "Categoria non trovata!";
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
                if (move_uploaded_file($tmp_name, '../../../images/gallery/' . $file_name)) {
                    // Inserisci l'immagine nel database
                    $stmt = $pdo->prepare("INSERT INTO galleria (categoria_id, file) VALUES (?, ?)");
                    $stmt->execute([$categoria_id, $file_name]);
                }
            }

            $_SESSION["success"] = "Foto aggiunte con successo!";
        } else {
            $_SESSION["danger"] = "Nessuna foto selezionata!";
        }
    } elseif (isset($_POST['delete_photo'])) {
        // Elimina foto dalla galleria
        $id = $_POST['id'];
        $stmt = $pdo->prepare("SELECT file FROM galleria WHERE id = ?");
        $stmt->execute([$id]);
        $foto = $stmt->fetch();

        if ($foto) {
            // Rimuovi il file dalla cartella
            unlink('../../../images/gallery/' . $foto['file']);

            // Elimina il record dal database
            $stmt = $pdo->prepare("DELETE FROM galleria WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION["success"] = "Foto eliminata con successo!";
        } else {
            $_SESSION["warning"] = "Foto non trovata!";
        }
    }
}
?>

<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Gestione Galleria</h2>
                    <p class="text-muted">Visualizza, gestisci e aggiungi foto alle categorie.</p>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddPhoto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo-plus"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 8h.01" />
                                <path d="M12 20h-7a2 2 0 0 1 -2 -2v-7a2 2 0 0 1 2 -2h6l2 -2h5a2 2 0 0 1 2 2v3" />
                                <path d="M16 19h6" />
                                <path d="M19 16v6" />
                            </svg>
                            Aggiungi Nuova Foto
                        </button>
                    </div>
                </div>
                <?php include(BASE_PATH . "/components/alerts.php"); ?>
            </div>
        </div>
    </div>

    <!-- Dashboard Statistica -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $totalCategories; ?></h3>
                            <p class="text-muted">Categorie Totali</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $totalPhotos; ?></h3>
                            <p class="text-muted">Foto Totali</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visualizzazione delle Categorie -->
            <div class="row mt-4">
                <?php foreach ($categorie as $categoria): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <a href="#" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasGallery<?php echo $categoria['id']; ?>">
                                <img src="../../../images/categories/<?php echo htmlspecialchars($categoria['banner']); ?>"
                                    style="height:200px;object-fit: cover;" class="card-img-top"
                                    alt="<?php echo htmlspecialchars($categoria['nome']); ?>">
                            </a>
                            <div class="card-body text-center">
                                <h5 class="card-title mt-3"><?php echo htmlspecialchars($categoria['nome']); ?></h5>
                                <div class="btn-list mt-2">
                                    <button
                                        class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center"
                                        data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasGallery<?php echo $categoria['id']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-photo me-2" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" style="width: 24px; height: 24px;">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 7m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                            <path d="M17 16m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                            <path d="M7 16m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        </svg>
                                        Gestisci Galleria
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Offcanvas per Galleria -->
                    <div class="offcanvas offcanvas-end" id="offcanvasGallery<?php echo $categoria['id']; ?>">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title">Galleria - <?php echo htmlspecialchars($categoria['nome']); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div class="row">
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM galleria WHERE categoria_id = ?");
                                $stmt->execute([$categoria['id']]);
                                $fotografie = $stmt->fetchAll();
                                ?>
                                <?php if (count($fotografie) > 0): ?>
                                    <?php foreach ($fotografie as $foto): ?>
                                        <div class="col-6 mb-3 position-relative">
                                            <img src="../../../images/gallery/<?php echo htmlspecialchars($foto['file']); ?>"
                                                class="card-img-top">
                                            <form action="" method="post" class="position-absolute top-0 end-0">
                                                <input type="hidden" name="id" value="<?php echo $foto['id']; ?>">
                                                <button type="submit" name="delete_photo" class="btn btn-icon btn-danger btn-sm"
                                                    title="Elimina Foto">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-trash" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7h16" />
                                                        <path d="M10 11v6" />
                                                        <path d="M14 11v6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-2a2 2 0 1 1 4 0v2" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">Nessuna foto presente.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas per Aggiungere Foto -->
<div class="offcanvas offcanvas-end" id="offcanvasAddPhoto">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Aggiungi Foto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="categoriaSelect" class="form-label">Seleziona Categoria</label>
                <select name="categoria_id" id="categoriaSelect" class="form-select">
                    <?php foreach ($categorie as $categoria): ?>
                        <option value="<?php echo $categoria['id']; ?>"><?php echo htmlspecialchars($categoria['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Seleziona Foto</label>
                <input type="file" name="files[]" class="form-control" multiple>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" name="add_photo" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                        <polyline points="7 9 12 4 17 9" />
                        <line x1="12" y1="4" x2="12" y2="16" />
                    </svg>
                    Carica Foto
                </button>
            </div>
        </form>
    </div>
</div>

<?php include(BASE_PATH . "/components/footer.php"); ?>