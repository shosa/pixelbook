<?php
require("../../config/config.php");

header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['id']) || !isset($input['status'])) {
        throw new Exception("Dati mancanti.");
    }

    $id = intval($input['id']);
    $status = $input['status'];

    $pdo = Database::getInstance();

    if ($status === "voided") {
        $stmt = $pdo->prepare("UPDATE prenotazioni SET voided = 1, confirmed = 0 WHERE id = ?");
    } elseif ($status === "confirmed") {
        $stmt = $pdo->prepare("UPDATE prenotazioni SET voided = 0, confirmed = 1 WHERE id = ?");
    } else {
        $stmt = $pdo->prepare("UPDATE prenotazioni SET voided = 0, confirmed = 0 WHERE id = ?");
    }

    $stmt->execute([$id]);
    $_SESSION["success"] = "Stato aggiornato!";
    echo json_encode(['success' => true, 'message' => 'Stato aggiornato.']);
} catch (Exception $e) {
    $_SESSION["Danger"]="Errore";
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
