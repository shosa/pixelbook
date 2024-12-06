<?php
// thank_you.php
require 'config/db.php';
require 'components/header.php'; // Include your header here

// Retrieve the ID from the URL
$reservation_id = $_GET['id'] ?? null;

if ($reservation_id) {
    // Database connection
    $pdo = Database::getInstance();

    try {
        // Retrieve reservation details along with the category name
        $stmt = $pdo->prepare("
            SELECT p.*, c.nome AS category_name
            FROM prenotazioni p
            JOIN categorie c ON p.category_id = c.id
            WHERE p.id = :id
        ");
        $stmt->execute(['id' => $reservation_id]);
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reservation) {
            throw new Exception("Reservation not found.");
        }

        // Extract reservation details for display
        $first_name = $reservation['first_name'];
        $last_name = $reservation['last_name'];
        $phone_number = $reservation['phone'];
        $service = $reservation['service'];
        $date = $reservation['date'];
        $price = $reservation['price'];
        $category_name = $reservation['category_name']; // Category name from join

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<div class="container mt-5 text-center animated fadeIn celebration-bg">
    <h1 class="text-gradient-custom">Thank You, <?php echo htmlspecialchars($first_name); ?>!</h1>
    <p>Your request has been confirmed. We will get back to you soon!</p>

    <h4 class="celebration-title">Reservation Details</h4>
    <table class="table mt-4">
        <tbody>
            <tr>
                <td><strong>Name:</strong></td>
                <td><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td><?php echo htmlspecialchars($phone_number); ?></td>
            </tr>
            <tr>
                <td><strong>Category:</strong></td>
                <td><?php echo htmlspecialchars($category_name); ?></td> <!-- Category name from join -->
            </tr>
            <tr>
                <td><strong>Service:</strong></td>
                <td><?php echo htmlspecialchars($service); ?></td>
            </tr>
            <tr>
                <td><strong>Date:</strong></td>
                <td><?php echo htmlspecialchars($date); ?></td>
            </tr>
            <tr>
                <td><strong>Total Price:</strong></td>
                <td class="h3 text-gradient-custom font-weight-bold">
                    <?php echo htmlspecialchars(number_format($price, 2)); ?> AED
                </td>
            </tr>
        </tbody>
    </table>

    <div class="btn rounded-pill btn-lg btn-success mb-4 shadow celebration-btn">
        <a href="https://wa.me/393206397274" target="_blank" aria-label="Chat on WhatsApp" class="text-white">
            <i class="fab fa-whatsapp text-white"></i> Chat with Us!
        </a>
    </div>

    <br>
    <a href="index.php" class="btn rounded-pill btn-gradient-custom celebration-btn">Return to Home</a>
</div>

<!-- Canvas for confetti -->
<canvas id="confetti"
    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none;"></canvas>

<?php require 'components/footer.php'; // Include your footer here ?>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
<script>
    // Confetti animation
    function launchConfetti() {
        confetti({
            particleCount: 200,
            spread: 70,
            origin: { x: 0.5, y: 0.5 }
        });
    }

    window.onload = function () {
        launchConfetti();
    };
</script>

<style>
    /* Background with celebration effect */

    /* FadeIn effect */
    .animated.fadeIn {
        animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    /* Custom gradient for text */
</style>