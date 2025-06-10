<footer>
    <section class="container">
        <section id="footer-logo">
            <img src="images/logopaimonnho.png" />
        </section>
        <section id="footer-link">
            <ul>
                <li><a href="#">Chúng tôi</a></li>
                <li><a href="#">Hỏi đáp</a></li>
                <li><a href="#">Điều khoản sử dụng</a></li>
                <li><a href="#">Thanh toán bảo mật</a></li>
                <li><a href="#">Giao hàng</a></li>
                <li><a href="#">Liên hệ</a></li>
            </ul>
        </section>
        <section id="social-network-link">
            <a href="#"><img src="images/pinterest.png" /></a>
            <a href="#"><img src="images/twitter.png" /></a>
            <a href="#"><img src="images/facebook.png" /></a>
        </section>
        <section class="clear-both"></section>
    </section>
</footer>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="js/carouseller.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="libs/fancybox/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="libs/easing/easing.min.js"></script>
    <script src="libs/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
<script>
    $("#cart-form").validate({
        rules: {
            ten: {
                required: true
            },
            sdt: {
                required: true,
                minlength: 8
            },
            fb: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Bạn phải nhập họ và tên"
            },
            phone: {
                required: "Bạn phải nhập số điện thoại",
                minlength: "Số điện thoại phải có ít nhất 8 ký tự"
            },
            address: {
                required: "Bạn phải nhập đường dẫn facebook của mình"
            }
        },
        submitHandler: function (form) {
            $.ajax({
                type: "POST",
                url: './process_cart.php?action=submit',
                data: $(form).serializeArray(),
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status == 0) { //Đăng nhập lỗi
                        alert(response.message);
                    } else { //Đăng nhập thành công
                        alert(response.message);
                        location.href = 'category.php';
                    }
                }
            });
        }
    });
</script>
<script>
    function updateQuantity(quantity) {
        if (quantity != "") {
            $.ajax({
                type: "POST",
                url: './process_cart.php?action=update',
                data: $('#cart-form').serializeArray(),
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status == 0) { //Cập nhật không thành công
                        alert(response.message);
                    } else { //Cập nhật thành công
                        alert(response.message);
                        $('#cart-icon span').html(response.total_quantity);
                        $.get('ajax-cart-content.php', function (cartContentHTML) {
                            $('#ajax-cart').html(cartContentHTML);
                        });
                    }
                }
            });
        }
    }
    function deleteCart(productID) {
        $.ajax({
            type: "POST",
            url: './process_cart.php?action=delete',
            data: {
                "id": productID
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.status == 0) { //Xóa không thành công
                    alert(response.message);
                } else { //Xóa thành công
                    alert(response.message);
                    $('#cart-icon span').html(response.total_quantity);
                    $.get('ajax-cart-content.php', function (cartContentHTML) {
                        $('#ajax-cart').html(cartContentHTML);
                    });
                }
            }
        });
    }
    $("#add-to-cart-form").validate({
        rules: {
            "soluong[<?= isset($product['id']) ? $product['id'] : 0 ?>]": {
                required: true,
                remote: {
                    url: "check-quantity.php",
                    type: "post"
                }
            }
        },
        submitHandler: function (form) {
            $.ajax({
                type: "POST",
                url: './process_cart.php?action=add',
                data: $(form).serializeArray(),
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status == 0) { //Mua không thành công
                        alert(response.message);
                    } else { //Mua thành công
                        $('#cart-icon span').html(response.total_quantity);
                        alert(response.message);
                    }
                    $('#cart-icon a').trigger('click');
                }
            });
        }
    });
    $(".quick-buy-form").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: './process_cart.php?action=add',
            data: $(this).serializeArray(),
            success: function (response) {
                response = JSON.parse(response);
                if (response.status == 0) { //Mua không thành công
                    alert(response.message);
                } else { //Mua thành công
                    $('#cart-icon span').html(response.total_quantity);
                    alert(response.message);
                }
                $('#cart-icon a').trigger('click');
            }
        });
    });
    $(function () {
        $('#product-slide').carouseller();
    });
</script>
<!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
</body>
</html>
