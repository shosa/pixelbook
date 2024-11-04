<?php
require("../../config/config.php");

$pdo = Database::getInstance();
$response = ["status" => "error", "message" => "Invalid action"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'];
    $table = $_POST['table'];
    $id = $_POST['id'] ?? null;
    $data = $_POST['data'] ?? [];

    try {
        switch ($action) {
            case 'retrieve':
                $stmt = $pdo->prepare("SELECT * FROM `$table`");
                $stmt->execute();
                $response = ["status" => "success", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)];
                break;

            case 'update':
                if ($id && !empty($data)) {
                    $setPart = implode(", ", array_map(fn($key) => "`$key` = :$key", array_keys($data)));
                    $data['id'] = $id; // aggiungi l'ID per la clausola WHERE
                    $stmt = $pdo->prepare("UPDATE `$table` SET $setPart WHERE `id` = :id");
                    $stmt->execute($data);
                    $response = ["status" => "success", "message" => "Record updated"];
                } else {
                    $response = ["status" => "error", "message" => "Invalid data for update"];
                }
                break;

            case 'delete':
                if ($id) {
                    $stmt = $pdo->prepare("DELETE FROM `$table` WHERE `id` = :id");
                    $stmt->execute(['id' => $id]);
                    $response = ["status" => "success", "message" => "Record deleted"];
                } else {
                    $response = ["status" => "error", "message" => "Invalid ID for delete"];
                }
                break;

            default:
                $response = ["status" => "error", "message" => "Unknown action"];
        }
    } catch (Exception $e) {
        $response = ["status" => "error", "message" => $e->getMessage()];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
