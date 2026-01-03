<?php
$title = "Аккаунт";
include("include/header.php");
?>

<div class="thankyou-container">
    <h1 class="thankyou-title">Спасибо за заказ!</h1>
    <p class="thankyou-subtitle">Заказ №2115 оформлен</p>

    <div class="thankyou-video">
        <span class="thankyou-live">● Live</span>
        <p class="thankyou-video-text">Прямой эфир из пиццерии</p>
    </div>

    <div class="thankyou-status">
        <span class="thankyou-step active">Приняли</span>
        <span class="thankyou-step">Готовим</span>
        <span class="thankyou-step">Упаковка</span>
        <span class="thankyou-step">Курьер</span>
    </div>

    <div class="thankyou-order">
        <h2 class="thankyou-order-title">Состав заказа</h2>

        <div class="thankyou-item">
            <span>Пицца Пепперони фреш (30см)</span>
            <span>666 ₽</span>
        </div>
        <div class="thankyou-item">
            <span>Злой Кола 0.5л</span>
            <span>666 ₽</span>
        </div>
        <div class="thankyou-item">
            <span>Досмер с говном</span>
            <span>666 ₽</span>
        </div>

        <div class="thankyou-total">
            <span>Итого:</span>
            <strong>666 ₽</strong>
        </div>
    </div>

    <button class="thankyou-pay-button">
        Отменить заказ
    </button>
</div>

<?php
include("include/footer.php");
?>