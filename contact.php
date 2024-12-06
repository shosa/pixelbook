<?php
require 'config/db.php';
require 'components/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center mb-4">Contact Us</h1>
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">Information</h5>
                    <p class="card-text">
                        <strong>Email:</strong> info@pixiod.com<br>
                        <strong>Phone:</strong> +39 320 639 7274<br>
                    </p>
                </div>
            </div>
            <div class="card shadow mt-4">
                <div class="card-body">
                    <h5 class="card-title">Write us a message</h5>
                    <form action="send_message.php" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Your name"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Your email"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4"
                                placeholder="Write your message" required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit"
                                class="btn btn-gradient-custom-yellow shadow-sm rounded-pill btn-block">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'components/footer.php'; ?>