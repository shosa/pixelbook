<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <title>Pixiod</title>
    <link rel="stylesheet" href="components/style.css?v=<?php echo time(); ?>">

    <!-- Font Awesome & Google Fonts -->
    <link href="vendor/fortawesome/font-awesome/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>

<style>
    /* Forza la larghezza al 100% senza zoomare */
    html,
    body {
        width: 100% !important;
        overflow-x: hidden !important;
        /* Evita lo scroll orizzontale */
        margin: 0 !important;
        padding: 0 !important;
        -webkit-text-size-adjust: 100% !important;
        /* Per evitare che il testo venga ridimensionato automaticamente su dispositivi iOS */
    }

    /* Impostazione predefinita per il pulsante */
    .navbar .btn {
        position: relative;
        margin-left: auto;
    }

    /* Stile per mobile */
    @media (max-width: 767px) {
        .mobile-booknow-container {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f1f1f1;
            padding: 3%;
            text-align: center;
            z-index: 1000;
            box-shadow: 0px -5px 21px 7px rgba(0, 0, 0, 0.26);
        }

        .mobile-booknow-container .btn {
            width: calc(100% - 40px);
            margin: 0 auto;
            border-radius: 0;
        }

        /* Centra il logo nella navbar su mobile */
        .navbar-center-logo {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        body {
            font-size: 14px !important;
            /* Impostazione del font di default per mobile */
        }
    }

    /* Forzare il layout fluido su dispositivi mobili */
    @media (max-width: 767px) {
        .navbar {
            width: 100% !important;

        }
    }
</style>

<body class="mt-2 d-flex flex-column min-vh-100">
    <!-- Header with dropdown and Book Now button -->

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm bg-gradient-custom">
        <a class="navbar-brand font-weight-bold text-white <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'navbar-center-logo' : ''; ?>"
            href="<?php echo BASE_URL; ?>">
            <img src="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? BASE_URL . '/src/img/logo.png' : BASE_URL . '/src/img/logoOne.png'; ?>"
                alt="Pixiod Logo" style="height: 40px;">
        </a>

        <!-- Book Now Button in Navbar (solo su desktop) -->
        <?php if (basename($_SERVER['PHP_SELF']) == 'index.php'): ?>
            <a href="book" class="btn btn-light font-weight-bold rounded-pill shadow-sm ml-auto d-none d-lg-inline">
                Book Now
            </a>
        <?php endif; ?>

        <!-- Icona Home (visibile solo se non siamo su index) -->
        <?php if (basename($_SERVER['PHP_SELF']) != 'index.php'): ?>
            <a href="index" class="ml-auto btn-light btn-circle">
                <i class="fal fa-home text-dark"></i> <!-- Icona Home -->
            </a>
        <?php endif; ?>
    </nav>

    <!-- Book Now Button (visibile solo su mobile) -->
    <?php if (basename($_SERVER['PHP_SELF']) == 'index.php'): ?>
        <div class="mobile-booknow-container d-lg-none">
            <a href="book.php" class="btn btn-gradient-custom font-weight-bold rounded-pill shadow-sm">Book Now</a>
        </div>
    <?php endif; ?>