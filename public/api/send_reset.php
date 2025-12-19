<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../src/Config/Database.php';

use App\Config\Database;

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

$db = new Database();
$conn = $db->connect();

// Check if user exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
if (!$stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Email not found']);
    exit;
}

// Generate Token
$token = bin2hex(random_bytes(32));

// Store Token
$stmt = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (:email, :token)");
$stmt->execute(['email' => $email, 'token' => $token]);

// Mock Email Sending behavior
// We return the link in the response so the frontend can display it in an alert
$link = "/reset_password.php?token=" . $token . "&email=" . urlencode($email);

echo json_encode([
    'success' => true,
    'message' => 'Reset link sent',
    'mock_link' => $link
]);
?>