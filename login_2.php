<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="./vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

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
                            <div class="col-lg-6">
                                <div class="p-5">
								<?php
                                    session_start();
                                    include './db_connect.php';
                                    $error = false;
                                    if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
                                        $result = mysqli_query($conn, "Select `id`,`username`,`fullname`,`email`,`birthday` ,`email` , `status` from `user` WHERE (`username` ='" . $_POST['username'] . "' AND `password` = ('" . $_POST['password'] . "'))");
                                        if (!$result) {
                                            $error = mysqli_error($conn);
                                        } else {
                                            $user = mysqli_fetch_assoc($result);
                                            if ($user) {
                                                $_SESSION['current_user'] = $user;

                                                if ($user['status'] == 1) {
                                                    header("Location: admin/list_sp.php");
                                                    exit();
                                                } elseif ($user['status'] == 2) {
                                                    header("Location: ./index_2.php");
                                                    exit();
                                                } else {
                                                    $error = "Trạng thái tài khoản không hợp lệ!";
                                                }
                                            } else {
                                                $error = "Thông tin đăng nhập không chính xác!";
                                            }
                                        }
                                        mysqli_close($conn);
                                        if ($error !== false || $result->num_rows == 0) {
                                            ?>
                                            <div id="login-notify" class="box-content">
                                                <h1>Thông báo</h1>
                                                <h4><?= $error ?></h4>
                                                <a href="./login_2.php">Quay lại</a>
                                            </div>
                                            <?php
                                            exit;
                                        }
                                        ?>
                                    <?php } ?>
                                    <?php if (empty($_SESSION['current_user'])) { ?>
                                    <div id="user_login">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Đăng nhập</h1>
                                    </div>
                                    <form action="./login_2.php" method="Post" autocomplete="off">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." name="username"/>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="password"  name="password"/>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        <input type="submit"class="btn btn-primary btn-user btn-block" value="Đăng nhập"/>
                                        <hr>
                                        <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="./admin/create_user_2.php">Create an Account!</a>
                                    </div><div class="text-center">
                                        <a class="small" href="index_2.php">Back</a>
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