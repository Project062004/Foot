<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../src/Config/Database.php';

use App\Config\Database;

$input = json_decode(file_get_contents('php://input'), true);

// Validation
if (!isset($input['name']) || !isset($input['category']) || !isset($input['price_retail']) || !isset($input['color_name']) || !isset($input['hex_code'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$db = new Database();
$conn = $db->connect();

try {
    $conn->beginTransaction();

    // 1. Insert Product
    $stmt = $conn->prepare("INSERT INTO products (name, category, description, price_retail, is_new, is_bestseller) VALUES (:name, :cat, :desc, :price, 1, 0)");
    $stmt->execute([
        'name' => $input['name'],
        'cat' => $input['category'],
        'desc' => $input['description'] ?? '',
        'price' => $input['price_retail']
    ]);
    $productId = $conn->lastInsertId();

    // 2. Insert Initial Color Variant (Required for product to be visible)
    $cStmt = $conn->prepare("INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES (:pid, :cname, :hex, :img, :stock)");
    $cStmt->execute([
        'pid' => $productId,
        'cname' => $input['color_name'],
        'hex' => $input['hex_code'],
        'img' => $input['image_url'] ?? 'https://via.placeholder.com/600',
        'stock' => 500 // Default stock
    ]);

    $conn->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    $conn->rollBack();
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
