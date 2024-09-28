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

    /* Stile di base */
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        background-color: #f8f8f8;
        color: #333;
    }

    .container {
        padding: 20px;
    }

    /* Stile per i banner delle categorie */
    .category-link {
        text-decoration: none;
        display: block;
    }

    .category-banner {
        position: relative;
        background-size: cover;
        background-position: center;
        border-radius: 12px;
        overflow: hidden;
        height: 200px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .category-title {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        text-align: center;
        padding: 10px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        font-size: 1.5em;
    }
</style>
<div class="container">
    <h1 class="text-center font-weight-bold text-indigo">Book the Best</h1>
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