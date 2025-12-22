<?php
$title = "Аккаунт";
include("include/header.php");
?>

<div class="checkout">
    <div class="checkout-container">
        <!-- LEFT -->
        <section class="checkout-form">
            <h2 class="checkout-title">Заказ на доставку</h2>

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
                        <input type="text" class="checkout-input">
                    </div>
                </div>
            </div>

            <div class="checkout-field">
                <div class="checkout-field-row">
                    <label class="checkout-label">Адрес доставки</label>
                    <div class="checkout-input-wrapper">
                        <textarea class="checkout-textarea">деревня Шепилово, городской округ Серпухов, Московская область</textarea>
                        <button class="checkout-change">Изменить</button>
                    </div>
                </div>
            </div>

            <div class="checkout-field">
                <div class="checkout-field-row">
                    <label class="checkout-label">Время доставки</label>
                    <div class="checkout-input-wrapper">
                        <div class="checkout-time">
                            <button class="checkout-time-btn checkout-time-btn--active">Побыстрее</button>
                            <button class="checkout-time-btn">17:45</button>
                            <button class="checkout-time-btn">Другое время</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Разделительная линия как на картинке -->
            <div class="checkout-divider-full"></div>
        </section>

        <!-- RIGHT -->
        <aside class="checkout-summary">
            <h3 class="checkout-summary-title">МамаПицца</h3>

            <ul class="checkout-list">
                <li class="checkout-item">
                    <span>Пицца пепперони</span><span>666 ₽</span>
                </li>
                <li class="checkout-item">
                    <span>Кока-Кола</span><span>150 ₽</span>
                </li>
                <li class="checkout-item">
                    <span>Картошка Фри</span><span>254 ₽</span>
                </li>
                <li class="checkout-item">
                    <span>Наггетсы</span><span>190 ₽</span>
                </li>
            </ul>

            <div class="checkout-divider"></div>

            <div class="checkout-total-row">
                <span>Скидка</span><span>0%</span>
            </div>
            <div class="checkout-total-row">
                <span>Списанные мамакоины</span><span>0</span>
            </div>
            <div class="checkout-total-row checkout-total-row--bold">
                <span>Итоговая сумма</span><span>1000 ₽</span>
            </div>

            <!-- Кнопка оформления перенесена вниз -->
            <button class="checkout-submit">Оформить</button>
        </aside>
    </div>
</div>

<?php
include("include/footer.php");
?>