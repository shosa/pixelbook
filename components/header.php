<?php include("vendor/autoload.php"); ?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PixelShoot</title>
    <link rel="stylesheet" href="components/style.css?v=<?php echo time(); ?>">

    <link href="vendor/fortawesome/font-awesome/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- Swiper JS -->
  

</head>


<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3 p-2 shadow-sm" style="width: 100%;">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <span class="text-gradient-custom font-weight-bold">Pixel</span>Shoot
        </a>
        <div class="ml-auto nav-home-icon">
            <a class="h4 btn bg-transparent text-dark d-flex align-items-center" href="./">
                <i class="fal fa-home" style="font-size: 1.5rem; margin-top: 0.1rem;"></i>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbarNav"></div>
    </nav>