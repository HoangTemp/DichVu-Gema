<!DOCTYPE html>

<html>
    <head>
        <title>Đổi password</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .box-content{
                margin: 0 auto;
                width: 800px;
                border: 1px solid #ccc;
                text-align: center;
                padding: 20px;
            }
            #edit_user form{
                width: 200px;
                margin: 40px auto;
            }
            #edit_user form input{
                margin: 5px 0;
            }
        </style>
    </head>
    <body>
        <?php
        include '../db_connect.php';
        $error = false;
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            if (isset($_POST['user_id']) && !empty($_POST['user_id']) && isset($_POST['old_password']) && !empty($_POST['old_password']) && isset($_POST['new_password']) && !empty($_POST['new_password'])
            ) {
                $userResult = mysqli_query($conn, "Select * from `user` WHERE (`id` = " . $_POST['user_id'] . " AND `password` = '" . md5($_POST['old_password']) . "')");
                if ($userResult->num_rows > 0) {
                    $result = mysqli_query($conn, "UPDATE `user` SET `password` = ('" . $_POST['new_password'] . "'), `last_updated`=" . time() . " WHERE (`id` = " . $_POST['user_id'] . " AND `password` = '" . ($_POST['old_password']) . "')");
                    if (!$result) {
                        $error = "Không thể cập nhật tài khoản";
                    }
                } else {
                    $error = "Mật khẩu cũ không đúng.";
                }
                mysqli_close($conn);
                if ($error !== false) {
                    ?>
                    <div id="error-notify" class="box-content">
                        <h1>Thông báo</h1>
                        <h4><?= $error ?></h4>
                        <a href="./edit.php">Đổi lại mật khẩu</a>
                    </div>
                <?php } else { ?>
                    <div id="edit-notify" class="box-content">
                        <h1><?= ($error !== false) ? $error : "Sửa tài khoản thành công" ?></h1>
                        <a href="./login.php">Quay lại tài khoản</a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div id="edit-notify" class="box-content">
                    <h1>Vui lòng nhập đủ thông tin để sửa tài khoản</h1>
                    <a href="./edit_user.php">Quay lại sửa tài khoản</a>
                </div>
                <?php
            }
        } else {
            session_start();
            $user = $_SESSION['current_user'];
            if (!empty($user)) {
                ?>
                <div id="edit_user" class="box-content">
                    <h1>Xin chào "<?= $user['fullname'] ?>". Bạn đang thay đổi mật khẩu</h1>
                    <form action="./edit.php?action=edit" method="Post" autocomplete="off">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <label>Password cũ</label></br>
                        <input type="password" name="old_password" value="" /></br>
                        <label>Password mới</label></br>
                        <input type="password" name="new_password" value="" /></br>
                        <br><br>
                        <input type="submit" value="Edit" />
                    </form>
                </div>
                <?php
            }
        }
        ?>
    </body>
</html>
