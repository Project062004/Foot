<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../src/Config/Database.php';

use App\Config\Database;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['index']) || !isset($_SESSION['cart'][$input['index']])) {
    echo json_encode(['success' => false, 'error' => 'Item not found']);
    exit;
}

try {
    // We are REPLACING the item at $index with new logic similar to cart.php add
    // Ideally we share code but for speed we duplicate the pricing logic

    $index = $input['index'];

    $db = new Database();
    $conn = $db->connect();

    // Fetch product details
    $stmt = $conn->prepare("SELECT name, price_retail, category FROM products WHERE id = ?");
    $stmt->execute([$input['product_id']]);
    $product = $stmt->fetch();
    if (!$product)
        throw new Exception("Product not found");

    $item = [
        'id' => $_SESSION['cart'][$index]['id'], // Keep ID
        'product_id' => $input['product_id'],
        'name' => $product['name'],
        'type' => $input['type'],
        'timestamp' => time()
    ];

    if ($input['type'] === 'retail') {
        $item['color_id'] = $input['color_id'];
        $item['size'] = $input['size'];
        $item['quantity'] = (int) $input['quantity'];

        $item['packaging'] = $input['packaging'] ?? 'box';
        $item['packaging_cost'] = ($item['packaging'] === 'box') ? 9 : 0;

        $item['price'] = $product['price_retail'] + $item['packaging_cost'];

        $cStmt = $conn->prepare("SELECT color_name, image_url, hex_code FROM product_colors WHERE id = ?");
        $cStmt->execute([$input['color_id']]);
        $colorData = $cStmt->fetch();
        $item['color_name'] = $colorData['color_name'];
        $item['image'] = $colorData['image_url'];
        $item['hex'] = $colorData['hex_code'];

    } elseif ($input['type'] === 'wholesale') {
        $item['total_quantity'] = (int) $input['total_quantity'];
        $item['breakdown'] = $input['breakdown'] ?? [];
        $item['colors'] = array_values(array_unique(array_column($item['breakdown'], 'color_id')));

        if (!empty($item['colors'])) {
            $placeholders = str_repeat('?,', count($item['colors']) - 1) . '?';
            $cStmt = $conn->prepare("SELECT id, color_name FROM product_colors WHERE id IN ($placeholders)");
            $cStmt->execute($item['colors']);
            $colorMap = $cStmt->fetchAll(PDO::FETCH_KEY_PAIR);
            foreach ($item['breakdown'] as &$bItem) {
                $bItem['color_name'] = $colorMap[$bItem['color_id']] ?? 'Unknown';
            }
        }

        $item['packaging'] = $input['packaging'] ?? 'box';

        // Price Logic
        $qty = $item['total_quantity'];
        $pricePerPair = 650;
        $tStmt = $conn->prepare("SELECT * FROM wholesale_tiers ORDER BY min_pairs ASC");
        $tStmt->execute();
        $tiers = $tStmt->fetchAll();
        foreach ($tiers as $tier) {
            if ($qty >= $tier['min_pairs']) {
                $pricePerPair = $tier['price_per_pair'];
            }
        }

        $item['price_per_pair'] = $pricePerPair;
        $item['packaging_cost'] = ($item['packaging'] === 'box') ? 9 : 0;
        $item['total_price'] = $qty * ($item['price_per_pair'] + $item['packaging_cost']);

        if (count($item['colors']) > 0) {
            $cStmt = $conn->prepare("SELECT image_url FROM product_colors WHERE id = ?");
            $cStmt->execute([$item['colors'][0]]);
            $item['image'] = $cStmt->fetchColumn();
        }
    }

    // Replace
    $_SESSION['cart'][$index] = $item;
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
