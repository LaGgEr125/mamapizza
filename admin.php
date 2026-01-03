<?php
$title = "Аккаунт";
include("include/header.php");
?>


<style>
    /* ОБЩАЯ ОБЁРТКА */
    .admin-panel * {
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    .admin-panel {
      margin: 0;
      height: 100vh;
      display: flex;
    }

    /* ЛЕВОЕ МЕНЮ */
    .admin-sidebar {
      width: 260px;
      background: #ff8c00;
      color: #fff;
      padding: 20px 0;
    }

    .admin-logo {
      padding: 0 20px 20px;
      font-size: 20px;
      font-weight: bold;
    }

    .admin-menu {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .admin-menu-item {
      padding: 15px 20px;
      cursor: pointer;
      transition: background 0.2s;
    }

    .admin-menu-item:hover,
    .admin-menu-item.admin-active {
      background: rgba(255, 255, 255, 0.2);
    }

    /* ПРАВАЯ ЧАСТЬ */
    .admin-content {
      flex: 1;
      background: #f5f5f5;
      padding: 30px;
      overflow-y: auto;
    }

    .admin-card {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 15px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .admin-status {
      font-weight: bold;
    }

    .admin-details {
      color: #ff8c00;
      cursor: pointer;
    }





    /* ===== ТОВАРЫ ===== */
.admin-products {
  max-width: 1000px;
}

.admin-product-form {
  background: #fff;
  border-radius: 16px;
  padding: 20px 24px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
  margin-bottom: 30px;
}

.admin-form-row {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 16px;
}

.admin-form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.admin-form-group label {
  font-size: 14px;
}

.admin-form-group input,
.admin-form-group textarea {
  padding: 8px 10px;
  border-radius: 8px;
  border: 1px solid #888;
  outline: none;
}

.admin-form-textarea {
  grid-column: 1 / -1;
}

.admin-form-actions {
  display: flex;
  justify-content: flex-end;
}

.admin-save-btn {
  background: #ff8c00;
  color: #fff;
  border: none;
  border-radius: 18px;
  padding: 8px 18px;
  cursor: pointer;
}

/* ===== ТАБЛИЦА ===== */
.admin-table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

.admin-table th,
.admin-table td {
  border: 1px solid #777;
  padding: 10px;
  text-align: center;
  font-size: 14px;
}

.admin-table th {
  background: #f5f5f5;
}

.admin-link {
  color: #ff8c00;
  cursor: pointer;
}

.admin-edit {
  color: red;
  cursor: pointer;
}

  </style>
</head>
<body>

<div class="admin-panel">

  <!-- ЛЕВОЕ МЕНЮ -->
  <aside class="admin-sidebar">
    <ul class="admin-menu">
      <li class="admin-menu-item admin-active" data-page="active">Активные заказы</li>
      <li class="admin-menu-item" data-page="history">История заказов</li>
      <li class="admin-menu-item" data-page="products">Товары</li>
    </ul>
  </aside>

  <!-- КОНТЕНТ -->
  <main class="admin-content" id="admin-content">
    <!-- Контент подгружается JS -->
  </main>

</div>

<script>
  const adminMenuItems = document.querySelectorAll('.admin-menu-item');
  const adminContent = document.getElementById('admin-content');

  const adminPages = {
    active: `
      <div class="admin-card">
        <div>
          <div>#229 01.12.25</div>
          <div class="admin-status">Принят</div>
        </div>
        <div class="admin-details">Подробнее</div>
      </div>

      <div class="admin-card">
        <div>
          <div>#230 01.12.25</div>
          <div class="admin-status">Готовят</div>
        </div>
        <div class="admin-details">Подробнее</div>
      </div>

      <div class="admin-card">
        <div>
          <div>#231 01.12.25</div>
          <div class="admin-status">В пути</div>
        </div>
        <div class="admin-details">Подробнее</div>
      </div>
    `,
    history: `
<div class="admin-cards">

  <div class="admin-card">
    <div class="admin-card-left">
      <div class="admin-card-number">#229 01.12.25</div>
      <div class="admin-status admin-status-delivered">
        Доставлен <span class="admin-status-arrow">▾</span>
      </div>
    </div>
    <div class="admin-details">Подробнее</div>
  </div>

  <div class="admin-card">
    <div class="admin-card-left">
      <div class="admin-card-number">#229 01.12.25</div>
      <div class="admin-status admin-status-canceled">
        Отменён <span class="admin-status-arrow">▾</span>
      </div>
    </div>
    <div class="admin-details">Подробнее</div>
  </div>

</div>
    `,
    products: `
<div class="admin-products">

  <!-- ФОРМА ДОБАВЛЕНИЯ -->
  <div class="admin-product-form">
    <div class="admin-form-row">
      <div class="admin-form-group">
        <label>Название</label>
        <input type="text">
      </div>

      <div class="admin-form-group">
        <label>Категория</label>
        <input type="text">
      </div>

      <div class="admin-form-group">
        <label>Цена</label>
        <input type="text">
      </div>

      <div class="admin-form-group">
        <label>Картинка</label>
        <input type="text">
      </div>
    </div>

    <div class="admin-form-group admin-form-textarea">
      <label>Описание</label>
      <textarea rows="4"></textarea>
    </div>

    <div class="admin-form-actions">
      <button class="admin-save-btn">Сохранить</button>
    </div>
  </div>

  <!-- ТАБЛИЦА -->
  <table class="admin-table">
    <thead>
      <tr>
        <th>Название</th>
        <th>Категория</th>
        <th>Цена</th>
        <th>Картинка</th>
        <th>Описание</th>
        <th>Изменить</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Пеперони</td>
        <td>Пицца</td>
        <td>350₽</td>
        <td><span class="admin-link">Просмотр</span></td>
        <td><span class="admin-link">Подробнее</span></td>
        <td><span class="admin-edit">Изменить</span></td>
      </tr>
      <tr>
        <td></td><td></td><td></td><td></td><td></td>
        <td><span class="admin-edit">Изменить</span></td>
      </tr>
      <tr>
        <td></td><td></td><td></td><td></td><td></td>
        <td><span class="admin-edit">Изменить</span></td>
      </tr>
    </tbody>
  </table>

</div>

    `
  };

  function adminLoadPage(page) {
    adminContent.innerHTML = adminPages[page];
  }

  adminMenuItems.forEach(item => {
    item.addEventListener('click', () => {
      adminMenuItems.forEach(i => i.classList.remove('admin-active'));
      item.classList.add('admin-active');
      adminLoadPage(item.dataset.page);
    });
  });

  adminLoadPage('active');
</script>




<!-- <?php
include("include/footer.php");
?> -->