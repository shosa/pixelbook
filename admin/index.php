<?php
require '../config/db.php';
require 'components/header.php';

echo "<h1 class='admin-title'>Dashboard Admin</h1>";
echo "<a href='categories.php' class='btn btn-primary'>Gestisci Categorie</a><br>";
echo "<a href='gallery.php' class='btn btn-primary'>Gestisci Gallerie</a><br>";
echo "<a href='bookings.php' class='btn btn-primary'>Gestisci Prenotazioni</a>";

require '../components/footer.php';
