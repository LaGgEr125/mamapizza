<?php
session_start();
require_once "include/database.php";

$title = "Аккаунт";
include("include/header.php");

// Проверка авторизации
if (empty($_SESSION['user_id'])) {
    echo '<div class="container mx-auto px-4 py-12 text-center"><p class="text-gray-600">Пожалуйста, <a href="./auth.php" class="text-brand">авторизуйтесь</a></p></div>';
    include("include/footer.php");
    exit;
}

$userId = (int)$_SESSION['user_id'];

// Получаем данные пользователя
$user = [];
$stmt = $mysqli->prepare("SELECT id, first_name, last_name, phone, email FROM users WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $userId);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$stmt->close();

// Получаем заказы пользователя
$orders = [];
$stmt = $mysqli->prepare("SELECT id, total_price, status, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
$stmt->bind_param('i', $userId);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $orders[] = $row;
}
$stmt->close();
?>

<main class="min-h-screen bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold mb-12 text-gray-900">Мой аккаунт</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Левая колонка: Редактирование профиля -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Личные данные</h2>

                <form id="profileForm" class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Имя</label>
                            <input type="text" name="first_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent" value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Фамилия</label>
                            <input type="text" name="last_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent" value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Телефон</label>
                            <input type="tel" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Email</label>
                            <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div id="profileError" class="hidden p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"></div>
                    <div id="profileSuccess" class="hidden p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm"></div>

                    <button type="submit" class="w-full py-3 px-6 bg-brand text-white font-bold rounded-lg hover:bg-orange-700 transition-colors" style="background: #FF8904;">Сохранить изменения</button>
                </form>

                <div class="mt-8 pt-8 border-t">
                    <button onclick="logoutUser()" class="w-full py-3 px-6 bg-red-500 text-white font-bold rounded-lg hover:bg-red-600 transition-colors">Выход из аккаунта</button>
                </div>
            </div>

            <!-- Правая колонка: История заказов -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Заказы</h2>

                <?php if (empty($orders)): ?>
                    <div class="text-center py-12 text-gray-500">
                        <p class="mb-6 text-lg">У вас нет заказов</p>
                        <a href="./index.php" class="inline-block px-6 py-3 bg-brand text-white font-bold rounded-lg hover:bg-orange-700 transition-colors" style="background: #FF8904;">Сделать заказ</a>
                    </div>
                <?php else: ?>
                    <div class="space-y-4 max-h-[600px] overflow-y-auto">
                        <?php foreach ($orders as $order): 
                            $statusClass = 'bg-gray-100 text-gray-700';
                            $statusText = 'В ожидании';
                            
                            if ($order['status'] === 'confirmed') { $statusClass = 'bg-blue-100 text-blue-700'; $statusText = 'Подтверждён'; }
                            elseif ($order['status'] === 'preparing') { $statusClass = 'bg-purple-100 text-purple-700'; $statusText = 'Готовится'; }
                            elseif ($order['status'] === 'ready') { $statusClass = 'bg-green-100 text-green-700'; $statusText = 'Готов'; }
                            elseif ($order['status'] === 'delivered') { $statusClass = 'bg-emerald-100 text-emerald-700'; $statusText = 'Доставлен'; }
                            elseif ($order['status'] === 'cancelled') { $statusClass = 'bg-red-100 text-red-700'; $statusText = 'Отменён'; }
                        ?>
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-brand transition-colors">
                                <div class="flex justify-between items-start gap-2 mb-2">
                                    <h3 class="font-semibold text-gray-900">№<?php echo htmlspecialchars($order['id']); ?></h3>
                                    <span class="text-xs font-bold px-2 py-1 rounded-full <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                </div>
                                <p class="text-xs text-gray-500 mb-2"><?php echo date('d.m.Y', strtotime($order['created_at'])); ?></p>
                                <p class="text-lg font-bold text-brand"><?php echo htmlspecialchars($order['total_price']); ?> ₽</p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script>
(function() {
    const form = document.getElementById('profileForm');
    const errorEl = document.getElementById('profileError');
    const successEl = document.getElementById('profileSuccess');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        errorEl.classList.add('hidden');
        successEl.classList.add('hidden');

        const fd = new FormData(this);
        fd.append('action', 'update_profile');

        try {
            const res = await fetch('./api/profile.php', { 
                method: 'POST', 
                body: fd,
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();

            if (data.success) {
                successEl.textContent = 'Данные успешно обновлены';
                successEl.classList.remove('hidden');
                setTimeout(() => successEl.classList.add('hidden'), 3000);
            } else {
                errorEl.textContent = data.message || 'Ошибка при обновлении';
                errorEl.classList.remove('hidden');
            }
        } catch (err) {
            console.error('Error:', err);
            errorEl.textContent = 'Ошибка сети: ' + err.message;
            errorEl.classList.remove('hidden');
        }
    });
})();

function logoutUser() {
    if (confirm('Вы уверены?')) {
        const fd = new FormData();
        fd.append('action', 'logout');
        fetch('./api/auth.php', { 
            method: 'POST', 
            body: fd,
            headers: { 'Accept': 'application/json' }
        }).then(() => {
            window.location.href = './index.php';
        });
    }
}
</script>

<?php include("include/footer.php"); ?>