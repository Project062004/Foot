<?php
require_once __DIR__ . '/src/Config/Database.php';

use App\Config\Database;

$db = new Database();
$pdo = $db->connect();

// The user provided images
$images = [
    ['url' => 'https://i.pinimg.com/1200x/cf/84/62/cf846211edde03312ecfc36dc89747c1.jpg', 'color' => 'Classic Nude', 'hex' => '#E6C2B0'],
    ['url' => 'https://i.pinimg.com/1200x/6d/ae/65/6dae65a3e10973731bf889f145bba4b9.jpg', 'color' => 'Pure White', 'hex' => '#FFFFFF'],
    ['url' => 'https://i.pinimg.com/1200x/e8/e0/c2/e8e0c2eeb4a01257d513346f5ef818c8.jpg', 'color' => 'Midnight Black', 'hex' => '#000000'],
    ['url' => 'https://i.pinimg.com/1200x/33/e8/64/33e864fd9a5dfc5afddea68dcb45bceb.jpg', 'color' => 'Sandy Brown', 'hex' => '#F4A460'],
    ['url' => 'https://i.pinimg.com/736x/cd/1c/15/cd1c150002fbe12f955fa318932f2deb.jpg', 'color' => 'Cream Beige', 'hex' => '#F5F5DC'],
    ['url' => 'https://i.pinimg.com/1200x/65/a4/d7/65a4d7a7323c31ede79ff17974d0feb0.jpg', 'color' => 'Coffee Brown', 'hex' => '#8B4513'],
    ['url' => 'https://i.pinimg.com/1200x/df/75/5b/df755b70f839864e965e595fc462f032.jpg', 'color' => 'Obsidian', 'hex' => '#1A1A1A'],
    ['url' => 'https://i.pinimg.com/1200x/46/57/65/46576503a6b3749b4e86dfb86ed47a51.jpg', 'color' => 'Soft Pink', 'hex' => '#FFD1DC'],
    ['url' => 'https://i.pinimg.com/1200x/8f/33/47/8f3347d0c15ffe9b80e622faa0e8d730.jpg', 'color' => 'Scarlet Red', 'hex' => '#FF2400'],
    ['url' => 'https://i.pinimg.com/1200x/db/3b/7e/db3b7e5846df257ae5b79578b73e53fb.jpg', 'color' => 'Bronze', 'hex' => '#CD7F32'],
    ['url' => 'https://i.pinimg.com/736x/05/6b/62/056b6279a31e5a5aba3f1c1dfa160a19.jpg', 'color' => 'Olive Chic', 'hex' => '#808000']
];

try {
    // 1. Clear existing product_colors
    echo "Clearing existing product_colors...\n";
    $pdo->exec("DELETE FROM product_colors");

    // DDL statement - implicit commit
    $pdo->exec("ALTER TABLE product_colors AUTO_INCREMENT = 1");

    // Start transaction for inserts
    $pdo->beginTransaction();

    // 2. Get all products
    $stmt = $pdo->query("SELECT id, name FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Found " . count($products) . " products.\n";

    $imageIndex = 0;

    foreach ($products as $product) {
        $productId = $product['id'];
        echo "Updating Product: " . $product['name'] . " (ID: $productId)\n";

        // REQ: Maximum 5 images per product
        $numVariations = rand(3, 5);

        for ($i = 0; $i < $numVariations; $i++) {
            // Get current image details using modulo to wrap around
            $imgData = $images[$imageIndex % count($images)];

            // Insert into product_colors
            $ins = $pdo->prepare("INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES (?, ?, ?, ?, ?)");
            $ins->execute([
                $productId,
                $imgData['color'],
                $imgData['hex'],
                $imgData['url'],
                rand(50, 200)
            ]);

            $imageIndex++;
        }
    }

    $pdo->commit();
    echo "Successfully updated all product images using the provided list!\n";

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "PDO Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
}
