<?php
$host = "localhost";
$db = "mompizza";
$user = "root";
$pasword = "";

$conn = mysqli_connect($host, $user, $pasword, $db);

if ($conn->connect_error) {
    die("Ошибка соединения: ".$conn->connect_error);
}

?>