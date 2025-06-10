<?php include 'header.php'; ?>
<?php
$param = "";
$sortParam = "";
$orderConditon = "";
//Tìm kiếm
$search = isset($_GET['name']) ? $_GET['name'] : "";
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
$item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 8;
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
<section id="hot-products">
<div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item position-relative active" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="anh/slideopy23.png" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Genshin Impact</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Hỗ trợ nạp các gói trong game và nhận cày thuê với giá cực rẻ!</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Xem ngay</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="anh/slideopy23.png" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Honkai Star Rail</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Hỗ trợ nạp các gói trong game và nhận cày các nội dung khó!</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Xem ngay</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="anh/slideopy23.png" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Arknights</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Chỉ nhận hỗ trợ nạp các gói trong game</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Xem ngay</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="anh/slideopy23.png" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Phụ kiện cực chất</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Ở đây không chỉ có hỗ trợ về game mà còn có bán các phụ kiện liên quan đến game!</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Xem ngay</a>
                                </div>
                            </div>
                        </div>
                        <ol class="carousel-indicators">
                        <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#header-carousel" data-slide-to="1"></li>
                        <li data-target="#header-carousel" data-slide-to="2"></li>
                        <li data-target="#header-carousel" data-slide-to="3"></li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="anh/slideopy23.png" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Giảm ngay 20%</h6>
                        <h3 class="text-white mb-3">Khi nạp trên 2 triệu</h3>
                        <a href="" class="btn btn-primary">Xem ngay</a>
                    </div>
                </div>
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="anh/slideopy23.png" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Giảm 15%</h6>
                        <h3 class="text-white mb-3">Các phụ kiện </h3>
                        <a href="" class="btn btn-primary">Xem ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                <form class="quick-buy-form" action="giohang.php?action=add" method="POST">
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
            }
            ?>
            <section class="clear-both"></section>
        </section>
    </section>
</section>
<?php include("footer.php"); ?>