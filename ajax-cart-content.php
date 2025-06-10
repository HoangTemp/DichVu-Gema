<div class="container">
    <?php
    session_start();
    include './db_connect.php';
    if (!empty($_SESSION["cart"])) {
        $products = mysqli_query($conn, "SELECT * FROM `sanpham` WHERE `id` IN (" . implode(",", array_keys($_SESSION["cart"])) . ")");
    }
    ?>
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
                        <td class="product-quantity"><input oninput="javascript:updateQuantity(this.value)" type="text" value="<?= $_SESSION["cart"][$row['id']] ?>" name="soluong[<?= $row['id'] ?>]" /></td>
                        <td class="total-money"><?= number_format($row['gia'] * $_SESSION["cart"][$row['id']], 0, ",", ".") ?> đ</td>
                        <td class="product-delete">
                            <section class="wrap-button">
                                <section class="left-buy-button"></section>
                                 <section class="content-buy-button">
                                    <a href="javascript:deleteCart(<?= $row['id'] ?>)">Xóa</a>
                                </section>
                                <section class="right-buy-button"></section>
                                <section class="clear-both"></section>
                            </section>
                        </td>
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
                    <td class="product-delete"></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <section id="order-cart-button" class="wrap-button ">
            <section class="left-buy-button"></section>
            <section class="content-buy-button">
                <a href="checkout.php">Mua hàng</a>
            </section>
            <section class="right-buy-button"></section>
            <section class="clear-both"></section>
        </section>
    </form>

</div>