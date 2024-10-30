<?php
// Assicurati che la sessione sia avviata

// Tipi di alert: success, error, warning, info
$alertTypes = [
    'success' => 'alert-success',
    'error' => 'alert-danger',
    'warning' => 'alert-warning',
    'info' => 'alert-info'
];

// Mostra gli alert se le variabili di sessione sono impostate
foreach ($alertTypes as $key => $class) {
    if (isset($_SESSION[$key])) {
        echo '<div class="alert ' . $class . ' alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($_SESSION[$key]);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        // Rimuove il messaggio dalla sessione per evitare di visualizzarlo di nuovo
        unset($_SESSION[$key]);
    }
}
?>