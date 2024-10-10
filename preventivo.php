<?php require 'config/db.php';
// calcolo_preventivo.php

$pdo = Database::getDbInstance();
// Recupera i dati dalla query string
$category = $_GET['category'];
$service = $_GET['service'];
$duration = $_GET['duration'];

// Recupera il base_price dalla tabella categoria
$stmt = $pdo->prepare("SELECT base_price FROM categoria WHERE nome = :category");
$stmt->execute(['category' => $category]);
$base_price = $stmt->fetchColumn();

if (!$base_price) {
    echo "Categoria non trovata.";
    exit();
}

// Recupera i valori dalla tabella tariffario
$stmt = $pdo->query("SELECT photo, video, `photo&video`, one, two, three, custom FROM tariffario WHERE id = 1");
$tariffario = $stmt->fetch(PDO::FETCH_ASSOC);

// Calcola il preventivo
$service_price = 0;
switch ($service) {
    case 'photo':
        $service_price = $tariffario['photo'];
        break;
    case 'video':
        $service_price = $tariffario['video'];
        break;
    case 'photo&video':
        $service_price = $tariffario['photo&video'];
        break;
}

$duration_multiplier = 1; // Valore di default
if ($duration == '1') {
    $duration_multiplier = $tariffario['one'];
} elseif ($duration == '2') {
    $duration_multiplier = $tariffario['two'];
} elseif ($duration == '3') {
    $duration_multiplier = $tariffario['three'];
} elseif ($duration == 'custom') {
    $duration_multiplier = $tariffario['custom'];
}

// Calcolo finale
$preventivo = $base_price * $service_price * $duration_multiplier;

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Preventivo</title>
</head>

<body>
    <h1>Preventivo</h1>
    <p>Categoria: <?php echo htmlspecialchars($category); ?></p>
    <p>Servizio: <?php echo htmlspecialchars($service); ?></p>
    <p>Durata: <?php echo htmlspecialchars($duration); ?></p>
    <p>Preventivo totale: € <?php echo number_format($preventivo, 2); ?></p>
</body>

</html>