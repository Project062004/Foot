<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/../../src/Config/Database.php';
use App\Config\Database;

$input = json_decode(file_get_contents('php://input'), true);
$method = $input['method'] ?? 'mobile';

$db = new Database();
$conn = $db->connect();

try {
    $user = null;

    if ($method === 'email') {
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            echo json_encode(['success' => false, 'error' => 'Invalid email or password.']);
            exit;
        }

    } else {
        // Mobile flow
        $mobile = $input['mobile'] ?? '';
        // Mock ID Token Check
        $isMock = ($input['id_token'] ?? '') === 'mock_id_token_12345';

        // In real app verify valid token for phone

        $stmt = $conn->prepare("SELECT * FROM users WHERE mobile = :mobile");
        $stmt->execute(['mobile' => $mobile]);
        $user = $stmt->fetch();

        if (!$user) {
            echo json_encode(['success' => false, 'error' => 'User not found. Please register first.']);
            exit;
        }
    }

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['first_name'];
        $_SESSION['account_type'] = $user['account_type'];

        // Redirect logic
        $redirect = ($input['redirect'] ?? '') === 'checkout' ? '/checkout.php' : '/profile.php';

        echo json_encode(['success' => true, 'redirect' => $redirect]);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
