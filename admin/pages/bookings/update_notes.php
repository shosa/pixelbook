<?php
require("../../config/config.php");

$pdo = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $adminNote = $_POST['adminNote'];

    $stmt = $pdo->prepare("UPDATE prenotazioni SET note = ? WHERE id = ?");
    $stmt->execute([$adminNote, $id]);

    $_SESSION['success'] = "Note aggiornate con successo!";
    header("Location: details?token=" . $id);
    exit();
}
?>