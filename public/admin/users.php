<?php
require_once __DIR__ . '/../../src/Config/Database.php';
use App\Config\Database;

$db = new Database();
$conn = $db->connect();

// Fetch pending users
$stmt = $conn->prepare("SELECT * FROM users WHERE account_type = 'wholesale' AND is_verified = 0"); // Using is_verified as approval flag for now
$stmt->execute();
$users = $stmt->fetchAll();
?>
<!-- Reuse Admin Layout Header or include it (simple inline for now) -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Wholesale Approvals</h1>

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                <?php foreach ($users as $user): ?>
                    <li>
                        <div class="px-4 py-4 sm:px-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-indigo-600 truncate">
                                    <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></p>
                                <p class="text-sm text-gray-500">GST: <?= htmlspecialchars($user['gst_number']) ?></p>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($user['email']) ?> |
                                    <?= htmlspecialchars($user['mobile']) ?></p>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="approveUser(<?= $user['id'] ?>)"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none">
                                    Approve
                                </button>
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                                    Reject
                                </button>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($users)): ?>
                    <li class="px-4 py-4 text-gray-500 text-center">No pending approvals.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <script>
        function approveUser(id) {
            fetch('/admin/api/approve_user.php', {
                method: 'POST',
                body: JSON.stringify({ id: id }),
                headers: { 'Content-Type': 'application/json' }
            }).then(() => window.location.reload());
        }
    </script>
</body>

</html>