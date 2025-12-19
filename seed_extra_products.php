<?php
require_once __DIR__ . '/src/Config/Database.php';

use App\Config\Database;

$db = new Database();
$conn = $db->connect();

echo "Seeding extra products for sliders...\n";

// Get existing 3 products
$stmt = $conn->query("SELECT * FROM products LIMIT 3");
$baseProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($baseProducts)) {
    die("No base products found. Please run initial setup first.\n");
}

// We want total ~15 products to test sliders nicely
for ($i = 1; $i <= 5; $i++) {
    foreach ($baseProducts as $prod) {
        // Create duplicate product
        $newName = $prod['name'] . " V" . $i;
        $sql = "INSERT INTO products (name, category, description, price_retail, is_bestseller, is_new, discount_percent, specs) 
                VALUES (:name, :cat, :desc, :price, :best, :new, :disc, :specs)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'name' => $newName,
            'cat' => $prod['category'],
            'desc' => $prod['description'],
            'price' => $prod['price_retail'],
            'best' => $i % 2 == 0 ? 1 : 0, // Toggle bestseller
            'new' => $i % 2 != 0 ? 1 : 0,
            'disc' => $prod['discount_percent'],
            'specs' => $prod['specs']
        ]);

        $newId = $conn->lastInsertId();

        // Seed colors for this new product (using same logic as before)
        // We can just copy colors from the original product
        $cStmt = $conn->prepare("SELECT * FROM product_colors WHERE product_id = :pid");
        $cStmt->execute(['pid' => $prod['id']]);
        $colors = $cStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($colors as $color) {
            $ins = $conn->prepare("INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) 
                                   VALUES (:pid, :name, :hex, :url, :stock)");
            $ins->execute([
                'pid' => $newId,
                'name' => $color['color_name'],
                'hex' => $color['hex_code'],
                'url' => $color['image_url'],
                'stock' => 100
            ]);
        }

        echo "Created $newName\n";
    }
}

echo "Done seeding extra products.\n";
