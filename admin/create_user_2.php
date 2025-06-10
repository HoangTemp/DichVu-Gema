<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>dang ky</title>

    <!-- Custom fonts for this template-->
    <link href="./vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
								<?php
                include '../db_connect.php';
                include '../function.php';
                $error = false;
                if (isset($_GET['action']) && $_GET['action'] == 'reg') {
                    if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
                        $fullname = $_POST['fullname'];
                        $birthday = $_POST['birthday'];
                        $check = validateDateTime($birthday);
                        if ($check) {
                            $birthday = strtotime($birthday);
                            $result = mysqli_query($conn, "INSERT INTO `user` (`fullname`,`username`, `password`,`email`,`birthday`, `status`, `created_time`, `last_updated`) VALUES ('" . $_POST['fullname'] . "', '" . $_POST['username'] . "', '" . $_POST['password'] . "', '" . $_POST['email'] . "', '" . $birthday . "', 2, " . time() . ", '" . time() . "');");
                            if (!$result) {
                                if (strpos(mysqli_error($conn), "Duplicate entry") !== FALSE) {
                                    $error = "Tài khoản đã tồn tại. Bạn vui lòng chọn tài khoản khác.";
                                }
                            }
                            mysqli_close($conn);
                        } else {
                            $error = "Ngày tháng nhập chưa chính xác";
                        }
                        if ($error !== false) {
                    ?>
                                    <div id="error-notify" class="box-content">
                                        <h1>Thông báo</h1>
                                        <h4><?= $error ?></h4>
                                        <a href="./create_user.php">Quay lại</a>
                                    </div>
                                <?php } else { ?>
                                    <div id="edit-notify" class="box-content">
                                        <h1><?= ($error !== false) ? $error : "Đăng ký tài khoản thành công" ?></h1>
                                        <a href="../login_2.php">Mời bạn đăng nhập</a>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div id="edit-notify" class="box-content">
                                    <h1>Vui lòng nhập đủ thông tin để đăng ký tài khoản</h1>
                                    <a href="./create_user_2.php">Quay lại đăng ký</a>
                                </div>
                                <?php
                            }
                        } else {
                                ?>
                                <div id="user_register">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Đăng ký</h1>
                                    </div>
                                    <form action="./create_user.php?action=reg" method="Post" autocomplete="off">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter user name" name="username"/>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="password"  name="password"/>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter full name" name="fullname"/>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." name="email"/>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Birthday (DD-MM-YYYY)" name="birthday"/>
                                        </div>
                                        <input type="submit"class="btn btn-primary btn-user btn-block" value="Đăng ký"/>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="../login_2.php">Login !</a>
                                    </div>
                                </div> 
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>