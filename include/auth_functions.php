<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/database.php';

function register_user($phone, $password, $email = '') {
    global $mysqli;
    $phone = trim($phone); $password = trim($password);
    if ($phone === '' || $password === '') return ['success'=>false,'message'=>'Телефон и пароль обязательны'];

    $stmt = $mysqli->prepare("SELECT id FROM users WHERE phone = ? LIMIT 1");
    $stmt->bind_param('s', $phone);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) { $stmt->close(); return ['success'=>false,'message'=>'Телефон уже зарегистрирован']; }
    $stmt->close();

    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $mysqli->prepare("INSERT INTO users (phone, email, password, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param('sss', $phone, $email, $hash);
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $stmt->close();
        return ['success'=>true,'message'=>'Регистрация успешна'];
    }
    $stmt->close();
    return ['success'=>false,'message'=>'Ошибка регистрации'];
}

function login_user($phone, $password) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT id, password, is_admin FROM users WHERE phone = ? LIMIT 1");
    $stmt->bind_param('s', $phone);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    $stmt->close();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = !empty($user['is_admin']);
        return ['success'=>true,'message'=>'Вход выполнен'];
    }
    return ['success'=>false,'message'=>'Неверный телефон или пароль'];
}

function logout_user() {
    if (session_status() === PHP_SESSION_ACTIVE) {
        unset($_SESSION['user_id'], $_SESSION['is_admin']);
        session_regenerate_id(true);
    }
    return ['success'=>true];
}
