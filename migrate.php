<?php
require_once __DIR__ . '/src/Config/Database.php';
use App\Config\Database;

$db = new Database();
$conn = $db->connect();

$sql = file_get_contents(__DIR__ . '/database_setup.sql');
$sql .= "\n" . file_get_contents(__DIR__ . '/seed_colors.sql');

try {
    $conn->exec($sql);
    echo "Database setup completed successfully.\n";
} catch (PDOException $e) {
    echo "Error setting up database: " . $e->getMessage() . "\n";
}
