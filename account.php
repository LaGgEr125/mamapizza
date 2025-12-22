<?php
$title = "Аккаунт";
include("include/header.php");

$days = range(1, 31);
$months = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
$years = range(date("Y"), 1970);
?>

<div class="account-container">
    <div class="account-column">
        <h1>Личные данные</h1>

        <div class="input-group">
            <label>Имя</label>
            <input type="text" value="">
        </div>
        <div class="input-group">
            <label>Фамилия</label>
            <input type="text" value="">
        </div>
        <div class="input-group">
            <label>Телефон</label>
            <input type="text" value="">
        </div>
        <div class="input-group">
            <label>Почта</label>
            <input type="email" value="">
        </div>
        <div class="birth-date-section">
            <h3>Дата рождения</h3>
            <div class="select-container">
                <select>
                    <option>День</option>
                    <?php foreach ($days as $day): ?>
                        <option value="<?= $day ?>"><?= $day ?></option>
                    <?php endforeach; ?>
                </select>
                <select>
                    <option>Месяц</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?= $month ?>"><?= $month ?></option>
                    <?php endforeach; ?>
                </select>
                <select>
                    <option>Год</option>
                    <?php foreach ($years as $year): ?>
                        <option value="<?= $year ?>"><?= $year ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mammacoins-section">
            <h3>Мамакоины</h3>
            <div class="mammacoins-card">
                <span>125</span>
                <img src="assets/image/мамакоин.png" alt="coin">
            </div>
        </div>
    </div>

    <div class="account-column">
        <h1>История заказов</h1>

        <div class="order-card">
            <div class="order-header">Заказ #228 01.12.25</div>
            <div class="order-status status-delivered">Доставлен</div>
            <div class="order-price">Сумма заказа: 1000р</div>
            <a href="#" class="order-link">Подробнее</a>
        </div>

        <div class="order-card">
            <div class="order-header">Заказ #229 01.12.25</div>
            <div class="order-status status-cancelled">Отменён</div>
            <div class="order-price">Сумма заказа: 5500р</div>
            <a href="#" class="order-link">Подробнее</a>
        </div>
    </div>
</div>

<?php
include("include/footer.php");
?>