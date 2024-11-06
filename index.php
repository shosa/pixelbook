<?php
require 'config/db.php';
require 'components/header.php';
$pdo = Database::getInstance();
// Function to get random images from the folder
$images = glob('images/gallery/*.{jpg,png,jpeg}', GLOB_BRACE);
shuffle($images); // Shuffle images in random order
$selected_images = array_slice($images, 0, 20); // Select only the first 20 images
?>
<style>
    .image-grid {
        overflow-x: hidden;
    }

    .image-row {
        display: flex;
        animation: scrollImages 50s linear infinite;
        width: 150%;
    }

    .image-item {
        padding: 0.5rem;
        flex: 0 0 75%;
    }

    .image-item img {
        object-fit: cover;
        aspect-ratio: 1 / 1;
        width: 100%;
        height: auto;
    }

    /* Image scrolling animation */
    @keyframes scrollImages {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .offset-row {
        animation: scrollImages 40s linear infinite reverse;
    }

    /* Container width adjustment */
    .custom-container {
        width: 100%;
        padding: 0;
    }

    /* Adjust to 60% width on larger screens */
    @media (min-width: 1025px) {
        .custom-container {
            width: 60%;
            margin: 0 auto;
        }
    }

    /* Responsive adjustments */
    @media (min-width: 320px) {
        .image-item {
            flex: 0 0 30%;
        }
    }

    @media (min-width: 481px) {
        .image-item {
            flex: 0 0 20%;
        }
    }

    @media (min-width: 641px) {
        .image-item {
            flex: 0 0 20%;
        }
    }

    @media (min-width: 961px) {
        .image-item {
            flex: 0 0 20%;
        }
    }

    @media (min-width: 1025px) {
        .image-item {
            flex: 0 0 20%;
        }
    }

    @media (min-width: 1281px) {
        .image-item {
            flex: 0 0 10%;
        }
    }
</style>

<header class="bg-white py-4">
    <div class="container-fluid text-center">
        <h1 class="font-weight-bold"><span class="text-gradient-custom">Book The Best</span>
            Photographers & Videographers in <span class="text-gradient-custom">Dubai</span>
        </h1>
        <div class="image-grid mt-2">
            <div class="image-row">
                <?php foreach (array_slice($selected_images, 0, 10) as $image): ?>
                    <div class="image-item">
                        <img class="img-fluid" src="<?= $image ?>" alt="Gallery Image">
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="image-row offset-row mt-2">
                <?php foreach (array_slice($selected_images, 10, 10) as $image): ?>
                    <div class="image-item">
                        <img class="img-fluid" src="<?= $image ?>" alt="Gallery Image">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <a class="btn btn-gradient-custom btn-xl text-uppercase mt-3 floating-button" href="book">Book Now</a>
    </div>
</header>

<div class="custom-container">
    <div class="row text-center">
        <!-- First column -->
        <div class="col-md-4">
            <div class="p-2">
                <img class="img-fluid w-100" src="2.png" alt="Image 2">
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-2">
                <img class="img-fluid w-50" src="1.png" alt="Image 1">
            </div>
        </div>
        <!-- Second column -->
        <div class="col-md-4">
            <div class="p-2">
                <img class="img-fluid w-100" src="3.png" alt="Image 3">
            </div>
        </div>
    </div>
    <hr>
    <div class="row text-center">
        <div class="col-md-6">
            <?php include("elements/trusted_by.php"); ?>
        </div>
        <div class="col-md-6">
            <?php include("elements/reviews.php"); ?>
        </div>
    </div>
    <hr>

</div>
<div class="container-fluid">
    <div class="row text-center">
        <div class="col-md-4"> </div>
        <div class="col-md-4">
            <?php include("elements/home_carousel.php"); ?>
        </div>
        <div class="col-md-4"> </div>
    </div>
</div>
<section class="container-fluid mt-4"></section>
<?php require 'components/footer.php'; ?>