<?php
require 'config/db.php';

// Check if the ID is passed
if (!isset($_GET['id'])) {
    echo "No ID provided.";
    exit;
}

// Get the ID from the query parameter
$booking_id = (int) $_GET['id'];

// Database connection
$pdo = Database::getInstance();
try {
    // Update the confirmed status
    $stmt = $pdo->prepare("UPDATE prenotazioni SET confirmed = 1 WHERE id = :id");
    $stmt->execute(['id' => $booking_id]);

    // Redirect to thank you page
    header("Location: thank_you.php");
    exit;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>