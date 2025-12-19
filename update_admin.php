<?php
require_once __DIR__ . '/src/Config/Database.php';

use App\Config\Database;

$db = new Database();
$conn = $db->connect();

try {
    // 1. Update ENUM to include 'admin'
    // Note: In MySQL, to add a value to an ENUM, you redefine the column.
    $sql = "ALTER TABLE users MODIFY COLUMN account_type ENUM('retail', 'wholesale', 'admin') DEFAULT 'retail'";
    $conn->exec($sql);
    echo "Table schema updated successfully.<br>";

    // 2. Clear existing admin if exists to simple reset
    $conn->exec("DELETE FROM users WHERE email = 'admin@wear.com'");

    // 3. Seed Admin User
    // Use a simple hash for 'admin123'
    $password = password_hash('admin123', PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, mobile, email, password_hash, account_type, is_verified) VALUES (:fn, :ln, :mob, :email, :pass, :type, 1)");

    $stmt->execute([
        'fn' => 'System',
        'ln' => 'Admin',
        'mob' => '+910000000000', // Dummy mobile for admin
        'email' => 'admin@wear.com',
        'pass' => $password,
        'type' => 'admin'
    ]);

    echo "Admin User Created:<br>";
    echo "Email: <b>admin@wear.com</b><br>";
    echo "Password: <b>admin123</b><br>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>