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

    .parallax-container {
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px 0;
        /* Definisce una minima altezza verticale */
        width: 100%;
        min-height: 300px;
        /* Altezza minima per garantire visibilità su schermi più piccoli */
    }

    .parallax-item {
        position: absolute;
        will-change: transform;
        transition: transform 0.1s;
        max-width: 100%;
        height: auto;
    }

    .phone-image {
        position: relative;
        /* Posizionato in modo relativo per influire sull'altezza del container */
        z-index: 1;
        width: 90%;
        max-width: 100%;
    }

    .elements-inside {
        z-index: 2;
        width: 90%;
        max-width: 100%;
    }

    .elements-inside2 {
        z-index: 3;
        width: 90%;
        max-width: 100%;
    }

    @media (max-width: 767px) {

        .phone-image,
        .elements-inside,
        .elements-inside2 {
            width: 120%;
        }
    }
</style>

<header class="bg-white py-4 mt-5">
    <div class="container-fluid text-center pr-0 pl-0 mt-2">
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
    </div>
</header>

<div class="custom-container w-100">
    <div class="row text-center bg-gradient-custom">
        <div class="col-md-6 text-left d-flex align-items-center">
            <div class="container p-4 ml-5">
                <span class="h1 text-white font-weight-bold ">Book Photography and Video Services in Just One
                    Click</span>
                <br><br><i class="font-weight-normal">PIXIOD is the platform that makes booking photography and video
                    services easy. Everything you
                    need,
                    in
                    one link.
                    Choose, book, and pay online. Your photography and video services, at your fingertips.</i>
                <br><br>
                <a class="btn btn-light  rounded-pill font-weight-bold" style="background-color:white !important "
                    href="book">Find Out
                    More <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row parallax-container">
                <img src="2.png" class="parallax-item phone-image" alt="Phone Screen">
                <img src="3.png" class="parallax-item elements-inside" alt="Elements Inside">
                <img src="4.png" class="parallax-item elements-inside2" alt="Elements Inside">
            </div>
        </div>
    </div>
</div>
<div class="custom-container">
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
<div class="container-fluid my-4">
    <div class="row align-items-center text-center">
        <div class="col-md-4 bg-light p-4 text-right">
            <h4 class="font-weight-bold">Exclusive Service, Tailored Creativity!</h4>
            <p class="mt-3">
                We work only with the best professionals in the industry to ensure impeccable results.
                Every shot and every recording are designed to exceed your expectations and turn every idea into a
                visual masterpiece.
            </p>
        </div>
        <div class="col-md-8">
            <?php include("elements/home_carousel_personal.php"); ?>
        </div>
    </div>
</div>

<div class="container-fluid my-4">
    <div class="row align-items-center text-center">

        <div class="col-md-8">
            <?php include("elements/home_carousel_business.php"); ?>
        </div>
        <div class="col-md-4 bg-light p-4 text-left">
            <h4 class="font-weight-bold">Simplified Booking for Every Occasion</h4>
            <p class="mt-3">
                Whether you need a photographer or a videographer, select the category that best represents your style
                or needs. Book in just a few clicks and bring your ideas to life!
            </p>
        </div>
    </div>
</div>
<section class="container-fluid mt-4"></section>
<?php include("elements/faq.php"); ?>
<?php require 'components/footer.php'; ?>

<script>
    // Parallax effect on scroll
    document.addEventListener("scroll", () => {
        const parallaxContainer = document.querySelector(".parallax-container");
        const phoneImage = document.querySelector(".phone-image");
        const elementsInside = document.querySelector(".elements-inside");
        const elementsInside2 = document.querySelector(".elements-inside2");

        // Calcola la distanza dell'elemento dal top della pagina e l'altezza del contenitore
        const containerRect = parallaxContainer.getBoundingClientRect();
        const containerTop = containerRect.top;
        const containerHeight = containerRect.height;
        const windowHeight = window.innerHeight;

        // Verifica che il contenitore sia visibile nel viewport
        if (containerTop < windowHeight && containerTop > -containerHeight) {
            // Calcola la percentuale di scroll rispetto alla posizione del contenitore
            const scrollRatio = (windowHeight - containerTop) / (windowHeight + containerHeight);

            // Applica la trasformazione in base alla percentuale di scroll
            phoneImage.style.transform = `translateX(${scrollRatio * 20}px)`; // Modifica la velocità dell'effetto
            elementsInside.style.transform = `translateX(-${scrollRatio * 40}px)`; // Modifica la velocità dell'effetto
            elementsInside2.style.transform = `translateX(-${scrollRatio * 40}px)`;

        }
    });
</script>