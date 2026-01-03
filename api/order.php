<?php
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../include/database.php';
require_once __DIR__ . '/../include/cart_functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Use POST']);
    exit;
}
$action = $_POST['action'] ?? 'create';
if ($action !== 'create') {
    echo json_encode(['success' => false, 'message' => 'Unknown action']);
    exit;
}

$cart = cart_get_items();
if (empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Корзина пуста']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['delivery_address'] ?? '');
$notes = trim($_POST['notes'] ?? '');

$total = cart_total();
$userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

$stmt = $mysqli->prepare("INSERT INTO orders (user_id, total_price, delivery_address, phone, notes, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->bind_param('idsss', $userId, $total, $address, $phone, $notes);
if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Ошибка создания заказа']);
    exit;
}
$orderId = $stmt->insert_id;
$stmt->close();

$stmtItem = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, size_label, quantity, price) VALUES (?, ?, ?, ?, ?)");
foreach ($cart as $it) {
    $pid = (int)$it['product_id'];
    $size = $it['size'] ?? '';
    $qty = (int)$it['quantity'];
    $price = (float)$it['price'];
    $stmtItem->bind_param('iisis', $orderId, $pid, $size, $qty, $price);
    $stmtItem->execute();
}
$stmtItem->close();

cart_clear();
echo json_encode(['success' => true, 'order_id' => $orderId]);
exit;
