<?php
require("../../config/config.php");
include(BASE_PATH . "/components/header.php");

$pdo = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aggiungi categoria
    if (isset($_POST['add_category'])) {
        $nome = $_POST['nome'];
        $descrizione = $_POST['descrizione'];
        $price = $_POST['price'];
        $type = $_POST['type'];

        // Gestione del caricamento del file banner
        $banner = null;
        if (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {
            $banner = $_FILES['banner']['name'];
            $targetDir = '../../images/categories/';
            $targetFile = $targetDir . basename($banner);

            // Sposta il file caricato nella directory di destinazione
            if (!move_uploaded_file($_FILES['banner']['tmp_name'], $targetFile)) {
                $_SESSION["error"] = "Errore nel caricamento del file immagine.";
            }
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO categorie (nome, descrizione, banner, base_price, type) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nome, $descrizione, $banner, $price, $type]);
            $_SESSION["success"] = "Categoria aggiunta con successo!";
        } catch (PDOException $e) {
            $_SESSION["error"] = "Errore: " . $e->getMessage();
        }
    }

    // Modifica categoria

    if (isset($_POST['update_category'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $descrizione = $_POST['descrizione'];
        $price = $_POST['price'];
        $type = $_POST['type'];

        // Gestione del caricamento del file banner
        $banner = null;
        if (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {
            $banner = $_FILES['banner']['name'];
            $targetDir = '../../images/categories/';
            $targetFile = $targetDir . basename($banner);

            // Sposta il file caricato nella directory di destinazione
            if (!move_uploaded_file($_FILES['banner']['tmp_name'], $targetFile)) {
                $_SESSION["error"] = "Errore nel caricamento del file immagine.";
            }
        }

        try {
            if ($banner) {
                // Aggiornamento con nuovo banner
                $stmt = $pdo->prepare("UPDATE categorie SET nome = ?, descrizione = ?, banner = ?, base_price = ?, type = ? WHERE id = ?");
                $stmt->execute([$nome, $descrizione, $banner, $price, $type, $id]);
            } else {
                // Aggiornamento senza modificare il banner
                $stmt = $pdo->prepare("UPDATE categorie SET nome = ?, descrizione = ?, base_price = ?, type = ? WHERE id = ?");
                $stmt->execute([$nome, $descrizione, $price, $type, $id]);
            }
            $_SESSION["success"] = "Categoria aggiornata con successo!";
        } catch (PDOException $e) {
            $_SESSION["error"] = "Errore: " . $e->getMessage();
        }
    }

    // Cancella categoria
    if (isset($_POST['delete_category'])) {
        $id = $_POST['id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM categorie WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION["success"] = "Categoria eliminata con successo!";
        } catch (PDOException $e) {
            $_SESSION["error"] = "Errore: " . $e->getMessage();
        }
    }

}
?>

<div class="page-wrapper">

    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <ol class="breadcrumb" aria-label="breadcrumbs">
                        <li class="breadcrumb-item"><a href="../../index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="index">Categorie</a></li>

                    </ol>
                    <h2 class="page-title">Gestisci Categorie</h2>
                    <p class="text-muted">Aggiungi, modifica e rimuovi le categorie di servizi.</p>
                </div>
                <div class="col-auto ms-auto">
                    <button class="btn rounded-pill text-info" data-bs-toggle="modal"
                        data-bs-target="#addCategoryModal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 12h6" />
                            <path d="M12 9v6" />
                            <path d="M6 19a2 2 0 0 1 -2 -2v-4l-1 -1l1 -1v-4a2 2 0 0 1 2 -2" />
                            <path d="M18 19a2 2 0 0 0 2 -2v-4l1 -1l-1 -1v-4a2 2 0 0 0 -2 -2" />
                        </svg> Aggiungi Categoria
                    </button>
                </div>
                <?php include(BASE_PATH . "/components/alerts.php"); ?>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categorie Esistenti</h3>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Base Prezzo (AED)</th>
                                <th>Tipo</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->query("SELECT * FROM categorie");
                            $categorie = $stmt->fetchAll();
                            foreach ($categorie as $categoria): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($categoria['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($categoria['base_price']); ?></td>
                                    <td class="text-uppercase"><?php echo htmlspecialchars($categoria['type']); ?></td>
                                    <td>
                                        <a href="#" class="btn btn-icon btn-outline-primary rounded-pill "
                                            data-bs-toggle="offcanvas" data-bs-target="#editCategoryOffcanvas"
                                            onclick="loadCategoryData(<?php echo $categoria['id']; ?>)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                <path d="M13.5 6.5l4 4" />
                                            </svg>
                                        </a>
                                        <form style="display:inline;">
                                            <button type="button" onclick="confirmDelete(<?php echo $categoria['id']; ?>)"
                                                class="btn btn-icon btn-outline-danger rounded-pill">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas Modifica Categoria -->
<div class="offcanvas offcanvas-end" id="editCategoryOffcanvas" tabindex="-1"
    aria-labelledby="editCategoryOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="editCategoryOffcanvasLabel">Modifica Categoria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" id="editCategoryForm">
        <!-- Contenuto caricato dinamicamente -->
    </div>
</div>

<!-- Modal Aggiungi Categoria -->
<div class="modal modal-blur fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="index" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Aggiungi Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">AED Base</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo</label>
                        <select name="type" class="form-select" required>
                            <option value="PERSONAL">PERSONAL</option>
                            <option value="BUSINESS">BUSINESS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrizione</label>
                        <textarea name="descrizione" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Banner (Immagine)</label>
                        <input type="file" name="banner" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn rounded-pill" data-bs-dismiss="modal">Annulla</button>
                    <button type="submit" name="add_category" class="btn btn-outline-primary rounded-pill">Aggiungi
                        Categoria</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function loadCategoryData(id) {
        fetch('getCategory.php?id=' + id)
            .then(response => response.text())
            .then(data => {
                document.getElementById('editCategoryForm').innerHTML = data;
            });
    }

    function confirmDelete(categoryId) {
        // Funzionalità di eliminazione come nel codice originale...
    }
</script>

<?php include(BASE_PATH . "/components/footer.php"); ?>