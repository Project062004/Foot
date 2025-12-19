<?php
require_once __DIR__ . '/src/Config/Database.php';
use App\Config\Database;
$db = new Database();
$conn = $db->connect();
$products = $conn->query("SELECT id, name, specs FROM products")->fetchAll(PDO::FETCH_ASSOC);
print_r($products);
