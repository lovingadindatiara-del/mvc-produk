
CREATE DATABASE IF NOT EXISTS db_produk
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE db_produk;

CREATE TABLE IF NOT EXISTS produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_produk VARCHAR(20) NOT NULL UNIQUE,
    nama_produk VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    harga DECIMAL(12,2) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO produk (kode_produk, nama_produk, kategori, harga, stok)
VALUES
('PRD001', 'Laptop Lenovo', 'Elektronik', 7500000, 10),
('PRD002', 'Mouse Wireless', 'Aksesori', 150000, 25),
('PRD003', 'Keyboard Mechanical', 'Aksesori', 450000, 15);
