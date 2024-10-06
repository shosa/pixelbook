<?php
require '../config/db.php';
require 'components/header.php';
?>

<div class="container mt-5">
    <h1 class="admin-title text-center">Dashboard Admin</h1>
    <p class="text-center">Benvenuto nella tua area di gestione. Scegli un'opzione qui sotto per iniziare.</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center mb-4 shadow-sm">
                <a href="categories.php" class="text-decoration-none text-dark">
                    <div class="card-body p-4">

                        <p class="card-text">Aggiungi, modifica o elimina le categorie delle tue gallerie.</p>
                    </div>
                    <div class="card-footer bg-primary text-white" style="border-radius: 0 0 0.35rem 0.35rem;">
                        <strong>Gestisci Categorie</strong>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center mb-4 shadow-sm">
                <a href="gallery.php" class="text-decoration-none text-dark">
                    <div class="card-body p-4">

                        <p class="card-text">Carica e gestisci le foto delle tue gallerie per le categorie.</p>
                    </div>
                    <div class="card-footer bg-success text-white" style="border-radius: 0 0 0.35rem 0.35rem;">
                        <strong>Gestisci Gallerie</strong>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center mb-4 shadow-sm">
                <a href="bookings.php" class="text-decoration-none text-dark">
                    <div class="card-body p-4">

                        <p class="card-text">Controlla e gestisci le prenotazioni dei tuoi servizi.</p>
                    </div>
                    <div class="card-footer bg-info text-white" style="border-radius: 0 0 0.35rem 0.35rem;">
                        <strong>Gestisci Prenotazioi</strong>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<?php
require '../components/footer.php';
?>