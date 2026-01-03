document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const navbar = document.getElementById('top-bar');
    const cartOffcanvas = document.getElementById('cartOffcanvas');
    const scrollThreshold = 500;

    // --- 1. УНИВЕРСАЛЬНАЯ ФУНКЦИЯ БЛОКИРОВКИ СКРОЛЛА ---
    function toggleBodyScroll(isLocked) {
        if (isLocked) {
            const scrollBarWidth = window.innerWidth - document.documentElement.clientWidth;
            
            
            body.style.overflow = 'hidden';
        } else {
            body.style.paddingRight = '';
            if (navbar) navbar.style.paddingRight = '';
            body.style.overflow = '';
        }
    }

    // --- 2. ЛОГИКА ТОПБАРА (ИСПРАВЛЕННАЯ) ---
    function handleScroll() {
        // Используем window.scrollY (современный стандарт)
        const currentScroll = window.scrollY || window.pageYOffset;

        if (currentScroll > scrollThreshold) {
            if (!navbar.classList.contains('fixed')) {
                navbar.classList.add('fixed');
            }
        } else {
            if (navbar.classList.contains('fixed')) {
                navbar.classList.remove('fixed');
            }
        }
    }

    // Слушаем скролл с использованием requestAnimationFrame для производительности
    window.addEventListener('scroll', function() {
        window.requestAnimationFrame(handleScroll);
    });

    // Запускаем проверку один раз при загрузке
    handleScroll();

    // --- 3. КОРЗИНА (ОФФКАНВАС) ---
    function toggleCart(isOpen) {
        if (isOpen) {
            cartOffcanvas.classList.add('active');
            toggleBodyScroll(true);
        } else {
            cartOffcanvas.classList.remove('active');
            toggleBodyScroll(false);
        }
    }

    // Обработчики корзины (проверьте наличие ID в HTML)
    const openCartBtn = document.getElementById('openCart');
    const closeOverlay = document.getElementById('closeCartOverlay');
    const closeBtnExtern = document.getElementById('closeCartBtnExtern');

    if (openCartBtn) openCartBtn.addEventListener('click', () => toggleCart(true));
    if (closeOverlay) closeOverlay.addEventListener('click', () => toggleCart(false));
    if (closeBtnExtern) closeBtnExtern.addEventListener('click', () => toggleCart(false));

    // --- 4. МОДАЛЬНЫЕ ОКНА (DIALOG) ---
    const allModals = document.querySelectorAll('dialog');
    
    const modalObserver = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'open') {
                const anyModalOpen = Array.from(allModals).some(modal => modal.hasAttribute('open'));
                const isCartOpen = cartOffcanvas && cartOffcanvas.classList.contains('active');
                
                toggleBodyScroll(anyModalOpen || isCartOpen);
            }
        });
    });

    allModals.forEach(modal => {
        modalObserver.observe(modal, { attributes: true });
    });

    // --- 5. ОБРАБОТКА ВЫБОРА ВНУТРИ МОДАЛОК ---
    document.body.addEventListener('click', function(e) {
        // Выбор размера
        if (e.target.closest('.pill-btn[data-size]')) {
            const btn = e.target.closest('.pill-btn');
            const group = btn.closest('.pill-switch-group');
            group.querySelectorAll('.pill-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            updateModalState(btn.closest('dialog'));
        }

        // Выбор теста
        if (e.target.closest('.pill-btn[data-dough]')) {
            const btn = e.target.closest('.pill-btn');
            const group = btn.closest('.pill-switch-group');
            group.querySelectorAll('.pill-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            updateModalState(btn.closest('dialog'));
        }

        // Добавки
        if (e.target.closest('.extra-card')) {
            const card = e.target.closest('.extra-card');
            card.classList.toggle('added');
            updateModalState(card.closest('dialog'));
        }
    });

    function updateModalState(modal) {
        if (!modal) return;

        const activeSizeBtn = modal.querySelector('.pill-btn[data-size].active');
        const activeDoughBtn = modal.querySelector('.pill-btn[data-dough].active');
        
        let basePrice = activeSizeBtn ? parseInt(activeSizeBtn.dataset.price) : 0;
        let extrasPrice = 0;
        let selectedExtras = [];

        modal.querySelectorAll('.extra-card.added').forEach(card => {
            const priceBtn = card.querySelector('.extra-add-btn');
            if (priceBtn) {
                const price = parseInt(priceBtn.dataset.extraPrice);
                const name = card.querySelector('.extra-name').textContent.trim();
                extrasPrice += price;
                selectedExtras.push({ name, price });
            }
        });

        const totalPrice = basePrice + extrasPrice;
        const priceDisplay = modal.querySelector('.total-price-display');
        if (priceDisplay) priceDisplay.textContent = `${totalPrice} ₽`;

        // Обновление скрытых полей
        const sizeInput = modal.querySelector('.selected-size-input');
        const doughInput = modal.querySelector('.selected-dough-input');
        const extrasInput = modal.querySelector('.selected-extras-input');

        if (sizeInput && activeSizeBtn) sizeInput.value = activeSizeBtn.dataset.size;
        if (doughInput && activeDoughBtn) doughInput.value = activeDoughBtn.dataset.dough;
        if (extrasInput) extrasInput.value = JSON.stringify(selectedExtras);
    }

    // Закрытие по ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (cartOffcanvas && cartOffcanvas.classList.contains('active')) {
                toggleCart(false);
            }
        }
    });

    // === Новое: работа с корзиной через AJAX (использует api/cart.php) ===
    async function fetchCartState() {
        try {
            const res = await fetch('api/cart.php?action=get', { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            if (data.success) updateCartUI(data);
        } catch (e) {
            console.error(e);
        }
    }

    function formatPrice(v) { return Math.round(v) + ' ₽'; }

    function updateCartUI(data) {
        const countEl = document.getElementById('offcanvasCartCount');
        const totalEl = document.getElementById('offcanvasCartTotal');
        const summaryCount = document.getElementById('summaryCount');
        const summaryTotal = document.getElementById('summaryTotal');
        const finalSum = document.getElementById('finalSum');
        const coins = document.getElementById('summaryCoins');
        if (countEl) countEl.textContent = data.count || 0;
        if (totalEl) totalEl.textContent = formatPrice(data.total || 0);
        if (summaryCount) summaryCount.textContent = (data.count || 0) + ' товар(ов)';
        if (summaryTotal) summaryTotal.textContent = formatPrice(data.total || 0);
        if (finalSum) finalSum.textContent = formatPrice(data.total || 0);
        if (coins) coins.textContent = Math.floor((data.total || 0) / 20);

        const bodyEl = document.querySelector('.offcanvas-body');
        if (!bodyEl) return;
        bodyEl.innerHTML = '';
        if (!data.items || data.items.length === 0) {
            bodyEl.innerHTML = '<div style="padding:20px;">Корзина пуста</div>';
            return;
        }
        data.items.forEach(it => {
            const div = document.createElement('div');
            div.className = 'cart-card';
            div.innerHTML = `
                <div class="cart-card-main">
                    <img src="assets/image/${it.img}" class="cart-card-img" alt="">
                    <div class="cart-card-info">
                        <div class="cart-card-header">
                            <h3>${it.name}</h3>
                            <button class="remove-item" data-key="${it.key}">✕</button>
                        </div>
                        <p class="cart-card-desc">${it.size ? it.size : ''} см</p>
                        <div class="cart-card-footer">
                            <div class="cart-card-prices"><span class="price-actual">${formatPrice(it.price)}</span></div>
                            <div class="cart-card-controls">
                                <button class="change-btn">Изменить</button>
                                <div class="quantity-pill">
                                    <button class="q-minus" data-key="${it.key}">−</button>
                                    <span class="q-num" data-key="${it.key}">${it.quantity}</span>
                                    <button class="q-plus" data-key="${it.key}">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            bodyEl.appendChild(div);
        });
    }

    // Перехват submit форм добавления в корзину
    document.body.addEventListener('submit', function(e) {
        const form = e.target.closest && e.target.closest('.add-to-cart-form');
        if (!form) return;
        e.preventDefault();

        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) submitBtn.disabled = true;

        const actionUrl = form.getAttribute('action') || 'api/cart.php?action=add';
        const fd = new FormData(form);
        fetch(actionUrl, { method: 'POST', body: fd, headers: { 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(json => {
                if (json.success) {
                    // обновим корзину и откроем оффканвас
                    fetchCartState();
                    toggleCart(true);

                    // Закрываем родительский dialog, если указано
                    try {
                        const dlg = form.closest('dialog');
                        if (dlg && (form.dataset.closeModal === "1" || form.hasAttribute('data-close-modal'))) {
                            if (typeof dlg.close === 'function') dlg.close();
                        }
                    } catch (err) { /* silent */ }
                } else {
                    alert(json.message || 'Ошибка добавления');
                }
            })
            .catch(() => {
                alert('Ошибка сети');
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    // небольшая визуальная обратная связь
                    submitBtn.blur();
                }
            });
    });

    // Делегирование кликов внутри оффканваса: удалить/плюс/минус
    document.body.addEventListener('click', function(e){
        const rem = e.target.closest('.remove-item');
        if (rem) {
            const key = rem.dataset.key;
            fetch('api/cart.php?action=remove', { method: 'POST', body: new URLSearchParams({ key }), headers: { 'Accept': 'application/json' } })
                .then(r => r.json()).then(()=> fetchCartState());
            return;
        }
        const plus = e.target.closest('.q-plus');
        if (plus) {
            const key = plus.dataset.key;
            const numEl = document.querySelector(`.q-num[data-key="${key}"]`);
            const cur = parseInt(numEl?.textContent || '1', 10);
            const newQty = cur + 1;
            fetch('api/cart.php?action=update', { method: 'POST', body: new URLSearchParams({ key, quantity: newQty }), headers: { 'Accept': 'application/json' } })
                .then(r => r.json()).then(()=> fetchCartState());
            return;
        }
        const minus = e.target.closest('.q-minus');
        if (minus) {
            const key = minus.dataset.key;
            const numEl = document.querySelector(`.q-num[data-key="${key}"]`);
            const cur = parseInt(numEl?.textContent || '1', 10);
            const newQty = Math.max(0, cur - 1);
            fetch('api/cart.php?action=update', { method: 'POST', body: new URLSearchParams({ key, quantity: newQty }), headers: { 'Accept': 'application/json' } })
                .then(r => r.json()).then(()=> fetchCartState());
            return;
        }
    });

    // Инициализация: получить состояние корзины при загрузке
    fetchCartState();

    // === Обработчик кнопки "К оформлению заказа" ===
    const checkoutBtn = document.getElementById('openCheckoutBtn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const cart = document.querySelectorAll('.offcanvas-body .cart-card');
            if (cart.length === 0) {
                alert('Корзина пуста');
                return;
            }
            // Редирект на страницу оформления заказа
            window.location.href = './checkout.php';
        });
    }

    // --- 6. АВТОРИЗАЦИЯ (LOGIN/REGISTER) ---
    const authForms = document.querySelectorAll('.auth-form');
    const authLinks = document.querySelectorAll('[data-auth-target]');

    authLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.dataset.authTarget;
            authForms.forEach(form => {
                if (form.classList.contains('auth-active')) {
                    form.classList.remove('auth-active');
                } else if (form.classList.contains(target)) {
                    form.classList.add('auth-active');
                }
            });
        });
    });

    // Закрытие модалки авторизации по клику вне области формы
    document.addEventListener('click', function(e) {
        const isClickInside = e.target.closest('.auth-form');
        const isAuthActive = document.querySelector('.auth-form.auth-active');
        if (!isClickInside && isAuthActive) {
            isAuthActive.classList.remove('auth-active');
        }
    });
});

function authShowRegister() {
    document.querySelector('.auth-form-login').classList.remove('auth-active');
    document.querySelector('.auth-form-register').classList.add('auth-active');
}

function authShowLogin() {
    document.querySelector('.auth-form-register').classList.remove('auth-active');
    document.querySelector('.auth-form-login').classList.add('auth-active');
}