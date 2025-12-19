<?php
require_once __DIR__ . '/../../src/Config/Database.php';
use App\Config\Database;

$db = new Database();
$conn = $db->connect();

$stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Product Management</h1>
            <a href="/admin/product_add.php" class="bg-blue-600 text-white px-4 py-2 rounded">Add New Product</a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                <?php foreach ($products as $product): ?>
                    <li>
                        <a href="/admin/product_edit.php?id=<?= $product['id'] ?>" class="block hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6 flex items-center justify-between">
                                <div class="flex items-center">
                                    <p class="text-sm font-medium text-indigo-600 truncate w-40">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </p>
                                    <div class="ml-4 flex-shrink-0">
                                        <p
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <?= htmlspecialchars($product['category']) ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <span class="mr-4">Price: ₹<?= $product['price_retail'] ?></span>
                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>

</html>