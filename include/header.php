<?php
// start session early for auth/cart usage
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@400;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Tailwind CDN with config for brand color and fonts -->
    <script>
        window.tailwindConfig = {
            theme: {
                extend: {
                    colors: {
                        brand: '#FF8904' /* ваш основной цвет */
                    },
                    fontFamily: {
                        sans: ['"Montserrat Alternates"', 'Roboto', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        .header-btn {
            background-color: red !important;
            display: inline-block;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            color: white;
            background: transparent;
            transition: all 0.3s ease;
            cursor: pointer;
        }
    </style>
    <title><?= htmlspecialchars($title ?? '') ?> | Мамапицца</title>
</head>

<body class="antialiased bg-white text-gray-800 font-sans">
    <header class="bg-brand text-white">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <img src="./assets/image/логотип.png" alt="logo" class="h-12">
                <div>
                    <p class="text-2xl font-semibold leading-none">Мамина пицца</p>
                    <p class="text-sm opacity-90">Сеть №1 в России</p>
                </div>
            </div>

            <div>
                <?php
                // Показываем "Личный кабинет" только если пользователь авторизован
                if (!empty($_SESSION['user_id']) && ($title !== 'Аккаунт' && $title !== "Чекаут")): ?>
                    <a href="./account.php" class="header-btn">Личный кабинет</a>
                <?php elseif ($title === 'Аккаунт' || $title === "Чекаут"): ?>
                    <a href="./index.php" class="header-btn">На главную</a>
                <?php else: ?>
                    <a href="./auth.php" class="header-btn">Войти</a>
                <?php endif; ?>
            </div>
        </div>
    </header>