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

        .picture input[type="file"] {
            cursor: pointer;
            display: block;
            height: 100%;
            left: 0;
            opacity: 0 !important;
            position: absolute;
            top: 0;
            width: 100%;
            margin-top: 10px !important;
        }

        #wizardPicturePreview {
            border-radius: 50%;
            margin-bottom: 10px;
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
                <a class="navbar-brand" href="#pablo">สมัครสมาชิก</a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar navbar-kebab"></span>
                <span class="navbar-toggler-bar navbar-kebab"></span>
                <span class="navbar-toggler-bar navbar-kebab"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a href="<?= site_url(); ?>" class="nav-link">
                            <i class="now-ui-icons users_circle-08"></i> เข้าสู่ระบบ
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="wrapper wrapper-full-page ">
        <div class="full-page register-page section-image" filter-color="black">
            <!-- <div class="content"> -->
            <div class="container" style="padding-top:100px">
                <div class="row">
                    <div class="col-md-8 mr-auto">
                        <div class="card card-signup text-center">
                            <div class="card-header ">
                                <h4 class="card-title">สมัครสมาชิก</h4>
                            </div>
                            <div class="card-body ">
                                <form class="form" method="" action="">
                                    <div class="col-md-4 ml-auto mr-auto">
                                        <div class="picture-container">
                                            <div class="picture">
                                                <img src="<?= base_url('assets/images/noimage.jpg'); ?>" class="picture-src" id="wizardPicturePreview" title="" />
                                                <input type="file" id="wizard-picture" class="valid" aria-invalid="false">
                                            </div>
                                            <h6 class="description">Choose Picture</h6>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="form-check form-check-radio form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input title" type="radio" name="exampleRadios" id="title" value="นาย">
                                                <span class="form-check-sign"></span>
                                                นาย
                                            </label>
                                        </div>
                                        <div class="form-check form-check-radio form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input title" type="radio" name="exampleRadios" id="title" value="นางสาว">
                                                <span class="form-check-sign"></span>
                                                นางสาว
                                            </label>
                                        </div>
                                        <div class="form-check form-check-radio form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input title" type="radio" name="exampleRadios" id="title" value="นาง">
                                                <span class="form-check-sign"></span>
                                                นาง
                                            </label>
                                        </div>
                                        <div class="form-check form-check-radio form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="other" value="">
                                                <span class="form-check-sign"></span>
                                                อื่นๆ
                                            </label>
                                        </div>
                                    </div>
                                    <div class="input-group" id="othertitle">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="now-ui-icons users_circle-08"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="คำนำหน้าอื่นๆ">
                                    </div>
                                    <div class="row">
                                        <div class="input-group col-md-6">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="now-ui-icons users_circle-08"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" placeholder="ชื่อ">
                                        </div>
                                        <div class="input-group col-md-6">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="now-ui-icons text_caps-small"></i>
                                                </div>
                                            </div>
                                            <input type="text" placeholder="นามสกุล" class="form-control">
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="now-ui-icons business_badge"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="รหัสนักศึกษา">
                                    </div>
                                    <div class="row">
                                        <div class="input-group col-md-6">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="now-ui-icons ui-1_email-85"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" placeholder="อีเมล">
                                        </div>
                                        <div class="input-group col-md-6">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="now-ui-icons tech_mobile"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" placeholder="เบอร์โทร">
                                        </div>
                                    </div>
                                    <div class="form-check text-left">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox">
                                            <span class="form-check-sign"></span>
                                            I agree to the
                                            <a href="#something">terms and conditions</a>.
                                        </label>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer ">
                                <a href="#pablo" class="btn btn-primary btn-round btn-lg">Get Started</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ml-auto">
                        <div class="info-area info-horizontal mt-5">
                            <div class="icon icon-primary">
                                <i class="now-ui-icons media-2_sound-wave"></i>
                            </div>
                            <div class="description">
                                <h5 class="info-title">Appoint-IT</h5>
                                <p class="description">
                                    รออียุ้ย
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
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
        $('#othertitle').hide();
        $("#other").click(function() {
            $('#othertitle').slideDown();
        });
        $(".title").click(function() {
            $('#othertitle').slideUp();
        });


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#wizardPicturePreview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#wizard-picture").change(function() {
            readURL(this);
        });
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