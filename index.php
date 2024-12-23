<?php
require 'config/db.php';
require 'components/header.php';
$pdo = Database::getInstance();
// Function to get random images from the folder
$images = glob('images/gallery/*.{jpg,png,jpeg}', GLOB_BRACE);
shuffle($images); // Shuffle images in random order
$selected_images = array_slice($images, 0, 30); // Select only the first 20 images
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
        animation: scrollImages 60s linear infinite reverse;
       
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

    @media (max-width: 767px) {
        .didascaliasx {
            margin-right: 0.75rem !important;
        }

        .didascaliadx {
            margin-left: 0.75rem !important;
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
                <?php foreach (array_slice($selected_images, 10, 20) as $image): ?>
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
        <div class="col-md-1"> </div>
        <div class="col-md-5 text-left d-flex align-items-center ">
            <div class="container p-4 ml-5">
                <span class="h1 text-white font-weight-bold ">Book Photography and Video Services in Just One
                    Click</span>
                <br><br><i class="font-weight-normal">PIXIOD is the platform that makes booking photography and video
                    services easy. Everything you
                    need,
                    in
                    one link.
                    Choose and book. Your photography and video services, at your fingertips.</i>
                <br><br>
                <a class="btn  rounded-pill font-weight-bold btn-gradient-custom-yellow text-dark"
                    style="background-color:white !important " href="book">Find Out
                    More <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
        <style>
            /*    @media (max-width: 768px) {
                .paramobil {
                    border-radius: 0 50rem 50rem 0 !important;
                    background-color: #fff !important;
                    padding: 3rem !important;
                    margin-bottom: 1rem !important;
                }
            }*/
        </style>
        <div class="col-md-6">
            <div class="row parallax-container paramobil">
                <img src="src/home/2.png" class="parallax-item phone-image" alt="Phone Screen">
                <img src="src/home/3.png" class="parallax-item elements-inside" alt="Elements Inside">
                <img src="src/home/4.png" class="parallax-item elements-inside2" alt="Elements Inside">
            </div>
        </div>
    </div>
</div>

<div class="container-fluid my-4">
    <div class="row align-items-center text-center">

        <div class="col-md-4 bg-light p-4 text-center bg-gradient-custom shadow-lg didascaliasx"
            style="border-radius: 0 50rem  50rem 0 !important;">
            <h4 class="font-weight-bold pr-5">Exclusive Service, Tailored Creativity!</h4>
            <p class="mt-3 pr-5">
                We work only with the best professionals in the industry to ensure impeccable results.
                Every shot and every recording are designed to exceed your expectations and turn every idea into a
                visual masterpiece. <br>
                <a class="btn mt-3 rounded-pill btn-gradient-custom-yellow shadow-sm font-weight-bold"
                    href="book">DISCOVER ALL
                    CATEGORIES</a>
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
        <div class="col-md-4 bg-light p-4 text-center  bg-gradient-custom shadow-lg didascaliadx"
            style="border-radius: 50rem 0 0 50rem !important;">
            <h4 class="font-weight-bold pl-5">Simplified Booking for Every Occasion</h4>
            <p class="mt-3 pl-5">
                Whether you need a photographer or a videographer, select the category that best represents your style
                or needs. Book in just a few clicks and bring your ideas to life!
                <br>
                <a class="btn mt-3 rounded-pill btn-gradient-custom-yellow shadow-sm  font-weight-bold" href="book">TRY
                    NOW</a>
            </p>
        </div>
    </div>
</div>
<hr>

<?php include("elements/trusted_by.php"); ?>
<hr>
<?php include("elements/reviews.php"); ?>
<hr>

<div class="custom-container w-100">
    <div class="row text-center">
        <div class="col-md-6">
            <img src="src/home/5.png" class="img-fluid" alt="Phone Screen">
        </div>
        <div class="col-md-4 text-left d-flex align-items-center">
            <div class="container p-4 ml-5">
                <span class="h1 text-white font-weight-bold text-gradient-custom ">Simple Booking Process</span>
                <br><br><i class="font-weight-normal">Booking your photography services has never been easier. Pixiod
                    guides you through every step with just a few simple clicks.</i>
            </div>
        </div>
        <div class="col-md-2"> </div>
    </div>
</div>
<div class="custom-container w-100">
    <div class="row text-center">
        <div class="col-md-2"> </div>
        <div class="col-md-4 text-left d-flex align-items-center">
            <div class="container p-4 ml-5">
                <span class="h1 text-white font-weight-bold text-gradient-custom ">No Technical Skills Needed</span>
                <br><br><i class="font-weight-normal">Using Pixiod is incredibly easy. No technical experience required,
                    just follow our intuitive process. Anyone can do it!</i>
            </div>
        </div>
        <div class="col-md-6">
            <img src="src/home/6.png" class="img-fluid" alt="Phone Screen">
        </div>

    </div>
</div>
<style>
    @media (min-width: 1025px) {

        .imgpc {
            width: 60% !important;
            display: block;
            margin: 0 auto !important;
            /* Per centrare il contenitore */
        }
    }
</style>

<section class="container-fluid mt-4 "> <img src="src/home/7.png" class="img-fluid imgpc" alt="Phone Screen"></section>
<?php include("elements/faq.php"); ?>
<?php include("elements/support.php"); ?>
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