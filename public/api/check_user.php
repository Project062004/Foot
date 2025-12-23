<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../src/Config/Database.php';
use App\Config\Database;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$mobile = $input['mobile'] ?? '';

if (!$mobile) {
    echo json_encode(['exists' => false]);
    exit;
}

try {
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare("SELECT id FROM users WHERE mobile = ?");
    $stmt->execute([$mobile]);

    echo json_encode(['exists' => (bool) $stmt->fetch()]);
} catch (Exception $e) {
    echo json_encode(['exists' => false, 'error' => $e->getMessage()]);
}
