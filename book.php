<?php
require 'config/db.php';
require 'components/header.php';

// Recupera le categorie dal database
$pdo = Database::getInstance();
$stmt = $pdo->query("SELECT * FROM categorie");
$categorie = $stmt->fetchAll();
?>
<style>
/* Stile per i banner delle categorie */
.category-link {
    text-decoration: none;
    display: block;
    transition: transform 0.3s ease;
}

.category-link:hover {
    transform: scale(1.05);
}

.category-banner {
    position: relative;
    background-size: cover;
    background-position: center;
    border-radius: 5px;
    overflow: hidden;
    height: 220px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    transition: box-shadow 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.category-link:hover .category-banner {
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

.category-title {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: 0; /* Rimuovi padding e margini */
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.2); /* Sfondo scuro più evidente */
    color: white;
    font-size: 1.5rem;
    font-weight: 500;
    text-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
    text-align: center;
    z-index: 1; /* Assicurarsi che il testo sia sopra lo sfondo */
}

/* Media queries per migliorare il layout su dispositivi mobili */
@media (max-width: 768px) {
    .category-banner {
        height: 180px;
    }

    h1 {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .category-banner {
        height: 150px;
    }

}
</style>
<div class="container">
    <h6 class="h2 text-center font-weight-bold text-dark">Book the <span class="h1 text-success font-weight-bold">
            Best</span></h6>
    <h6 class=" h3 text-center font-weight-bold text-dark">in <span class="h1 text-success font-weight-bold">3</span>
        simple
        steps.</h6>
    <div class="row">
        <?php foreach ($categorie as $categoria): ?>
            <div class="col-6 col-md-3 mb-4">
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