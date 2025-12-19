<?php
namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private $host = 'localhost';
    private $db_name = 'wear_db';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // In production, log this error instead of echoing
            error_log("Connection Error: " . $e->getMessage());
            die("Database connection failed.");
        }

        return $this->conn;
    }
}
