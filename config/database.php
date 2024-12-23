<?php
include_once __DIR__ . "/../helper.php";

class Database {
    private $conn;


    public function newConnection() {
        $this->conn = null;

        try {
            $host = getenv('DB_HOST');
            $dbName = getenv('DB_NAME');
            $username = getenv('DB_USER');
            $password = getenv('DB_PASS');

            if ($host == null || $dbName == null || $username === false) {
                jsonErrorResponse(500, "Database configuration error", [
                    "hint" => "Admin must check environment variables"
                ]);
            }

            $this->conn = new PDO(
                "mysql:host=$host;dbname=$dbName",
                $username,
                $password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            jsonErrorResponse(500, "Database connection error", ["error" => $e->getMessage()]);
        }
        return $this->conn;
    }

    public function __construct() {
        $this->newConnection();
    }

    public function __destruct() {
        $this->conn = null;
    }

    public function getConnection() {
        return $this->conn;
    }
}
$database = new Database();
?>