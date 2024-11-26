<?php require 'config/db.php';
require 'components/header.php'; // Include your header here ?>

<div class="container mt-5 text-center">
    <h1 class="text-gradient-custom">Thank You!</h1>
    <p>Your request has been confirmed. We will get back to you soon!</p>
    <div class="btn  rounded-pill btn-lg btn-success mb-4 shadow">
        <a href="https://wa.me/393206397274" target="_blank" aria-label="Chat on WhatsApp" class="text-white">
            <i class="fab fa-whatsapp text-white"></i> Chat with Us!
        </a>
    </div><br>
    <a href="index.php" class="btn rounded-pill btn-gradient-custom ">Return to Home</a>

</div>

<?php require 'components/footer.php'; // Include your footer here ?>