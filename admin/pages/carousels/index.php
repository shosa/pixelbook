<?php
ob_start(); // Inizia il buffer di output
require("../../config/config.php");
include(BASE_PATH . "/components/header.php");

$pdo = Database::getInstance();

// Funzione per gestire l'eliminazione dei carousel
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM home_carousel WHERE id = ?");
        $stmt->execute([$deleteId]);
        $_SESSION["success"] = "Carousel eliminato con successo.";
    } catch (Exception $e) {
        $_SESSION["danger"] = "Errore durante l'eliminazione: " . $e->getMessage();
    }
    header("Location: index");
    exit();
}

// Gestione del form POST (creazione o aggiornamento)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $foto_blur = $_POST['foto_blur'];
    $foto = $_POST['foto'];
    $tipo = $_POST['tipo'];

    try {
        if (isset($_POST['id']) && $_POST['id'] !== '') {
            $id = $_POST['id'];
            $sqlUpdate = "UPDATE home_carousel SET nome = ?, foto_blur = ?, foto = ?, tipo = ? WHERE id = ?";
            $stmt = $pdo->prepare($sqlUpdate);
            $stmt->execute([$nome, $foto_blur, $foto,  $tipo, $id]);
            $_SESSION["success"] = "Carousel aggiornato con successo.";
        } else {
            $sqlInsert = "INSERT INTO home_carousel (nome, foto_blur, foto, tipo) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sqlInsert);
            $stmt->execute([$nome, $foto_blur, $foto, $tipo]);
            $_SESSION["success"] = "Nuovo carousel aggiunto con successo.";
        }
    } catch (Exception $e) {
        $_SESSION["danger"] = "Errore durante il salvataggio: " . $e->getMessage();
    }

    header("Location: index");
    exit();
}

// Recupera tutte le voci della tabella `home_carousel`
$queryCarousel = $pdo->query("SELECT * FROM home_carousel");
$carouselItems = $queryCarousel->fetchAll(PDO::FETCH_ASSOC);

// Query per ottenere le immagini della galleria
$queryGalleria = $pdo->query("SELECT * FROM galleria");
$galleriaItems = $queryGalleria->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="page-wrapper">
    <!-- Visualizzazione dei messaggi di errore/successo -->
   

    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Gestisci Carousel</h2>
                    <p class="text-muted">Aggiungi, modifica ed elimina i carousel della homepage.</p>
                </div>
                <div class="col-auto ms-auto">
                    <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCarousel" onclick="resetForm()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg>
                        Aggiungi Nuovo Carousel
                    </button>
                </div>
            </div>
            <?php include(BASE_PATH . "/components/alerts.php"); ?>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista Carousel</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Tipo</th>
                                <th>Foto Banner</th>
                                <th>Foto Normale</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($carouselItems as $item): ?>
                                <tr>
                                    <td><?php echo $item['id']; ?></td>
                                    <td><?php echo htmlspecialchars($item['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($item['tipo']); ?></td>
                                    <td><img src="../../../<?php echo htmlspecialchars($item['foto_blur']); ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;"></td>
                                    <td><img src="../../../<?php echo htmlspecialchars($item['foto']); ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;"></td>
                                    <td>
                                        <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCarousel" onclick="editCarousel(<?php echo $item['id']; ?>)">
                                            Modifica
                                        </a>
                                        <a href="index?delete_id=<?php echo $item['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questa voce?');">
                                            Elimina
                                        </a>
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

<!-- Offcanvas per Aggiungere/Modificare Carousel -->
<div class="offcanvas offcanvas-end" id="offcanvasCarousel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Gestione Carousel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" action="index">
            <input type="hidden" name="id" id="carouselId">
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" id="carouselNome" required>
            </div>
           
            <div class="mb-3">
                <label class="form-label">Tipo</label>
                <select name="tipo" class="form-select" id="carouselTipo">
                    <option value="BUSINESS">BUSINESS</option>
                    <option value="PERSONAL">PERSONAL</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Foto Banner</label>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="setImageField('carouselFotoBlur', 'selectedBlurPreview')">Scegli dalla Galleria</button>
                    <div id="selectedBlurPreview"></div>
                    <input type="hidden" name="foto_blur" id="carouselFotoBlur">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Foto Normale</label>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="setImageField('carouselFoto', 'selectedFotoPreview')">Scegli dalla Galleria</button>
                    <div id="selectedFotoPreview"></div>
                    <input type="hidden" name="foto" id="carouselFoto">
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Salva</button>
        </form>
    </div>
</div>

<div class="modal modal-blur fade" id="galleryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleziona Foto dalla Galleria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="galleryAccordion">
                    <?php
                    // Recupera le categorie con le immagini associate
                    $categoriesQuery = $pdo->query("SELECT * FROM categorie");
                    $categories = $categoriesQuery->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($categories as $category):
                        $categoryId = $category['id'];
                        $categoryName = htmlspecialchars($category['nome']);
                        $imagesQuery = $pdo->prepare("SELECT * FROM galleria WHERE categoria_id = ?");
                        $imagesQuery->execute([$categoryId]);
                        $images = $imagesQuery->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-<?php echo $categoryId; ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $categoryId; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $categoryId; ?>">
                                    <?php echo $categoryName; ?>
                                </button>
                            </h2>
                            <div id="collapse-<?php echo $categoryId; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $categoryId; ?>" data-bs-parent="#galleryAccordion">
                                <div class="accordion-body">
                                    <div class="row g-2 g-md-3">
                                        <?php foreach ($images as $image): ?>
                                            <div class="col-6 col-md-4 col-lg-3">
                                                <a data-fslightbox="gallery" onclick="selectImage('<?php echo $image['file']; ?>')">
                                                    <div class="img-responsive img-responsive-1x1 " style="background-image: url('../../../images/gallery/<?php echo $image['file']; ?>');"></div>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    let selectedImageField = '';
    let previewContainer = '';

    function setImageField(field, preview) {
        selectedImageField = field;
        previewContainer = preview;
    }

    function resetForm() {
        document.getElementById('carouselId').value = '';
        document.getElementById('carouselNome').value = '';
    
        document.getElementById('carouselTipo').value = 'BUSINESS';
        document.getElementById('carouselFotoBlur').value = '';
        document.getElementById('carouselFoto').value = '';
        document.getElementById('selectedBlurPreview').innerHTML = '';
        document.getElementById('selectedFotoPreview').innerHTML = '';
    }

    function selectImage(filename) {
        const imagePath = `images/gallery/${filename}`;
        document.getElementById(selectedImageField).value = imagePath;
        document.getElementById(previewContainer).innerHTML = `
            <img src="../../../${imagePath}" class="img-thumbnail me-2" style="width: 40px; height: 40px; object-fit: cover;">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" viewBox="0 0 24 24" width="24" height="24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M5 12l5 5l10 -10" />
            </svg>`;
        const modal = bootstrap.Modal.getInstance(document.getElementById('galleryModal'));
        modal.hide();
    }

    function editCarousel(id) {
        fetch(`getCarousel.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('carouselId').value = data.id;
                document.getElementById('carouselNome').value = data.nome;
                
                document.getElementById('carouselTipo').value = data.tipo;
                document.getElementById('carouselFotoBlur').value = data.foto_blur;
                document.getElementById('carouselFoto').value = data.foto;
                if (data.foto_blur) {
                    document.getElementById('selectedBlurPreview').innerHTML = `
                        <img src="../../../${data.foto_blur}" class="img-thumbnail me-2" style="width: 40px; height: 40px; object-fit: cover;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" viewBox="0 0 24 24" width="24" height="24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 12l5 5l10 -10" />
                        </svg>`;
                }
                if (data.foto) {
                    document.getElementById('selectedFotoPreview').innerHTML = `
                        <img src="../../../${data.foto}" class="img-thumbnail me-2" style="width: 40px; height: 40px; object-fit: cover;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" viewBox="0 0 24 24" width="24" height="24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 12l5 5l10 -10" />
                        </svg>`;
                }
            });
    }
</script>

<?php include(BASE_PATH . "/components/footer.php"); ?>
