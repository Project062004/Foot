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

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Logic to add to session cart
// Structure:
// Retail: { type: 'retail', product_id, color_id, size, quantity: 1 }
// Wholesale: { type: 'wholesale', product_id, total_quantity, colors: [id, id], packaging: 'box' }
// Sample: { type: 'sample', product_id, color_id, size, quantity: 1 }

try {
    // Basic validation
    if (!isset($input['product_id']) || !isset($input['type'])) {
        throw new Exception("Invalid Data");
    }

    // Fetch product details for name/price cache
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare("SELECT name, price_retail, category FROM products WHERE id = ?");
    $stmt->execute([$input['product_id']]);
    $product = $stmt->fetch();

    if (!$product)
        throw new Exception("Product not found");

    $item = [
        'id' => uniqid(), // unique cart item id
        'product_id' => $input['product_id'],
        'name' => $product['name'],
        'type' => $input['type'],
        'timestamp' => time()
    ];

    if ($input['type'] === 'retail') {
        $item['color_id'] = $input['color_id'];
        $item['size'] = $input['size'];
        $item['quantity'] = 1;
        $item['price'] = $product['price_retail'];
        // Fetch Color Name
        $cStmt = $conn->prepare("SELECT color_name, image_url, hex_code FROM product_colors WHERE id = ?");
        $cStmt->execute([$input['color_id']]);
        $colorData = $cStmt->fetch();
        $item['color_name'] = $colorData['color_name'];
        $item['image'] = $colorData['image_url'];
        $item['hex'] = $colorData['hex_code'];

    } elseif ($input['type'] === 'wholesale') {
        // Advanced wholesale structure
        $item['total_quantity'] = (int) $input['total_quantity'];
        $item['colors'] = $input['colors']; // array of color IDs
        $item['packaging'] = $input['packaging'];

        // Calculate Price based on Tier
        // We know tiers from DB logic but need to replicate or fetch
        // Min Pairs logic
        $qty = $item['total_quantity'];
        $pricePerPair = 650; // Default fallback

        $tStmt = $conn->prepare("SELECT * FROM wholesale_tiers ORDER BY min_pairs ASC");
        $tStmt->execute();
        $tiers = $tStmt->fetchAll();
        foreach ($tiers as $tier) {
            if ($qty >= $tier['min_pairs']) {
                $pricePerPair = $tier['price_per_pair'];
            }
        }

        $item['price_per_pair'] = $pricePerPair;
        $item['packaging_cost'] = ($item['packaging'] === 'box') ? 10 : 0;
        $item['total_price'] = $qty * ($item['price_per_pair'] + $item['packaging_cost']);

        // Fetch Image of first color
        if (count($item['colors']) > 0) {
            $cStmt = $conn->prepare("SELECT image_url FROM product_colors WHERE id = ?");
            $cStmt->execute([$item['colors'][0]]);
            $item['image'] = $cStmt->fetchColumn();
        }

    } elseif ($input['type'] === 'sample') {
        $item['color_id'] = $input['color_id'];
        $item['size'] = $input['size'];
        $item['quantity'] = 1;
        $item['price'] = $product['price_retail'] * 0.8; // 20% Discount
        // Fetch Color Name
        $cStmt = $conn->prepare("SELECT color_name, image_url FROM product_colors WHERE id = ?");
        $cStmt->execute([$input['color_id']]);
        $colorData = $cStmt->fetch();
        $item['color_name'] = $colorData['color_name'];
        $item['image'] = $colorData['image_url'];
    }

    $_SESSION['cart'][] = $item;

    echo json_encode(['success' => true, 'count' => count($_SESSION['cart'])]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
