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
    .form-control {
      border-radius: 0 !important;
    }

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

    .modal {
      top: 30% !important;
    }

    .modal-content .modal-body+.modal-footer {
      padding-top: 24px !important;
    }

    /* Absolute Center Spinner */
    .loading {
      position: fixed;
      z-index: 999;
      height: 2em;
      width: 2em;
      overflow: visible;
      margin: auto;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
    }

    /* Transparent Overlay */
    .loading:before {
      content: '';
      display: block;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(236, 240, 241, 1);
    }

    /* :not(:required) hides these rules from IE9 and below */
    .loading:not(:required) {
      /* hide "loading..." text */
      font: 0/0 a;
      color: transparent;
      text-shadow: none;
      background-color: transparent;
      border: 0;
    }

    .loading:not(:required):after {
      content: '';
      display: block;
      font-size: 10px;
      width: 1em;
      height: 1em;
      margin-top: -0.5em;
      -webkit-animation: spinner 1500ms infinite linear;
      -moz-animation: spinner 1500ms infinite linear;
      -ms-animation: spinner 1500ms infinite linear;
      -o-animation: spinner 1500ms infinite linear;
      animation: spinner 1500ms infinite linear;
      border-radius: 0.5em;
      -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
      box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
    }

    /* Animation */

    @-webkit-keyframes spinner {
      0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
      }

      100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }

    @-moz-keyframes spinner {
      0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
      }

      100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }

    @-o-keyframes spinner {
      0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
      }

      100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }

    @keyframes spinner {
      0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
      }

      100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }
  </style>
</head>

<body class=" sidebar-mini">
  <div class="loading">Loading&#8230;</div>
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
                      <input id="username" type="email" placeholder="อีเมล" class="form-control " name="username" value="" required autocomplete="email" autofocus>
                    </div>
                    <div class="input-group no-border form-control-lg">
                      <input id="password" placeholder="รหัสผ่าน" type="password" class="form-control" name="password" required autocomplete="current-password">
                    </div>
                    <!-- alert -->
                    <?= $msg; ?>
                  </div>
                  <div class="card-footer ">
                    <button type="submit" class="btn btn-primary btn-round btn-lg btn-block mb-3">เข้าสู่ระบบ</button>
                    <div class="pull-right">
                      <h6>
                        <a href="#" class="link footer-link" data-toggle="modal" data-target="#Repass">ลืมรหัสผ่าน?</a>
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
  <!-- model repass -->
  <div class="modal fade" id="Repass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">ลืมรหัสผ่าน?</h4>
        </div>
        <form action="<?= site_url('student/repassword') ?>" method="post" enctype="multipart/form-data" name="formRepassword" id="formRepassword" class="form-horizontal" novalidate">
          <div class="modal-body">
            <input type="text" class="form-control" id="s_email" name="s_email" placeholder="กรุณากรอกอีเมลที่ใช้ลงทะเบียน" data-url="<?= site_url('student/getemail'); ?>">
            <p style="margin-top:5px 0 0;font-size:10px;text-align:center;color:red" id="textresult"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
            <button type="submit" class="btn btn-primary" id="resetpass">รีเซตรหัสผ่าน</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="<?= base_url('assets/js/appnow.js'); ?>" type="text/javascript"></script>
  <script src="<?= base_url('assets/js/now-ui-dashboard.min.js'); ?>" type="text/javascript"></script>
  <script src="<?= base_url('assets/js/themes.js'); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?= base_url('assets/js/lib/plugins/validate/jquery.validate.min.js') ?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/js/lib/plugins/toastr/toastr.min.js') ?>"></script>
  <script>
    $('.loading').hide();
    document.getElementById("resetpass").disabled = true;
    $("#s_email").blur(function() {
      if ($('#s_email').val() != '') {
        var s_email = $('#s_email').val();
        var url = $("#s_email").attr("data-url");

        $.ajax({
          method: "POST",
          url: url,
          data: {
            s_email: s_email,
          },
          dataType: 'json',
          success: function(result) {
            console.log(result);
            if (result == true) {
              $('#textresult').html('');
              document.getElementById("resetpass").disabled = false;
            } else {
              $('#textresult').html('ไม่พบอีเมล');
              document.getElementById("resetpass").disabled = true;
            } //endif
          } //endsuccess
        }) //endajax
      } //endif
    })
    $("#formRepassword").submit(function() {
      $('#Repass').modal('hide');
      $('.loading').show();
    })
  </script>
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