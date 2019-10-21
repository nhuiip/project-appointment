<div class="row wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-8">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Colors buttons</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
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
									<!-- <li>
										<a href="<?= site_url('student/stdprofile/' . $loginid) ?>"><i class="fa fa-user"></i><span class="nav-label">ข้อมูลส่วนตัว</span></a>
									</li> -->

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
									<!-- <li><a href=""><?= $loginname; ?></a></li> -->
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
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>ประวัติการทำนัด</h5>
                <!-- <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div> -->
            </div>
            <div class="ibox-content">
                
            </div>
        </div>
    </div>
</div>