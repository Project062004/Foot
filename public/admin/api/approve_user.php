<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../src/Config/Database.php';

use App\Config\Database;

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? 0;

if ($id) {
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE id = :id");
    $stmt->execute(['id' => $id]);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
