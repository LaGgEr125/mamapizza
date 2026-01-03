<?php
$user = 'root';
$password = '';
$db = 'mamapizza';
$host = 'localhost';

// Подключаемся сначала к серверу без выбора БД
$mysqli = new mysqli($host, $user, $password);
if ($mysqli->connect_error) {
    die("Ошибка подключения к MySQL: " . $mysqli->connect_error);
}

// Если БД нет — создаём и импортируем init.sql
$haveDb = $mysqli->select_db($db);
if (!$haveDb) {
    if (!$mysqli->query("CREATE DATABASE IF NOT EXISTS `{$db}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
        die("Не удалось создать базу: " . $mysqli->error);
    }
    $mysqli->select_db($db);
    $init = __DIR__ . '/../database/init.sql';
    if (file_exists($init)) {
        $sql = file_get_contents($init);
        if ($sql !== false) {
            if (!$mysqli->multi_query($sql)) {
                // Попытка выполнить много-запрос — в лог
                error_log("Ошибка инициализации БД: " . $mysqli->error);
            } else {
                // очистим все результирующие наборы
                do {
                    if ($res = $mysqli->store_result()) $res->free();
                } while ($mysqli->more_results() && $mysqli->next_result());
            }
        }
    }
} else {
    $mysqli->select_db($db);
}
?>