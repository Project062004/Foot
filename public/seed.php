<?php
require_once __DIR__ . '/../src/Config/Database.php';
use App\Config\Database;

try {
    $db = new Database();
    $conn = $db->connect();

    // Read the SQL file
    $sql = file_get_contents(__DIR__ . '/../seed_colors.sql');

    // Execute
    $conn->exec($sql);

    echo "Database seeded successfully with new images and tiers!";
} catch (PDOException $e) {
    echo "Error seeding database: " . $e->getMessage();
}
