<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title><?= htmlspecialchars($title) ?> | Мамапицца</title>
</head>

<body>
    <header>
        <div class="header">
            <div class="header-logo">
                <img src="assets/image/логотип.png" alt="">
                <div>
                    <p class="header-name">Мамина пицца</p>
                    <p class="header-description">Сеть №1 в России</p>
                </div>
            </div>

            <div class="header-button">
                <?php if ($title !== 'Аккаунт'): ?>
                    <a href="account.php">Личный кабинет</a>
                <?php else: ?>
                    <a href="index.php">На главную</a>
                <?php endif; ?>
            </div>
        </div>
    </header>