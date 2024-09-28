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

<div class="container">
    <h1 class="text-center my-5"><?php echo htmlspecialchars($categoria['nome']); ?></h1>

    <?php if ($fotografie): ?>
        <div class="row">
            <?php foreach ($fotografie as $foto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="images/gallery/<?php echo htmlspecialchars($foto['file']); ?>" class="card-img-top"
                            alt="<?php echo htmlspecialchars($foto['descrizione']); ?>">
                        <div class="card-body">
                            <p class="card-text"><?php echo htmlspecialchars($foto['descrizione']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Non ci sono foto per questa categoria.</p>
    <?php endif; ?>
</div>

<?php require 'components/footer.php'; ?>