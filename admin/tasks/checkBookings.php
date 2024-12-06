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
            $mail->Subject = ($prenotazione['confirmed'] == 1 ? "[CONFERMATA]" : "[NON CONCLUSA]") .
                " Nuova Prenotazione: " . $prenotazione['first_name'] . " " . $prenotazione['last_name'];
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            // Corpo della mail
            $mail->isHTML(true);
            $mail->Body = "
            <div style=\"font-family: 'Montserrat', sans-serif; color: #333; max-width: 700px; margin: auto; border: 1px solid #ddd; border-radius: 10px; padding: 20px; background-color: #f9f9f9;\">
                <link href=\"https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap\" rel=\"stylesheet\">
                <div style=\"text-align: center; margin-bottom: 20px;\">
                    <div style=\"background-color: " . ($prenotazione['confirmed'] == 1 ? '#4CAF50' : '#FFA500') . "; color: white; padding: 10px; border-radius: 5px;\">
                        <h2 style=\"margin: 0;\">" . ($prenotazione['confirmed'] == 1 ? 'CONFERMATA' : 'NON CONFERMATA') . "</h2>
                    </div>
                    <p style=\"color: #666; font-size: 14px; margin-top: 10px;\">Ricevuta il " . date('d/m/Y') . " alle " . date('H:i') . "</p>
                </div>
                <table style=\"width: 100%; border-collapse: collapse; margin-bottom: 20px;\">
                    <tr style=\"background-color: #f1f1f1;\">
                        <th style=\"text-align: left; padding: 8px; border-bottom: 1px solid #ddd;\">Dettaglio</th>
                        <th style=\"text-align: left; padding: 8px; border-bottom: 1px solid #ddd;\">Informazione</th>
                    </tr>
                    <tr>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">Nome:</td>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">{$prenotazione['first_name']} {$prenotazione['last_name']}</td>
                    </tr>
                    <tr>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">Email:</td>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">{$prenotazione['mail']}</td>
                    </tr>
                    <tr>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">Telefono:</td>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">{$prenotazione['phone']}</td>
                    </tr>
                    <tr>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">Servizio:</td>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">{$prenotazione['service']}</td>
                    </tr>
                     <tr>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">Durata:</td>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">{$prenotazione['duration']} h</td>
                    </tr>
                    <tr>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">Data evento:</td>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">" . date('d/m/Y', strtotime($prenotazione['date'])) . "</td>
                    </tr>
                    <tr>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">Ora:</td>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">{$prenotazione['time_of_day']}</td>
                    </tr>
                    <tr>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">Prezzo:</td>
                        <td style=\"padding: 8px; border-bottom: 1px solid #ddd;\">AED " . number_format($prenotazione['price'], 2) . "</td>
                    </tr>
                </table>
                <div style=\"margin-bottom: 20px;\">
                    <table style=\"width: 100%; border-collapse: collapse; text-align: center;\">
                        <thead>
                            <tr style=\"background-color: #f1f1f1; color: #333;\">
                                <th>LUN</th><th>MAR</th><th>MER</th><th>GIO</th><th>VEN</th><th>SAB</th><th>DOM</th>
                            </tr>
                        </thead>
                        <tbody>
            ";

            // Generazione del calendario
            $eventDate = strtotime($prenotazione['date']);
            $startOfMonth = strtotime(date('Y-m-01', $eventDate));
            $daysInMonth = date('t', $eventDate);
            $firstDayOfWeek = date('N', $startOfMonth); // 1 (Mon) to 7 (Sun)
            $highlightDay = date('j', $eventDate);

            $day = 1;
            for ($row = 0; $day <= $daysInMonth; $row++) {
                $mail->Body .= "<tr>";
                for ($col = 1; $col <= 7; $col++) {
                    if ($row === 0 && $col < $firstDayOfWeek) {
                        $mail->Body .= "<td style=\"padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9;\">&nbsp;</td>";
                    } elseif ($day <= $daysInMonth) {
                        $style = ($day == $highlightDay) ? "background-color: #4CAF50; color: white; font-weight: bold;" : "background-color: #fff;";
                        $mail->Body .= "<td style=\"padding: 10px; border: 1px solid #ddd; $style\">$day</td>";
                        $day++;
                    } else {
                        $mail->Body .= "<td style=\"padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9;\">&nbsp;</td>";
                    }
                }
                $mail->Body .= "</tr>";
            }

            $mail->Body .= "
                        </tbody>
                    </table>
                </div>
                <div style=\"margin-top: 20px; text-align: center;\">
                    <a href=\"https://www.pixiod.com/admin/pages/bookings/details?token=" . $prenotazione["id"] . "\" style=\"background-color: #4CAF50; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 14px;\">Gestisci Prenotazioni</a>
                </div>
                <p style=\"text-align: center; color: #666; font-size: 12px; margin-top: 20px;\">Questa email è stata generata automaticamente. Per assistenza, contattaci a <a href=\"mailto:support@pixiod.com\">support@pixiod.com</a>.</p>
            </div>
            ";


            // Invia l'email
            $mail->send();

            // Aggiorna isRead a 1
            $updateStmt = $pdo->prepare("UPDATE prenotazioni SET isRead = 1 WHERE id = ?");
            $updateStmt->execute([$prenotazione['id']]);

            echo "Email ADMIN NUOVO inviata per la prenotazione ID {$prenotazione['id']}.\n";
        } catch (Exception $e) {
            error_log("Errore nell'invio dell'email per la prenotazione ID {$prenotazione['id']}: " . $mail->ErrorInfo);
        }
    }
} catch (Exception $e) {
    error_log("Errore generale: " . $e->getMessage());
    echo "Errore: " . $e->getMessage() . "\n";
}
