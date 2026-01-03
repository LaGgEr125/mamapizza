<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
require_once __DIR__ . '/../include/database.php';

// Проверка прав администратора
if (empty($_SESSION['is_admin'])) {
    echo json_encode(['success' => false, 'message' => 'Доступ запрещён']);
    exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'create') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $img = trim($_POST['img'] ?? '');
    $desc = trim($_POST['description'] ?? '');

    if (!$name || !$category || !$price) {
        echo json_encode(['success' => false, 'message' => 'Заполните обязательные поля']);
        exit;
    }

    $stmt = $mysqli->prepare("INSERT INTO goods (name, category, price, img, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssdss', $name, $category, $price, $img, $desc);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка БД']);
    }
    $stmt->close();
    exit;
}

if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    $stmt = $mysqli->prepare("DELETE FROM goods WHERE id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка удаления']);
    }
    $stmt->close();
    exit;
}

echo json_encode(['success' => false, 'message' => 'Unknown action']);
exit;
