<?php
require("../config/config.php");

function getPrenotazioniGiornalieri($periodo)
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

    // Query per calcolare le prenotazioni giornaliere
    $query = "
        SELECT DATE(date_of_submit) as giorno, COUNT(*) as prenotazioni
        FROM prenotazioni
        WHERE date_of_submit >= DATE_SUB(CURDATE(), INTERVAL $interval)
        GROUP BY DATE(date_of_submit)
        ORDER BY giorno ASC
    ";

    try {
        $stmt = $db->query($query);
        $risultati = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Formatta i dati per il grafico
        $dati = [];
        foreach ($risultati as $riga) {
            $dati[] = [
                'data' => $riga['giorno'],
                'prenotazioni' => (int)$riga['prenotazioni']
            ];
        }

        return $dati;
    } catch (PDOException $e) {
        throw new Exception("Errore nel recupero dei dati: " . $e->getMessage());
    }
}

header('Content-Type: application/json');

try {
    // Recupera il periodo inviato tramite POST
    $periodo = $_POST['periodo'] ?? 'Ultimi 7 giorni';

    // Calcola le prenotazioni giornaliere
    $datiPrenotazioni = getPrenotazioniGiornalieri($periodo);

    // Restituisci i dati come JSON
    echo json_encode([
        'success' => true,
        'data' => $datiPrenotazioni
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
