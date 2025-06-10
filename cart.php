<?php session_start(); ?>

<!DOCTYPE html>

<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/cart.css" >
    </head>
    <body>
        <?php
        include './db_connect.php';
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = array();
        }
        $GLOBALS['changed_cart'] = false;
        $error = false;
        $success = false;
        if (isset($_GET['action'])) {

            function update_cart($conn, $add = false) {
                foreach ($_POST['soluong'] as $id => $quantity) {
                    if ($quantity == 0) {
                        unset($_SESSION["cart"][$id]);
                    } else {
                        if (!isset($_SESSION["cart"][$id])) {
                            $_SESSION["cart"][$id] = 0;
                        }
                        var_dump($_SESSION["cart"][$id]);
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
            }

            switch ($_GET['action']) {
                case "add":
                    update_cart($conn, true);
                    if ($GLOBALS['changed_cart'] == false) {
                        header('Location: ./cart.php');
                    }
                    break;
                case "delete":
                    if (isset($_GET['id'])) {
                        unset($_SESSION["cart"][$_GET['id']]);
                    }
                    header('Location: ./cart.php');
                    break;
                case "submit":
                    if (isset($_POST['update_click'])) { //Cập nhật số lượng sản phẩm
                        update_cart($conn);
                        header('Location: ./cart.php');
                    } elseif ($_POST['order_click']) { //Đặt hàng sản phẩm
                        if (empty($_POST['ten'])) {
                            $error = "Bạn chưa nhập tên của người nhận";
                        } elseif (empty($_POST['sdt'])) {
                            $error = "Bạn chưa nhập số điện thoại người nhận";
                        } elseif (empty($_POST['fb'])) {
                            $error = "Bạn chưa nhập facebook người nhận";
                        } elseif (empty($_POST['soluong'])) {
                            $error = "Giỏ hàng rỗng";
                        }
                        if ($error == false && !empty($_POST['soluong'])) { //Xử lý lưu giỏ hàng vào db
                            $products = mysqli_query($conn, "SELECT * FROM `sanpham` WHERE `id` IN (" . implode(",", array_keys($_POST['soluong'])) . ")");
                            $total = 0;
                            $orderProducts = array();
                            $updateString = "";
                            while ($row = mysqli_fetch_array($products)) {
                                $orderProducts[] = $row;
                                if ($_POST['soluong'][$row['id']] > $row['soluong']) {
                                    $_POST['soluong'][$row['id']] = $row['soluong'];
                                    $GLOBALS['changed_cart'] = true;
                                } else {
                                    $total += $row['gia'] * $_POST['soluong'][$row['id']];
                                    $updateString .= " when id = ".$row['id']." then soluong - ".$_POST['soluong'][$row['id']];
                                }
                            }
                            if ($GLOBALS['changed_cart'] == false) {
                                $updateQuantity = mysqli_query($conn, "update `sanpham` set soluong = CASE".$updateString." END where id in (".implode(",", array_keys($_POST['soluong'])).")");
                                $insertOrder = mysqli_query($conn, "INSERT INTO `donhang` (`id`, `ten`, `sdt`, `fb`, `note`, `total`, `created_time`, `last_updated`) VALUES (NULL, '" . $_POST['ten'] . "', '" . $_POST['sdt'] . "', '" . $_POST['fb'] . "', '" . $_POST['note'] . "', '" . $total . "', '" . time() . "', '" . time() . "');");
                                $orderID = $conn->insert_id;
                                $insertString = "";
                                foreach ($orderProducts as $key => $product) {
                                    $insertString .= "(NULL, '" . $orderID . "', '" . $product['id'] . "', '" . $_POST['soluong'][$product['id']] . "', '" . $product['gia'] . "', '" . time() . "', '" . time() . "')";
                                    if ($key != count($orderProducts) - 1) {
                                        $insertString .= ",";
                                    }
                                }
                                $insertOrder = mysqli_query($conn, "INSERT INTO `chitiet_donhang` (`id`, `id_donhang`, `id_sanpham`, `soluong`, `gia`, `created_time`, `last_updated`) VALUES " . $insertString . ";");
                                $success = "Đặt hàng thành công";
                                unset($_SESSION['cart']);
                            }
                        }
                    }
                    break;
            }
        }
        if (!empty($_SESSION["cart"])) {
            $products = mysqli_query($conn, "SELECT * FROM `sanpham` WHERE `id` IN (" . implode(",", array_keys($_SESSION["cart"])) . ")");
        }
//        $result = mysqli_query($con, "SELECT * FROM `product` WHERE `id` = ".$_GET['id']);
//        $product = mysqli_fetch_assoc($result);
//        $imgLibrary = mysqli_query($con, "SELECT * FROM `image_library` WHERE `product_id` = ".$_GET['id']);
//        $product['images'] = mysqli_fetch_all($imgLibrary, MYSQLI_ASSOC);
        ?>
        <div class="container">
            <?php if (!empty($error)) { ?> 
                <div id="notify-msg">
                    <?= $error ?>. <a href="javascript:history.back()">Quay lại</a>
                </div>
            <?php } elseif (!empty($success)) { ?>
                <div id="notify-msg">
                    <?= $success ?>. <a href="index.php">Tiếp tục mua hàng</a>
                </div>
            <?php } else { ?>
                <a href="index.php">Trang chủ</a>
                <h1>Giỏ hàng</h1>
                <?php if ($GLOBALS['changed_cart']) { ?>
                    <h3>Số lượng sản phẩm trong giỏ hàng đã thay đổi, do lượng sản phẩm tồn kho không đủ. Vui lòng <a href="cart.php">tải lại</a> giỏ hàng</h3>
                <?php } else { ?>
                    <form id="cart-form" action="cart.php?action=submit" method="POST">
                        <table>
                            <tr>
                                <th class="product-number">STT</th>
                                <th class="product-name">Tên sản phẩm</th>
                                <th class="product-img">Ảnh sản phẩm</th>
                                <th class="product-price">Đơn giá</th>
                                <th class="product-quantity">Số lượng</th>
                                <th class="total-money">Thành tiền</th>
                                <th class="product-delete">Xóa</th>
                            </tr>
                            <?php
                            if (!empty($products)) {
                                $total = 0;
                                $num = 1;
                                while ($row = mysqli_fetch_array($products)) {
                                    ?>
                                    <tr>
                                        <td class="product-number"><?= $num++; ?></td>
                                        <td class="product-name"><?= $row['tensp'] ?></td>
                                        <td class="product-img"><img src="<?= $row['anh'] ?>" /></td>
                                        <td class="product-price"><?= number_format($row['gia'], 0, ",", ".") ?></td>
                                        <td class="product-quantity"><input type="text" value="<?= $_SESSION["cart"][$row['id']] ?>" name="soluong[<?= $row['id'] ?>]" /></td>
                                        <td class="total-money"><?= number_format($row['gia'] * $_SESSION["cart"][$row['id']], 0, ",", ".") ?></td>
                                        <td class="product-delete"><a href="cart.php?action=delete&id=<?= $row['id'] ?>">Xóa</a></td>
                                    </tr>
                                    <?php
                                    $total += $row['gia'] * $_SESSION["cart"][$row['id']];
                                    $num++;
                                }
                                ?>
                                <tr id="row-total">
                                    <td class="product-number">&nbsp;</td>
                                    <td class="product-name">Tổng tiền</td>
                                    <td class="product-img">&nbsp;</td>
                                    <td class="product-price">&nbsp;</td>
                                    <td class="product-quantity">&nbsp;</td>
                                    <td class="total-money"><?= number_format($total, 0, ",", ".") ?></td>
                                    <td class="product-delete">Xóa</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <div id="form-button">
                            <input type="submit" name="update_click" value="Cập nhật" />
                        </div>
                        <hr>
                        <div><label>Người nhận: </label><input type="text" value="" name="ten" /></div>
                        <div><label>Điện thoại: </label><input type="text" value="" name="sdt" /></div>
                        <div><label>Địa chỉ: </label><input type="text" value="" name="fb" /></div>
                        <div><label>Ghi chú: </label><textarea name="note" cols="50" rows="7" ></textarea></div>
                        <input type="submit" name="order_click" value="Đặt hàng" />
                    </form>
                <?php } ?>
            <?php } ?>
        </div>
    </body>
</html>