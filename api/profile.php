<?php
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../include/database.php';

if (empty($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Не авторизованы']);
    exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'update_profile') {
    $userId = (int)$_SESSION['user_id'];
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (!$firstName || !$lastName || !$phone || !$email) {
        echo json_encode(['success' => false, 'message' => 'Заполните все поля']);
        exit;
    }

    $stmt = $mysqli->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ?, email = ? WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Ошибка БД: ' . $mysqli->error]);
        exit;
    }
    $stmt->bind_param('ssssi', $firstName, $lastName, $phone, $email, $userId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Данные обновлены']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка: ' . $stmt->error]);
    }
    $stmt->close();
    exit;
}

echo json_encode(['success' => false, 'message' => 'Unknown action']);
exit;
