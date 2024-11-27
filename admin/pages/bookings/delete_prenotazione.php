<?php
require("../../config/config.php");

header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['id'])) {
        throw new Exception("ID prenotazione mancante.");
    }

    $id = intval($input['id']);
    $pdo = Database::getInstance();

    $stmt = $pdo->prepare("DELETE FROM prenotazioni WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION["info"] = "Prenotazione Eliminata";
    echo json_encode(['success' => true, 'message' => 'Prenotazione eliminata.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}