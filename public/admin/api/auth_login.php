<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../src/Config/Database.php';

use App\Config\Database;

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Credentials required']);
    exit;
}

$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND account_type = 'admin'");
$stmt->execute(['email' => $email]);
$admin = $stmt->fetch();

if ($admin && password_verify($password, $admin['password_hash'])) {
    $_SESSION['user_id'] = $admin['id'];
    $_SESSION['role'] = 'admin';
    $_SESSION['name'] = $admin['first_name'];

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
}
