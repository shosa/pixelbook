<?php
// db.php
class Database
{
    private static $instance = null;
    private static $dbInstance = null;
    private $pdo;

    private $host = 'localhost';      // Il tuo host
    public $db = 'my_pixelbook';    // Nome del tuo database
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

    // Per chi usa solo PDO
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }

    // Per accedere all'intera classe Database
    public static function getDatabaseInstance()
    {
        if (self::$dbInstance === null) {
            self::$dbInstance = new Database();
        }
        return self::$dbInstance;
    }

    public function verifyUser($email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    public function getUserByPin($pin)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE pin = :pin LIMIT 1");
        $stmt->execute(['pin' => $pin]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}