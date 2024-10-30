<?php
require '../../config/db.php';

$pdo = Database::getInstance();

// Verifica se è stato passato un ID tramite la query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepara ed esegui la query per ottenere i dati del carousel
    $stmt = $pdo->prepare("SELECT * FROM home_carousel WHERE id = ?");
    $stmt->execute([$id]);
    $carouselItem = $stmt->fetch(PDO::FETCH_ASSOC);

    // Restituisci i dati del carousel in formato JSON
    if ($carouselItem) {
        header('Content-Type: application/json');
        echo json_encode($carouselItem);
    } else {
        // Restituisce un errore se l'elemento non è stato trovato
        http_response_code(404);
        echo json_encode(['error' => 'Elemento non trovato']);
    }
} else {
    // Restituisce un errore se non è stato fornito l'ID
    http_response_code(400);
    echo json_encode(['error' => 'ID non fornito']);
}
