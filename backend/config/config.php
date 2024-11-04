<?php

require("url.php");
require("db.php");

session_start();

// Funzione per controllare l'autenticazione
function checkAuthentication() {
    // Controlla se il nome della pagina è login.php o login
    $currentPage = basename($_SERVER['PHP_SELF'], ".php");
    if ($currentPage === "login") {
        return; // Salta il controllo se siamo su login.php o login
    }

    // Se l'utente non è loggato nella sessione e non ci sono cookie, reindirizza a login
    if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])) {
        header("Location: " . BASE_URL . "/login");
        exit();
    }

    // Se ci sono i cookie, imposta la sessione
    if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['user_email'] = $_COOKIE['user_email'];
    }
}

// Esegui il controllo di autenticazione su tutte le pagine tranne login
checkAuthentication();
