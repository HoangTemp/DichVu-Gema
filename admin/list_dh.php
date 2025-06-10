<?php
include 'header.php';
$config_name = "dh";
$config_title = "đơn hàng";
if (!empty($_SESSION['current_user'])) {
    if(!empty($_GET['action']) && $_GET['action'] == 'search' && !empty($_POST)){
        $_SESSION['product_filter'] = $_POST;
        header('Location: list_'.$config_name.'.php');exit;
    }
    if(!empty($_SESSION['product_filter'])){
        $where = "";
        foreach ($_SESSION['product_filter'] as $field => $value) {
            if(!empty($value)){
                switch ($field) {
                    case 'ten':
                    $where .= (!empty($where))? " AND "."`".$field."` LIKE '%".$value."%'" : "`".$field."` LIKE '%".$value."%'";
                    break;
                    default:
                    $where .= (!empty($where))? " AND "."`".$field."` = ".$value."": "`".$field."` = ".$value."";
                    break;
                }
            }
        }
        extract($_SESSION['product_filter']);
    }
    $item_per_page = (!empty($_GET['per_page'])) ? $_GET['per_page'] : 10;
    $current_page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $offset = ($current_page - 1) * $item_per_page;
    if(!empty($where)){
        $totalRecords = mysqli_query($conn, "SELECT * FROM `donhang` where (".$where.")");
    }else{
        $totalRecords = mysqli_query($conn, "SELECT * FROM `donhang`");
    }
    $totalRecords = $totalRecords->num_rows;
    $totalPages = ceil($totalRecords / $item_per_page);
    if(!empty($where)){
        $orders = mysqli_query($conn, "SELECT * FROM `donhang` where (".$where.") ORDER BY `id` DESC LIMIT " . $item_per_page . " OFFSET " . $offset);
    }else{
        $orders = mysqli_query($conn, "SELECT * FROM `donhang` ORDER BY `id` DESC LIMIT " . $item_per_page . " OFFSET " . $offset);
    }
    mysqli_close($conn);
    ?>
    <div class="main-content">
        <h1>Danh sách <?= $config_title ?></h1>
        <div class="listing-items">
            <div class="listing-search">
                <form id="<?= $config_name ?>-search-form" action="list_<?= $config_name ?>.php?action=search" method="POST">
                    <fieldset>
                        <legend>Tìm kiếm <?= $config_title ?>:</legend>
                        ID: <input type="text" name="id" value="<?= !empty($id) ? $id : "" ?>" />
                        Tên <?= $config_title ?>: <input type="text" name="ten" value="<?= !empty($name) ? $name : "" ?>" />
                        <input type="submit" value="Tìm" />
                    </fieldset>
                </form>
            </div>
            <div class="total-items">
                <?php /*
                  <span>Có tất cả <strong><?=$totalRecords?></strong> <?=$config_title?> trên <strong><?=$totalPages?></strong> trang</span> */ ?>
            </div>
            <ul>
                <li class="listing-item-heading">
                    <div class="listing-prop listing-id">ID</div>
                    <div class="listing-prop listing-name1">Tên người nhận</div>
                    <div class="listing-prop listing-address">Facebook</div>
                    <div class="listing-prop listing-phone">Điện thoại</div>
                    <div class="listing-prop listing-button">
                        In đơn  
                    </div>
                    <div class="listing-prop listing-time1">Ngày tạo</div>
                    <div class="clear-both"></div>
                </li>
                <?php  while ($row = mysqli_fetch_array($orders)) { ?>
                <li>
                    <div class="listing-prop listing-id"><?=$row['id']?></div>
                    <div class="listing-prop listing-name1"><?=$row['ten']?></div>
                    <div class="listing-prop listing-address"><?=$row['fb']?></div>
                    <div class="listing-prop listing-phone"><?=$row['sdt']?></div>
                    <div class="listing-prop listing-button">
                        <a href="in_dh.php?id=<?=$row['id']?>" target="_blank">In</a>
                    </div>
                    <div class="listing-prop listing-time1"><?=date('d/m/Y H:i', $row['created_time'])?></div>
                    <div class="clear-both"></div>
                </li>
                <?php  } ?>
            </ul>
            <?php /*
              include './pagination.php';
             */ ?>
            <div class="clear-both"></div>
        </div>
    </div>
    <?php
}
include './footer.php';
?>