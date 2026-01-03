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
});

function authShowRegister() {
    document.querySelector('.auth-form-login').classList.remove('auth-active');
    document.querySelector('.auth-form-register').classList.add('auth-active');
}

function authShowLogin() {
    document.querySelector('.auth-form-register').classList.remove('auth-active');
    document.querySelector('.auth-form-login').classList.add('auth-active');
}