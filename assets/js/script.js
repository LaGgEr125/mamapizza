    // Получаем элемент навигационной панели
    const navbar = document.getElementById('top-bar');
    
    // Порог прокрутки для фиксации (можно настроить)
    const scrollThreshold = 100;
    
    // Функция для обработки прокрутки
    function handleScroll() {
        if (window.pageYOffset > scrollThreshold) {
            // Добавляем класс fixed при прокрутке
            navbar.classList.add('fixed');
        } else {
            // Убираем класс fixed когда вверху страницы
            navbar.classList.remove('fixed');
        }
    }
    
    // Вешаем обработчик события прокрутки
    window.addEventListener('scroll', handleScroll);
    
    // Инициализация при загрузке страницы
    document.addEventListener('DOMContentLoaded', function() {
        handleScroll();
    });



// Пример открытия модального окна
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.showModal();
        
        // Дополнительное центрирование
        modal.style.position = 'fixed';
        modal.style.top = '50%';
        modal.style.left = '50%';
        modal.style.transform = 'translate(-50%, -50%)';
    }
}

// Или для закрытия
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.close();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Базовая цена для каждого размера
    const basePrices = {
        20: 379,
        25: 429,
        30: 479,
        35: 529
    };
    
    // Текущий выбор
    let currentSize = 30;
    let currentDough = 'traditional';
    let currentExtras = [];
    let quantity = 1;
    
    // Элементы DOM
    const totalPriceElement = document.getElementById('total-price');
    const cartPriceElement = document.getElementById('cart-price');
    const selectedSizeInput = document.getElementById('selected-size');
    const selectedDoughInput = document.getElementById('selected-dough');
    const selectedExtrasInput = document.getElementById('selected-extras');
    const quantityInput = document.getElementById('quantity-input');
    const pizzaInfoElement = document.querySelector('.pizza-info');
    
    // Функция обновления цены
    function updatePrice() {
        // Получаем базовую цену для выбранного размера
        let basePrice = basePrices[currentSize] || 479;
        
        // Добавляем стоимость допов
        let extrasPrice = currentExtras.reduce((sum, extra) => sum + extra.price, 0);
        
        // Общая цена за 1 пиццу
        let pricePerPizza = basePrice + extrasPrice;
        
        // Итоговая цена с учетом количества
        let totalPrice = pricePerPizza * quantity;
        
        // Обновляем отображение цены
        totalPriceElement.textContent = `${pricePerPizza} ₽`;
        cartPriceElement.textContent = `${totalPrice} ₽`;
        
        // Обновляем скрытые поля формы
        selectedSizeInput.value = currentSize;
        selectedDoughInput.value = currentDough;
        selectedExtrasInput.value = JSON.stringify(currentExtras);
        
        // Обновляем информацию о пицце
        const doughNames = {
            'traditional': 'традиционное тесто',
            'thin': 'тонкое тесто'
        };
        pizzaInfoElement.textContent = `${currentSize} см, ${doughNames[currentDough]}`;
    }
    
    // Обработка выбора размера
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Убираем активный класс у всех кнопок
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            
            // Добавляем активный класс текущей кнопке
            this.classList.add('active');
            
            // Обновляем текущий размер
            currentSize = parseInt(this.dataset.size);
            
            // Обновляем цену
            updatePrice();
        });
    });
    
    // Обработка выбора теста
    document.querySelectorAll('.dough-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Убираем активный класс у всех кнопок
            document.querySelectorAll('.dough-btn').forEach(b => b.classList.remove('active'));
            
            // Добавляем активный класс текущей кнопке
            this.classList.add('active');
            
            // Обновляем текущее тесто
            currentDough = this.dataset.dough;
            
            // Обновляем цену
            updatePrice();
        });
    });
    
    // Обработка добавления/удаления допов
    document.querySelectorAll('.extra-add-btn').forEach((btn, index) => {
        btn.addEventListener('click', function() {
            const extraPrice = parseInt(this.dataset.extraPrice);
            const extraName = this.closest('.extra-item').querySelector('.extra-name').textContent;
            const extraId = `extra-${index}`;
            
            // Проверяем, добавлен ли уже этот доп
            const existingExtraIndex = currentExtras.findIndex(extra => extra.id === extraId);
            
            if (existingExtraIndex === -1) {
                // Добавляем доп
                currentExtras.push({
                    id: extraId,
                    name: extraName,
                    price: extraPrice
                });
                this.classList.add('added');
                this.textContent = '✓';
            } else {
                // Удаляем доп
                currentExtras.splice(existingExtraIndex, 1);
                this.classList.remove('added');
                this.textContent = '+';
            }
            
            // Обновляем цену
            updatePrice();
        });
    });
    
    // Управление количеством
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            
            if (this.classList.contains('minus')) {
                if (value > 1) {
                    value--;
                }
            } else if (this.classList.contains('plus')) {
                value++;
            }
            
            quantityInput.value = value;
            quantity = value;
            
            // Обновляем цену
            updatePrice();
        });
    });
    
    // Обработка изменения количества через input
    quantityInput.addEventListener('change', function() {
        let value = parseInt(this.value);
        if (isNaN(value) || value < 1) {
            value = 1;
            this.value = 1;
        }
        quantity = value;
        updatePrice();
    });
    
    // Инициализация цены при загрузке
    updatePrice();
});




// Инициализация корзины
let cart = {
    items: [
        { name: "Пепперони фреш", price: 659, quantity: 1 },
        { name: "Сырная", price: 660, quantity: 1 }
    ],
    total: 1319,
    discount: 149, // скидка 1468 - 1319
    coins: 52
};

// Обновление отображения корзины в основном интерфейсе
function updateCartDisplay() {
    const itemCount = cart.items.reduce((total, item) => total + item.quantity, 0);
    const cartTotal = cart.total;
    
    // Обновляем кнопку корзины
    document.getElementById('cartCount').textContent = itemCount;
    document.getElementById('cartTotal').textContent = formatPrice(cartTotal);
    
    // Обновляем оффканвас
    document.getElementById('offcanvasCartCount').textContent = itemCount;
    document.getElementById('offcanvasCartTotal').textContent = formatPrice(cartTotal);
    document.getElementById('summaryItemsCount').textContent = itemCount;
    document.getElementById('summaryItemsPrice').textContent = formatPrice(cartTotal);
    document.getElementById('summaryTotalPrice').textContent = formatPrice(cartTotal);
}

// Форматирование цены
function formatPrice(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + " ₽";
}

// Открытие оффканваса
document.getElementById('openCart').addEventListener('click', function() {
    document.getElementById('cartOffcanvas').classList.add('active');
    updateCartDisplay();
});

// Закрытие оффканваса
document.getElementById('closeCart').addEventListener('click', function() {
    document.getElementById('cartOffcanvas').classList.remove('active');
});

document.getElementById('closeCartBtn').addEventListener('click', function() {
    document.getElementById('cartOffcanvas').classList.remove('active');
});

// Добавление товаров в корзину
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productName = this.getAttribute('data-product');
        const productPrice = parseInt(this.getAttribute('data-price'));
        
        // Проверяем, есть ли уже такой товар в корзине
        const existingItem = cart.items.find(item => item.name === productName);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.items.push({
                name: productName,
                price: productPrice,
                quantity: 1
            });
        }
        
        // Пересчитываем общую сумму
        cart.total = cart.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        
        // Начисляем мамакоины (примерно 5% от суммы)
        cart.coins = Math.round(cart.total * 0.05);
        
        updateCartDisplay();
        
        // Показываем уведомление
        showNotification(`${productName} добавлен в корзину!`);
    });
});

// Показ уведомления
function showNotification(message) {
    // Создаем элемент уведомления
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #2ecc71;
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        z-index: 2000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: fadeInOut 3s ease-in-out;
    `;
    
    // Добавляем стили анимации
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-20px); }
            15% { opacity: 1; transform: translateY(0); }
            85% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-20px); }
        }
    `;
    document.head.appendChild(style);
    
    document.body.appendChild(notification);
    
    // Удаляем уведомление через 3 секунды
    setTimeout(() => {
        notification.remove();
        style.remove();
    }, 3000);
}

// Закрытие оффканваса при нажатии Esc
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        document.getElementById('cartOffcanvas').classList.remove('active');
    }
});

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    updateCartDisplay();
});