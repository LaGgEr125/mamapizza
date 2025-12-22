<?php
$type = isset($_GET['type']) ? $_GET['type'] : 'delivery';
$title = "Чекаут";
include("include/header.php");
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
        position: relative;
    }

    .checkout-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
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
        text-decoration: none;
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        transition: opacity 0.2s;
        cursor: pointer;
        border: none;
    }

    .checkout-switch:hover {
        opacity: 0.9;
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
        font-size: 14px;
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
        align-items: flex-start;
        gap: 10px;
    }

    .checkout-address-text {
        font-size: 12px;
        color: #333;
        line-height: 1.4;
        margin: 0;
        flex: 1;
    }

    .checkout-change {
        background: none;
        border: none;
        color: #ff8a00;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        padding: 0;
        white-space: nowrap;
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
        transition: all 0.2s;
    }

    .checkout-time-btn--active {
        background: #fff;
        border-color: #e2e2e2;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

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
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 700;
        color: #000;
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
        color: #000;
    }

    .checkout-item span:last-child {
        font-weight: 700;
    }

    .checkout-summary-footer {
        margin-top: auto;
    }

    .checkout-total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
        font-size: 13px;
        color: #000;
        font-weight: 600;
    }

    .checkout-total-row--bold {
        font-weight: 800;
        font-size: 15px;
        margin-top: 5px;
    }

    .checkout-timestamp {
        display: block;
        text-align: right;
        font-size: 10px;
        color: #999;
        margin-bottom: 20px;
    }

    .checkout-submit-container {
        display: flex;
        justify-content: center;
    }

    .checkout-submit {
        background: #ff8a00;
        color: #fff;
        border: none;
        padding: 10px 35px;
        border-radius: 20px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
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
                    <div class="checkout-input-wrapper">
                        <input type="text" class="checkout-input">
                    </div>
                </div>
            </div>

            <div class="checkout-field">
                <div class="checkout-field-row">
                    <label class="checkout-label">Номер телефона</label>
                    <div class="checkout-input-wrapper">
                        <input type="text" class="checkout-input js-phone-input" placeholder="8 000 000 00 00" maxlength="15">
                    </div>
                </div>
            </div>

            <div class="checkout-field">
                <div class="checkout-field-row">
                    <label class="checkout-label" id="js-address-label">
                        <?php echo ($type === 'pickup') ? 'Адрес пиццерии' : 'Адрес доставки'; ?>
                    </label>
                    <div class="checkout-input-wrapper">
                        <div class="checkout-address-box">
                            <p class="checkout-address-text">деревня Шепилово, городской округ Серпухов, Московская область</p>
                            <button class="checkout-change">Изменить</button>
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
                <li class="checkout-item"><span>Картошка Фри</span><span>254 ₽</span></li>
                <li class="checkout-item"><span>Наггетсы</span><span>190 ₽</span></li>
            </ul>
            <div class="checkout-summary-footer">
                <div class="checkout-total-row"><span>Скидка:</span><span>0%</span></div>
                <div class="checkout-total-row"><span>Списанные бонусы:</span><span>0 бонусов</span></div>
                <div class="checkout-total-row checkout-total-row--bold"><span>Итоговая сумма:</span><span>1000 ₽</span></div>
                <span class="checkout-timestamp">22:00 10.12.2023</span>
                <div class="checkout-submit-container"><button class="checkout-submit">Оформить</button></div>
            </div>
        </aside>
    </div>
</div>

<script>
const typeToggle = document.getElementById('js-type-toggle');
const mainTitle = document.getElementById('js-main-title');
const addressLabel = document.getElementById('js-address-label');
const timeLabel = document.getElementById('js-time-label');
const checkoutRoot = document.getElementById('checkout-root');

typeToggle.addEventListener('click', function() {
    const currentType = checkoutRoot.getAttribute('data-type');
    const newType = currentType === 'delivery' ? 'pickup' : 'delivery';
    
    checkoutRoot.setAttribute('data-type', newType);
    
    if (newType === 'pickup') {
        mainTitle.textContent = 'Заказ на самовывоз';
        addressLabel.textContent = 'Адрес пиццерии';
        timeLabel.textContent = 'Время самовывоза';
        this.textContent = 'Доставка';
    } else {
        mainTitle.textContent = 'Заказ на доставку';
        addressLabel.textContent = 'Адрес доставки';
        timeLabel.textContent = 'Время доставки';
        this.textContent = 'Самовывоз';
    }

    const url = new URL(window.location);
    url.searchParams.set('type', newType);
    window.history.pushState({}, '', url);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('checkout-time-btn')) {
        const buttons = e.target.closest('.checkout-time').querySelectorAll('.checkout-time-btn');
        buttons.forEach(btn => btn.classList.remove('checkout-time-btn--active'));
        e.target.classList.add('checkout-time-btn--active');
    }
});

document.querySelector('.js-phone-input').addEventListener('input', function (e) {
    let input = e.target.value.replace(/\D/g, '');
    let formatted = '';
    if (input.length > 0) {
        formatted += input[0];
        if (input.length > 1) formatted += ' ' + input.substring(1, 4);
        if (input.length > 4) formatted += ' ' + input.substring(4, 7);
        if (input.length > 7) formatted += ' ' + input.substring(7, 9);
        if (input.length > 9) formatted += ' ' + input.substring(9, 11);
    }
    e.target.value = formatted.trim();
});
</script>

<?php
include("include/footer.php");
?>
