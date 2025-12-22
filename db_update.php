<?php
require_once __DIR__ . '/src/Config/Database.php';

use App\Config\Database;

try {
    $db = new Database();
    $conn = $db->connect();
    // Check if column exists first to avoid error
    $check = $conn->query("SHOW COLUMNS FROM products LIKE 'sale_mode'");
    if ($check->rowCount() == 0) {
        $conn->exec("ALTER TABLE products ADD COLUMN sale_mode ENUM('retail', 'wholesale', 'both') DEFAULT 'both' AFTER category");
        echo "Successfully added 'sale_mode' column to products table.\n";
    } else {
        echo "'sale_mode' column already exists.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>