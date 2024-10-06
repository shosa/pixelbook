<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service = $_POST['service'];
    $time_of_day = $_POST['time_of_day'];
    $duration = $_POST['duration'];

    // Se la durata è personalizzata, prendi il valore custom_duration
    if ($duration === 'Custom') {
        $duration = $_POST['custom_duration'] . ' Ore';
    }

    $date = $_POST['date'];
    $flexible_date = isset($_POST['flexible_date']) ? 'Yes' : 'No';

    // Ora puoi utilizzare questi dati come preferisci
    echo "Service: $service, Time of Day: $time_of_day, Duration: $duration, Date: $date, Flexible: $flexible_date";
} ?>