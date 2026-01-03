<?php
$title = "Аккаунт";
include("include/header.php");
?>

<div class="auth-container">
    <div class="auth-box">

        <!-- ВХОД -->
        <div class="auth-form auth-form-login auth-active">
            <h2 class="auth-title">Авторизация</h2>

            <input type="text" class="auth-input" placeholder="Телефон">
            <input type="password" class="auth-input" placeholder="Пароль">

            <div class="auth-text">
                Нет аккаунта?
                <button class="auth-switch" onclick="authShowRegister()">Зарегистрироваться</button>
            </div>

            <button class="auth-button">Войти</button>
        </div>

        <!-- РЕГИСТРАЦИЯ -->
        <div class="auth-form auth-form-register">
            <h2 class="auth-title">Регистрация</h2>

            <input type="text" class="auth-input" placeholder="Телефон">
            <input type="password" class="auth-input" placeholder="Пароль">

            <div class="auth-text">
                Уже есть аккаунт?
                <button class="auth-switch" onclick="authShowLogin()">Войти</button>
            </div>

            <button class="auth-button">Создать</button>
        </div>

    </div>
</div>

<?php
include("include/footer.php");
?>