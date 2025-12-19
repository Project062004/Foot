<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../src/Config/Database.php';

use App\Config\Database;

$input = json_decode(file_get_contents('php://input'), true);
$token = $input['token'] ?? '';
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

if (!$token || !$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$db = new Database();
$conn = $db->connect();

// Verify Token
$stmt = $conn->prepare("SELECT * FROM password_resets WHERE email = :email AND token = :token ORDER BY created_at DESC LIMIT 1");
$stmt->execute(['email' => $email, 'token' => $token]);
$reset = $stmt->fetch();

if (!$reset) {
    echo json_encode(['success' => false, 'message' => 'Invalid or expired token']);
    exit;
}

// Update Password
$hash = password_hash($password, PASSWORD_DEFAULT);
$upd = $conn->prepare("UPDATE users SET password_hash = :hash WHERE email = :email");
if ($upd->execute(['hash' => $hash, 'email' => $email])) {
    // Delete used token
    $conn->prepare("DELETE FROM password_resets WHERE email = :email")->execute(['email' => $email]);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database update failed']);
}
?>