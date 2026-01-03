<?php
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../include/cart_functions.php';

$action = $_REQUEST['action'] ?? 'get';

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = (int)($_POST['product_id'] ?? 0);
    $size = $_POST['size'] ?? '';
    $dough = $_POST['dough'] ?? '';
    $qty = max(1, (int)($_POST['quantity'] ?? 1));
    $extras = !empty($_POST['extras']) ? json_decode($_POST['extras'], true) : [];
    $res = cart_add_item($product_id, $size, $dough, $extras, $qty);
    echo json_encode(['success'=>!!$res['success'],'count'=>cart_count(),'total'=>cart_total(),'message'=>$res['message'] ?? null]);
    exit;
}

if ($action === 'get') {
    echo json_encode(['success'=>true,'items'=>cart_get_items(),'count'=>cart_count(),'total'=>cart_total()]);
    exit;
}

if ($action === 'remove' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = $_POST['key'] ?? '';
    $ok = cart_remove_item($key);
    echo json_encode(['success'=>$ok,'count'=>cart_count(),'total'=>cart_total()]);
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = $_POST['key'] ?? '';
    $qty = (int)($_POST['quantity'] ?? 1);
    $ok = cart_update_quantity($key, $qty);
    echo json_encode(['success'=>$ok,'count'=>cart_count(),'total'=>cart_total()]);
    exit;
}

if ($action === 'clear') {
    cart_clear();
    echo json_encode(['success'=>true,'count'=>0,'total'=>0]);
    exit;
}

echo json_encode(['success'=>false,'message'=>'Unknown action']);
exit;
