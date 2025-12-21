-- Создание таблицы товаров
CREATE TABLE goods (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    img VARCHAR(255),
    category ENUM('kombo', 'pizza', 'snacks', 'drinks', 'desserts') NOT NULL
);

-- Вставка тестовых данных
INSERT INTO goods (name, description, price, img, category) VALUES
-- Комбо
('Комбо "Мафия"', 'Большая пицца + 2 напитка + картофель фри', 899.00, 'kombo1.png', 'kombo'),
('Комбо "Босс"', 'Средняя пицца + напиток + крылышки', 649.00, 'kombo2.png', 'kombo'),
('Комбо "Семейное"', '2 пиццы средние + 4 напитка + наггетсы', 1299.00, 'kombo3.png', 'kombo'),
('Комбо "Студенческое"', 'Маленькая пицца + напиток', 399.00, 'kombo4.png', 'kombo'),

-- Пиццы
('Пеперони фреш', 'Пепперони, увеличенная порция моцареллы, томаты, томатный соус', 289.00, 'peperone.png', 'pizza'),
('Маргарита', 'Увеличенная порция моцареллы, томаты, итальянские травы, томатный соус', 249.00, 'margarita.png', 'pizza'),
('Четыре сыра', 'Соус карбонара, моцарелла, сыры чеддер и пармезан, сыр блю чиз', 329.00, 'fourcheese.png', 'pizza'),
('Гавайская', 'Курица, ананасы, моцарелла, томатный соус', 299.00, 'hawaiian.png', 'pizza'),
('Мясная', 'Цыпленок, говядина, пепперони, моцарелла, томатный соус', 349.00, 'meat.png', 'pizza'),
('Вегетарианская', 'Шампиньоны, томаты, сладкий перец, красный лук, моцарелла, томатный соус', 279.00, 'vegetarian.png', 'pizza'),

-- Закуски
('Картофель фри', 'Хрустящая картошечка с солью', 129.00, 'fries.png', 'snacks'),
('Куриные крылышки', '6 острых куриных крылышек', 199.00, 'wings.png', 'snacks'),
('Наггетсы', '8 куриных наггетсов с соусом', 159.00, 'nuggets.png', 'snacks'),
('Чесночные гренки', 'Сытные гренки с чесночным соусом', 89.00, 'bread.png', 'snacks'),
('Картофель по-деревенски', 'Ароматный картофель со специями', 149.00, 'countrypotato.png', 'snacks'),

-- Напитки
('Кока-Кола', 'Освежающая газировка 0.5л', 99.00, 'cola.png', 'drinks'),
('Фанта', 'Апельсиновая газировка 0.5л', 99.00, 'fanta.png', 'drinks'),
('Спрайт', 'Лаймовая газировка 0.5л', 99.00, 'sprite.png', 'drinks'),
('Сок апельсиновый', 'Натуральный сок 0.33л', 129.00, 'juice.png', 'drinks'),
('Вода негазированная', 'Вода питьевая 0.5л', 79.00, 'water.png', 'drinks'),
('Морс клюквенный', 'Ягодный морс 0.33л', 119.00, 'mors.png', 'drinks'),

-- Десерты
('Чизкейк Нью-Йорк', 'Нежный чизкейк с ягодным соусом', 189.00, 'cheesecake.png', 'desserts'),
('Тирамису', 'Итальянский десерт с кофе и какао', 199.00, 'tiramisu.png', 'desserts'),
('Шоколадный торт', 'Шоколадный бисквит с кремом', 179.00, 'chococake.png', 'desserts'),
('Мороженое ванильное', '2 шарика ванильного мороженого', 149.00, 'icecream.png', 'desserts'),
('Пончики', '3 пончика с сахарной пудрой', 159.00, 'donuts.png', 'desserts');

-- Создание таблицы корзины (если нужно для cart.php)
CREATE TABLE IF NOT EXISTS cart (
    id INT PRIMARY KEY AUTO_INCREMENT,
    session_id VARCHAR(255) NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES goods(id) ON DELETE CASCADE
);

-- Создание индексов для оптимизации
CREATE INDEX idx_category ON goods(category);
CREATE INDEX idx_session ON cart(session_id);