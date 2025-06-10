<?php
include 'header.php';
if (!empty($_SESSION['current_user'])) {
    ?>
    <div class="main-content">
        <div id="content-box">
            <?php
            if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) {    
                if (isset($_POST['tensp']) && !empty($_POST['tensp']) && isset($_POST['gia']) && !empty($_POST['gia'])) {
                    $galleryImages = array();
                    if (empty($_POST['tensp'])) {
                        $error = "Bạn phải nhập tên sản phẩm";
                    } elseif (empty($_POST['gia'])) {
                        $error = "Bạn phải nhập giá sản phẩm";
                    } elseif (!empty($_POST['gia']) && is_numeric(str_replace('.', '', $_POST['gia'])) == false) {
                        $error = "Giá nhập không hợp lệ";
                    }
                    if (isset($_FILES['anh']) && !empty($_FILES['anh']['name'][0])) {
                        $uploadedFiles = $_FILES['anh'];
                        $result = uploadFiles($uploadedFiles);
                        if (!empty($result['errors'])) {
                            $error = $result['errors'];
                        } else {
                            $image = $result['path'];
                        }
                    }
                    if (!isset($image) && !empty($_POST['anh'])) {
                        $image = $_POST['anh'];
                    }
                    if (!isset($error)) {
                        if ($_GET['action'] == 'edit' && !empty($_GET['id'])) { //Cập nhật lại sản phẩm
                            $result = mysqli_query($conn, "UPDATE `sanpham` SET `tensp` = '" . $_POST['tensp'] . "', `soluong` = '" . $_POST['soluong'] . "',`anh` =  '" . $image . "', `gia` = " . str_replace('.', '', $_POST['gia']) . ", `mota` = '" . $_POST['mota'] . "',`maloai` = '" . $_POST['maloai'] . "', `last_updated` = " . time() . " WHERE `sanpham`.`id` = " . $_GET['id']);
                        } else { //Thêm sản phẩm
                            $result = mysqli_query($conn, "INSERT INTO `sanpham` (`id`, `tensp`, `soluong`,`anh`, `gia`, `mota`,`maloai`, `created_time`, `last_updated`) VALUES (NULL, '" . $_POST['tensp'] . "', '" . $_POST['soluong'] . "','" . $image . "', " . str_replace('.', '', $_POST['gia']) . ", '" . $_POST['mota'] . "','" . $_POST['maloai'] . "', " . time() . ", " . time() . ");");
                        }
                        if (!$result) { //Nếu có lỗi xảy ra
                            $error = "Có lỗi xảy ra trong quá trình thực hiện.";
                        } else { //Nếu thành công
                            if (!empty($galleryImages)) {
                                $product_id = ($_GET['action'] == 'edit' && !empty($_GET['id'])) ? $_GET['id'] : $conn->insert_id;
                                $insertValues = "";
                                foreach ($galleryImages as $path) {
                                    if (empty($insertValues)) {
                                        $insertValues = "(NULL, " . $product_id . ", '" . $path . "', " . time() . ", " . time() . ")";
                                    } else {
                                        $insertValues .= ",(NULL, " . $product_id . ", '" . $path . "', " . time() . ", " . time() . ")";
                                    }
                                }
                                $result = mysqli_query($conn, "INSERT INTO `image_library` (`id`, `product_id`, `path`, `created_time`, `last_updated`) VALUES " . $insertValues . ";");
                            }
                        }
                    }
                } else {
                    $error = "Bạn chưa nhập thông tin sản phẩm.";
                }
                ?>
                <div class = "container">
                    <div class = "error"><?= isset($error) ? $error : "Cập nhật thành công" ?></div>
                    <a href = "list_sp.php">Quay lại danh sách sản phẩm</a>
                </div>
                <?php
            } else {
                if (!empty($_GET['id'])) {
                    $result = mysqli_query($conn, "SELECT * FROM `sanpham` WHERE `id` = " . $_GET['id']);
                    $product = $result->fetch_assoc();
                    $gallery = mysqli_query($conn, "SELECT * FROM `image_library` WHERE `product_id` = " . $_GET['id']);
                    if (!empty($gallery) && !empty($gallery->num_rows)) {
                        while ($row = mysqli_fetch_array($gallery)) {
                            $product['gallery'][] = array(
                                'id' => $row['id'],
                                'path' => $row['path']
                            );
                        }
                    }
                }
                ?>
                <form id="editing-form" method="POST" action="<?= (!empty($product) && !isset($_GET['task'])) ? "?action=edit&id=" . $_GET['id'] : "?action=add" ?>"  enctype="multipart/form-data">
                    <input type="submit" title="Lưu sản phẩm" value="" />
                    <div class="clear-both"></div>
                    <div class="wrap-field">
                        <label>Tên sản phẩm: </label>
                        <input type="text" name="tensp" value="<?= (!empty($product) ? $product['tensp'] : "") ?>" />
                        <div class="clear-both"></div>
                    </div>
                    <div class="wrap-field">
                        <label>Giá sản phẩm: </label>
                        <input type="text" name="gia" value="<?= (!empty($product) ? number_format($product['gia'], 0, ",", ".") : "") ?>" />
                        <div class="clear-both"></div>
                    </div>
                    <div class="wrap-field">
                        <label>Mã loại: </label>
                        <input type="text" name="maloai" value="<?= (!empty($product) ? $product['maloai'] : "") ?>" />
                        <div class="clear-both"></div>
                    </div>
                    
                    <div class="wrap-field">
                        <label>Tồn kho: </label>
                        <input type="text" name="soluong" value="<?= (!empty($product) ? $product['soluong'] : "") ?>" />
                        <div class="clear-both"></div>
                    </div>
                    <div class="wrap-field">
                        <label>Ảnh đại diện: </label>
                        <div class="right-wrap-field">
                    <?php if (!empty($product['anh'])) { ?>
                                <img src="../<?= $product['anh'] ?>" /><br/>
                                <input type="hidden" name="anh" value="<?= $product['anh'] ?>" />
                            <?php } ?>
                            <input type="file" name="anh" />
                        </div>
                        <div class="clear-both"></div>
                    </div>
                    <div class="wrap-field">
                        <label>Nội dung: </label>
                        <textarea name="mota" id="product-content"><?= (!empty($product) ? $product['mota'] : "") ?></textarea>
                        <div class="clear-both"></div>
                    </div>
                </form>
                <div class="clear-both"></div>
                <script>
                    // Replace the <textarea id="editor1"> with a CKEditor
                    // instance, using default configuration.
                    CKEDITOR.replace('product-content');
                </script>
    <?php } ?>
        </div>
    </div>

    <?php
}
include './footer.php';
?>