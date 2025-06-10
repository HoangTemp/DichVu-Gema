<?php
session_start();
$id = (array_keys($_POST['soluong']))[0];
$quantity = $_POST['soluong'][$id];
include './db_connect.php';
//Kiểm tra số lượng sản phẩm tồn kho
$addProduct = mysqli_query($conn, "SELECT `soluong` FROM `sanpham` WHERE `id` = " . $id);
$addProduct = mysqli_fetch_assoc($addProduct);
if(isset($_SESSION["cart"][$id])){
    $quantity += $_SESSION["cart"][$id];
}
if ($quantity > $addProduct['soluong']) {
    echo json_encode("Số lượng tồn kho không đủ, bạn chỉ có thể mua tối đa: " . $addProduct['soluong'] . " sản phẩm. Bạn vui lòng kiểm tra lại giỏ hàng.");
}else{
    echo json_encode(true);
}