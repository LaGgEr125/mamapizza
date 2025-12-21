<?php
$user = 'root';
$password = '';
$db = 'mompizza';
$host = 'localhost';

$mysqli = new mysqli($host,$user,$password,$db,);
if ($mysqli->connect_error) {
    die ("error rom MYDAK" . $mysqli->connect_error); 
}

?>