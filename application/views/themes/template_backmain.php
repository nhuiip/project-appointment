<?
$loginid 	= $this->encryption->decrypt($this->input->cookie('sysi'));
$loginname	= $this->encryption->decrypt($this->input->cookie('sysn'));
$position 	= $this->encryption->decrypt($this->input->cookie('sysp'));

?>
<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Appoint-IT</title>
	<link rel="icon" href="<?= base_url('assets/images/logo/logo.png'); ?>" type="image/x-icon">
	<link rel="shortcut icon" href="<?= base_url('assets/images/logo/logo.png'); ?>" type="image/x-icon">

	<!-- css style -->
	<link href="https://fonts.googleapis.com/css?family=Trirong:300,400&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Sarabun:300,400|Trirong:300,400&display=swap" rel="stylesheet">
	<link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/plugins/toastr/toastr.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/plugins/dataTables/datatables.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/plugins/select2/select2.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/animate.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/custom.css'); ?>" rel="stylesheet">
	<?PHP
	if (!empty($css)) {
		echo $css;
	}
	?>
	<style>
		.img-circular {
			position: relative;
			width: 30px;
			height: 30px;
			background: url('https://scontent.fbkk6-2.fna.fbcdn.net/v/t1.0-9/70847629_2363954343844207_4579293697203503104_n.jpg?_nc_cat=109&_nc_eui2=AeGjshH5FV8hQKl0o6UGvQzD2eRFUnfQjIBUt8bqiEJyxMZDK4hAWqfzVB2fC8J4M1KZvhYJbnmWqBykNIaQKwyCFTdg4NCjT7fsH6nPf44nLw&_nc_oc=AQmwzzPWGPdInHVocYYVdOdC0ieBHON43dOZgPRfsOBi2NOvL5FrjbQcyHyBlUl8aYA&_nc_ht=scontent.fbkk6-2.fna&oh=1237d67d4cb2cb0c2962bb5e1b9135c3&oe=5DF8E78E') no-repeat center;
			background-size: cover;
			display: inline-block;
			margin: 0;
			top: 10px;
			border-radius: 100px;
			-webkit-border-radius: 100px;
			-moz-border-radius: 100px;
		}
	</style>
	<link href="<?= base_url('assets/css/style.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/plugins/datapicker/datepicker3.css'); ?>" rel="stylesheet">
	<!-- script js -->
	<script src="<?= base_url('assets/js/lib/jquery-2.1.1.js'); ?>"></script>
	<script src="<?= base_url('assets/js/lib/plugins/dataTables/datatables.min.js'); ?>"></script>
	<script src="<?= base_url('assets/js/lib/plugins/dataTables/Responsive-2.2.2/js/dataTables.responsive.min.js'); ?>"></script>
	<script data-main="<?= base_url('assets/js/app.js'); ?>" src="<?= base_url('assets/js/require.js'); ?>"></script>
</head>

<? if ($position == 'นักศึกษา') { ?>

	<body class="pace-done">
	<? } else { ?>

		<body class="top-navigation"><? } ?>

		<? if ($position == 'นักศึกษา') { ?>
			<div id="wrapper">
				<nav class="navbar-default navbar-static-side" role="navigation">
					<div class="sidebar-collapse">
						<ul class="nav metismenu" id="side-menu">
							<li class="nav-header">
								<div class="dropdown profile-element">
									<center><img src="<?= base_url('assets/images/reunion.svg'); ?>" width="50%"></center>
								</div>
								<div class="logo-element">
									<img src="<?= base_url('assets/images/reunion.svg'); ?>" alt="">
								</div>
							</li>
							<li>
								<a href="<?= site_url('dashboard/index'); ?>"><i class="fa fa-tachometer"></i> <span class="nav-label">หน้าแรก</span></a>
							</li>
							<li>
								<a href="<?= site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))); ?>"><i class="fa fa-user"></i> <span class="nav-label">ข้อมูลส่วนตัว</span></a>
							</li>
							<li>
								<a href="<?= site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))); ?>"><i class="fa fa-calendar"></i> <span class="nav-label">การนัดหมาย</span></a>
							</li>
							<? if ($position == 'ผู้ดูแลระบบ' || $position == 'หัวหน้าสาขา' || $position == 'อาจารย์ผู้สอน') { ?>
								<li>
									<a href="<?= site_url('subject/index'); ?>"><i class="fa fa-align-left"></i> <span class="nav-label">จัดการรายวิชา</span></a>
								</li>
								<li>
									<a href="<?= site_url('administrator/main'); ?>"><i class="fa fa-graduation-cap"></i> <span class="nav-label">ข้อมูลนักศึกษา</span></a>
								</li>
								<li>
									<a href="<?= site_url('administrator/main'); ?>"><i class="fa fa-th-large"></i> <span class="nav-label">ข้อมูลโปรเจค</span></a>
								</li>
							<? } ?>
							<? if ($position == 'ผู้ดูแลระบบ' || $position == 'ฉุกเฉิน') { ?>
								<li>
									<a href="<?= site_url('administrator/main'); ?>"><i class="fa fa-group"></i> <span class="nav-label">จัดการข้อมูลผู้ใช้</span></a>
								</li>
							<? } ?>
							<? if ($position == 'ผู้ดูแลระบบ') { ?>
								<li>
									<a href="<?= site_url('setting/index'); ?>"><i class="fa fa-tasks"></i> <span class="nav-label">ตั้งค่าระบบ</span></a>
								</li>
							<? } ?>

						</ul>
					</div>
				</nav>
				<div id="page-wrapper" class="gray-bg">
					<div class="row border-bottom">
						<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
							<div class="navbar-header">
								<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
							</div>
							<ul class="nav navbar-top-links navbar-right">
								<li>
									<span class="m-r-sm text-muted welcome-message"><?= $loginname; ?></span>
								</li>
								<li>
									<a href="<?= site_url('administrator/logout'); ?>" style="color:#c0392b"> <i class="fa fa-sign-out"></i> ออกจากระบบ </a>
								</li>
							</ul>
						</nav>
					</div>

					<!-- contents -->
					<?= $contents ?>
					<!-- contents end -->

					<div class="footer"><strong>Copyright</strong> Napassorn | Preedarat &copy; 2019 </div>
				</div>

			</div>
		<? } else { ?>
			<div id="wrapper">
				<div id="page-wrapper" class="gray-bg">
					<div class="row border-bottom white-bg">
						<nav class="navbar navbar-static-top" role="navigation">
							<div class="navbar-header">
								<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
									<i class="fa fa-reorder"></i>
								</button>
								<a href="#" class="navbar-brand">Appoint-IT</a>
							</div>
							<div class="navbar-collapse collapse" id="navbar">
								<ul class="nav navbar-nav">
									<li>
										<a aria-expanded="false" role="button" href="<?= site_url('dashboard/index'); ?>">หน้าแรก</a>
									</li>
									<li>
										<a href="<?= site_url('calendar/index/'); ?>"><i class="fa fa-calendar"></i> <span class="nav-label">การนัดหมาย</span></a>
									</li>
									<li>
										<a href="<?= site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))); ?>"><i class="fa fa-user"></i> <span class="nav-label">ข้อมูลส่วนตัว</span></a>
									</li>

								</ul>
								<ul class="nav navbar-top-links navbar-right">
									<li><a href=""><?= $loginname; ?></a></li>
									<div class="img-circular" style=""></div>
									<li>
										<a href="<?= site_url('administrator/logout'); ?>" style="color:#c0392b"> <i class="fa fa-sign-out"></i> ออกจากระบบ </a>
									</li>
								</ul>
							</div>
						</nav>
					</div>
					<!-- for content-->
					<?= $contents ?>
					<!-- for footer-->
					<div class="footer"><strong>Copyright</strong> Napassorn | Preedarat &copy; 2019 </div>

				</div>
			</div>
		<? } ?>

		</body>

</html>