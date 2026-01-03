<?php
$type = isset($_GET['type']) ? $_GET['type'] : 'delivery';
$title = "Чекаут";
include("include/header.php");

$pizzerias = [
    'Серпухов' => [
        ['addr' => 'ул. Ворошилова, 133', 'work' => '09:00 — 23:00'],
        ['addr' => 'Борисовское шоссе, 1', 'work' => '10:00 — 22:00'],
        ['addr' => 'ул. Советская, 78', 'work' => '09:00 — 23:00'],
        ['addr' => 'Московское шоссе, 55', 'work' => '24/7']
    ],
    'Пущино' => [
        ['addr' => 'микрорайон Д, 13А', 'work' => '09:00 — 23:00'],
    ]
];
?>
<style>
    .checkout {
        padding: 40px;
        background: #f8f8f8;
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    .checkout-container {
        display: flex;
        gap: 30px;
        max-width: 1100px;
        margin: 0 auto;
        align-items: flex-start;
    }

    .checkout-form {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        flex: 2;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .checkout-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .checkout-title {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #000;
    }

    .checkout-switch {
        background: #ff8a00;
        color: #fff;
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        border: none;
    }

    .checkout-field {
        margin-bottom: 20px;
    }

    .checkout-field-row {
        display: flex;
        align-items: center;
    }

    .checkout-label {
        width: 160px;
        font-weight: 700;
        color: #000;
        font-size: 14px;
        flex-shrink: 0;
    }

    .checkout-input-wrapper {
        flex: 1;
        position: relative;
    }

    .checkout-input {
        width: 100%;
        padding: 12px 15px;
        border-radius: 12px;
        border: 1px solid #e2e2e2;
        font-size: 12px;
        background: #f4f4f4;
        box-sizing: border-box;
        outline: none;
    }

    .checkout-address-box {
        background: #f4f4f4;
        border-radius: 12px;
        padding: 12px 15px;
        border: 1px solid #e2e2e2;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .checkout-address-text {
        font-size: 13px;
        color: #333;
        margin: 0;
    }

    .checkout-change {
        background: none;
        border: none;
        color: #ff8a00;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
    }

    .checkout-time {
        display: flex;
        gap: 8px;
    }

    .checkout-time-btn {
        padding: 8px 16px;
        border-radius: 18px;
        border: 1px solid #e2e2e2;
        background: #f4f4f4;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
    }

    .checkout-time-btn--active {
        background: #fff;
        border-color: #e2e2e2;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* SUMMARY RIGHT */
    .checkout-summary {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        flex: 1;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        min-height: 480px;
        display: flex;
        flex-direction: column;
    }

    .checkout-summary-title {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .checkout-list {
        list-style: none;
        padding: 0;
        margin: 0 0 20px 0;
    }

    .checkout-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 13px;
    }

    .checkout-total-row--bold {
        font-weight: 800;
        font-size: 15px;
        margin-top: 10px;
    }

    .checkout-submit {
        background: #ff8a00;
        color: #fff;
        border: none;
        padding: 12px 40px;
        border-radius: 25px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        width: 100%;
        margin-top: 5%;
    }

    .checkout-summary-footer {
        margin-top: 100%;
    }

    /* MODAL DO-DO STYLE */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: #fff;
        width: 100%;
        height: 80%;
        max-width: 700px;
        border-radius: 20px;
        overflow: hidden;
        animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 20px;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #999;
    }

    .modal-body {
        padding: 20px;
        max-height: 70vh;
        overflow-y: auto;
    }

    .city-tabs {
        display: flex;
        background: #f4f4f4;
        padding: 4px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .city-tab {
        flex: 1;
        text-align: center;
        padding: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border-radius: 10px;
        transition: 0.2s;
        color: #555;
    }

    .city-tab.active {
        background: #fff;
        color: #000;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .pizzeria-card {
        padding: 15px;
        border: 1px solid #e2e2e2;
        border-radius: 12px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: 0.2s;
    }

    .pizzeria-card:hover {
        border-color: #ff8a00;
        background: #fffaf5;
    }

    .pizzeria-card h4 {
        margin: 0 0 5px 0;
        font-size: 15px;
    }

    .pizzeria-card p {
        margin: 0;
        font-size: 12px;
        color: #777;
    }

    .hidden {
        display: none !important;
    }

    .checkout-delivery-input {
        display: block;
    }
</style>

<div class="checkout" id="checkout-root" data-type="<?php echo $type; ?>">
    <div class="checkout-container">
        <section class="checkout-form">
            <div class="checkout-header">
                <h2 class="checkout-title" id="js-main-title">
                    <?php echo ($type === 'pickup') ? 'Заказ на самовывоз' : 'Заказ на доставку'; ?>
                </h2>
                <button class="checkout-switch" id="js-type-toggle">
                    <?php echo ($type === 'pickup') ? 'Доставка' : 'Самовывоз'; ?>
                </button>
            </div>

            <div class="checkout-field">
                <div class="checkout-field-row">
                    <label class="checkout-label">Имя</label>
                    <div class="checkout-input-wrapper"><input type="text" class="checkout-input" placeholder="Ваше имя"></div>
                </div>
            </div>

            <div class="checkout-field">
                <div class="checkout-field-row">
                    <label class="checkout-label">Номер телефона</label>
                    <div class="checkout-input-wrapper">
                        <input type="text" class="checkout-input js-phone-input" placeholder="8 (000) 000 00 00" maxlength="15">
                    </div>
                </div>
            </div>

            <div class="checkout-field">
                <div class="checkout-field-row">
                    <label class="checkout-label" id="js-address-label">
                        <?php echo ($type === 'pickup') ? 'Адрес пиццерии' : 'Адрес доставки'; ?>
                    </label>
                    <div class="checkout-input-wrapper">
                        <div id="js-pickup-view" class="checkout-address-box <?php echo ($type === 'delivery') ? 'hidden' : ''; ?>">
                            <p class="checkout-address-text" id="js-address-display">Выберите пиццерию</p>
                            <button class="checkout-change" id="js-open-pizzeria-modal">Изменить</button>
                        </div>

                        <div id="js-delivery-view" class="<?php echo ($type === 'pickup') ? 'hidden' : ''; ?>">
                            <input type="text" class="checkout-input" id="js-delivery-input" 
                                   placeholder="Город, улица, дом, квартира" 
                                   value="деревня Шепилово, городской округ Серпухов, Московская область">
                        </div>
                    </div>
                </div>
            </div>

            <div class="checkout-field">
                <div class="checkout-field-row">
                    <label class="checkout-label" id="js-time-label">
                        <?php echo ($type === 'pickup') ? 'Время самовывоза' : 'Время доставки'; ?>
                    </label>
                    <div class="checkout-input-wrapper">
                        <div class="checkout-time">
                            <button class="checkout-time-btn checkout-time-btn--active">Побыстрее</button>
                            <button class="checkout-time-btn">17:45</button>
                            <button class="checkout-time-btn">Другое время</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <aside class="checkout-summary">
            <h3 class="checkout-summary-title">МамаПицца</h3>
            <ul class="checkout-list">
                <li class="checkout-item"><span>Пицца пепперони</span><span>666 ₽</span></li>
                <li class="checkout-item"><span>Кока-Кола</span><span>150 ₽</span></li>
            </ul>
            <div class="checkout-summary-footer">
                <div class="checkout-total-row checkout-total-row--bold"><span>Итоговая сумма:</span><span>1000 ₽</span></div>
                <button class="checkout-submit" id="js-submit-order">Оформить</button>
            </div>
        </aside>
    </div>
</div>

<div class="modal-overlay" id="js-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Выберите пиццерию</h3>
            <button class="modal-close" id="js-modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="city-tabs">
                <div class="city-tab active" data-city="Серпухов">Серпухов</div>
                <div class="city-tab" data-city="Пущино">Пущино</div>
            </div>
            <div id="js-modal-pizzerias">
                <?php foreach ($pizzerias as $city => $list): ?>
                    <div class="city-content" id="city-<?php echo $city; ?>" style="<?php echo $city === 'Серпухов' ? '' : 'display:none;'; ?>">
                        <?php foreach ($list as $piz): ?>
                            <div class="pizzeria-card" data-full-addr="<?php echo $city . ', ' . $piz['addr']; ?>">
                                <h4><?php echo $piz['addr']; ?></h4>
                                <p>Режим работы: <?php echo $piz['work']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Элементы управления типом заказа
    const root = document.getElementById('checkout-root');
    const typeToggle = document.getElementById('js-type-toggle');
    
    // Элементы времени
    const timeContainer = document.getElementById('js-time-container') || document.querySelector('.checkout-time');
    const otherTimeBtn = document.getElementById('js-other-time-trigger');
    const customPicker = document.getElementById('js-custom-picker');
    const hourSelect = document.getElementById('js-hours');

    // Элементы модалки
    const modal = document.getElementById('js-modal');
    const openModalBtn = document.getElementById('js-open-pizzeria-modal');
    const closeModalBtn = document.getElementById('js-modal-close');

    // 1. ДИНАМИЧЕСКАЯ СМЕНА ТИПА (GET в URL + Интерфейс)
    if (typeToggle && root) {
        typeToggle.addEventListener('click', () => {
            const isDelivery = root.dataset.type === 'delivery';
            const newType = isDelivery ? 'pickup' : 'delivery';
            
            root.dataset.type = newType;

            // Обновляем URL без перезагрузки
            const url = new URL(window.location);
            url.searchParams.set('type', newType);
            window.history.pushState({}, '', url);

            // Обновляем тексты
            const titleEl = document.getElementById('js-main-title');
            const addrLabelEl = document.getElementById('js-address-label');
            const timeLabelEl = document.getElementById('js-time-label');

            if (titleEl) titleEl.textContent = isDelivery ? 'Заказ на самовывоз' : 'Заказ на доставку';
            if (addrLabelEl) addrLabelEl.textContent = isDelivery ? 'Адрес пиццерии' : 'Адрес доставки';
            if (timeLabelEl) timeLabelEl.textContent = isDelivery ? 'Время самовывоза' : 'Время доставки';
            typeToggle.textContent = isDelivery ? 'Доставка' : 'Самовывоз';

            // Переключаем блоки
            const pickupView = document.getElementById('js-pickup-view');
            const deliveryView = document.getElementById('js-delivery-view');
            
            if (pickupView) pickupView.classList.toggle('hidden', newType === 'delivery');
            if (deliveryView) deliveryView.classList.toggle('hidden', newType === 'pickup');
        });
    }

    // 2. ЛОГИКА ВЫБОРА ВРЕМЕНИ
    function initTimeSystem() {
        if (!timeContainer) return; // Если контейнера нет, выходим из функции без ошибки

        const now = new Date();
        const curH = now.getHours();
        
        // Удаляем старые кнопки слотов
        document.querySelectorAll('.js-dynamic-slot').forEach(el => el.remove());



        if (hourSelect) {
            hourSelect.innerHTML = '';
            for (let h = curH; h <= 23; h++) {
                const opt = document.createElement('option');
                opt.value = h;
                opt.textContent = h.toString().padStart(2, '0');
                hourSelect.appendChild(opt);
            }
        }
    }

    function selectTime(btn) {
        document.querySelectorAll('.checkout-time-btn').forEach(b => b.classList.remove('checkout-time-btn--active'));
        btn.classList.add('checkout-time-btn--active');
        if (customPicker) {
            customPicker.classList.toggle('active', btn === otherTimeBtn);
        }
    }

    // Обработка клика по существующим кнопкам времени
    document.querySelectorAll('.checkout-time-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            selectTime(btn);
        });
    });

    // 3. МОДАЛЬНОЕ ОКНО И ТАБЫ
    if (openModalBtn) {
        openModalBtn.onclick = (e) => {
            e.preventDefault();
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        };
    }

    if (closeModalBtn) {
        closeModalBtn.onclick = (e) => {
            e.preventDefault();
            modal.classList.remove('active');
            document.body.style.overflow = '';
        };
    }

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // Табы городов
    document.querySelectorAll('.city-tab').forEach(tab => {
        tab.onclick = function() {
            document.querySelectorAll('.city-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const city = this.dataset.city;
            document.querySelectorAll('.city-content').forEach(c => c.style.display = 'none');
            
            // Ищем контент по ID (учитываем разные варианты именования)
            const content = document.getElementById(`city-${city}`) || document.getElementById(`modal-city-${city}`);
            if (content) content.style.display = 'block';
        }
    });

    // Выбор карточки пиццерии
    document.querySelectorAll('.pizzeria-card').forEach(card => {
        card.onclick = function() {
            const addr = this.dataset.fullAddr || this.dataset.addr;
            const display = document.getElementById('js-address-display');
            if (display) display.textContent = addr;
            
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    });

    // 4. МАСКА ТЕЛЕФОНА
    const phoneInput = document.querySelector('.js-phone-input');
    if (phoneInput) {
        phoneInput.addEventListener('input', (e) => {
            let val = e.target.value.replace(/\D/g, '');
            let res = '';
            if (val.length > 0) {
                res += val[0];
                if (val.length > 1) res += ' (' + val.substring(1, 4);
                if (val.length > 4) res += ') ' + val.substring(4, 7);
                if (val.length > 7) res += ' ' + val.substring(7, 9);
                if (val.length > 9) res += ' ' + val.substring(9, 11);
            }
            e.target.value = res;
        });
    }

    // Запуск системы времени
    initTimeSystem();
});
</script>

<?php include("include/footer.php"); ?>