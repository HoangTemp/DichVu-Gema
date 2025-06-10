<?php include 'header.php'; ?>

<?php
$param = "";
$sortParam = "";
$orderConditon = "";
//Tìm kiếm
$search = isset($_GET['tensp']) ? $_GET['tensp'] : "";
if ($search) {
    $where = "WHERE `tensp` LIKE '%" . $search . "%'";
    $param .= "tensp=" . $search . "&";
    $sortParam = "tensp=" . $search . "&";
}

//Sắp xếp
$orderField = isset($_GET['field']) ? $_GET['field'] : "";
$orderSort = isset($_GET['sort']) ? $_GET['sort'] : "";
if (!empty($orderField) && !empty($orderSort)) {
    $orderConditon = "ORDER BY `sanpham`.`" . $orderField . "` " . $orderSort;
    $param .= "field=" . $orderField . "&sort=" . $orderSort . "&";
}

include './db_connect.php';
$item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 12;
$current_page = !empty($_GET['page']) ? $_GET['page'] : 1; //Trang hiện tại
$offset = ($current_page - 1) * $item_per_page;
if ($search) {
    $products = mysqli_query($conn, "SELECT * FROM `sanpham` WHERE `tensp` LIKE '%" . $search . "%' " . $orderConditon . "  LIMIT " . $item_per_page . " OFFSET " . $offset);
    $totalRecords = mysqli_query($conn, "SELECT * FROM `sanpham` WHERE `tensp` LIKE '%" . $search . "%'");
} else {
    $products = mysqli_query($conn, "SELECT * FROM `sanpham` " . $orderConditon . " LIMIT " . $item_per_page . " OFFSET " . $offset);
    $totalRecords = mysqli_query($conn, "SELECT * FROM `sanpham`");
}
$totalRecords = $totalRecords->num_rows;
$totalPages = ceil($totalRecords / $item_per_page);
?>
<section id="product-filter">
    <section class="container">
        <label>Filter</label>
        <section id="brand-filter" class="filter-column">
            <h2>Game hỗ trợ</h2>
            <section id="brand-list">
                <ul>
                    <li><a href="#">Genshin</a></li>
                    <li><a href="#">Arknights</a></li>
                    <li><a href="#">Honkai:SR</a></li>
                    <li><a href="#">Tof</a></li>
                    <li><a href="#">Honkai I3</a></li>
                    <li><a href="#">Gov:NIKKE</a></li>
                    <li><a href="#">Tốc Chiến</a></li>
                    <li><a href="#">PUBG</a></li>
                    <li><a href="#">Free Fire</a></li>
                    <li><a href="#">Play Together</a></li>
                    <li><a href="#">Counter:Side</a></li>
                    <li><a href="#">Liên quân</a></li>
                    <li><a href="#">Diabo</a></li>
                    <li class="clear-both"></li>
                </ul>
            </section>
        </section>
        <section id="category-statistic" class="filter-column">
            <section class="category">
                <h3>Tiêu dùng</h3>
                <section class="category-image" >
                    <a href="filter.php?maloai=5"> 
                    <img src="./anh/aaa111111111.png" style="width:80%" /> 
                </section>
                <section class="total-product">Tổng</section>
                <section class="number-product" >357 sản phẩm</section>
                <img src="images/product-list-icon.png" />
            </a></section>
            <section class="category center-block">
                <h3>Cày thuê</h3>
                <section class="category-image">
                    <a href="filter.php?maloai=3"> 
                    <img src="./anh/slideopy23.png" style="width:80%"/>
                </section>
                <section class="total-product">Tổng</section>
                <section class="number-product">125 sản phẩm</section>
                <img src="images/product-list-icon.png" />
            </a>
            </section>
            <section class="category">
                <h3>Nạp game</h3>
                <section class="category-image">
                    <a href="filter.php?maloai=1"> 
                    <img src="./anh/nap.png" style="width:80%" />
                </section>
                <section class="total-product">Tổng</section>
                <section class="number-product">251 sản phẩm</section>
                <img src="images/product-list-icon.png" />
            </a>
            </section>
            <section class="clear-both"></section>
        </section>
        <section id="property-filter" class="filter-column">
            <img src="images/property-filter.jpg" />
        </section>
        <section class="clear-both"></section>
    </section>
</section>
<section id="hot-products">
    <section class="container">
        <section class="heading-title">
            <h2>Sản phẩm <span>hot</span></h2>
            <a href="category.php"><img src="images/arrow.png" />Xem tất cả</a>
            <section class="clear-both"></section>
        </section>
        <section class="box-content">
            <?php
            $num = 1;
            while ($row = mysqli_fetch_array($products)) {
                ?>
                <section class="product-item <?php if ($num % 4 == 1) { ?> first-line <?php } ?> ">
                    <section class="product-image"><a href="detail.php?id=<?= $row['id'] ?>"><img src="<?= $row['anh'] ?>" title="<?= $row['tensp'] ?>" /></a></section>
                    <section class="product-name"><a href="detail.php?id=<?= $row['id'] ?>"><?= $row['tensp'] ?></a></section>
                    <section class="wrap-button">
                        <section class="left-buy-button"></section>
                        <section class="content-buy-button">
                            <?php if ($row['soluong'] > 0) { ?>
                                <section class="product-price"><?= number_format($row['gia'], 0, ",", ".") ?> đ</section>
                                <form class="quick-buy-form" action="cart.php?action=add" method="POST">
                                    <input type="hidden" value="1" name="soluong[<?= $row['id'] ?>]" />
                                    <input type="submit" value="Mua ngay" />
                                </form>
                            <?php } else { ?>
                                <a href="#">Hết hàng</a>
                            <?php } ?>
                        </section>
                        <section class="right-buy-button"></section>
                        <section class="clear-both"></section>
                    </section>
                </section>
                <?php
                $num++;
            } ?>
            
            <section class="clear-both"></section>
        </section>
           <?php
            include './pagination.php';
            ?>
    </section>
</section>
<?php include("footer.php"); ?>