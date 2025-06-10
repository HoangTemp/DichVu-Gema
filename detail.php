<?php include 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/detail.css">
        <?php
        include './db_connect.php';
        $result = mysqli_query($conn, "SELECT * FROM `sanpham` WHERE `id` = ".$_GET['id']);
        $product = mysqli_fetch_assoc($result);
        $imgLibrary = mysqli_query($conn, "SELECT * FROM `sanpham` WHERE `id` = ".$_GET['id']);
        $product['images'] = mysqli_fetch_all($imgLibrary, MYSQLI_ASSOC);
        ?>
<section id="hot-products">
<section id="product-box" class="container">
        <section class="product-detail">
            <section id="product-name">
                <h1><?= $product['tensp'] ?></h1>
            </section>
            <section id="product-attributes">
                <section id="product-gallery">
                    <section id="main-image">
                        <img src="<?= $product['anh'] ?>"> 
                    </section>

                </section>  
                <section id="product-attribute-detail">
                    <section id="product-price"><span><?= number_format($product['gia'], 0, ",", ".") ?> Đ</span></section>
                    <hr>
                    <?php if ($product['soluong'] > 0) { ?>
                        <div class="product-quantity"><label>Tồn kho: </label><strong><?= $product['soluong'] ?></strong></div>

                        <form id="add-to-cart-form" action="cart.php?action=add" method="POST">
                            <label>Số lượng: </label>
                            <input type="text" value="1" name="soluong[<?= $product['id'] ?>]" size="2" style=" width: 30px; "><br>
                            <input type="submit" value="">
                        </form>
                    <?php } else { ?>
                        <span class="error">Hết hàng</span>
                    <?php } ?>
                </section>
                <section class="clear-both"></section>
            </section>
        </section>
    </section>
    <section id="product-heading" class="container">
        <ul>
            <li id="product-intro" class="active">Chi tiết sản phẩm</li>
            <li id="proudct-comment">Bình luận sản phẩm</li>
            <li class="clear-both" ></li>
        </ul>
    </section>
    <section id="product-content" class="container">
        <section id="product-display">
            <section id="produc-intro-content" class="display-box active">
                <?= $product['mota'] ?>
            </section>
            <section id="product-comment-content"  class="display-box">
                Nội dung bình luận
            </section>
        </section>
    </section>
</section>
<?php include("footer.php"); ?>