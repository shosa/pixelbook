<?php

// Prevenzione del caching HTTP
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Wed, 11 Jan 1984 05:00:00 GMT"); // Data scaduta

// Svuota l'Opcode Cache di PHP (se attiva)
if (function_exists('opcache_reset')) {
    opcache_reset();
}





use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Abilita il reporting degli errori per il debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', BASE_PATH . '/checkBookings_error.log'); // Log degli errori

try {
    // Connessione al database
   

    // Recupera la configurazione SMTP per "noreply@pixiod.com"
    $smtpStmt = $pdo->prepare("SELECT * FROM smtp_settings WHERE from_email = ?");
    $smtpStmt->execute(['noreply@pixiod.com']);
    $smtp = $smtpStmt->fetch(PDO::FETCH_ASSOC);

    if (!$smtp) {
        throw new Exception("Configurazione SMTP non trovata per noreply@pixiod.com");
    }

    // Recupera le prenotazioni con notified_newOrder = 0
    $stmt = $pdo->prepare("SELECT * FROM prenotazioni WHERE notified_newOrder = 0");
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
            $mail->addAddress($prenotazione['mail']);

            // Modifica l'oggetto in base al valore di "confirmed"
            $mail->Subject = " Your Booking #" . $prenotazione['id'];
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            // Carica il template
            ob_start();
            include('../mail/new-order/source.html');
            $template = ob_get_clean();


            $template = str_replace(
                [
                    '%name%',
                    '%first_name%',
                    '%last_name%',
                    '%email%',
                    '%phone%',
                    '%service%',
                    '%duration%',
                    '%event_date%',
                    '%time_of_day%',
                    '%price%'
                ],
                [
                    $prenotazione['first_name'],
                    $prenotazione['first_name'],
                    $prenotazione['last_name'],
                    $prenotazione['mail'],
                    $prenotazione['phone'],
                    $prenotazione['service'],
                    $prenotazione['duration'],
                    // Data nel formato desiderato: "Monday, 06 December 2024"
                    strftime('%A, %d %B %Y', strtotime($prenotazione['date'])),
                    $prenotazione['time_of_day'],
                    number_format($prenotazione['price'], 2)
                ],
                $template
            );

            // Corpo della mail
            $mail->isHTML(true);
            $mail->Body = $template;

            // Invia l'email
            $mail->send();

            // Aggiorna notified_newOrder a 1
            $updateStmt = $pdo->prepare("UPDATE prenotazioni SET notified_newOrder = 1 WHERE id = ?");
            $updateStmt->execute([$prenotazione['id']]);

            echo "Email NUOVO ORDINE inviata per la prenotazione ID {$prenotazione['id']}.\n";
        } catch (Exception $e) {
            error_log("Errore nell'invio dell'email per la prenotazione ID {$prenotazione['id']}: " . $mail->ErrorInfo);
        }
    }
} catch (Exception $e) {
    error_log("Errore generale: " . $e->getMessage());
    echo "Errore: " . $e->getMessage() . "\n";
}
