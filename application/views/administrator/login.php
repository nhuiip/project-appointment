<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/images/reunion.svg'); ?>">
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/reunion.svg'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Appoint-IT
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="<?= base_url('assets/css/app.css'); ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/now-ui-dashboard.min.css'); ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/theme.css'); ?>" rel="stylesheet" />
  <style>
    label.error {
      display: none !important;
    }

    input.error {
      border: 1px #ff0000 solid !important;
    }
    .navbar .navbar-brand,
    .navbar .navbar-nav .nav-link {
      font-size: 1.2em !important;
    }
  </style>
</head>

<body class=" sidebar-mini">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary ">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-toggle">
          <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
        <a class="navbar-brand" href="#">หน้าแรก</a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navigation">
        <ul class="navbar-nav">
          <li class="nav-item ">
            <a href="<?= site_url('student/register'); ?>" class="nav-link">
              <i class="now-ui-icons users_circle-08"></i> สมัครสมาชิก
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="wrapper wrapper-full-page ">
    <div class="full-page login-page section-image" filter-color="black" data-image="<?= base_url('assets/images/bg.jpg'); ?>">
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
      <form class="m-t" role="form" method="post" action="<?= site_url('administrator/authen'); ?>" id="loginForm" novalidate>
        <input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
        <div class="content">
          <div class="container">
            <div class="col-md-4 ml-auto mr-auto">
              <form class="form" method="" action="">
                <div class="card card-login card-plain">
                  <div class="card-header ">
                    <div class="logo-container">
                      <img src="<?= base_url('assets/images/logo/LOGO-RMUTR.png'); ?>" alt="">
                    </div>
                  </div>
                  <div class="card-body ">
                    <div class="input-group no-border form-control-lg">
                      <span class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="now-ui-icons ui-1_email-85"></i>
                        </div>
                      </span>
                      <input id="username" type="email" placeholder="อีเมล" class="form-control " name="username" value="" required autocomplete="email" autofocus>
                    </div>
                    <div class="input-group no-border form-control-lg">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="now-ui-icons now-ui-icons ui-1_lock-circle-open"></i>
                        </div>
                      </div>
                      <input id="password" placeholder="รหัสผ่าน" type="password" class="form-control " name="password" required autocomplete="current-password">
                    </div>
                    <!-- alert -->
                    <?= $msg; ?>
                  </div>
                  <div class="card-footer ">
                    <button type="submit" class="btn btn-primary btn-round btn-lg btn-block mb-3">เข้าสู่ระบบ</button>
                    <div class="pull-right">
                      <h6>
                        <a href="#" class="link footer-link">ลืมรหัสผ่าน?</a>
                      </h6>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </form>
      <footer class="footer">
        <div class="container-fluid">
          <div class="copyright" id="copyright">
            &copy;
            <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, Coded by
            <a href="#" target="_blank">Napassorn | Preedarat</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="<?= base_url('assets/js/appnow.js'); ?>" type="text/javascript"></script>
  <script src="<?= base_url('assets/js/now-ui-dashboard.min.js'); ?>" type="text/javascript"></script>
  <script src="<?= base_url('assets/js/themes.js'); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?= base_url('assets/js/lib/plugins/validate/jquery.validate.min.js') ?>"></script>
  <script>
    $("#loginForm").validate({
      rules: {
        username: {
          required: true
        },
        password: {
          required: true
        },
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
  </script>
  <script>
    $(document).ready(function() {
      themejs.checkFullPageBackgroundImage();
    });
  </script>

</body>

</html>