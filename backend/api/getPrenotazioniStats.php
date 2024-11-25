<?php
require("../config/config.php");

function getPrenotazioniStats($periodo)
{
    // Ottieni l'istanza del database
    $db = Database::getInstance();

    // Calcola l'intervallo di date
    $dateInterval = [
        'Ultimi 7 giorni' => '7 DAY',
        'Ultimi 30 giorni' => '30 DAY',
        'Ultimi 3 mesi' => '90 DAY'
    ];

    if (!array_key_exists($periodo, $dateInterval)) {
        throw new Exception("Periodo non valido.");
    }

    $interval = $dateInterval[$periodo];

    // Query per calcolare il totale delle prenotazioni
    $queryTotale = "
        SELECT COUNT(*) as totale 
        FROM prenotazioni 
        WHERE date_of_submit >= DATE_SUB(CURDATE(), INTERVAL $interval)
    ";

    // Query per calcolare il totale delle prenotazioni confermate
    $queryConfirmed = "
        SELECT COUNT(*) as confermate 
        FROM prenotazioni 
        WHERE date_of_submit >= DATE_SUB(CURDATE(), INTERVAL $interval) 
          AND confirmed = 1
    ";

    try {
        // Calcola il totale delle prenotazioni
        $stmtTotale = $db->query($queryTotale);
        $totale = $stmtTotale->fetch(PDO::FETCH_ASSOC)['totale'];

        // Calcola il totale delle prenotazioni confermate
        $stmtConfirmed = $db->query($queryConfirmed);
        $confermate = $stmtConfirmed->fetch(PDO::FETCH_ASSOC)['confermate'];

        // Calcola il tasso di conversione
        $conversionRate = ($totale > 0) ? ($confermate / $totale) * 100 : 0;

        // Restituisci i risultati
        return [
            'totale' => $totale,
            'confermate' => $confermate,
            'conversionRate' => round($conversionRate, 2)
        ];
    } catch (PDOException $e) {
        throw new Exception("Errore nel recupero dei dati: " . $e->getMessage());
    }
}

header('Content-Type: application/json');

try {
    // Recupera il periodo inviato tramite POST
    $periodo = $_POST['periodo'] ?? 'Ultimi 7 giorni';

    // Calcola le statistiche
    $stats = getPrenotazioniStats($periodo);

    // Restituisci la risposta come JSON
    echo json_encode([
        'success' => true,
        'data' => $stats
    ]);
} catch (Exception $e) {
    // Gestione degli errori
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
