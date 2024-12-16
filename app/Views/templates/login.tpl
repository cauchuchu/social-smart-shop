{block name="content"}
<!DOCTYPE html>
<html lang="vi-VN">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="..\assets\css\font-awesome.min.css" rel="stylesheet">
    <link href="..\assets\css\bootstrap.min.css" rel="stylesheet">
    <script src="..\assets\lib\jquery\jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="..\assets\js\bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="..\assets\css\login.css">
  </head>
  <body class="login-main">
    <!-- End Google Tag Manager (noscript) -->
    <!--MAIN-CONTENT-->
    <div id="page" class="wrap-main">
      <div class="main-container">
        <div class="head-login">
          <div class="info">
            <div class="logo-login">
              <img src="images/sukien-logo.png">
            </div>
          </div>
        </div>
        <div class="form-login-cms">
          <!-- <div class="thumbnail"></div> -->
          <h4 id="login-title">Đăng nhập</h4>
          <form id="login-form" class="form-horizontal" action="/login" method="post">
            <input type="number" id="mobile" placeholder="Số điện thoại" name="mobile" required="required">
            <input type="password" id="password" placeholder="Mật khẩu" name="password" required="required">
            <div id="message" style="margin-top: 20px; color: red;"></div>
            <button type="submit" class="btn btn-primary login-btn">Đăng nhập</button>

          </form>
          <p class="sign-now">Bạn chưa có tài khoản? <a href="/SmartShop/public/signup">Đăng ký ngay</a>
          </p>
          <p class="message">
            <span>
              <a href="/forget-password">Quên mật khẩu?</a>
            </span>
          </p>
        </div>

      </div>
    </div>
  </body>
</html>
{literal}
  <script>
        $(document).ready(function () {
            // Xử lý sự kiện submit form
            $('#login-form').on('submit', function (e) {
                e.preventDefault(); // Ngăn chặn submit form thông thường

                var mobile = $('#mobile').val();
                var password = $('#password').val();

                // Gửi request Ajax
                $.ajax({
                    url: 'check-login', // URL backend để xử lý login
                    type: 'POST',
                    data: {
                        mobile: mobile,
                        password: password
                    },
                    success: function (response) {
                        // Kiểm tra phản hồi từ server
                        if (response.success) {
                            $('#message').css('color', 'green').text('Login successful!');
                            // Thực hiện redirect hoặc hành động khác
                            window.location.href = '/dashboard';
                        } else {
                            $('#message').css('color', 'red').text(response.message || 'Login failed!');
                        }
                    },
                    error: function (xhr, status, error) {
                        // Xử lý lỗi
                        $('#message').css('color', 'red').text('An error occurred. Please try again.');
                        console.error(error);
                    }
                });
            });
        });
    </script>
{/literal}
{/block}