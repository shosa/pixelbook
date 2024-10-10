<?php
require 'config/db.php';
require 'components/header.php';

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
<hr>
<div class="container">
    <!-- Strengths Section -->
    <div class="p-3 shadow-lg rounded">
        <section class="section py-4 text-center">
            <h2 class="section-title text-gradient-custom font-weight-bold">Our Service Strengths</h2>
            <div class="section-content">
                <div class="d-flex flex-column align-items-center">
                    <span class="icon-text p-2"><i class="fas fa-camera icon text-gradient-custom"></i> Professional
                        photographers with years of experience.</span>
                    <span class="icon-text p-2"><i class="fas fa-star icon text-gradient-custom"></i> Customized
                        services
                        for every type of event.</span>
                    <span class="icon-text p-2"><i class="fas fa-dollar-sign icon text-gradient-custom"></i> Flexible
                        packages to suit every budget.</span>
                    <span class="icon-text p-2"><i class="fas fa-cogs icon text-gradient-custom"></i> State-of-the-art
                        equipment for high-quality results.</span>
                    <span class="icon-text p-2"><i class="fas fa-headset icon text-gradient-custom"></i> 24/7 customer
                        support for any needs.</span>
                </div>
            </div>
        </section>
    </div>
    <hr>
    <!-- How It Works Section -->
    <div class="p-3 shadow-lg rounded">
        <section class="section py-4 text-center">
            <h2 class="section-title text-gradient-custom font-weight-bold">How It Works</h2>
            <div class="section-content mx-auto" style="max-width: 800px;">
                <p>Our process is simple and quick:</p>
                <ol class="list-unstyled">
                    <li class="d-flex align-items-center mb-2">
                        <span class="btn btn-gradient-custom rounded-circle mr-2">1</span>
                        <span>Select the type of service you need.</span>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <span class="btn btn-gradient-custom rounded-circle mr-2">2</span>
                        <span>Choose the desired duration of service.</span>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <span class="btn btn-gradient-custom rounded-circle mr-2">3</span>
                        <span>Indicate the date and time of the event.</span>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <span class="btn btn-gradient-custom rounded-circle mr-2">4</span>
                        <span>Receive a confirmation via email.</span>
                    </li>
                </ol>
                <div class="bg-gradient-custom rounded shadow-sm p-3 mt-2 text-white">
                    <h4 class="font-weight-bold">Get ready for an unforgettable experience!</h4>
                </div>
            </div>
        </section>
    </div>
    <hr>
    <!-- Customer Testimonials Section -->
    <div class="p-3 shadow-lg rounded">
        <section class="section py-4 text-center">
            <h2 class="section-title text-gradient-custom font-weight-bold">Customer Testimonials</h2>
            <h3 class="text-yellow">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </h3>
            <div class="section-content">
                <div class="alert alert-info">"Exceptional service! The photos from our wedding are simply stunning!" -
                    <strong>Maria R.</strong>
                </div>
                <div class="alert alert-info">"A fantastic experience, the photographers were professional and very
                    friendly." - <strong>Luca S.</strong></div>
                <div class="alert alert-info">"Highly recommend! They captured every special moment of our party." -
                    <strong>Anna P.</strong>
                </div>
            </div>
        </section>
    </div>
    <hr>
    <!-- FAQ Section -->
    <div class="p-3 shadow-lg rounded">
        <section class="section py-4 text-center">
            <h2 class="section-title text-gradient-custom font-weight-bold">FAQ</h2>
            <div class="section-content mx-auto" style="max-width: 800px;">
                <div class="faq border rounded p-3 mb-2 shadow-sm">
                    <strong class="text-gradient-custom">1. What is the booking process?</strong>
                    <p>You can book directly from our site by selecting the service, duration, and date.</p>
                </div>
                <div class="faq border rounded p-3 mb-2 shadow-sm">
                    <strong class="text-gradient-custom">2. How can I pay?</strong>
                    <p>We accept various payment methods, including credit cards and PayPal.</p>
                </div>
                <div class="faq border rounded p-3 mb-2 shadow-sm">
                    <strong class="text-gradient-custom">3. Can I customize my package?</strong>
                    <p>Yes, we can customize the package based on your specific needs.</p>
                </div>
                <div class="faq border rounded p-3 mb-2 shadow-sm">
                    <strong class="text-gradient-custom">4. What is your cancellation policy?</strong>
                    <p>We offer full refunds if you cancel your booking with 48 hours notice.</p>
                </div>
                <div class="faq border rounded p-3 mb-2 shadow-sm">
                    <strong class="text-gradient-custom">5. When will I receive my photos?</strong>
                    <p>Photos are typically delivered within 2 weeks after the event.</p>
                </div>
            </div>
        </section>
    </div>
    <div class="mb-4"></div>
</div>

<?php require 'components/footer.php'; ?>