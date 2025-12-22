<?php
require_once __DIR__ . '/src/Config/Database.php';

use App\Config\Database;

$db = new Database();
$pdo = $db->connect();

try {
    $stmt = $pdo->query("SELECT p.name, pc.color_name, pc.image_url FROM product_colors pc JOIN products p ON pc.product_id = p.id LIMIT 5");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Verification Results:\n";
    foreach ($results as $row) {
        echo "Product: " . $row['name'] . " | Color: " . $row['color_name'] . " | Image: " . $row['image_url'] . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
