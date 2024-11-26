<?php
require '../config/config.php'; // Assicurati che config includa la connessione al database

$pdo = Database::getInstance();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notifica_id'])) {
    $notifica_id = $_POST['notifica_id'];
    $stmt = $pdo->prepare("UPDATE notifiche SET nascosta = 1 WHERE id = :id");
    $stmt->execute(['id' => $notifica_id]);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>