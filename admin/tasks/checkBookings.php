<?php
require("../config/config.php");
require(BASE_PATH . "/vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {
    // Connessione al database
    $pdo = Database::getInstance();

    // Recupera la configurazione SMTP per "notifications@pixiod.com"
    $smtpStmt = $pdo->prepare("SELECT * FROM smtp_settings WHERE from_email = ?");
    $smtpStmt->execute(['notifications@pixiod.com']);
    $smtp = $smtpStmt->fetch(PDO::FETCH_ASSOC);

    if (!$smtp) {
        throw new Exception("Configurazione SMTP non trovata per notifications@pixiod.com");
    }

    // Recupera le prenotazioni con isRead = 0
    $stmt = $pdo->prepare("SELECT * FROM prenotazioni WHERE isRead = 0");
    $stmt->execute();
    $prenotazioni = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($prenotazioni)) {
        echo "Nessuna nuova prenotazione da notificare.\n";
        exit;
    }

    // Configura PHPMailer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = $smtp['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $smtp['username'];
    $mail->Password = $smtp['password'];
    $mail->SMTPSecure = $smtp['encryption'];
    $mail->Port = $smtp['port'];
    $mail->setFrom($smtp['from_email'], $smtp['from_name']);

    // Cicla attraverso le prenotazioni e invia email
    foreach ($prenotazioni as $prenotazione) {
        try {
            // Pulisce i destinatari e altri dati dell'email
            $mail->clearAddresses();
            $mail->clearAllRecipients();
            $mail->clearAttachments();

            // Imposta il destinatario
            $mail->addAddress('admin@pixiod.com');

            // Modifica l'oggetto in base al valore di "confirmed"
            if ($prenotazione['confirmed'] == 1) {
                $mail->Subject = "[CONFERMATA] Nuova Prenotazione: " . $prenotazione['first_name'] . " " . $prenotazione['last_name'];
            } else {
                $mail->Subject = "[NON CONCLUSA] Nuova Prenotazione: " . $prenotazione['first_name'] . " " . $prenotazione['last_name'];
            }

            // Corpo della mail
            $mail->isHTML(true);
            $mail->Body = "
                <h3>Dettagli della nuova prenotazione:</h3>
                <p><strong>Nome:</strong> {$prenotazione['first_name']} {$prenotazione['last_name']}</p>
                <p><strong>Email:</strong> {$prenotazione['mail']}</p>
                <p><strong>Telefono:</strong> {$prenotazione['phone']}</p>
                <p><strong>Servizio:</strong> {$prenotazione['service']}</p>
                <p><strong>Data evento:</strong> " . date('d/m/Y', strtotime($prenotazione['date'])) . "</p>
                <p><strong>Ora:</strong> {$prenotazione['time_of_day']}</p>
                <p><strong>Durata:</strong> {$prenotazione['duration']} ore</p>
                <p><strong>Prezzo:</strong> €" . number_format($prenotazione['price'], 2) . "</p>
                <p><strong>Note:</strong> {$prenotazione['note']}</p>
            ";

            // Invia l'email
            $mail->send();

            // Aggiorna isRead a 1
            $updateStmt = $pdo->prepare("UPDATE prenotazioni SET isRead = 1 WHERE id = ?");
            $updateStmt->execute([$prenotazione['id']]);

            echo "Email inviata per la prenotazione ID {$prenotazione['id']}.\n";
        } catch (Exception $e) {
            echo "Errore nell'invio dell'email per la prenotazione ID {$prenotazione['id']}: {$mail->ErrorInfo}\n";
        }
    }
} catch (Exception $e) {
    echo "Errore: " . $e->getMessage() . "\n";
}
