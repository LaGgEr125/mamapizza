<?php
session_start();
require_once "include/database.php";

$title = "Детали заказа";
include("include/header.php");

if (empty($_SESSION['user_id']) || empty($_GET['id'])) {
    echo '<div class="container mx-auto px-4 py-12"><p class="text-center">Заказ не найден</p></div>';
    include("include/footer.php");
    exit;
}

$userId = (int)$_SESSION['user_id'];
$orderId = (int)$_GET['id'];

$stmt = $mysqli->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ? LIMIT 1");
$stmt->bind_param('ii', $orderId, $userId);
$stmt->execute();
$res = $stmt->get_result();
$order = $res->fetch_assoc();
$stmt->close();

if (!$order) {
    echo '<div class="container mx-auto px-4 py-12"><p class="text-center">Заказ не найден</p></div>';
    include("include/footer.php");
    exit;
}

$stmt = $mysqli->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->bind_param('i', $orderId);
$stmt->execute();
$res = $stmt->get_result();
$items = [];
while ($row = $res->fetch_assoc()) {
    $items[] = $row;
}
$stmt->close();

$statusClass = 'bg-gray-100 text-gray-700';
$statusText = 'В ожидании';

if ($order['status'] === 'confirmed') { $statusClass = 'bg-blue-100 text-blue-700'; $statusText = 'Подтверждён'; }
elseif ($order['status'] === 'preparing') { $statusClass = 'bg-purple-100 text-purple-700'; $statusText = 'Готовится'; }
elseif ($order['status'] === 'ready') { $statusClass = 'bg-green-100 text-green-700'; $statusText = 'Готов'; }
elseif ($order['status'] === 'delivered') { $statusClass = 'bg-emerald-100 text-emerald-700'; $statusText = 'Доставлен'; }
elseif ($order['status'] === 'cancelled') { $statusClass = 'bg-red-100 text-red-700'; $statusText = 'Отменён'; }
?>

<main class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-2xl">
        <a href="./account.php" class="inline-block text-brand font-semibold mb-6">← Назад</a>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Заказ #<?php echo htmlspecialchars($order['id']); ?></h1>
                <span class="text-sm font-semibold px-4 py-2 rounded-full <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b">
                <div>
                    <p class="text-sm text-gray-600">Дата заказа</p>
                    <p class="text-lg font-semibold"><?php echo date('d.m.Y H:i', strtotime($order['created_at'])); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Сумма</p>
                    <p class="text-lg font-semibold text-brand"><?php echo htmlspecialchars($order['total_price']); ?> ₽</p>
                </div>
            </div>

            <div class="mb-6 pb-6 border-b">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Состав заказа</h2>
                <div class="space-y-3">
                    <?php foreach ($items as $item): ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-700"><?php echo $item['quantity']; ?> × <?php echo $item['size_label']; ?></span>
                            <span class="font-semibold"><?php echo ($item['price'] * $item['quantity']); ?> ₽</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-bold text-gray-800 mb-4">Адрес доставки</h2>
                <p class="text-gray-700"><?php echo htmlspecialchars($order['delivery_address']); ?></p>
                <p class="text-gray-700 mt-2">Телефон: <?php echo htmlspecialchars($order['phone']); ?></p>
                <?php if (!empty($order['notes'])): ?>
                    <p class="text-gray-700 mt-2">Комментарий: <?php echo htmlspecialchars($order['notes']); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include("include/footer.php"); ?>
