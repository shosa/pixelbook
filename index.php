<?php
require 'config/db.php';
require 'components/header.php';

// Recupera le categorie dal database
$pdo = Database::getInstance();
$stmt = $pdo->query("SELECT * FROM categorie");
$categorie = $stmt->fetchAll();
?>
<style>
    /* styles.css */
</style>
<div class="container">
    <h6 class="h2 text-center font-weight-bold text-dark">Book the <span class="h1 text-indigo font-weight-bold">
            Best</span></h6>
    <h6 class=" h3 text-center font-weight-bold text-dark">in <span class="h1 text-indigo font-weight-bold">3</span>
        simple
        steps.</h6>
    <div class="row ">
        <?php foreach ($categorie as $categoria): ?>
            <div class="col-md-4 mb-4">
                <a href="category.php?id=<?php echo $categoria['id']; ?>" class="category-link">
                    <div class="category-banner"
                        style="background-image: url('images/categories/<?php echo $categoria['banner']; ?>');">
                        <h2 class="category-title"><?php echo $categoria['nome']; ?></h2>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require 'components/footer.php'; ?>