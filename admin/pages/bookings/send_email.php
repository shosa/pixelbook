<?php
require("../../config/config.php");
require(BASE_PATH . "/vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

try {
    // Recupera l'ID della prenotazione
    if (!isset($_POST['id'])) {
        throw new Exception("ID prenotazione mancante");
    }

    $id = $_POST['id'];
    $price = $_POST['price'];
    // Connessione al database
    $pdo = Database::getInstance();

    // Recupera i dettagli della prenotazione
    $stmt = $pdo->prepare("SELECT * FROM prenotazioni WHERE id = ?");
    $stmt->execute([$id]);
    $prenotazione = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$prenotazione) {
        throw new Exception("Prenotazione non trovata");
    }

    // Recupera i dettagli della prenotazione
    $to = $prenotazione['mail'];
    $subject = "Offerta per il tuo evento";
    $price = number_format($price, 2);
    $original_price = number_format($prenotazione['price'], 2); // Esempio: prezzo originale con incremento del 20%
    $service = htmlspecialchars($prenotazione['service']);
    $event_date = date('d/m/Y', strtotime($prenotazione['date']));
    $time_of_day = htmlspecialchars($prenotazione['time_of_day']);
    $duration = htmlspecialchars($prenotazione['duration']);

    // Carica il template HTML
    ob_start();
    include('../../mail/offer/source.html');
    $htmlTemplate = ob_get_clean();

    // Sostituisci i placeholder nel template
    $htmlContent = str_replace(
        ['%price%', '%original_price%', '%service%', '%event_date%', '%time_of_day%', '%duration%'],
        [$price, $original_price, $service, $event_date, $time_of_day, $duration],
        $htmlTemplate
    );

    // Configura PHPMailer
    $mail = new PHPMailer(true);

    // Configurazione SMTP
    $smtp = $pdo->query("SELECT * FROM smtp_settings LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    $mail->isSMTP();
    $mail->Host = $smtp['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $smtp['username'];
    $mail->Password = $smtp['password'];
    $mail->SMTPSecure = $smtp['encryption'];
    $mail->Port = $smtp['port'];

    // Imposta il mittente e destinatario
    $mail->setFrom($smtp['from_email'], $smtp['from_name']);
    $mail->addAddress($to);

    // Includi immagini inline
    $mail->addEmbeddedImage('../../mail/offer/assets/logo.png', 'logo');
    $mail->addEmbeddedImage('../../mail/offer/assets/illustrations-undraw_wallet_aym5.png', 'wallet');

    // Sostituisci i percorsi delle immagini con i CID
    $htmlContent = str_replace('./assets/logo.png', 'cid:logo', $htmlContent);
    $htmlContent = str_replace('./assets/illustrations-undraw_wallet_aym5.png', 'cid:wallet', $htmlContent);

    // Imposta l'email in formato HTML
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $htmlContent;

    // Invia l'email
    $mail->send();

    echo json_encode(['success' => true, 'message' => 'Email inviata con successo!']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => "Errore nell'invio dell'email: {$e->getMessage()}"]);
}
