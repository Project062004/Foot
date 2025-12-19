USE wear_db;

INSERT INTO product_colors (product_id, color_name, hex_code, image_url, stock_quantity) VALUES 
(1, 'Black', '#000000', 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=600&auto=format', 500),
(1, 'Tan', '#D2B48C', 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=600&auto=format', 500),
(1, 'White', '#FFFFFF', 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=600&auto=format', 500),
(2, 'Navy', '#000080', 'https://images.unsplash.com/photo-1535043934128-6a3d5f3404ba?q=80&w=600&auto=format', 500),
(2, 'Grey', '#808080', 'https://images.unsplash.com/photo-1535043934128-6a3d5f3404ba?q=80&w=600&auto=format', 500),
(3, 'Red', '#FF0000', 'https://images.unsplash.com/photo-1543508282-6319a3e2621f?q=80&w=600&auto=format', 500),
(3, 'Beige', '#F5F5DC', 'https://images.unsplash.com/photo-1543508282-6319a3e2621f?q=80&w=600&auto=format', 500);

-- Wholesale Tiers Table
CREATE TABLE IF NOT EXISTS wholesale_tiers (
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
