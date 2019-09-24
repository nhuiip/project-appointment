<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/images/reunion.svg'); ?>">
	<link rel="icon" type="image/png" href="<?= base_url('assets/images/reunion.svg'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<title>
		Appoint-IT
	</title>
	<link rel="icon" href="<?= base_url('assets/images/logo/logo.png'); ?>" type="image/x-icon">
	<link rel="shortcut icon" href="<?= base_url('assets/images/logo/logo.png'); ?>" type="image/x-icon">

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
			border: 1px #c0392b solid !important;
			border-left: none !important;
			border-right: 1px solid #afaeae !important;
			border-top: 1px solid #afaeae !important;
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

		.description,
		.form-check .form-check-label,
		.input-group-prepend .input-group-text {
			color: #2c3e50 !important;
			font-weight: 500 !important;
		}

		.form-control::placeholder {
			color: #34495e !important;
			font-weight: 500 !important;
		}

		.form-check .form-check-sign:after,
		.form-check .form-check-sign:before {
			border: 3px solid #afaeae !important;
		}

		.input-group-prepend .input-group-text {
			border: 1px solid #afaeae !important;
			border-right: none !important;
		}

		.form-control {
			border: 1px solid #afaeae !important;
			border-left: none !important;
		}

		#sub_id.form-control {
			border: 1px solid #afaeae !important;
			border-left: none !important;
			border-radius: 30px !important;
		}

		#std_imgpre {
			width: 200px;
			height: 200px;
			background-size: cover !important;
			display: inline-block;
			border-radius: 100px;
			margin-bottom: 10px;
			-webkit-border-radius: 100px;
			-moz-border-radius: 100px;
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
			<div class="container" style="padding-top:100px">
				<div class="row">

					<div class="col-md-8 mr-auto">
						<div class="card card-signup text-center">
							<div class="card-header ">
								<h4 class="card-title">สมัครสมาชิก</h4>
							</div>
							<div class="card-body ">
								<!-- form ---------------------------------------------------------------------------------------------------------------------->
								<form action="<?= site_url('student/create') ?>" method="post" enctype="multipart/form-data" name="formRegister" id="formRegister" class="form-horizontal" novalidate>
									<input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
									<div class="col-md-4 ml-auto mr-auto">
										<div class="picture-container">
											<div class="picture">
												<div style="background: url('<?= base_url('assets/images/noimage.jpg'); ?>');" id="std_imgpre"></div>
												<input type="file" id="std_img" aria-invalid="false" accept="image/*">
												<input type="hidden" id="std_img2" name="std_img" aria-invalid="false" accept="image/*">
											</div>
											<h6 class="description">Choose Picture</h6>
										</div>
									</div>
									<div class="input-group">
										<div class="form-check form-check-radio form-check-inline">
											<label class="form-check-label">
												<input class="form-check-input title" type="radio" name="std_title" id="std_title" value="นาย">
												<span class="form-check-sign"></span>
												นาย
											</label>
										</div>
										<div class="form-check form-check-radio form-check-inline">
											<label class="form-check-label">
												<input class="form-check-input title" type="radio" name="std_title" id="std_title" value="นางสาว">
												<span class="form-check-sign"></span>
												นางสาว
											</label>
										</div>
										<div class="form-check form-check-radio form-check-inline">
											<label class="form-check-label">
												<input class="form-check-input title" type="radio" name="std_title" id="std_title" value="นาง">
												<span class="form-check-sign"></span>
												นาง
											</label>
										</div>
										<div class="form-check form-check-radio form-check-inline">
											<label class="form-check-label">
												<input class="form-check-input" type="radio" name="std_title" id="other" value="">
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
										<input type="text" class="form-control" placeholder="คำนำหน้าอื่นๆ" name="std_title_input">
									</div>
									<div class="row">
										<div class="input-group col-md-6">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="now-ui-icons users_circle-08"></i>
												</div>
											</div>
											<input type="text" class="form-control" name="std_fname" id="std_fname" placeholder="ชื่อ">
										</div>
										<div class="input-group col-md-6">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="now-ui-icons text_caps-small"></i>
												</div>
											</div>
											<input type="text" placeholder="นามสกุล" name="std_lname" id="std_lname" class="form-control">
										</div>
									</div>
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<i class="now-ui-icons business_badge"></i>
											</div>
										</div>
										<input type="text" class="form-control" name="std_number" id="std_number" placeholder="รหัสนักศึกษา">
									</div>
									<div class="row">
										<div class="input-group col-md-6">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="now-ui-icons ui-1_email-85"></i>
												</div>
											</div>
											<input type="text" class="form-control" name="std_tel" id="std_tel" placeholder="เบอร์โทร">
										</div>
										<div class="input-group col-md-6">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="now-ui-icons files_single-copy-04"></i>
												</div>
											</div>
											<select name="sub_id" id="sub_id" class="form-control" placeholder="เลือกวิชาลงทะเบียน">
												<option value="">เลือกวิชาลงทะเบียน</option>
												<? foreach ($subject as $key => $value) { ?>
													<option value="<?= $value['sub_id']; ?>"><?= $value['sub_name']; ?></option>
												<? } ?>
											</select>
										</div>
									</div>
									<div class="row">
										<div class="input-group col-md-6">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="now-ui-icons ui-1_email-85"></i>
												</div>
											</div>
											<input type="email" class="form-control" name="std_email" id="std_email" placeholder="อีเมล">
										</div>
										<div class="input-group col-md-6">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="now-ui-icons tech_mobile"></i>
												</div>
											</div>
											<input type="text" class="form-control" name="std_pass" id="std_pass" placeholder="รหัสผ่าน">
										</div>
									</div>
									<div class="form-check text-left">
										<label class="form-check-label">
											<input class="form-check-input" type="checkbox" name="check-sign" id="check-sign" value="1">
											<span class="form-check-sign"></span>
											I agree to the
											<a href="#something">terms and conditions</a>.
										</label>
									</div>
							</div>
							<div class="card-footer ">
								<button class="btn btn-primary btn-round btn-lg btn-block" type="submit"> ลงทะเบียน </button>
							</div>
							</form>
							<!-- form end ------------------------------------------------------------------------------------------------------------------>
						</div>
					</div>

					<div class="col-md-4 ml-auto">
						<div class="info-area info-horizontal mt-5">
							<div class="icon icon-primary">
								<i class="now-ui-icons media-2_sound-wave"></i>
							</div>
							<div class="description">
								<h5 class="info-title">Appoint-IT</h5>
							</div>
						</div>
					</div>

				</div>
			</div>
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
				const reader = new FileReader({type:'image/png'});
				// const newreader = new Blob(['foo'], {type:'image/png'});

				reader.onload = function(e) {
					$('#std_imgpre').css('background', 'url(' + e.target.result + ') no-repeat center');
					var img = e.target.result;
					$("#std_img2").val(img);
				}

				reader.readAsDataURL(input.files[0]);
			}
		}
		$("#std_img").change(function(e) {
			readURL(this);
			console.log(e.target.result);
		});
	</script>
	<!-- <script>
		$("#formRegister").validate({
			rules: {
				std_title: {
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
	</script> -->
	<script>
		$(document).ready(function() {
			themejs.checkFullPageBackgroundImage();
		});
	</script>


</body>

</html>