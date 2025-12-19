<?php
require_once __DIR__ . '/../../src/Config/Database.php';
use App\Config\Database;

$id = $_GET['id'] ?? 0;
if (!$id)
    die("Invalid Product");

$db = new Database();
$conn = $db->connect();

// Fetch Product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

// Fetch Colors
$cStmt = $conn->prepare("SELECT * FROM product_colors WHERE product_id = ?");
$cStmt->execute([$id]);
$colors = $cStmt->fetchAll();

// In a real app, we would have a 'product_variants' table for Size x Color specific stock
// For this MVP schema, we have 'stock_quantity' in 'product_colors' which represents TOTAL pairs for that color
// The detailed Matrix (Size 7-11 per Color) is calculated dynamically in Wholesale Logic
// But let's assume valid "Stock" management just updates the total `stock_quantity` per color.

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Product - Matrix</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Inventory Matrix: <?= htmlspecialchars($product['name']) ?></h1>

        <form method="POST" action="/admin/api/update_inventory.php">
            <input type="hidden" name="product_id" value="<?= $id ?>">

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Color</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Image URL</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Stock (Pairs)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($colors as $color): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full border border-gray-200 mr-2"
                                            style="background-color: <?= $color['hex_code'] ?>"></div>
                                        <span
                                            class="text-sm font-medium text-gray-900"><?= htmlspecialchars($color['color_name']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <input type="text" name="colors[<?= $color['id'] ?>][image]"
                                        value="<?= htmlspecialchars($color['image_url']) ?>"
                                        class="border border-gray-300 rounded px-2 py-1 w-full">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <input type="number" name="colors[<?= $color['id'] ?>][stock]"
                                        value="<?= $color['stock_quantity'] ?>"
                                        class="border border-gray-300 rounded px-2 py-1 w-24">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Update detailed sizes</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Save
                    Changes</button>
            </div>
        </form>
    </div>
</body>

</html>