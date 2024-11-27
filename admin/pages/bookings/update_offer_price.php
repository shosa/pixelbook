<?php
require("../../config/config.php");

header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['id']) || !isset($input['offer_price'])) {
        throw new Exception("Dati mancanti.");
    }

    $id = intval($input['id']);
    $offerPrice = floatval($input['offer_price']);
    $dateOfOffer = date('Y-m-d'); // Ottieni la data e l'ora attuali

    $pdo = Database::getInstance();
    $stmt = $pdo->prepare("UPDATE prenotazioni SET offer_price = ?, date_of_offer = ? WHERE id = ?");
    $stmt->execute([$offerPrice, $dateOfOffer, $id]);

    echo json_encode(['success' => true, 'message' => 'Offerta e data salvate con successo.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
