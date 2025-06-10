<div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Bảng quản lý </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Quản lý</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Bảng quản lý sản phẩm</h4>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> Ảnh </th>
                            <th> Tên sản phẩm </th>
                            <th> Số lượng </th>
                            <th> Giá </th>
                            <th> Ngày tạo </th>
                            <th> Ngày cập nhật </th>
                            <th> Mô tả </th>
                            <th> Mã loại </th>
                            <th> Xóa </th>
                            <th> Sửa </th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($products)) {
                                ?>
                                <tr>
                                    <td class="py-1">
                                        <img src="../<?= $row['anh'] ?>" alt="<?= $row['tensp'] ?>" title="<?= $row['tensp'] ?>" />
                                    </td>
                                    <td><?= $row['tensp'] ?></td>
                                    <td><?= $row['soluong'] ?></td>
                                    <td><?= $row['gia'] ?></td>
                                    <td><?= date('d/m/Y H:i', $row['created_time']) ?></td>
                                    <td><?= date('d/m/Y H:i', $row['last_updated']) ?></td>
                                    <td><?= $row['soluong'] ?></td>
                                    <td><a href="./delete_<?=$config_name?>.php?id=<?= $row['id'] ?>">Xóa</a></td>
                                    <td><a href="./edit_<?=$config_name?>.php?id=<?= $row['id'] ?>">Sửa</a></td>
                                    <div class="clear-both"></div>
                                </tr>
                            <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>

             <!--tạm-->
    <!--<div class="main-content">
        <h1>Danh sách <?=$config_title?></h1>
        <div class="listing-items">
            <div class="buttons">
                <a href="./edit_<?=$config_name?>.php">Thêm <?=$config_title?></a>
            </div>
            <div class="listing-search">
                <form id="<?=$config_name?>-search-form" action="list_<?=$config_name?>.php?action=search" method="POST">
                    <fieldset>
                        <legend>Tìm kiếm <?=$config_title?>:</legend>
                        ID: <input type="text" name="id" value="<?=!empty($id)?$id:""?>" />
                        Tên <?=$config_title?>: <input type="text" name="tensp" value="<?=!empty($name)?$name:""?>" />
                        <input type="submit" value="Tìm" />
                    </fieldset>
                </form>
            </div>
            <div class="total-items">
                <span>Có tất cả <strong><?=$totalRecords?></strong> <?=$config_title?> trên <strong><?=$totalPages?></strong> trang</span>
            </div>
            <ul>
                <li class="listing-item-heading">
                    <div class="listing-prop listing-img">Ảnh</div>
                    <div class="listing-prop listing-name">Tên <?=$config_title?></div>
                    <div class="listing-prop listing-button">
                        Xóa
                    </div>
                    <div class="listing-prop listing-button">
                        Sửa
                    </div>
                    <div class="listing-prop listing-time">Ngày tạo</div>
                    <div class="listing-prop listing-time">Ngày cập nhật</div>
                    <div class="clear-both"></div>
                </li>
                <?php
                while ($row = mysqli_fetch_array($products)) {
                    ?>
                    <li>
                        <div class="listing-prop listing-img"><img src="../<?= $row['anh'] ?>" alt="<?= $row['tensp'] ?>" title="<?= $row['tensp'] ?>" /></div>
                        <div class="listing-prop listing-name"><?= $row['tensp'] ?></div>
                        <div class="listing-prop listing-button">
                            <a href="./delete_<?=$config_name?>.php?id=<?= $row['id'] ?>">Xóa</a>
                        </div>
                        <div class="listing-prop listing-button">
                            <a href="./edit_<?=$config_name?>.php?id=<?= $row['id'] ?>">Sửa</a>
                        </div>
                        <div class="listing-prop listing-time"><?= date('d/m/Y H:i', $row['created_time']) ?></div>
                        <div class="listing-prop listing-time"><?= date('d/m/Y H:i', $row['last_updated']) ?></div>
                        <div class="clear-both"></div>
                    </li>
                <?php } ?>
            </ul>
            <?php
            include './pagination.php';
            ?>
            <div class="clear-both"></div>
        </div>
    </div>-->