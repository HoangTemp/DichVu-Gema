<?php
session_start();
include './db_connect.php';
switch ($_GET['action']) {
    case "add":
        $result = update_cart(true);
        echo json_encode(array(
            'status'=>$result,
            'message'=>"Thêm sản phẩm thành công"
        ));
        break;
    default:
        break;
}

function update_cart($add = false) {
    foreach ($_POST['soluong'] as $id => $quantity) {
        if ($quantity == 0) {
            unset($_SESSION["cart"][$id]);
        } else {
            if (!isset($_SESSION["cart"][$id])) {
                $_SESSION["cart"][$id] = 0;
            }
            if ($add) {
                $_SESSION["cart"][$id] += $quantity;
            } else {
                $_SESSION["cart"][$id] = $quantity;
            }
            //Kiểm tra số lượng sản phẩm tồn kho
           $addProduct = mysqli_query($conn, "SELECT `soluong` FROM `sanpham` WHERE `id` = " . $id);
           $addProduct = mysqli_fetch_assoc($addProduct);
           if ($_SESSION["cart"][$id] > $addProduct['soluong']) {
               $_SESSION["cart"][$id] = $addProduct['soluong'];
               $GLOBALS['changed_cart'] = true;
           }
        }
    }
    return true;
}
