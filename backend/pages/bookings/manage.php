<?php
require("../../config/config.php");

$pdo = Database::getInstance();

// Funzione per ottenere i dettagli della prenotazione
function getPrenotazioneDetails($id, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM prenotazioni WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Azione: Visualizzare Dettagli
if (isset($_GET['action']) && $_GET['action'] == 'view' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $prenotazione = getPrenotazioneDetails($id, $pdo);
    if ($prenotazione) {
        echo json_encode($prenotazione);
    } else {
        echo json_encode(['error' => 'Prenotazione non trovata.']);
    }
    exit;
}

// Azione: Eliminare Prenotazione
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM prenotazioni WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION["success"] = "Prenotazione eliminata con successo.";
    } catch (Exception $e) {
        $_SESSION["danger"] = "Errore durante l'eliminazione: " . $e->getMessage();
    }
    header("Location: index.php");
    exit;
}

// Azione: Modificare Prenotazione
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = $_POST['id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['mail'];
    $phone = $_POST['phone'];
    $service = $_POST['service'];
    $date = $_POST['date'];

    try {
        $stmt = $pdo->prepare("
            UPDATE prenotazioni 
            SET first_name = ?, last_name = ?, mail = ?, phone = ?, service = ?, date = ? 
            WHERE id = ?
        ");
        $stmt->execute([$firstName, $lastName, $email, $phone, $service, $date, $id]);
        $_SESSION["success"] = "Prenotazione aggiornata con successo.";
    } catch (Exception $e) {
        $_SESSION["danger"] = "Errore durante l'aggiornamento: " . $e->getMessage();
    }
    header("Location: index.php");
    exit;
}
?>
