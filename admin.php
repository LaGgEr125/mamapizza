<?php
session_start();
require_once "include/database.php";

// Проверка прав администратора
if (empty($_SESSION['is_admin'])) {
    header('Location: ./auth.php');
    exit;
}

$title = "Администратор";
include("include/header.php");

// Загрузка активных заказов
$activeOrders = [];
$stmt = $mysqli->prepare("SELECT id, phone, total_price, status, created_at FROM orders WHERE status IN ('pending', 'confirmed', 'preparing') ORDER BY created_at DESC LIMIT 20");
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $activeOrders[] = $row;
}
$stmt->close();

// Загрузка истории заказов
$historyOrders = [];
$stmt = $mysqli->prepare("SELECT id, phone, total_price, status, created_at FROM orders WHERE status IN ('delivered', 'cancelled') ORDER BY created_at DESC LIMIT 50");
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $historyOrders[] = $row;
}
$stmt->close();

// Загрузка товаров
$products = [];
$stmt = $mysqli->prepare("SELECT id, name, category, price, img, description FROM goods ORDER BY category, name");
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $products[] = $row;
}
$stmt->close();
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

  const statusMap = {
    'pending': 'В ожидании',
    'confirmed': 'Подтверждён',
    'preparing': 'Готовится',
    'ready': 'Готов',
    'delivered': 'Доставлен',
    'cancelled': 'Отменён'
  };

  function formatDate(date) {
    const d = new Date(date);
    return d.toLocaleDateString('ru-RU') + ' ' + d.toLocaleTimeString('ru-RU', {hour: '2-digit', minute: '2-digit'});
  }

  function generateActiveOrders() {
    const activeOrders = <?php echo json_encode($activeOrders); ?>;
    if (activeOrders.length === 0) return '<div style="padding: 20px; text-align: center; color: #999;">Нет активных заказов</div>';
    return activeOrders.map(order => `
      <div class="admin-card">
        <div>
          <div><strong>#${order.id}</strong> ${formatDate(order.created_at)}</div>
          <div class="admin-status">${statusMap[order.status] || order.status}</div>
          <div style="font-size: 12px; color: #666;">Телефон: ${order.phone}</div>
        </div>
        <div style="display: flex; gap: 20px; align-items: center;">
          <div><strong>${order.total_price} ₽</strong></div>
          <div class="admin-details" onclick="changeOrderStatus(${order.id}, '${order.status}')">Изменить статус</div>
        </div>
      </div>
    `).join('');
  }

  function generateHistoryOrders() {
    const historyOrders = <?php echo json_encode($historyOrders); ?>;
    if (historyOrders.length === 0) return '<div style="padding: 20px; text-align: center; color: #999;">Нет заказов в истории</div>';
    return historyOrders.map(order => `
      <div class="admin-card">
        <div>
          <div><strong>#${order.id}</strong> ${formatDate(order.created_at)}</div>
          <div class="admin-status">${statusMap[order.status] || order.status}</div>
        </div>
        <div style="display: flex; gap: 20px; align-items: center;">
          <div><strong>${order.total_price} ₽</strong></div>
        </div>
      </div>
    `).join('');
  }

  function generateProductsPage() {
    const products = <?php echo json_encode($products); ?>;
    return `
      <div class="admin-products">
        <div class="admin-product-form">
          <div class="admin-form-row">
            <div class="admin-form-group">
              <label>Название</label>
              <input type="text" id="prod-name" placeholder="">
            </div>
            <div class="admin-form-group">
              <label>Категория</label>
              <select id="prod-category">
                <option value="pizza">Пицца</option>
                <option value="snacks">Закуски</option>
                <option value="drinks">Напитки</option>
                <option value="desserts">Десерты</option>
                <option value="kombo">Комбо</option>
              </select>
            </div>
            <div class="admin-form-group">
              <label>Цена</label>
              <input type="text" id="prod-price" placeholder="">
            </div>
            <div class="admin-form-group">
              <label>Картинка</label>
              <input type="text" id="prod-img" placeholder="">
            </div>
          </div>
          <div class="admin-form-group admin-form-textarea">
            <label>Описание</label>
            <textarea id="prod-desc" rows="4"></textarea>
          </div>
          <div class="admin-form-actions">
            <button class="admin-save-btn" onclick="addProduct()">Добавить товар</button>
          </div>
        </div>

        <table class="admin-table">
          <thead>
            <tr>
              <th>Название</th>
              <th>Категория</th>
              <th>Цена</th>
              <th>Картинка</th>
              <th>Описание</th>
              <th>Действие</th>
            </tr>
          </thead>
          <tbody>
            ${products.map(p => `
              <tr>
                <td>${p.name}</td>
                <td>${p.category}</td>
                <td>${p.price}₽</td>
                <td>${p.img}</td>
                <td>${p.description.substring(0, 20)}...</td>
                <td><span class="admin-edit" onclick="deleteProduct(${p.id})">Удалить</span></td>
              </tr>
            `).join('')}
          </tbody>
        </table>
      </div>
    `;
  }

  const adminPages = {
    active: () => generateActiveOrders(),
    history: () => generateHistoryOrders(),
    products: () => generateProductsPage()
  };

  function adminLoadPage(page) {
    adminContent.innerHTML = adminPages[page]();
  }

  adminMenuItems.forEach(item => {
    item.addEventListener('click', () => {
      adminMenuItems.forEach(i => i.classList.remove('admin-active'));
      item.classList.add('admin-active');
      adminLoadPage(item.dataset.page);
    });
  });

  adminLoadPage('active');

  // ФУНКЦИИ CRUD
  async function addProduct() {
    const name = document.getElementById('prod-name')?.value || '';
    const category = document.getElementById('prod-category')?.value || '';
    const price = document.getElementById('prod-price')?.value || '';
    const img = document.getElementById('prod-img')?.value || '';
    const desc = document.getElementById('prod-desc')?.value || '';

    if (!name || !price) { alert('Заполните название и цену'); return; }

    const fd = new FormData();
    fd.append('action', 'create');
    fd.append('name', name);
    fd.append('category', category);
    fd.append('price', price);
    fd.append('img', img);
    fd.append('description', desc);

    try {
      const res = await fetch('./api/admin-products.php', { method: 'POST', body: fd });
      const data = await res.json();
      if (data.success) {
        location.reload();
      } else {
        alert(data.message || 'Ошибка');
      }
    } catch (err) {
      alert('Ошибка сети: ' + err.message);
    }
  }

  async function deleteProduct(id) {
    if (!confirm('Удалить товар?')) return;
    try {
      const res = await fetch('./api/admin-products.php', {
        method: 'POST',
        body: new URLSearchParams({ action: 'delete', id })
      });
      const data = await res.json();
      if (data.success) {
        location.reload();
      } else {
        alert(data.message || 'Ошибка');
      }
    } catch (err) {
      alert('Ошибка сети: ' + err.message);
    }
  }

  async function changeOrderStatus(orderId, currentStatus) {
    const statuses = ['pending', 'confirmed', 'preparing', 'ready', 'delivered', 'cancelled'];
    const nextStatus = prompt('Новый статус: ' + statuses.join(', '), currentStatus);
    if (!nextStatus || !statuses.includes(nextStatus)) return;

    try {
      const res = await fetch('./api/admin-orders.php', {
        method: 'POST',
        body: new URLSearchParams({ action: 'update_status', id: orderId, status: nextStatus })
      });
      const data = await res.json();
      if (data.success) {
        location.reload();
      } else {
        alert(data.message || 'Ошибка');
      }
    } catch (err) {
      alert('Ошибка сети: ' + err.message);
    }
  }
</script>

<?php include("include/footer.php"); ?>