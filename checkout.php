<?php include 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/cart.css">
<?php
include './db_connect.php';
if (!empty($_SESSION["cart"])) {
    $products = mysqli_query($conn, "SELECT * FROM `sanpham` WHERE `id` IN (" . implode(",", array_keys($_SESSION["cart"])) . ")");
}
?>
<div id="checkout-content" class="container">
    <?php if (!empty($error)) { ?> 
        <div id="notify-msg">
            <?= $error ?>. <a href="javascript:history.back()">Quay lại</a>
        </div>
    <?php } elseif (!empty($success)) { ?>
        <div id="notify-msg">
            <?= $success ?>. <a href="index_2.php">Tiếp tục mua hàng</a>
        </div>
    <?php } else { ?>
        <a href="index_2.php">Trang chủ</a>
        <h1>Giỏ hàng</h1>
        <form id="cart-form" action="cart.php?action=submit" method="POST">
            <table>
                <tr>
                    <th class="product-number">STT</th>
                    <th class="product-name">Tên sản phẩm</th>
                    <th class="product-img">Ảnh sản phẩm</th>
                    <th class="product-price">Đơn giá</th>
                    <th class="product-quantity">Số lượng</th>
                    <th class="total-money">Thành tiền</th>
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
                            <td class="product-quantity"><?= $_SESSION["cart"][$row['id']] ?></td>
                            <td class="total-money"><?= number_format($row['gia'] * $_SESSION["cart"][$row['id']], 0, ",", ".") ?></td>
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
                    </tr>
                    <?php
                }
                ?>
            </table>
            <hr>
            <div><label>Người nhận: </label><input type="text" value="" name="ten" /></div>
            <div><label>Điện thoại: </label><input type="text" value="" name="sdt" /></div>
            <div><label>Địa chỉ: </label><input type="text" value="" name="fb" /></div>
            <div><label>Ghi chú: </label><textarea name="note" cols="50" rows="7" ></textarea></div>
            <section id="checkout-button" class="wrap-button ">
                <section class="left-buy-button"></section>
                <section class="content-buy-button">
                    <input type="submit" value="Đặt hàng" />
                </section>
                <section class="right-buy-button"></section>
                <section class="clear-both"></section>
            </section>
            <a href="category.php">Về trang danh sách sản phẩm</a>
        </form>
    <?php } ?>
    </div>
<?php include("footer.php"); ?>