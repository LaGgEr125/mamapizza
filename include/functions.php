<?php
function GetAllProducts($conn) {
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    return $result;
}

function GetPopularProducts($conn) {
    $sql = "SELECT * FROM products WHERE popular > 4 ORDER BY popular DESC LIMIT 4";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

?>