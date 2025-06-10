<?php

session_start();
include './db_connect.php';
include './func_libs.php';

$GLOBALS['connection'] = $conn;
switch ($_GET['action']) {
    case "add":
        $result = update_cart(true);
        $totalQuantity = getTotalQuantity();
        $result['total_quantity'] = $totalQuantity;
        echo json_encode($result);
        break;
    case "update":
        $result = update_cart();
        $totalQuantity = getTotalQuantity();
        $result['total_quantity'] = $totalQuantity;
        echo json_encode($result);
        break;
    case "delete":
        if (isset($_POST['id'])) {
            unset($_SESSION["cart"][$_POST['id']]);
        }
        echo json_encode(array(
            'status' => 1,
            'message' => 'Xóa sản phẩm thành công',
            'total_quantity' => getTotalQuantity()
        ));
        break;
    case "submit":
        if(empty($_SESSION["cart"])){
            echo json_encode(array(
                'status' => 0,
                'message' => "Giỏ hàng rỗng. Bạn vui lòng lựa chọn sản phẩm vào giỏ hàng."
            ));exit;
        }
        $products = mysqli_query($conn, "SELECT * FROM `sanpham` WHERE `id` IN (" . implode(",", array_keys($_SESSION["cart"])) . ")");
        $total = 0;
        $orderProducts = array();
        $updateString = "";
        $changeQuantity = false;
        while ($row = mysqli_fetch_array($products)) {
            $orderProducts[] = $row;
            if ($_SESSION["cart"][$row['id']] > $row['soluong']) { //Thay đổi số lượng sản phẩm trong giỏ hàng
                $_SESSION["cart"][$row['id']] = $row['soluong'];
                $changeQuantity = true;
            } else {
                $total += $row['gia'] * $_SESSION["cart"][$row['id']];
                $updateString .= " when id = " . $row['id'] . " then soluong - " . $_SESSION["cart"][$row['id']]; //Trừ đi sản phẩm tồn kho
            }
        }
        if ($changeQuantity == false) {
            $updateQuantity = mysqli_query($conn, "update `sanpham` set soluong = CASE" . $updateString . " END where id in (" . implode(",", array_keys($_SESSION["cart"])) . ")");
            $insertOrder = mysqli_query($conn, "INSERT INTO `donhang` (`id`, `ten`, `sdt`, `fb`, `note`, `total`, `created_time`, `last_updated`) VALUES (NULL, '" . $_POST['ten'] . "', '" . $_POST['sdt'] . "', '" . $_POST['fb'] . "', '" . $_POST['note'] . "', '" . $total . "', '" . time() . "', '" . time() . "');");
            $orderID = $conn->insert_id;
            $insertString = "";
            foreach ($orderProducts as $key => $product) {
                $insertString .= "(NULL, '" . $orderID . "', '" . $product['id'] . "', '" . $_SESSION["cart"][$product['id']] . "', '" . $product['gia'] . "', '" . time() . "', '" . time() . "')";
                if ($key != count($orderProducts) - 1) {
                    $insertString .= ",";
                }
            }
            $insertOrder = mysqli_query($conn, "INSERT INTO `chitiet_donhang` (`id`, `id_donhang`, `id_sanpham`, `soluong`, `gia`, `created_time`, `last_updated`) VALUES " . $insertString . ";");
            unset($_SESSION['cart']);
            echo json_encode(array(
                'status' => 1,
                'message' => "Đặt hàng thành công."
            ));
        } else {
            echo json_encode(array(
                'status' => 0,
                'message' => "Đặt hàng không thành công do số lượng sản phẩm tồn kho không đủ. Bạn vui lòng kiểm tra lại giỏ hàng"
            ));
        }
        break;
    default:
        break;
}
function update_cart($add = false) {
    $changeQuantity = false;
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
            $addProduct = mysqli_query($GLOBALS['connection'], "SELECT `soluong` FROM `sanpham` WHERE `id` = " . $id);
            $addProduct = mysqli_fetch_assoc($addProduct);
            if ($_SESSION["cart"][$id] > $addProduct['soluong']) {
                $_SESSION["cart"][$id] = $addProduct['soluong'];
                if ($add) {
                    return array(
                        'status' => 0,
                        'message' => "Số lượng sản phẩm tồn kho chỉ còn: " . $addProduct['soluong'] . " sản phẩm. Bạn vui lòng kiểm tra lại giỏ hàng."
                    );
                } else {
                    $changeQuantity = true;
                }
            }
            if ($add) {
                return array(
                    'status' => 1,
                    'message' => "Thêm sản phẩm thành công"
                );
            }
        }
    }
    if ($changeQuantity) {
        return array(
            'status' => 1,
            'message' => "Số lượng sản phẩm trong giỏ hàng đã thay đổi do số lượng tồn kho không đủ. Bạn vui lòng kiểm tra lại giỏ hàng"
        );
    } else {
        return array(
            'status' => 1,
            'message' => "Cập nhật giỏ hàng thành công"
        );
    }
}
