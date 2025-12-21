<?php
$title = "Аккаунт";
include("include/header.php");
?>

<div class="account">
    <div>
        <h1>Личные данные</h1>
        <div class="account-input">
            <label for="name">Имя</label>
            <input type="text" id="name">
            <label for="f_name">Фамилия</label>
            <input type="text" id="f_name">
            <label for="number">Телефон</label>
            <input type="text" id="number">
            <label for="email">Почта</label>
            <input type="text" id="email">
        </div>
        
    </div>
    <div class="account-orders">
        <h1>История заказов</h1>
        <div class="account-history">
            <p>Заказ #228 01.12.25</p>
            <p>Сумма заказа:1000р</p>
            <p>Доставлен</p>
            <a href="">Подробнее</a>
        </div>
    </div>
</div>

<?php
include("include/footer.php");
?> 