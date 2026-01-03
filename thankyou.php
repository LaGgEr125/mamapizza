<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/include/database.php';
$title = "Спасибо";
include("include/header.php");

$order = null;
$items = [];

if (!empty($_GET['order_id'])) {
    $orderId = (int)$_GET['order_id'];
    $stmt = $mysqli->prepare("SELECT * FROM orders WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $res = $stmt->get_result();
    $order = $res->fetch_assoc();
    $stmt->close();

    if ($order) {
        $stmt = $mysqli->prepare("SELECT * FROM order_items WHERE order_id = ? ORDER BY id ASC");
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
}
?>

<main class="min-h-screen bg-gradient-to-b from-orange-50 to-white py-12">
    <div class="container mx-auto px-4 max-w-2xl">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800">Спасибо за заказ! ✅</h1>
            <?php if ($order): ?>
                <p class="text-gray-600 mt-2">Заказ №<?php echo htmlspecialchars($order['id']); ?> успешно создан</p>
            <?php endif; ?>
        </div>

        <?php if ($order): ?>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Детали заказа</h2>
                <div class="space-y-2">
                    <p><span class="font-semibold">Номер:</span> <?php echo htmlspecialchars($order['id']); ?></p>
                    <p><span class="font-semibold">Адрес доставки:</span> <?php echo htmlspecialchars($order['delivery_address']); ?></p>
                    <p><span class="font-semibold">Телефон:</span> <?php echo htmlspecialchars($order['phone']); ?></p>
                    <p><span class="font-semibold">Статус:</span> <span class="text-orange-600 font-bold"><?php echo ucfirst($order['status']); ?></span></p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Состав заказа</h2>
                <div class="space-y-2 border-b pb-4 mb-4">
                    <?php foreach ($items as $item): ?>
                        <div class="flex justify-between text-sm">
                            <span><?php echo htmlspecialchars($item['size_label'] ?? 'Товар'); ?></span>
                            <span><?php echo $item['quantity']; ?> × <?php echo $item['price']; ?> = <?php echo $item['quantity'] * $item['price']; ?> ₽</span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="flex justify-between font-bold text-lg">
                    <span>Итого:</span>
                    <span class="text-orange-600"><?php echo htmlspecialchars($order['total_price']); ?> ₽</span>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <p class="text-gray-600 mb-4">Заказ не найден</p>
                <a href="./index.php" class="inline-block px-6 py-2 bg-orange-500 text-white rounded-md">Вернуться в магазин</a>
            </div>
        <?php endif; ?>

        <div class="text-center mt-8">
            <a href="./index.php" class="inline-block px-6 py-2 border border-orange-500 text-orange-500 rounded-md font-semibold hover:bg-orange-50">Вернуться в магазин</a>
        </div>
    </div>
</main>

<?php include("include/footer.php"); ?>