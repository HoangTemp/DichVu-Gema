<!DOCTYPE html>

<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/carouseller.css">
        <link rel="stylesheet" href="libs/fancybox/jquery.fancybox.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/fonts.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/category.css">
        <link href="css/style2.css" type="text/css" rel="stylesheet">
        <link href="img/favicon.ico" rel="icon">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="libs/animate/animate.min.css" rel="stylesheet">
        <link href="libs/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        
    </head>
    <body>
        <?php
        session_start();
        include 'func_libs.php'; 
        $totalQuantity = getTotalQuantity();
        if (!isset ($_SESSION['current_user'])) {
            header("Location:login_2.php");
        }
        ?>
        <div id="cart-icon">
            <span><?=$totalQuantity?></span>
            <a data-fancybox data-type="ajax" data-src="ajax-giohang.php" href="javascript:;">
                <img width="80" src="images/cart-icon.png" alt="alt"/>
            </a>
        </div>
        <header>
        <header>
            <section class="container">
                <div id="header-top">
                    <span><img src="images/phone.png" />090 - 223 44 66</span>
                    <span><img src="images/email.png" />help@trendd.com</span>
                </div>
                <div id="header-bottom">
                    <section id="header-left">
                        <img src="images/logopaimon.png" />
                    </section>
                    <section id="header-right">
                        <section id="header-link">
                            
                            <?php
                            if (isset($_SESSION['current_user'])) {
                                // Hiển thị tên người dùng nếu đã đăng nhập
                                echo '<a id="cart-link" href="checkout.php"><img src="images/cart.png" /></a>';
                                echo '<a id="login-link" >' . $_SESSION['current_user']['fullname'] . '</a>';
                                echo '<a id="register-link" href="admin/logout.php">Đăng xuất</a>';
                            } else {
                                // Nếu chưa đăng nhập, hiển thị nút đăng nhập
                                echo '<a id="cart-link" href="checkout.php"><img src="images/cart.png" /></a>';
                                echo '<a id="login-link" href="./Login_2.php">Đăng nhập</a>';
                                echo '<a id="register-link" href="./admin/create_user_2.php"><img src="images/register.png" /></a>';
                            }
                            ?>
                        </section>
                    </section>
                    <section class="clear-both"></section>
                </div>
            </section>
            <section id="menu">
                <section class="container">
                    <ul>
                        <li><a href="index_2.php">Trang chủ</a></li>
                        <li><a href="https://www.hoyolab.com/home/events">Tin tức</a></li>
                        <li><a href="category.php">Sản phẩm</a></li>
                        <li><a href="#">Chúng tôi</a></li>
                        <li><a href="#">Donate🐧</a></li>
                        <li class="clear-both"></li>
                    </ul>
                    <form id="product-search" action="category.php?action=search" method="GET">
                        <input type="submit" value="">
                        <input type="text" name="tensp" placeholder="Tìm kiếm" />
                    </form>
                </section>
            </section>
        </header>

