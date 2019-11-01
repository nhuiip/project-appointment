<?
$loginid 	= $this->encryption->decrypt($this->input->cookie('sysli'));
$loginname	= $this->encryption->decrypt($this->input->cookie('sysn'));
$position 	= $this->encryption->decrypt($this->input->cookie('sysp'));
if (!empty($this->encryption->decrypt($this->input->cookie('sysimg'))) && $this->encryption->decrypt($this->input->cookie('sysimg')) != '') {
	$loginimg = $this->encryption->decrypt($this->input->cookie('sysimg'));
} else {
	$loginimg = 'noimage.png';
}
$this->db->select('tb_meetdetail.use_id');
$this->db->from('tb_meet');
$this->db->join('tb_settings', 'tb_settings.set_id = tb_meet.set_id');
$this->db->join('tb_project', 'tb_project.project_id = tb_meet.project_id');
$this->db->join('tb_subject', 'tb_subject.sub_id = tb_meet.sub_id');
$this->db->join('tb_meetdetail', 'tb_meetdetail.meet_id = tb_meet.meet_id');
$this->db->where(array(
	'tb_settings.set_status' => 2, 
	'tb_meetdetail.use_id' => $loginid,
	'tb_meetdetail.dmeet_status' => 2,
));
$query_meet = $this->db->get();
$listmeet = $query_meet->result_array();

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

	<!-- calendar -->
	<link href="<?= base_url('assets/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/plugins/fullcalendar/fullcalendar.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/plugins/fullcalendar/fullcalendar.print.css'); ?>" rel='stylesheet' media='print'>

	<?PHP
	if (!empty($css)) {
		echo $css;
	}
	?>

	<link href="<?= base_url('assets/css/style.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/plugins/datapicker/datepicker3.css'); ?>" rel="stylesheet">
	<style>
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
			background-color: rgba(236, 240, 241, 0.8);
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
	<!-- script js -->
	<script src="<?= base_url('assets/js/lib/jquery-2.1.1.js'); ?>"></script>
	<script src="<?= base_url('assets/js/lib/plugins/dataTables/datatables.min.js'); ?>"></script>
	<script src="<?= base_url('assets/js/lib/plugins/dataTables/Responsive-2.2.2/js/dataTables.responsive.min.js'); ?>"></script>
	<?PHP
	if (!empty($js)) {
		echo $js;
	}
	?>
	<script data-main="<?= base_url('assets/js/app.js'); ?>" src="<?= base_url('assets/js/require.js'); ?>"></script>

	<style>
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
<? if ($position != 'นักศึกษา') { ?>

	<body class="pace-done"><? } ?>
	<? if ($position == 'นักศึกษา') { ?>

		<body class="top-navigation"><? } ?>
		<div class="loading">Loading&#8230;</div>
		<? if ($position != 'นักศึกษา') { ?>
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
							<? if ($position != 'ฉุกเฉิน') { ?>
								<li>
									<a href="<?= site_url('dashboard/index'); ?>"><i class="fa fa-tachometer"></i> <span class="nav-label">หน้าแรก</span></a>
								</li>
								<li>
									<a href="<?= site_url('amcalendar/index/' . $loginid); ?>"><i class="fa fa-calendar"></i> <span class="nav-label">การนัดหมาย</span></a>
								</li>
							<? } ?>
							<? if ($position != 'ผู้ดูแลระบบ' && $position != 'ฉุกเฉิน') { ?>
								<li>
									<a href="<?= site_url('profile/index/' . $loginid); ?>"><i class="fa fa-user"></i> <span class="nav-label">ข้อมูลส่วนตัว</span></a>
								</li>
							<? } ?>
							<? if ($position != 'นักศึกษา' && $position != 'ฉุกเฉิน') { ?>
								<li><a href="<?= site_url('subject/index'); ?>"><i class="fa fa-align-left"></i> <span class="nav-label">จัดการรายวิชา</span></a></li>
								<li><a href="<?= site_url('student/index'); ?>"><i class="fa fa-graduation-cap"></i> <span class="nav-label">ข้อมูลนักศึกษา</span></a></li>
								<li><a href="<?= site_url('project/index'); ?>"><i class="fa fa-th-large"></i> <span class="nav-label">ข้อมูลปริญญานิพนธ์</span></a></li>
								<li><a href="<?= site_url('extra/index'); ?>"><i class="fa fa-male"></i> <span class="nav-label">อาจารย์พิเศษ</span></a></li>
							<? } ?>
							<? if ($position == 'ผู้ดูแลระบบ') { ?>
								<li><a href="<?= site_url('administrator/main'); ?>"><i class="fa fa-group"></i> <span class="nav-label">จัดการข้อมูลผู้ใช้</span></a></li>
								<li><a href="<?= site_url('setting/index'); ?>"><i class="fa fa-tasks"></i> <span class="nav-label">ตั้งค่าระบบ</span></a></li>
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
								<? if (($position == 'หัวหน้าสาขา' || $position == 'อาจารย์ผู้สอน') && count($listmeet) != 0) { ?>
									<li>
										<a class="dropdown-toggle count-info" href="<?=site_url('amcalendar/request/'.$loginid);?>">
											<i class="fa fa-envelope"></i> <span class="label label-danger"><?=count($listmeet);?></span>
										</a>
									</li>
								<? } ?>
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
		<? } ?>
		<? if ($position == 'นักศึกษา') { ?>
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
										<a href="<?= site_url('calendar/index/' . $loginid); ?>"><i class="fa fa-calendar"></i> <span class="nav-label">การนัดหมาย</span></a>
									</li>
									<li>
										<a href="<?= site_url('student/stdproject/' . $loginid); ?>"><i class="fa fa-book"></i> <span class="nav-label">ข้อมูลปริญญานิพนธ์</span></a>
									</li>
								</ul>
								<ul class="nav navbar-top-links navbar-right">
									<style>
										.img-circular {
											position: relative !important;
											width: 30px !important;
											height: 30px !important;
											background-repeat: no-repeat !important;
											background-position: center center !important;
											background-size: cover !important;
											display: inline-block !important;
											margin: 0 !important;
											top: 10px !important;
											border-radius: 50% !important;
											-webkit-border-radius: 100px !important;
											-moz-border-radius: 100px !important;
										}
									</style>
									<li class="dropdown">
										<a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?= $loginname; ?> <span class="caret"></span></a>
										<ul role="menu" class="dropdown-menu">
											<li><a href="" data-toggle="modal" data-target="#editdata">แก้ไขข้อมูลส่วนตัว</a></li>
											<li><a href="" data-toggle="modal" data-target="#modal-chengemail">เปลี่ยนที่อยู่อีเมล</a></li>
											<li><a href="" data-toggle="modal" data-target="#modal-chengpassword">เปลี่ยนรหัสผ่าน</a></li>
										</ul>
									</li>
									<div class="img-circular" style="background: url('<?= base_url("uploads/student/" . $loginimg); ?>');"></div>
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
<? if ($position == 'นักศึกษา') {
	$this->db->select('*');
	$this->db->where(array('std_id' => $loginid));
	$query_profile = $this->db->get('tb_student');
	$listprofiledata = $query_profile->result_array();

	$Id = 	$listprofiledata[0]['std_id'];
	$Img_std = 	$listprofiledata[0]['std_img'];
	$Tetx_number = $listprofiledata[0]['std_number'];
	$Text_name = $listprofiledata[0]['std_fname'];
	$Text_lastname = $listprofiledata[0]['std_lname'];
	$Tetx_tel = $listprofiledata[0]['std_tel'];
	?>
	<!-- edit profile -->
	<div class="modal fade" id="editdata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลส่วนตัว</h4>
				</div>
				<form action="<?= base_url('student/stdupdate/'); ?>" method="post" enctype="multipart/form-data" name="formStudentProfile" id="formStudentProfile" class="form-horizontal" novalidate>
					<div class="modal-body">
						<input type="hidden" name="Id" id="Id" value="<?= $Id; ?>">
						<div class="form-group">
							<div class="col-lg-12">
								<div class="col-lg-12 center">
									<div class="picture-container">
										<div class="picture">
											<?PHP if ($Img_std == "") { ?>
												<div style="background: url('<?= base_url('assets/images/noimage.jpg'); ?>');" id="std_imgpre"></div>
											<?PHP } else { ?>
												<div style="background: url('<?= base_url('uploads/student/' . $Img_std); ?>');" id="std_imgpre"></div>
											<?PHP } ?>
											<input type="file" id="std_img" aria-invalid="false" accept="image/*">
											<input type="hidden" id="std_img2" name="std_img">
										</div>
										<h6 class="description">เปลี่ยนรูปภาพ</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-12">รหัสนักศึกษา</label>
							<div class="col-lg-12">
								<input placeholder="รหัสนักศึกษา" class="form-control" value="<?= $Tetx_number; ?>" disabled>
								<input type="hidden" name="std_number" id="std_number" placeholder="รหัสนักศึกษา" class="form-control" value="<?= $Tetx_number; ?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-6">
								<label>ชื่อ<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
								<div>
									<input placeholder="ชื่อ" class="form-control" name="text_name" id="text_name" value="<?= $Text_name; ?>" class="form-control">
								</div>
							</div>
							<div class="col-lg-6">
								<label>นามสกุล<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
								<div>
									<input placeholder="นามสกุล" class="form-control" name="text_lastname" id="text_lastname" value="<?= $Text_lastname; ?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-12">เบอร์โทรศัพท์<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
							<div class="col-lg-12">
								<input placeholder="เบอร์โทรศัพท์" maxlength="10" class="form-control" name="text_tel" id="text_tel" value="<?= $Tetx_tel; ?>">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
						<button type="submit" class="btn btn-primary">บันทึก</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- chengemail email -->
	<div id="modal-chengemail" class="modal fade" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?= base_url('student/stdchangemail'); ?>" method="post" enctype="multipart/form-data" name="formChangemailstd" id="formChangemailstd" class="form-horizontal" novalidate>
					<input type="hidden" name="Idmail" id="Idmail" value="<?= $Id; ?>">
					<div class="modal-body">
						<h3 class="m-t-none m-b">เปลี่ยนที่อยู่อีเมล์</h3>
						<p><span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span>เมื่อเปลี่ยนอีเมล์แล้วต้องเข้าสู่ระบบใหม่อีกครั้ง.</p>
						<hr />
						<div class="form-group-mgTB">
							<input type="email" name="std_email" id="std_email" placeholder="กรอกข้อมูลอีเมล์" class="form-control" data-url="<?= site_url('student/checkemail'); ?>">
						</div>
						<div class="mgBottom">
							<button class="btn btn-lw100 btn-primary" type="submit"><strong>ยืนยันการเปลี่ยนที่อยู่อีเมล์</strong></button>
						</div>
						<div style="margin-bottom: 20px;"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- chengepassword -->
	<div id="modal-chengpassword" class="modal fade" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?= base_url('student/stdchangepassword'); ?>" method="post" enctype="multipart/form-data" name="formChangepasswordstd" id="formChangepasswordstd" class="form-horizontal" novalidate>
					<input type="hidden" name="Id2" id="Id2" value="<?= $Id; ?>">
					<div class="modal-body">
						<h3 class="m-t-none m-b">เปลี่ยนรหัสผ่าน</h3>
						<hr />
						<div class="form-group-mgTB">
							<input type="password" name="std_password" id="std_password" placeholder="กรุณากรอกรหัสผ่าน" class="form-control">
						</div>
						<div class="mgBottom">
							<button class="btn btn-lw100 btn-primary" type="submit"><strong>ยืนยันการเปลี่ยนรหัสผ่าน</strong></button>
						</div>
						<div style="margin-bottom: 20px;"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
<? } ?>

<script>
	$('.loading').hide();

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

	$("#std_img").change(function() {
		readURL(this);
	});
</script>