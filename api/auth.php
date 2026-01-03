<?php
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../include/auth_functions.php';

$action = $_POST['action'] ?? '';

if ($action === 'register') {
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $res = register_user($phone, $password, $email);
    echo json_encode($res); exit;
}

if ($action === 'login') {
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $res = login_user($phone, $password);
    echo json_encode($res); exit;
}

if ($action === 'logout') {
    $res = logout_user();
    echo json_encode($res); exit;
}

echo json_encode(['success'=>false,'message'=>'Unknown action']);
exit;
