<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/include/database.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// Вспомогательные функции
function cart_count() {
    $c = 0;
    foreach ($_SESSION['cart'] as $it) $c += (int)$it['quantity'];
    return $c;
}
function cart_total() {
    $t = 0;
    foreach ($_SESSION['cart'] as $it) $t += $it['price'] * $it['quantity'];
    return $t;
}

$action = $_REQUEST['action'] ?? ($_POST['action'] ?? 'get');
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) || (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);

if ($action === 'add') {
    $product_id = (int)($_POST['product_id'] ?? 0);
    $size = $_POST['size'] ?? '';
    $dough = $_POST['dough'] ?? '';
    $qty = max(1, (int)($_POST['quantity'] ?? 1));
    $extras = [];
    if (!empty($_POST['extras'])) {
        $extras = json_decode($_POST['extras'], true) ?: [];
    }

    // Получаем товар из БД
    $stmt = $mysqli->prepare("SELECT id, name, price, img FROM goods WHERE id = ? LIMIT 1");
    if (!$stmt) {
        $resp = ['success' => false, 'message' => 'Ошибка БД'];
        if ($isAjax) { echo json_encode($resp); exit; } else { header('Location: index.php'); exit; }
    }
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

    if (!$row) {
        $resp = ['success' => false, 'message' => 'Товар не найден'];
        if ($isAjax) { echo json_encode($resp); exit; } else { header('Location: index.php'); exit; }
    }

    // Ключ — уникален по продукту и варианту
    $key = 'p'.$row['id'].'_s'.md5($size.$dough.json_encode($extras));
    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['quantity'] += $qty;
    } else {
        $_SESSION['cart'][$key] = [
            'key' => $key,
            'product_id' => (int)$row['id'],
            'name' => $row['name'],
            'price' => (float)$row['price'],
            'img' => $row['img'],
            'size' => $size,
            'dough' => $dough,
            'extras' => $extras,
            'quantity' => $qty
        ];
    }

    $resp = ['success' => true, 'count' => cart_count(), 'total' => cart_total()];
    if ($isAjax) { echo json_encode($resp); exit; } else { header('Location: index.php'); exit; }
}

if ($action === 'get') {
    $items = array_values($_SESSION['cart']);
    $resp = ['success' => true, 'items' => $items, 'count' => cart_count(), 'total' => cart_total()];
    echo json_encode($resp); exit;
}

if ($action === 'remove') {
    $key = $_POST['key'] ?? '';
    if ($key && isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
    }
    $resp = ['success' => true, 'count' => cart_count(), 'total' => cart_total()];
    if ($isAjax) { echo json_encode($resp); exit; } else { header('Location: cart.php'); exit; }
}

if ($action === 'update') {
    $key = $_POST['key'] ?? '';
    $qty = max(0, (int)($_POST['quantity'] ?? 1));
    if ($key && isset($_SESSION['cart'][$key])) {
        if ($qty === 0) unset($_SESSION['cart'][$key]); else $_SESSION['cart'][$key]['quantity'] = $qty;
    }
    $resp = ['success' => true, 'count' => cart_count(), 'total' => cart_total()];
    if ($isAjax) { echo json_encode($resp); exit; } else { header('Location: cart.php'); exit; }
}

// По умолчанию — вернуть состояние
$items = array_values($_SESSION['cart']);
echo json_encode(['success' => true, 'items' => $items, 'count' => cart_count(), 'total' => cart_total()]);
exit;
