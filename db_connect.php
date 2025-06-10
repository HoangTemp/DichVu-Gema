<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "banhang";
$conn = mysqli_connect($host, $user, $password, $database);
if (mysqli_connect_error()){
    echo "Connection Fail: ".mysqli_connect_error();exit;
}
mysqli_set_charset($conn,"utf8");
?>