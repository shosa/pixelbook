<?php
require("../../config/config.php");
$pdo = Database::getInstance();

$table = $_GET['table'];
$details = json_decode($_GET['details'], true);

// Funzione per controllare e correggere una tabella
function checkAndCorrectTable($pdo, $table, $details) {
    $corrections = [];

    // Controlla se la tabella esiste
    $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
    if ($stmt->rowCount() === 0) {
        // Crea la tabella se non esiste
        createTable($pdo, $table, $details);
        $corrections[] = "Tabella `$table` creata.";
    } else {
        // Controlla e correggi le colonne
        $corrections = array_merge($corrections, checkAndCorrectColumns($pdo, $table, $details));
    }

    return [
        'message' => count($corrections) ? 'Correzioni effettuate.' : 'Struttura già corretta.',
        'corrections' => $corrections
    ];
}

// Funzione per creare una nuova tabella
function createTable($pdo, $table, $details) {
    $columns = [];
    foreach ($details['columns'] as $column => $definition) {
        $columns[] = "`$column` $definition";
    }
    $primaryKey = $details['primary_key'];
    $sql = "CREATE TABLE `$table` (" . implode(", ", $columns) . ", PRIMARY KEY (`$primaryKey`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $pdo->exec($sql);
}

// Funzione per verificare e correggere le colonne di una tabella esistente
function checkAndCorrectColumns($pdo, $table, $details) {
    $corrections = [];
    $existingColumns = [];
    
    // Ottieni le colonne esistenti nella tabella
    $stmt = $pdo->query("SHOW COLUMNS FROM `$table`");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $existingColumns[$row['Field']] = $row['Type'];
    }

    // Verifica la presenza di ogni colonna prevista
    foreach ($details['columns'] as $column => $definition) {
        if (!array_key_exists($column, $existingColumns)) {
            // Aggiungi la colonna se manca
            $pdo->exec("ALTER TABLE `$table` ADD `$column` $definition");
            $corrections[] = "Colonna `$column` aggiunta alla tabella `$table`.";
        }
    }

    // Verifica chiavi primarie, uniche e chiavi esterne
    if (isset($details['primary_key'])) {
        checkAndCorrectPrimaryKey($pdo, $table, $details['primary_key'], $corrections);
    }
    if (isset($details['foreign_keys'])) {
        checkAndCorrectForeignKeys($pdo, $table, $details['foreign_keys'], $corrections);
    }
    if (isset($details['unique_keys'])) {
        checkAndCorrectUniqueKeys($pdo, $table, $details['unique_keys'], $corrections);
    }

    return $corrections;
}

// Funzione per verificare e correggere la chiave primaria
function checkAndCorrectPrimaryKey($pdo, $table, $primaryKey, &$corrections) {
    // Verifica se esiste una chiave primaria
    $stmt = $pdo->query("SHOW INDEX FROM `$table` WHERE Key_name = 'PRIMARY'");
    $existingPrimaryKey = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingPrimaryKey || $existingPrimaryKey['Column_name'] !== $primaryKey) {
        // Elimina chiave primaria se diversa
        $pdo->exec("ALTER TABLE `$table` DROP PRIMARY KEY");
        // Imposta la nuova chiave primaria
        $pdo->exec("ALTER TABLE `$table` ADD PRIMARY KEY (`$primaryKey`)");
        $corrections[] = "Chiave primaria `$primaryKey` impostata per la tabella `$table`.";
    }
}

// Funzione per verificare e correggere le chiavi esterne
function checkAndCorrectForeignKeys($pdo, $table, $foreignKeys, &$corrections) {
    foreach ($foreignKeys as $column => $foreignKey) {
        $constraintName = "{$table}_{$column}_fk";
        
        // Verifica se la chiave esterna esiste
        $stmt = $pdo->prepare("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = ? AND COLUMN_NAME = ? AND CONSTRAINT_SCHEMA = DATABASE()");
        $stmt->execute([$table, $column]);
        $existingForeignKey = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existingForeignKey) {
            // Aggiunge la chiave esterna se mancante
            $pdo->exec("ALTER TABLE `$table` ADD CONSTRAINT `$constraintName` FOREIGN KEY (`$column`) REFERENCES `{$foreignKey['table']}` (`{$foreignKey['column']}`)");
            $corrections[] = "Chiave esterna aggiunta su `$column` riferita a `{$foreignKey['table']}`.`{$foreignKey['column']}`.";
        }
    }
}

// Funzione per verificare e correggere le chiavi uniche
function checkAndCorrectUniqueKeys($pdo, $table, $uniqueKeys, &$corrections) {
    foreach ($uniqueKeys as $uniqueKey) {
        $stmt = $pdo->prepare("SHOW INDEX FROM `$table` WHERE Key_name = ?");
        $stmt->execute([$uniqueKey]);
        $existingUniqueKey = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existingUniqueKey) {
            // Aggiunge la chiave unica se mancante
            $pdo->exec("ALTER TABLE `$table` ADD UNIQUE (`$uniqueKey`)");
            $corrections[] = "Chiave unica `$uniqueKey` aggiunta alla tabella `$table`.";
        }
    }
}

// Esegui la verifica e correzione per la tabella
$result = checkAndCorrectTable($pdo, $table, $details);
echo json_encode($result);
?>
