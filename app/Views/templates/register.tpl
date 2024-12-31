{block name="content"}
  <!DOCTYPE html>
  <html lang="vi-VN">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký thành viên</title>
    <link href="..\assets\css\font-awesome.min.css" rel="stylesheet">
    <link href="..\assets\css\bootstrap.min.css" rel="stylesheet">
    <script src="..\assets\lib\jquery\jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="..\assets\js\bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="..\assets\css\login.css">
    <!-- Google Tag Manager -->
  </head>

  <body class="login-main">
    <!--MAIN-CONTENT-->
    <div id="page" class="wrap-main">
      {if $flasherror}
        <div class="alert alert-danger">
          {$flasherror}
        </div>
      {/if}
      <div class="main-container">
        <style type="text/css">
          .show-password {
            position: absolute;
            left: auto !important;
            right: 20px;
            cursor: pointer;
            top: 25px !important;
          }

          .alert-danger {
            text-align: right;
          }
        </style>
        <div class="head-login">
          <div class="info">
            <div class="logo-login">
              <img src="images/sukien-logo.png">
            </div>
          </div>
        </div>
        <div class="form-login-cms">
          <h4 id="login-title">Đăng ký thành viên</h4>
          <form id="signup-form" class="form-horizontal" action="register" method="post">
            <?= csrf_field() ?>
            <div class="err error-name"></div>
            <input type="text" placeholder="Nhập tên cửa hàng" class="shop_name" name="shop_name" required="required">
            <input type="text" placeholder="Họ và tên của bạn" class="name" name="name" required="required">
            <input type="number" placeholder="Số điện thoại" class="mobile" name="mobile" required="required">
            <div class="err error-mobile"></div>
            <div style="position: relative;">
              <input type="password" placeholder="Mật khẩu" class="password" name="password" required="required"
                style="margin-bottom: 10px">
              <i class="fa fa-eye show-password" data-toggle="tooltip" title="Ẩn hiện password" aria-hidden="true"></i>
              <div class="err error-pass"></div>
            </div>
            <button type="submit" class="btn btn-primary btn-sign-up mt-20">Đăng ký</button>
            <p class="sign-now">Bạn đã có tài khoản? <a href="/login">Đăng nhập</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </body>

  {literal}
    <script src="..\assets\js\register.js" type="text/javascript"></script>
  {/literal}

  </html>

{/block}