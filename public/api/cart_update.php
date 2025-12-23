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

$index = $input['index'];
$item = &$_SESSION['cart'][$index];
$action = $input['action'] ?? 'update'; // 'update', 'inc', 'dec'

try {
    $db = new Database();
    $conn = $db->connect();

    // Handling Wholesale Breakdown Update
    if ($item['type'] === 'wholesale' && isset($input['sub_index'])) {
        $subIndex = $input['sub_index'];
        if (isset($item['breakdown'][$subIndex])) {

            // Update Quantity
            $currentQty = $item['breakdown'][$subIndex]['quantity'];
            $newQty = $currentQty;

            if ($action === 'inc') {
                $newQty++;
            } elseif ($action === 'dec') {
                $newQty--;
            } elseif (isset($input['quantity'])) {
                $newQty = (int) $input['quantity'];
            }

            // Prevent negative or zero if deemed invalid?
            // For wholesale, we probably want at least 0? If 0, remove line? 
            if ($newQty <= 0) {
                // Remove this line from breakdown
                array_splice($item['breakdown'], $subIndex, 1);
            } else {
                $item['breakdown'][$subIndex]['quantity'] = $newQty;
            }

            // Recalculate Totals
            $totalQty = 0;
            $colors = [];
            foreach ($item['breakdown'] as $b) {
                $totalQty += $b['quantity'];
                $colors[] = $b['color_id'];
            }

            // If empty breakdown, remove item?
            if ($totalQty == 0) {
                unset($_SESSION['cart'][$index]);
                $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex
                echo json_encode(['success' => true, 'removed' => true]);
                exit;
            }

            $item['total_quantity'] = $totalQty;
            $item['colors'] = array_values(array_unique($colors));

            // Recalculate Tier Price
            $pricePerPair = 650; // Default
            $tStmt = $conn->prepare("SELECT * FROM wholesale_tiers ORDER BY min_pairs ASC");
            $tStmt->execute();
            $tiers = $tStmt->fetchAll();
            foreach ($tiers as $tier) {
                if ($totalQty >= $tier['min_pairs']) {
                    $pricePerPair = $tier['price_per_pair'];
                }
            }

            $item['price_per_pair'] = $pricePerPair;
            $packagingCost = $item['packaging_cost'] ?? 0;
            // Packaging cost is per pair or flat? Previous logic: total_price = qty * (pair + padding)
            // Wait, previous logic: $item['packaging_cost'] = ($item['packaging'] === 'box') ? 10 : 0;
            // $item['total_price'] = $qty * ($item['price_per_pair'] + $item['packaging_cost']);

            // If packaging cost was store as "10" (unit cost), then calculation is correct.
            $item['total_price'] = $totalQty * ($pricePerPair + $packagingCost);
        }
    }
    // Handling Retail Update
    elseif ($item['type'] !== 'wholesale') {
        $newQty = $item['quantity'];
        if ($action === 'inc')
            $newQty++;
        if ($action === 'dec')
            $newQty--;
        if (isset($input['quantity']))
            $newQty = (int) $input['quantity'];

        if ($newQty <= 0) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            echo json_encode(['success' => true, 'removed' => true]);
            exit;
        }

        $item['quantity'] = $newQty;
    }

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
