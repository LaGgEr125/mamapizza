<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
require_once __DIR__ . '/../include/database.php';

if (empty($_SESSION['is_admin'])) {
    echo json_encode(['success' => false, 'message' => 'Доступ запрещён']);
    exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'update_status') {
    $id = (int)($_POST['id'] ?? 0);
    $status = trim($_POST['status'] ?? '');

    if (!in_array($status, ['pending', 'confirmed', 'preparing', 'ready', 'delivered', 'cancelled'])) {
        echo json_encode(['success' => false, 'message' => 'Неверный статус']);
        exit;
    }

    $stmt = $mysqli->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $status, $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка БД']);
    }
    $stmt->close();
    exit;
}

echo json_encode(['success' => false, 'message' => 'Unknown action']);
exit;
