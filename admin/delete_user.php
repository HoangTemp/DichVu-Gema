<!DOCTYPE html>

<html>
    <head>
        <title>Xóa tài khoản</title>
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
            #create_user form{
                width: 200px;
                margin: 40px auto;
            }
            #create_user form input{
                margin: 5px 0;
            }
        </style>
    </head>
    <body>
        <?php
        include 'header.php';
        $error = false;
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            include '../db_connect.php';
            $result = mysqli_query($conn, "DELETE FROM `user` WHERE `id` = " . $_GET['id']);
            if (!$result) {
                $error = "Không thể xóa tài khoản.";
            }
            mysqli_close($conn);
            if ($error !== false) {
                ?>
                <div id="error-notify" class="box-content">
                    <h1>Thông báo</h1>
                    <h4><?= $error ?></h4>
                    <a href="./list_user.php">Danh sách tài khoản</a>
                </div>
            <?php } else { ?>
                <div id="success-notify" class="box-content">
                    <h1>Xóa tài khoản thành công</h1>
                    <a href="./list_user.php">Danh sách tài khoản</a>
                </div>
            <?php } ?>
        <?php } include 'footer.php';?>

    </body>
</html>
