<?php
session_start();
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? '';
$productId = $input['product_id'] ?? 0;

if (!$productId) {
    echo json_encode(['success' => false, 'message' => 'Invalid Product']);
    exit;
}

if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

if ($action === 'toggle') {
    if (in_array($productId, $_SESSION['wishlist'])) {
        // Remove
        $_SESSION['wishlist'] = array_diff($_SESSION['wishlist'], [$productId]);
        echo json_encode(['success' => true, 'status' => 'removed']);
    } else {
        // Add
        $_SESSION['wishlist'][] = $productId;
        echo json_encode(['success' => true, 'status' => 'added']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Action']);
}
