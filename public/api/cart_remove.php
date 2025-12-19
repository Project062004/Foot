<?php
session_start();
$input = json_decode(file_get_contents('php://input'), true);
if (isset($input['index']) && isset($_SESSION['cart'][$input['index']])) {
    unset($_SESSION['cart'][$input['index']]);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
