<?php
require_once __DIR__ . '/src/Config/Database.php';

use App\Config\Database;

$db = new Database();
$conn = $db->connect();

echo "Updating database schema for Product Details and Reviews...\n";

// 1. Add 'specs' column to products if not exists
// A simple text field to store JSON: {"Material": "Leather", "Occasion": "Formal", ...}
try {
    $conn->query("ALTER TABLE products ADD COLUMN specs TEXT DEFAULT NULL");
    echo "Added 'specs' column to products.\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column') !== false) {
        echo "'specs' column already exists.\n";
    } else {
        echo "Error adding column: " . $e->getMessage() . "\n";
    }
}

// 2. Create Reviews Table
$sql = "CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_name VARCHAR(50) NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
)";
$conn->exec($sql);
echo "Created 'reviews' table.\n";

// 3. Seed Product Specs
$specs = [
    'Ultra Glide Reader' => json_encode([
        'Material' => 'Mesh & Synthetic',
        'Sole Material' => 'EVA',
        'Closure' => 'Lace-Up',
        'Occasion' => 'Sports',
        'Weight' => '250g (approx)'
    ]),
    'Urban Casual' => json_encode([
        'Material' => 'Canvas',
        'Sole Material' => 'Rubber',
        'Closure' => 'Slip-On',
        'Occasion' => 'Casual',
        'Fit' => 'Regular'
    ]),
    'Elegant Heels' => json_encode([
        'Material' => 'Synthetic Leather',
        'Sole Material' => 'Resin Sheet',
        'Heel Height' => '3 inches',
        'Heel Type' => 'Block Heel',
        'Occasion' => 'Party'
    ])
];

foreach ($specs as $name => $specJson) {
    $stmt = $conn->prepare("UPDATE products SET specs = :specs WHERE name = :name");
    $stmt->execute(['specs' => $specJson, 'name' => $name]);
}
echo "Seeded product specs.\n";

// 4. Seed Reviews
$conn->exec("DELETE FROM reviews"); // Clear old seeds
$conn->exec("ALTER TABLE reviews AUTO_INCREMENT = 1");

$reviewsData = [
    'Ultra Glide Reader' => [
        ['user' => 'Rahul K.', 'rating' => 5, 'comment' => 'Extremely comfortable for my morning runs.'],
        ['user' => 'Amit S.', 'rating' => 4, 'comment' => 'Good grip, but size runs a bit small.'],
        ['user' => 'Priya M.', 'rating' => 5, 'comment' => 'Loved the color and cushion.']
    ],
    'Urban Casual' => [
        ['user' => 'Sneha D.', 'rating' => 4, 'comment' => 'Very stylish and goes with everything.'],
        ['user' => 'Vikram R.', 'rating' => 3, 'comment' => 'Decent for the price, but could be softer.']
    ],
    'Elegant Heels' => [
        ['user' => 'Anjali P.', 'rating' => 5, 'comment' => 'Perfect heel height, danced all night!'],
        ['user' => 'Kavita S.', 'rating' => 5, 'comment' => 'Looks very premium. Highly recommend.']
    ]
];

$stmt = $conn->prepare("SELECT id, name FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // id => name? No, fetchAll logic varies. safely:

$products = $conn->query("SELECT name, id FROM products")->fetchAll(PDO::FETCH_KEY_PAIR);

foreach ($reviewsData as $pName => $reviews) {
    if (!isset($products[$pName]))
        continue;
    $pid = $products[$pName];

    foreach ($reviews as $rev) {
        $rStmt = $conn->prepare("INSERT INTO reviews (product_id, user_name, rating, comment) VALUES (:pid, :user, :rating, :comment)");
        $rStmt->execute([
            'pid' => $pid,
            'user' => $rev['user'],
            'rating' => $rev['rating'],
            'comment' => $rev['comment']
        ]);
    }
}
echo "Seeded reviews.\n";

?>