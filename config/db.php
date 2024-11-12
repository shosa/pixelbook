<?php
// db.php
class Database
{
    private static $instance = null;
    private $pdo;

    private $host = 'localhost';      // Il tuo host
    private $db = 'my_PixelBook';    // Nome del tuo database
    private $user = 'root';       // Username del database
    private $pass = '';       // Password del database
    private $charset = 'utf8mb4';     // Charset da usare

    private function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}

define('BASE_PATH', dirname(__DIR__));
// Determina la tua cartella app in modo statico
define('APP_FOLDER', '');
// URL base dell'app
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . APP_FOLDER;
define('BASE_URL', $base_url);
// Define the URL of the dominio
$dominio = BASE_URL;