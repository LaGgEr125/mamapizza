<!-- <?php
$title = "Аккаунт";
include("include/header.php");
?> -->

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Админка</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      margin: 0;
      height: 100vh;
      display: flex;
    }

    /* ЛЕВОЕ МЕНЮ */
    .sidebar {
      width: 260px;
      background: #ff8c00;
      color: #fff;
      padding: 20px 0;
    }

    .logo {
      padding: 0 20px 20px;
      font-size: 20px;
      font-weight: bold;
    }

    .menu {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .menu li {
      padding: 15px 20px;
      cursor: pointer;
      transition: background 0.2s;
    }

    .menu li:hover,
    .menu li.active {
      background: rgba(255, 255, 255, 0.2);
    }

    /* ПРАВАЯ ЧАСТЬ */
    .content {
      flex: 1;
      background: #f5f5f5;
      padding: 30px;
      overflow-y: auto;
    }

    .card {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 15px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .status {
      font-weight: bold;
    }

    .details {
      color: #ff8c00;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <!-- ЛЕВОЕ МЕНЮ -->
  <aside class="sidebar">
    <div class="logo">Мамина пицца</div>
    <ul class="menu">
      <li class="active" data-page="active">Активные заказы</li>
      <li data-page="history">История заказов</li>
      <li data-page="products">Товары</li>
    </ul>
  </aside>

  <!-- КОНТЕНТ -->
  <main class="content" id="content">
    <!-- Контент подгружается JS -->
  </main>

<script>
  const menuItems = document.querySelectorAll('.menu li');
  const content = document.getElementById('content');

  const pages = {
    active: `
      <div class="card">
        <div>
          <div>#229 01.12.25</div>
          <div class="status">Принят</div>
        </div>
        <div class="details">Подробнее</div>
      </div>

      <div class="card">
        <div>
          <div>#230 01.12.25</div>
          <div class="status">Готовят</div>
        </div>
        <div class="details">Подробнее</div>
      </div>

      <div class="card">
        <div>
          <div>#231 01.12.25</div>
          <div class="status">В пути</div>
        </div>
        <div class="details">Подробнее</div>
      </div>
    `,
    history: `
      <h2>История заказов</h2>
      <p>Здесь будет список выполненных заказов</p>
    `,
    products: `
      <h2>Товары</h2>
      <p>Здесь будет управление товарами</p>
    `
  };

  function loadPage(page) {
    content.innerHTML = pages[page];
  }

  menuItems.forEach(item => {
    item.addEventListener('click', () => {
      menuItems.forEach(i => i.classList.remove('active'));
      item.classList.add('active');
      loadPage(item.dataset.page);
    });
  });

  // загрузка страницы по умолчанию
  loadPage('active');
</script>

</body>
</html>


<!-- <?php
include("include/footer.php");
?> -->