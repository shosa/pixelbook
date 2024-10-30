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
    .masthead {
        background-color: #fff;
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    .image-grid {
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .image-row {
        display: flex;
        animation: scrollImages 20s linear infinite;
        will-change: transform;
        /* Performance optimization */
    }

    .image-item {
        flex: 0 0 40%;
        /* Keep 5 images per row */
        box-sizing: border-box;
        margin-right: 1rem;
    }

    .image-item img {
        width: 100%;
        height: auto;
        /* Maintain correct proportions */
        object-fit: cover;
        /* Cover the available area */
        aspect-ratio: 1 / 1;
        /* Aspect ratio 1:1 */
    }

    /* Image scrolling animation */
    @keyframes scrollImages {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
            /* Move half of the total width */
        }
    }

    /* Second offset row */
    .offset-row {
        margin-top: 1rem;
        /* Slightly overlap the two rows */
        animation: scrollImages 22s linear infinite reverse;
        /* Offset and reverse animation */
    }
</style>

<header class="masthead">
    <div class="container p-0 text-center">
        <span class="h1 p-1 font-weight-bold"><span class="text-gradient-custom">Book The Best</span>
            Photographers & Videographers in<span class="text-gradient-custom"> Dubai</span>
        </span>
        <div class="image-grid mt-2">
            <div class="image-row">
                <?php foreach (array_slice($selected_images, 0, 10) as $image): ?>
                    <div class="image-item">
                        <img src="<?= $image ?>" alt="Gallery Image">
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="image-row offset-row">
                <?php foreach (array_slice($selected_images, 10, 10) as $image): ?>
                    <div class="image-item">
                        <img src="<?= $image ?>" alt="Gallery Image">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <a class="btn btn-gradient-custom btn-xl text-uppercase btnBlur mt-3 floating-button" href="book">Book Now</a>
    </div>
</header>
<div class="container text-center">
    <img class="w-100" src="2.png">


</div>
<?php // include("elements/why_choose_us.php"); ?>
<?php include("elements/reviews.php"); ?>

<div class="container text-center">
   
    <img class="w-100" src="3.png">

</div>
<?php include("elements/home_carousel.php"); ?>
<?php include("elements/trusted_by.php"); ?>
<div class="container text-center">
    <img class="w-50" src="1.png">
   

</div>


<section class="container mt-4"></section>
<?php require 'components/footer.php'; ?>