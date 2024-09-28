<?php include("vendor/autoload.php"); ?>
<!DOCTYPE html>
<lang="it">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PixelBook</title>
        <link rel="stylesheet" href="components/style.css">
        <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="vendor/fortawesome/font-awesome/css/all.min.css" rel="stylesheet">
    </head>


    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light m-2">
            <a class="navbar-brand" href="#">
                <img src="images/sites/logo.png" alt="PixelBook Logo" style="height: 40px;">
                <span class="text-indigo font-weight-bold">Pixel</span>Book
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">Categorie</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="bookings.php">Prenotazioni</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Altro
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Opzione 1</a></li>
                            <li><a class="dropdown-item" href="#">Opzione 2</a></li>
                            <li><a class="dropdown-item" href="#">Opzione 3</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>