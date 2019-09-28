<?
if (isset($listdata) && count($listdata) != 0) {
	foreach ($listdata as $key => $value) {
		$use_id = $value['use_id'];
		$use_name = $value['use_name'];
		$use_email = $value['use_email'];
		$position_id = $value['position_id'];
	}
}
$title = $this->input->cookie('sysn');
?>
<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><?= $title; ?></h2>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('dashboard/index'); ?>">หน้าแรก</a></li>
			<li class="active"><strong>ข้อมูลส่วนตัว</strong></li>
		</ol>
	</div>
</div>
<!-- End breadcrumb for page -->
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>ข้อมูลส่วนตัว : <?= $title; ?></h5>
					<div class="ibox-tools">
						<button type="button" class="btn btn-outline btn-warning" data-toggle="modal" data-target="#REPASS"><i class="fa fa-lock"></i>&nbsp;&nbsp;เปลี่ยนรหัสผ่าน</button>
					</div>
				</div>
				<div class="ibox-content">
					<form action="<?= site_url('administrator/update'); ?>" method="post" enctype="multipart/form-data" name="formAdministrators_Up" id="formAdministrators_Up" class="form-horizontal" novalidate>
						<input type="hidden" name="type" id="type" value="T">
						<input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
						<input type="hidden" name="Id" id="Id" value="<?= $use_id ?>">
						<input type="hidden" name="position_id" id="position_id" value="<?= $position_id ?>">
						<div class="form-group row">
							<label class="col-md-12">ชื่อเต็ม <span class="text-muted" style="color:#c0392b">*</span></label>
							<div class="col-md-12">
								<input type="text" class="form-control" value="<?= $use_name; ?>" name="use_name" id="use_id">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-12">Email <span class="text-muted" style="color:#c0392b">*</span></label>
							<div class="col-md-8">
								<input type="text" class="form-control" value="<?= $use_email; ?>" name="use_email" id="use_email">
							</div>
							<div class="col-md-4">
								<button type="submit" class="btn btn-outline btn-primary btn-block"><i class="fa fa-check"></i>&nbsp;&nbsp;อัพเดตข้อมูล</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>วิชาที่เปิดสอน</h5>
					<div class="ibox-tools">
						<button type="button" class="btn btn-outline btn-warning" data-toggle="modal" data-target="#REPASS"><i class="fa fa-lock"></i>&nbsp;&nbsp;แก้ไขข้อมูล</button>
					</div>
				</div>
				<div class="ibox-content">
					<form action="<?= site_url('administrator/update'); ?>" method="post" enctype="multipart/form-data" name="formAdministrators_Up" id="formAdministrators_Up" class="form-horizontal" novalidate>
						<input type="hidden" name="type" id="type" value="T">
						<input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
						<input type="hidden" name="Id" id="Id" value="<?= $use_id ?>">
						<input type="hidden" name="position_id" id="position_id" value="<?= $position_id ?>">
						<div class="form-group row">
							<label class="col-md-12">ชื่อเต็ม <span class="text-muted" style="color:#c0392b">*</span></label>
							<div class="col-md-12">
								<input type="text" class="form-control" value="<?= $use_name; ?>" name="use_name" id="use_id">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-12">Email <span class="text-muted" style="color:#c0392b">*</span></label>
							<div class="col-md-8">
								<input type="text" class="form-control" value="<?= $use_email; ?>" name="use_email" id="use_email">
							</div>
							<div class="col-md-4">
								<button type="submit" class="btn btn-outline btn-primary btn-block"><i class="fa fa-check"></i>&nbsp;&nbsp;อัพเดตข้อมูล</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- model REPASS -->
<div class="modal fade" id="REPASS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">เปลี่ยนรหัสผ่าน</h4>
			</div>
			<form action="<?= site_url('administrator/changepassword'); ?>" method="post" enctype="multipart/form-data" name="formRepass" id="formRepass" class="form-horizontal" novalidate>
				<div class="modal-body">
					<input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
					<input type="hidden" name="Id" id="Id" value="<?= $use_id ?>">
					<input type="hidden" name="type" id="type" value="T">
					<div class="form-group">
						<label class="col-sm-3 control-label">รหัสผ่าน<span class="text-muted" style="color:#FF0000">*</span></label>
						<div class="col-sm-9">
							<input type="password" name="use_pass" id="use_pass" class="form-control">
						</div>
					</div>
					<!--*/form-group-->
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<label class="col-sm-3 control-label">ยืนยันรหัสผ่าน<span class="text-muted" style="color:#FF0000">*</span></label>
						<div class="col-sm-9">
							<input type="password" name="use_confirmPassword" id="use_confirmPassword" class="form-control">
						</div>
					</div>
					<!--*/form-group-->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
					<button type="submit" class="btn btn-primary">เปลี่ยนรหัสผ่าน</button>
				</div>
			</form>
		</div>
	</div>
</div>