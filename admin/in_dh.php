<!DOCTYPE html>

<html>
    <head>
        <title>Chi tiết đơn hàng</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/admin_style.css" >
        <script src="../resources/ckeditor/ckeditor.js"></script>
    </head>
    <body>
        <?php
        session_start();
        if (!empty($_SESSION['current_user'])) {
            include '../db_connect.php';
            $orders = mysqli_query($conn, "SELECT donhang.ten, donhang.fb, donhang.sdt, donhang.note, chitiet_donhang.*, sanpham.tensp as product_name 
            FROM donhang
            INNER JOIN chitiet_donhang ON donhang.id = chitiet_donhang.id_donhang
            INNER JOIN sanpham ON sanpham.id = chitiet_donhang.id_sanpham
            WHERE donhang.id = " . $_GET['id']);
            $orders = mysqli_fetch_all($orders, MYSQLI_ASSOC);
        }
        ?>
        <div id="order-detail-wrapper">
            <div id="order-detail">
                <h1>Chi tiết đơn hàng</h1>
                <label>Người nhận: </label><span> <?= $orders[0]['ten'] ?></span><br/>
                <label>Điện thoại: </label><span> <?= $orders[0]['sdt'] ?></span><br/>
                <label>Facebook: </label><span> <?= $orders[0]['fb'] ?></span><br/>
                <hr/>
                <h3>Danh sách sản phẩm</h3>
                <ul>
                    <?php
                    $totalQuantity = 0;
                    $totalMoney = 0;
                    foreach ($orders as $row) {
                        ?>
                        <li>
                            <span class="item-name"><?= $row['product_name'] ?></span>
                            <span class="item-quantity"> - SL: <?= $row['soluong'] ?> sản phẩm</span>
                        </li>
                        <?php
                        $totalMoney += ($row['gia'] * $row['soluong']);
                        $totalQuantity += $row['soluong'];
                    }
                    ?>
                </ul>
                <hr/>
                <label>Tổng SL:</label> <?= $totalQuantity ?> - <label>Tổng tiền:</label> <?= number_format($totalMoney, 0, ",", ".") ?> đ
                <p><label>Ghi chú: </label><?= $orders[0]['note'] ?></p>
            </div>
        </div>
    </body>
</html>