-- ============================================================
-- Bangle Store Database Schema
-- ============================================================

CREATE DATABASE IF NOT EXISTS bangle_bangari CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bangle_bangari;

-- Categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bangles (products)
CREATE TABLE bangles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT DEFAULT NULL,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    description TEXT,
    material VARCHAR(100),
    size VARCHAR(50),
    color VARCHAR(100),
    price DECIMAL(10,2) NOT NULL,
    compare_price DECIMAL(10,2) DEFAULT NULL COMMENT 'Strike-through original price',
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(255),
    is_featured TINYINT(1) DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Admin users
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(20) NOT NULL UNIQUE,
    customer_name VARCHAR(150) NOT NULL,
    customer_email VARCHAR(150) NOT NULL,
    customer_phone VARCHAR(20),
    address TEXT NOT NULL,
    city VARCHAR(100),
    state VARCHAR(100),
    pincode VARCHAR(10),
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending','confirmed','shipped','delivered','cancelled') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Order items
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    bangle_id INT NOT NULL,
    bangle_name VARCHAR(200) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (bangle_id) REFERENCES bangles(id) ON DELETE CASCADE
);

-- ============================================================
-- Seed Data
-- ============================================================

INSERT INTO categories (name, slug, description) VALUES
('Glass Bangles', 'glass-bangles', 'Traditional and colourful glass bangles'),
('Gold-Plated Bangles', 'gold-plated', 'Elegant gold-plated bangles for every occasion'),
('Silk Thread Bangles', 'silk-thread', 'Handcrafted silk thread bangles'),
('Meenakari Bangles', 'meenakari', 'Intricate Meenakari enamel work bangles'),
('Bridal Sets', 'bridal-sets', 'Complete bridal bangle sets');

-- Default admin (password: Admin@123)
INSERT INTO admin_users (name, email, password) VALUES
('Store Admin', 'admin@banglestore.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO bangles (category_id, name, slug, description, material, size, color, price, compare_price, stock, is_featured, is_active) VALUES
(1, 'Red Glass Bangle Set (12 pcs)', 'red-glass-bangle-set', 'Vibrant red glass bangles perfect for festive wear. Set of 12 pieces.', 'Glass', '2.6', 'Red', 299.00, 399.00, 50, 1, 1),
(2, 'Gold-Plated Kundan Bangle', 'gold-plated-kundan', 'Handcrafted gold-plated bangle with Kundan stone work. Perfect for weddings.', 'Brass with Gold Plating', '2.8', 'Gold', 899.00, 1199.00, 30, 1, 1),
(3, 'Silk Thread Multicolour Bangle', 'silk-thread-multicolour', 'Vibrant silk thread bangles handmade by local artisans.', 'Silk Thread', '2.6', 'Multicolour', 149.00, 199.00, 100, 1, 1),
(4, 'Meenakari Floral Bangle', 'meenakari-floral', 'Traditional Meenakari work bangle with floral motifs.', 'Brass with Enamel', '2.8', 'Blue & Gold', 649.00, 849.00, 25, 1, 1),
(5, 'Bridal Red & Gold Set (21 pcs)', 'bridal-red-gold-set', 'Complete bridal bangle set in red and gold. Comes in a beautiful gift box.', 'Mixed (Glass & Metal)', '2.6 / 2.8', 'Red & Gold', 1499.00, 1999.00, 15, 1, 1);
