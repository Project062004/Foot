USE wear_db;

-- Clear existing color data to avoid duplicates during re-seed
DELETE FROM product_colors;
ALTER TABLE product_colors AUTO_INCREMENT = 1;

-- Product 1: Ultra Glide Reader (Sports)
-- White
INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES 
(1, 'White', '#FFFFFF', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800&auto=format&fit=crop', 500);
-- Black
INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES 
(1, 'Black', '#1a1a1a', 'https://images.unsplash.com/photo-1491553895911-0055eca6402d?q=80&w=800&auto=format&fit=crop', 500);
-- Pink/Tan
INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES 
(1, 'Pink', '#ffb6c1', 'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?q=80&w=800&auto=format&fit=crop', 500);


-- Product 2: Urban Casual (Casual/Sneakers)
-- Blue/Navy
INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES 
(2, 'Navy', '#000080', 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?q=80&w=800&auto=format&fit=crop', 500);
-- Yellow/Gold
INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES 
(2, 'Mustard', '#E1AD01', 'https://images.unsplash.com/photo-1595341888016-a392ef81b7de?q=80&w=800&auto=format&fit=crop', 500);


-- Product 3: Elegant Heels (Formal)
-- Red
INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES 
(3, 'Red', '#AA0000', 'https://images.unsplash.com/photo-1560343090-f0409e92791a?q=80&w=800&auto=format&fit=crop', 500);
-- Beige/Nude
INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES 
(3, 'Nude', '#E5C4A8', 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=800&auto=format&fit=crop', 500);
-- Black
INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES 
(3, 'Black', '#000000', 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=800&auto=format&fit=crop', 500);


-- Wholesale Tiers (Reset and Re-insert)
DROP TABLE IF EXISTS wholesale_tiers;
CREATE TABLE wholesale_tiers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    min_pairs INT NOT NULL,
    price_per_pair DECIMAL(10,2) NOT NULL,
    delivery_days INT NOT NULL
);

INSERT INTO wholesale_tiers (min_pairs, price_per_pair, delivery_days) VALUES 
(60, 650.00, 7),
(120, 600.00, 15),
(180, 575.00, 20),
(240, 550.00, 25);
