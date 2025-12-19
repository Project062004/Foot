<?php
require_once __DIR__ . '/src/Config/Database.php';

use App\Config\Database;

$db = new Database();
$conn = $db->connect();

// Helper to get hex
function getHex($name)
{
    if (stripos($name, 'red') !== false)
        return '#EF4444';
    if (stripos($name, 'blue') !== false)
        return '#3B82F6';
    if (stripos($name, 'black') !== false)
        return '#111827';
    if (stripos($name, 'white') !== false)
        return '#F9FAFB';
    if (stripos($name, 'green') !== false)
        return '#10B981';
    if (stripos($name, 'pink') !== false)
        return '#EC4899';
    if (stripos($name, 'beige') !== false)
        return '#F5F5DC';
    if (stripos($name, 'brown') !== false)
        return '#92400E';
    return '#6B7280'; // Gray default
}

// 1. Array of Product Names to specific Pinterest Boards/Images
// Using high-quality fashion footwear images
$globalImages = [
    'https://i.pinimg.com/1200x/cf/84/62/cf846211edde03312ecfc36dc89747c1.jpg',
    'https://i.pinimg.com/1200x/6d/ae/65/6dae65a3e10973731bf889f145bba4b9.jpg',
    'https://i.pinimg.com/1200x/e8/e0/c2/e8e0c2eeb4a01257d513346f5ef818c8.jpg',
    'https://i.pinimg.com/1200x/33/e8/64/33e864fd9a5dfc5afddea68dcb45bceb.jpg',
    'https://i.pinimg.com/736x/cd/1c/15/cd1c150002fbe12f955fa318932f2deb.jpg',
    'https://i.pinimg.com/1200x/65/a4/d7/65a4d7a7323c31ede79ff17974d0feb0.jpg',
    'https://i.pinimg.com/1200x/df/75/5b/df755b70f839864e965e595fc462f032.jpg',
    'https://i.pinimg.com/1200x/46/57/65/46576503a6b3749b4e86dfb86ed47a51.jpg',
    'https://i.pinimg.com/1200x/8f/33/47/8f3347d0c15ffe9b80e622faa0e8d730.jpg',
    'https://i.pinimg.com/1200x/db/3b/7e/db3b7e5846df257ae5b79578b73e53fb.jpg',
    'https://i.pinimg.com/736x/05/6b/62/056b6279a31e5a5aba3f1c1dfa160a19.jpg'
];

echo "Seeding specific user images...\n";

// Use DELETE to respect FK constraints (Truncate fails if referenced)
$stmt = $conn->query("DELETE FROM product_colors");
$stmt->execute();
$conn->query("ALTER TABLE product_colors AUTO_INCREMENT = 1");

// Get Products
$prods = $conn->query("SELECT * FROM products")->fetchAll();

foreach ($prods as $prod) {
    $name = $prod['name'];

    // Use the global list for everyone
    $images = $globalImages;

    // Insert 6-8 variations acting as our image gallery
    $colorNames = ['Classic Brown', 'Midnight Black', 'Pearl White', 'Rose Gold', 'Taupe', 'Navy Blue', 'Olive', 'Crimson'];

    // Limit to 8 images max (User requested these specific images for everything)
    $imagesToInsert = array_slice($images, 0, 8);

    foreach ($imagesToInsert as $index => $url) {
        $cName = $colorNames[$index % count($colorNames)];
        $hex = getHex($cName);

        $sql = "INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES (:pid, :cname, :hex, :url, 100)";
        $iStmt = $conn->prepare($sql);
        $iStmt->execute([
            'pid' => $prod['id'],
            'cname' => $cName,
            'hex' => $hex,
            'url' => $url
        ]);
        echo "Inserted $cName for $name\n";
    }
}
echo "Done seeding detailed images.\n";