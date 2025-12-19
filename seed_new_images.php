<?php
require_once __DIR__ . '/src/Config/Database.php';

use App\Config\Database;

$db = new Database();
$pdo = $db->connect();

$sql = "
USE wear_db;

-- Clear existing colors to avoid duplicates/mess
DELETE FROM product_colors;

-- Reset Auto Increment
ALTER TABLE product_colors AUTO_INCREMENT = 1;

-- Product 1: Ultra Glide Reader (Sports)
INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES 
(1, 'Crimson Red', '#DC143C', 'https://i.pinimg.com/1200x/cf/84/62/cf846211edde03312ecfc36dc89747c1.jpg', 100),
(1, 'Arctic White', '#F0F8FF', 'https://i.pinimg.com/1200x/6d/ae/65/6dae65a3e10973731bf889f145bba4b9.jpg', 100),
(1, 'Midnight Black', '#000000', 'https://i.pinimg.com/1200x/e8/e0/c2/e8e0c2eeb4a01257d513346f5ef818c8.jpg', 100);

-- Product 2: Urban Casual (Casual)
INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES 
(2, 'Sandy Tan', '#D2B48C', 'https://i.pinimg.com/1200x/33/e8/64/33e864fd9a5dfc5afddea68dcb45bceb.jpg', 150),
(2, 'Classic Beige', '#F5F5DC', 'https://i.pinimg.com/736x/cd/1c/15/cd1c150002fbe12f955fa318932f2deb.jpg', 150),
(2, 'Mocha Brown', '#8B4513', 'https://i.pinimg.com/1200x/65/a4/d7/65a4d7a7323c31ede79ff17974d0feb0.jpg', 150);

-- Product 3: Elegant Heels (Formal)
INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES 
(3, 'Obsidian Black', '#1A1A1A', 'https://i.pinimg.com/1200x/df/75/5b/df755b70f839864e965e595fc462f032.jpg', 80),
(3, 'Nude Pink', '#FFD1DC', 'https://i.pinimg.com/1200x/46/57/65/46576503a6b3749b4e86dfb86ed47a51.jpg', 80),
(3, 'Scarlet Red', '#FF2400', 'https://i.pinimg.com/1200x/8f/33/47/8f3347d0c15ffe9b80e622faa0e8d730.jpg', 80);

-- Add a few more random products to make the 'New Arrivals' / 'Trending' sections pop if they select random IDs
-- Check if we need more products first. The user asked to 'add all images in backend'. 
-- I will assume adding these variations to the EXISTING products is what is meant, 
-- but I can also update the 'products' table description or names if needed. 
-- For now, the colors coverage is good.

";

try {
    $pdo->exec($sql);
    echo "Successfully seeded product images!";
} catch (PDOException $e) {
    echo "Seeding failed: " . $e->getMessage();
}
?>