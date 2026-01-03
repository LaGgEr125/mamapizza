-- Полная схема для проекта MamaPizza

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE IF NOT EXISTS mamapizza CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mamapizza;

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone VARCHAR(50) UNIQUE,
    email VARCHAR(150),
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    is_admin TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Таблица товаров (goods)
CREATE TABLE IF NOT EXISTS goods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    img VARCHAR(255),
    category ENUM('kombo','pizza','snacks','drinks','desserts') NOT NULL,
    special_tag VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Опциональная таблица размеров (если понадобится)
CREATE TABLE IF NOT EXISTS product_sizes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    size_label VARCHAR(100),
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES goods(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Заказы
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending','confirmed','preparing','ready','delivered','cancelled') DEFAULT 'pending',
    delivery_address TEXT,
    phone VARCHAR(50),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Позиции заказа
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    size_label VARCHAR(100),
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES goods(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Тестовые пользователи (пароль: password)
INSERT INTO users (phone, email, password, first_name, last_name, is_admin) VALUES
('9000000000','admin@mamapizza.local','$2y$10$e0NRK1VY0y5bqW7l0aHq1u6g0yqP1uD4z6Q0vE1tZxG1dY3Gq9U2', 'Admin', 'User', 1),
('9111111111','user@mamapizza.local','$2y$10$e0NRK1VY0y5bqW7l0aHq1u6g0yqP1uD4z6Q0vE1tZxG1dY3Gq9U2', 'Test', 'User', 0);

-- Тестовые товары (копия/вариация ваших данных)
INSERT INTO goods (name, description, price, img, category, special_tag) VALUES
('Комбо "Мафия"', 'Большая пицца + 2 напитка + картофель фри', 899.00, 'kombo1.png', 'kombo', NULL),
('Пеперони фреш', 'Пепперони, увеличенная порция моцареллы, томаты, томатный соус', 289.00, 'peperone.png', 'pizza', 'Хит'),
('Маргарита', 'Увеличенная порция моцареллы, томаты, итальянские травы', 249.00, 'margarita.png', 'pizza', NULL),
('Четыре сыра', 'Микс четырех сыров', 329.00, 'fourcheese.png', 'pizza', NULL),
('Картофель фри', 'Хрустящая картошечка с солью', 129.00, 'fries.png', 'snacks', NULL),
('Куриные крылышки', '6 острых куриных крылышек', 199.00, 'wings.png', 'snacks', NULL),
('Кока-Кола', 'Освежающая газировка 0.5л', 99.00, 'cola.png', 'drinks', NULL),
('Чизкейк Нью-Йорк', 'Нежный чизкейк с ягодным соусом', 189.00, 'cheesecake.png', 'desserts', NULL);

-- Базовые размеры для пеперони
INSERT INTO product_sizes (product_id, size_label, price) VALUES
(2, 'Малая (30см)', 289.00),
(2, 'Средняя (35см)', 379.00),
(2, 'Большая (40см)', 479.00);

-- Индексы
CREATE INDEX idx_goods_category ON goods(category);
CREATE INDEX idx_orders_user ON orders(user_id);

SET FOREIGN_KEY_CHECKS=1;
