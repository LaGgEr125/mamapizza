<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/database.php'; // предоставляет $mysqli

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

function cart_add_item($product_id, $size = '', $dough = '', $extras = [], $quantity = 1) {
    global $mysqli;
    $product_id = (int)$product_id;
    $quantity = max(1, (int)$quantity);

    $stmt = $mysqli->prepare("SELECT id, name, price, img FROM goods WHERE id = ? LIMIT 1");
    if (!$stmt) return ['success'=>false,'message'=>'DB error'];
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
    if (!$row) return ['success'=>false,'message'=>'Товар не найден'];

    $key = 'p'.$row['id'].'_'.md5($size.$dough.json_encode($extras));
    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$key] = [
            'key'=>$key,
            'product_id'=>$row['id'],
            'name'=>$row['name'],
            'price'=> (float)$row['price'],
            'img'=> $row['img'],
            'size'=>$size,
            'dough'=>$dough,
            'extras'=>$extras,
            'quantity'=>$quantity
        ];
    }
    return ['success'=>true,'key'=>$key];
}

function cart_get_items() {
    return array_values($_SESSION['cart'] ?? []);
}

function cart_count() {
    $c = 0;
    foreach ($_SESSION['cart'] ?? [] as $it) $c += (int)$it['quantity'];
    return $c;
}

function cart_total() {
    $t = 0;
    foreach ($_SESSION['cart'] ?? [] as $it) $t += $it['price'] * $it['quantity'];
    return $t;
}

function cart_remove_item($key) {
    if (isset($_SESSION['cart'][$key])) { unset($_SESSION['cart'][$key]); return true; }
    return false;
}

function cart_update_quantity($key, $quantity) {
    $quantity = max(0, (int)$quantity);
    if ($quantity === 0) return cart_remove_item($key);
    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['quantity'] = $quantity;
        return true;
    }
    return false;
}

function cart_clear() {
    $_SESSION['cart'] = [];
    return true;
}
