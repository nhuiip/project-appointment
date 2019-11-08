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
	<link href="<?= base_url('assets/css/plugins/toastr/toastr.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/theme.css'); ?>" rel="stylesheet" />
	<style>
		.form-control {
			border-radius: 0 !important;
		}

		.card-signup .form-check {
			margin-top: 0 !important;
		}

		.card-signup .form-check label {
			margin-left: 0 !important;
			padding-left: 20px !important;
		}

		@media screen and (max-width: 767px) {
			.full-page>.footer {
				position: relative !important;
			}

			.footer .copyright {
				/* float: none !important; */
				text-align: center !important;
			}
		}

		.card-signup .card-footer {
			margin-top: 0 !important;
		}

		#std_title-error,
		#check_sign-error {
			display: none !important;
		}

		label.error {
			width: 100% !important;
			display: block !important;
			text-align: end !important;
			color: #c0392b !important;
			margin-top: 5px !important;
			margin-bottom: 0 !important;
		}

		input.error {
			border: 1px #c0392b solid !;
			border-right: 1px solid #afaeae !important;
			border-top: 1px solid #afaeae !important;
		}

		.input-group .input-group-prepend .input-group-text {
			display: table !important;
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
	<!-- loading -->
	<div class="loading">
		<div class="loader">
			<div class="wrapcus">
				<span class="titlecus">ระบบกำลังดำเนินการ</span>
				<span class="textcus">กรุณาอย่าปิดหน้าเพจ</span>
			</div>
		</div>
	</div>
	<!-- loading -->
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
			<div class="container" style="padding-top:80px">
				<div class="row">
					<div class="col-md-8 mr-auto">
						<div class="card card-signup text-center">
							<div class="card-header ">
								<h4 class="card-title">สมัครสมาชิก</h4>
							</div>
							<div class="card-body ">
								<!-- form ---------------------------------------------------------------------------------------------------------------------->
								<form action="<?= site_url('student/create') ?>" method="post" enctype="multipart/form-data" name="formRegister" id="formRegister" class="form-horizontal" novalidate">
									<input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
									<div class="col-md-12">
										<div class="picture-container" style="margin-bottom: 30px;">
											<div class="picture">
												<div style="background: url('<?= base_url('assets/images/noimage.jpg'); ?>');" id="std_imgpre"></div>
												<input type="file" id="std_img" aria-invalid="false" accept="image/*">
												<input type="hidden" id="std_img2" name="std_img" aria-invalid="false" accept="image/*">
											</div>
											<h6 class="description">Choose Picture</h6>
										</div>
									</div>
									<div class="row">
										<div class="input-group col-md-6">
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
													<input class="form-check-input" type="radio" name="std_title" id="other" value="อื่นๆ">
													<span class="form-check-sign"></span>
													อื่นๆ
												</label>
											</div>
										</div>
										<div class="input-group col-md-6" id="othertitle">
											<input type="text" class="form-control" placeholder="คำนำหน้าอื่นๆ" name="std_title_input">
										</div>
									</div>
									<div class="row">
										<div class="input-group col-md-6">
											<input type="text" class="form-control" name="std_fname" id="std_fname" placeholder="ชื่อ">
										</div>
										<div class="input-group col-md-6">
											<input type="text" placeholder="นามสกุล" name="std_lname" id="std_lname" class="form-control">
										</div>
									</div>
									<div class="row">
										<div class="input-group col-md-6">
											<input type="text" class="form-control" name="std_number" id="std_number" placeholder="รหัสนักศึกษา" data-url="<?= site_url('student/checknumber') ?>">
										</div>
										<div class="input-group col-md-6">
											<input type="text" class="form-control" name="std_tel" id="std_tel" placeholder="เบอร์โทร" maxlength="10">
										</div>
									</div>
									<div class="row">
										<div class="input-group col-md-6">
											<input type="email" class="form-control" name="std_email" id="std_email" placeholder="อีเมล" data-url="<?= site_url('student/checkemail') ?>">
										</div>
										<div class="input-group col-md-6">
											<input type="password" class="form-control" name="std_pass" id="std_pass" placeholder="รหัสผ่าน">
										</div>
									</div>
							</div>
							<div class="card-footer ">
								<button class="btn btn-primary btn-round btn-lg btn-block" type="submit" id="submit"> ลงทะเบียน </button>
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
								<div style="color: #fff;">
									ระบบจองคิวสอบโปรเจคออนไลน์
									<br />
									สำหรับจองคิวขึ้นสอบปริญญานิพนธ์
									<br />
									สาขาวิชาเทคโนโลยีสารสนเทศ
									<br />
									คณะอุตสาหกรรมและเทคโนโลยี
									<br />
									มหาวิทยาลัยเทคโนโลยีราชมงคลรัตนโกสินทร์
									<br />
									วิทยาเขตวังไกลกังวล
								</div>
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
	<script type="text/javascript" src="<?= base_url('assets/js/lib/plugins/toastr/toastr.min.js') ?>"></script>
	<script>
		$('.loading').hide();
		$('#othertitle').hide();
		$("#other").click(function() {
			$('#othertitle').slideDown();
		});
		$(".title").click(function() {
			$('#othertitle').slideUp();
		});

		function readURL(input) {
			if (input.files && input.files[0]) {
				const reader = new FileReader({
					type: 'image/png'
				});
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
	<script>
		$("#formRegister").validate({
			rules: {
				std_fname: {
					required: true
				},
				std_lname: {
					required: true
				},
				std_number: {
					required: true,
					number: true,
					remote: {
						url: $("#std_number").attr("data-url"),
						type: "post",
						data: {
							std_number: function() {
								return $("#std_number").val();
							}
						}
					}
				},
				std_tel: {
					number: true,
				},
				std_email: {
					required: true,
					email: true,
					remote: {
						url: $("#std_email").attr("data-url"),
						type: "post",
						data: {
							std_email: function() {
								return $("#std_email").val();
							}
						}
					}
				},
				std_pass: {
					required: true,
					minlength: 6
				},
			},
			messages: {
				std_fname: {
					required: "กรุณากรอกชื่อ."
				},
				std_lname: {
					required: "กรุณากรอกนามสกุล."
				},
				std_lname: {
					required: "กรุณากรอกนามสกุล."
				},
				std_number: {
					required: "กรุณากรอกรหัสนักศึกษา",
					number: "กรุณากรอกเฉพาะตัวเลขเท่านั้น.",
					remote: "รหัสนักศึกษานี้มีในระบบอยุ่แล้ว"
				},
				std_tel: {
					number: "กรุณากรอกเฉพาะตัวเลขเท่านั้น.",
				},
				std_email: {
					required: "กรุณากรอกอีเมล.",
					email: "รูปแบบอีเมลผิดพลาด.",
					remote: "อีเมลนี้มีในระบบอยุ่แล้ว"
				},
				std_pass: {
					required: "กรุณากรอกรหัสผ่าน.",
					minlength: "กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัวอักษร."
				},
			},
			submitHandler: function() {
				$.ajax({
					url: $("#formRegister").attr("action"),
					data: $("#formRegister").serialize(),
					type: 'POST',
					dataType: "json",
					success: function(result) {
						toastr.options = {
							closeButton: true,
							progressBar: true,
							positionClass: "toast-top-center",
							showMethod: "slideDown",
							timeOut: 3000
						};
						if (result.error === true) {
							toastr.warning(result.title, result.msg);
							$('#submit').prop('disabled', false);
						} else {
							$('.loading').show();
							setTimeout(function() {
								location.href = result.url;
							}, 1000);
						}
					}
				});
			}
		});
	</script>
</body>

</html>