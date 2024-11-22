<?php
require 'config/db.php';
require 'components/header.php';

// Recupera le categorie dal database
$pdo = Database::getInstance();
$stmt = $pdo->query("SELECT * FROM categorie");
$categorie = $stmt->fetchAll();
?>

<style>
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
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.2);
        color: white;
        font-size: 1.5rem;
        font-weight: 500;
        text-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
        text-align: center;
        z-index: 1;
    }

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

    .filter-toggle {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px 0;
    }

    .filter-button-group {
        display: flex;
        background-color: #f1f1f1;
        border-radius: 50px;
        padding: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .filter-button {
        padding: 10px 20px;
        border: none;
        background-color: transparent;
        font-size: 1rem;
        cursor: pointer;
        outline: none;
        border-radius: 50px;
        transition: background-color 0.3s ease, color 0.3s ease;
        color: #333;
    }

    .filter-button.active {
        background-color: #000;
        color: #fff;
    }

    .filter-button-group .filter-button:not(.active):hover {
        background-color: #eaeaea;
    }

    .category-item {
        opacity: 1; /* Lasciamo che Isotope gestisca la transizione */
        transform: scale(1);
    }
</style>

<div class="container mt-5">
    <h6 class="h2 text-center font-weight-bold text-dark" style="font-size:2.5rem">Book the <span
            class="text-gradient-custom font-weight-bold">Best</span></h6>
    <h6 class=" h3 text-center font-weight-bold text-dark mb-2" style="font-size:2.5rem">in <span
            class="text-gradient-custom font-weight-bold">3</span> simple steps.</h6>

    <div class="filter-toggle">
        <div class="filter-button-group">
            <button class="filter-button active" onclick="filterCategories('ALL')">All</button>
            <button class="filter-button" onclick="filterCategories('PERSONAL')">Personal</button>
            <button class="filter-button" onclick="filterCategories('BUSINESS')">Business</button>
        </div>
    </div>

    <div class="row mt-" id="category-list">
        <?php foreach ($categorie as $categoria): ?>
            <div class="col-6 col-md-3 mb-2 mt-2 category-item" data-type="<?php echo $categoria['type']; ?>">
                <a href="category?id=<?php echo $categoria['id']; ?>" class="category-link">
                    <div class="category-banner"
                        style="background-image: url('images/categories/<?php echo $categoria['banner']; ?>');">
                        <h2 class="category-title"><?php echo $categoria['nome']; ?></h2>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

<script>
    // Inizializza Isotope per il layout e il filtraggio
    var iso = new Isotope('#category-list', {
        itemSelector: '.category-item',
        layoutMode: 'fitRows',
        transitionDuration: '0.5s' // Durata dell'animazione di transizione
    });

    // Funzione di filtraggio
    window.filterCategories = function(type) {
        var filterValue = type === 'ALL' ? '*' : '[data-type="' + type + '"]';
        
        // Filtra gli elementi usando Isotope
        iso.arrange({ filter: filterValue });

        // Aggiorna i pulsanti attivi
        document.querySelectorAll('.filter-button').forEach(function(button) {
            button.classList.remove('active');
        });
        document.querySelector('.filter-button[onclick="filterCategories(\'' + type + '\')"]').classList.add('active');
    };
</script>

<?php require 'components/footer.php'; ?>
