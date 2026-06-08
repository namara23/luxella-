-- Luxella Spaces — MySQL schema
-- Import via phpMyAdmin or: mysql -u root -p luxella < database.sql

CREATE DATABASE IF NOT EXISTS luxella CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE luxella;

CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  name VARCHAR(120) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  category VARCHAR(80) NOT NULL,
  description TEXT,
  price_ugx INT DEFAULT NULL,
  image_url VARCHAR(500) DEFAULT NULL,
  featured TINYINT(1) NOT NULL DEFAULT 0,
  published TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (category), INDEX (published)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS gallery_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  image_url VARCHAR(500) NOT NULL,
  caption VARCHAR(190) DEFAULT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  published TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS leads (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  phone VARCHAR(40) NOT NULL,
  email VARCHAR(190) DEFAULT NULL,
  interest VARCHAR(80) DEFAULT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Default admin: admin@luxellaspaces.com / Admin@123  (CHANGE AFTER LOGIN)
-- Hash generated with password_hash('Admin@123', PASSWORD_DEFAULT)
INSERT INTO admins (email, password_hash, name) VALUES
('admin@luxellaspaces.com', '$2y$12$uurRnlp7TkBGLW9Q1gMmUubE3xRMwoROImid6pmN6jvYpE3Fg8dy2', 'Luxella Admin')
ON DUPLICATE KEY UPDATE email = email;

-- Seed gallery (assumes images sit in /assets/images/)
INSERT INTO gallery_images (image_url, caption, sort_order) VALUES
('assets/images/g1.jpg','Living room project',1),
('assets/images/g2.jpg','Bedroom styling',2),
('assets/images/g3.jpg','Bathroom detail',3),
('assets/images/g4.jpg','Wall art',4),
('assets/images/g5.jpg','Kitchen styling',5),
('assets/images/g6.jpg','Hospitality interior',6);

-- Seed a few products
INSERT INTO products (name, category, description, price_ugx, image_url, featured) VALUES
('Velvet Lounge Sofa','Living Room','Sculptural three-seater in muted champagne velvet.',4200000,'assets/images/cat-living.jpg',1),
('Linen Bedding Set','Bedroom','Stone-washed linen duvet and pillow set.',650000,'assets/images/cat-bedroom.jpg',1),
('Brass Bath Set','Bathroom','Hand-finished brass bathroom accessories.',480000,'assets/images/cat-bathroom.jpg',0),
('Marble Kitchen Tray','Kitchen','Carrara marble serving tray with brass handles.',320000,'assets/images/cat-kitchen.jpg',0),
('Framed Wall Art','Wall Hangings','Curated abstract print, hand-framed.',780000,'assets/images/cat-wallart.jpg',1);
