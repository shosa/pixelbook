<?php
// offer.php
require 'config/db.php';
require 'components/header.php'; // Include il tuo header qui

// Recupera i dati dal POST
$category = $_POST['category'] ?? 'N/A';
$service = $_POST['service'] ?? 'N/A';
$time_of_day = $_POST['time_of_day'] ?? 'N/A';
$duration = $_POST['duration'] ?? 'N/A';
$date = $_POST['date'] ?? 'N/A';
$flexible_date = $_POST['flexible_date'] ?? 'N/A';

// Connessione al database
$pdo = Database::getInstance();


try {
    // 1. Recupera il prezzo base dalla tabella delle categorie
    $stmt = $pdo->prepare("SELECT base_price FROM categorie WHERE nome = :category");
    $stmt->execute(['category' => $category]);
    $base_price = $stmt->fetchColumn();

    // Controlla se il prezzo base è stato trovato
    if ($base_price === false) {
        throw new Exception("Categoria non trovata.");
    }

    // 2. Recupera il tariffario per il servizio
    $tariff_service = 1; // Valore predefinito
    if ($service === 'photo') {
        $tariff_service = 1; // Imposta il valore tariffario per il servizio foto
    } elseif ($service === 'video') {
        $tariff_service = 1.5; // Imposta il valore tariffario per il servizio video
    } elseif ($service === 'photo & video') {
        $tariff_service = 2; // Imposta il valore tariffario per entrambi i servizi
    }

    // 3. Recupera il tariffario per la durata
    $tariff_duration = 1; // Valore predefinito
    if ($duration === '1 Ora') {
        $tariff_duration = 1; // 1 ora
    } elseif ($duration === '2 Ore') {
        $tariff_duration = 1.5; // 2 ore
    } elseif ($duration === '3 Ore') {
        $tariff_duration = 2; // 3 ore
    } elseif ($duration === 'custom') {
        $tariff_duration = 2.5; // Maggiore di 3 ore
    }

    // 4. Calcola il prezzo finale
    $final_price = $base_price * $tariff_service * $tariff_duration;

} catch (Exception $e) {
    echo "Errore: " . $e->getMessage();
    exit;
}
?>

<div class="container mt-5">
    <h1 class="text-center">Riepilogo Offerta</h1>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Dettagli</h5>
            <table class="table">
                <tbody>
                    <tr>
                        <td><strong>Categoria:</strong></td>
                        <td><?php echo htmlspecialchars($category); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Servizio:</strong></td>
                        <td><?php echo htmlspecialchars($service); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Orario del giorno:</strong></td>
                        <td><?php echo htmlspecialchars($time_of_day); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Durata:</strong></td>
                        <td><?php echo htmlspecialchars($duration); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Data:</strong></td>
                        <td><?php echo htmlspecialchars($date); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Data flessibile:</strong></td>
                        <td><?php echo htmlspecialchars($flexible_date == 'on' ? 'Sì' : 'No'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Prezzo Totale:</strong></td>
                        <td><?php echo htmlspecialchars(number_format($final_price, 2)); ?> AED</td>
                    </tr>
                </tbody>
            </table>
            <a href="index.php" class="btn btn-primary">Torna al modulo</a>
            <a href="confirm.php" class="btn btn-success">Conferma Offerta</a>
        </div>
    </div>
</div>

<?php require 'components/footer.php'; // Include il tuo footer qui ?>
