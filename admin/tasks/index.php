<?php

// Calcola il percorso assoluto della directory corrente
define('BASE_PATH', __DIR__);

// Includi i file richiesti utilizzando percorsi assoluti
require(BASE_PATH . "/../config/config_no_auth.php");
require(BASE_PATH . "/../vendor/autoload.php");

// Configura la gestione degli errori (opzionale)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Non mostrare gli errori direttamente al client
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/tasks_error.log');

// Funzione per stampare messaggi formattati
function logMessage($message, $type = 'info') {
    // Ottieni il timestamp
    $timestamp = date('Y-m-d H:i:s');

    // Aggiungi il tipo di messaggio (info, success, error)
    switch ($type) {
        case 'success':
            $color = "\033[32m"; // Verde
            $label = "[SUCCESS]";
            break;
        case 'error':
            $color = "\033[31m"; // Rosso
            $label = "[ERROR]";
            break;
        default:
            $color = "\033[34m"; // Blu
            $label = "[INFO]";
            break;
    }

    // Formatta il messaggio con il timestamp e tipo
    echo $color . "[{$timestamp}] {$label} {$message}\033[0m\n";
}

// Ottieni tutti i file PHP nella cartella 'tasks'
$taskFiles = glob(__DIR__ . '/*.php');
$pdo = Database::getInstance();

// Cicla attraverso ogni file e includilo per eseguire il task
foreach ($taskFiles as $taskFile) {
    // Evita di eseguire 'index.php' stesso
    if (basename($taskFile) != 'index.php') {
        try {
            logMessage("Esecuzione task: " . basename($taskFile), 'info'); // Log inizio task

            include($taskFile); // Include ed esegue il task

            logMessage("Task completato: " . basename($taskFile), 'success'); // Log completamento task
        } catch (Exception $e) {
            logMessage("Errore nell'esecuzione del task {$taskFile}: " . $e->getMessage(), 'error'); // Log errore
        }
    }
}

?>
