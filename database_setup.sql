CREATE DATABASE IF NOT EXISTS wear_db;
USE wear_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    mobile VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    account_type ENUM('retail', 'wholesale') DEFAULT 'retail',
    is_verified BOOLEAN DEFAULT FALSE,
    gst_number VARCHAR(20) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    description TEXT,
    price_retail DECIMAL(10, 2) NOT NULL,
    is_bestseller BOOLEAN DEFAULT FALSE,
    is_new BOOLEAN DEFAULT FALSE,
    discount_percent INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS product_colors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    color_name VARCHAR(50) NOT NULL,
    hex_code VARCHAR(7),
    image_url VARCHAR(255),
    stock_quantity INT DEFAULT 0, -- Total pairs for this color
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_type ENUM('retail', 'wholesale', 'sample') NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'confirmed', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_color_id INT NOT NULL,
    size INT NOT NULL,
    quantity INT NOT NULL,
    price_per_pair DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (product_color_id) REFERENCES product_colors(id)
);

-- Seed some data
INSERT INTO products (name, category, description, price_retail, is_bestseller, is_new, discount_percent) VALUES 
('Ultra Glide Reader', 'Sports', 'High performance running shoes.', 2499.00, TRUE, TRUE, 20),
('Urban Casual', 'Casual', 'Comfortable daily wear.', 1499.00, TRUE, FALSE, 0),
('Elegant Heels', 'Formal', 'Perfect for office and parties.', 2999.00, FALSE, TRUE, 0);
