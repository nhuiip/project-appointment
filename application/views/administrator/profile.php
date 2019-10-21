<?
function DateThai($strDate)
{
	$strYear = date("Y", strtotime($strDate)) + 543;
	$strMonth = date("n", strtotime($strDate));
	$strDay = date("j", strtotime($strDate));
	$strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$strMonthThai = $strMonthCut[$strMonth];
	return "$strDay $strMonthThai $strYear";
}

if (isset($listdata) && count($listdata) != 0) {
	foreach ($listdata as $key => $value) {
		$use_id = $value['use_id'];
		$use_name = $value['use_name'];
		$use_email = $value['use_email'];
		$position_id = $value['position_id'];
	}
}
if (isset($listsubject) && count($listsubject) != 0) {
	foreach ($listsubject as $key => $value) {
		$sub_id = $value['sub_id'];
		$sub_name = $value['sub_name'];
		$sub_code = $value['sub_code'];
		$sub_setuse = $value['sub_setuse'];
		$sub_setless = $value['sub_setless'];
		$sub_type = $value['sub_type'];
	}
}
$title = $this->encryption->decrypt($this->input->cookie('sysn'));
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
<div class="wrapper wrapper-content">
	<div class="row">
		<div class="col-lg-4 animated fadeInRight">
			<div class="ibox float-e-margins" style="margin-bottom: 15px;">
				<div class="ibox-title">
					<div class="ibox-tools">
						<button type="button" class="btn btn-outline btn-warning btn-sm" data-toggle="modal" data-target="#REPASS"><i class="fa fa-lock"></i>&nbsp;&nbsp;เปลี่ยนรหัสผ่าน</button>
					</div>
				</div>
				<div class="ibox-content">
					<form action="<?= site_url('administrator/update'); ?>" method="post" enctype="multipart/form-data" name="formAdministrators_Up" id="formAdministrators_Up" class="form-horizontal" novalidate>
						<input type="hidden" name="type" id="type" value="T">
						<input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
						<input type="hidden" name="Id" id="use_id" value="<?= $use_id ?>">
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
								<input type="text" class="form-control" value="<?= $use_email; ?>" name="use_email" id="use_email_up" data-url="<?= site_url('administrator/checkemailup'); ?>">
							</div>
							<div class="col-md-4">
								<button type="submit" class="btn btn-outline btn-primary btn-block"><i class="fa fa-check"></i>&nbsp;&nbsp;อัพเดตข้อมูล</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>วิชาที่เปิดสอน</h5>
					<div class="ibox-tools">
						<button type="button" class="btn btn-outline btn-sm btn-default">รายการขึ้นสอบ</button>
					</div>
				</div>
				<div class="ibox-content">
					<div class="form-group row">
						<label class="col-md-12">ชื่อวิชา <span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-md-12">
							<input type="text" class="form-control" value="<?= $sub_name; ?>" name="sub_name" id="sub_name">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-12">รหัสวิชา <span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-md-12">
							<input type="text" class="form-control" value="<?= $sub_code; ?>" name="sub_code" id="sub_code">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-12">จำนวนอาจารย์ขึ้นสอบ <span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-md-12">
							<input type="text" class="form-control" value="<?= $sub_setuse; ?>" name="sub_setuse" id="sub_setuse">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-12">อาจารย์ขึ้นสอบอย่างน้อย <span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-md-8">
							<input type="text" class="form-control" value="<?= $sub_setless; ?>" name="sub_setless" id="sub_setless">
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-outline btn-primary btn-block"><i class="fa fa-check"></i>&nbsp;&nbsp;อัพเดตข้อมูล</button>
						</div>
					</div>
				</div>
				<div class="ibox-title">
					<h5>เอกสารประกอบ</h5>
					<div class="ibox-tools">
						<button type="button" class="btn btn-outline btn-primary btn-sm" data-toggle="modal" data-target="#upfile"><i class="fa fa-plus"></i></button>
					</div>
				</div>
				<div class="ibox-content">
					<? if (count($listatt) != 0) { ?>
						<div class="table-responsive">
							<table class="table table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th>#</th>
										<th>ชื่อไฟล์</th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<? $numrows = 1;
										foreach ($listatt as $key => $value) { ?>

										<tr>
											<td style="width:10%"><?= $numrows; ?></td>
											<td style="width:70%"><?= $value['att_name']; ?></td>
											<td style="width:10%">
												<button type="button" class="btn btn-sm btn-white"><i class="fa fa-download"></i></button>
											</td>
											<td style="width:10%">
												<button type="button" class="btn btn-sm btn-danger btn-alert" data-url="<?= site_url('attached/delete/' . $value['att_name'] . '/' . $value['att_id']); ?>" data-title="ต้องการลบข้อมูล?"><i class="fa fa-remove"></i></button>
											</td>
										</tr>
									<? $numrows++;
										} ?>
								</tbody>
							</table>
						</div>
					<? } else { ?>
						<center>ไม่พบไฟล์</center>
					<? } ?>
				</div>
			</div>
		</div>

		<div class="col-lg-8 animated fadeInRight">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>จัดการเวลา</h5>
				</div>
				<div class="ibox-content inspinia-timeline">

					<? foreach ($listsec as $key => $value) { ?>
						<div class="timeline-item">
							<div class="row">
								<div class="col-md-4 date">
									<i class="fa fa-calendar"></i>
									<?= DateThai($value['sec_date']); ?>
									<br>
									<small class="text-navy">this active</small>
								</div>
								<?
									$this->db->select("*");
									$this->db->where(array(
										'set_id' => $set_id,
										'sec_date' => $value['sec_date'],
										'use_id' => $this->encryption->decrypt($this->input->cookie('sysli'))
									));
									$query = $this->db->get('tb_section');
									$listusersec = $query->result_array();
									?>
								<div class="col-md-8 content no-top-border">
									<? foreach ($listusersec as $key => $v) { ?>
										<div class="col-md-2 timecheck">
											<label class="onoff"><input type="checkbox" value="1" id="sectione-<?= $v['sec_id']; ?>" name="sectione-<?= $v['sec_id']; ?>" class="timechecks" data-url="<?= site_url('section/timecheck/' . $v['sec_id']); ?>" <? if ($v['sec_status'] == 1) {
																																																																	echo 'checked';
																																																																} ?>><label for="sectione-<?= $v['sec_id']; ?>"></label></label>
											<p><?= $v['sec_time_one']; ?> น.</p>
										</div>
									<? } ?>
								</div>
							</div>
						</div>
					<? } ?>

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
					<input type="hidden" name="formcrf" id="formcrf2" value="<?= $formcrf; ?>">
					<input type="hidden" name="Id" id="use_id2" value="<?= $use_id ?>">
					<input type="hidden" name="type" id="type" value="T">
					<div class="form-group">
						<label class="col-sm-3 control-label">รหัสผ่าน<span class="text-muted" style="color:#FF0000">*</span></label>
						<div class="col-sm-9">
							<input type="password" name="use_pass" id="use_pass" class="form-control">
						</div>
					</div>
					<!--*/form-group-->
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

<div class="modal fade" id="upfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">เพิ่มเอกสาร</h4>
			</div>
			<form action="<?= site_url('attached/create'); ?>" method="post" enctype="multipart/form-data" name="formAttached" id="formAttached" class="form-horizontal" novalidate>
				<div class="modal-body">
					<input type="hidden" name="formcrf" id="formcrf3" value="<?= $formcrf; ?>">
					<input type="hidden" name="sub_id" id="sub_id" value="<?= $sub_id ?>">
					<input type="hidden" name="use_id" value="<?= $use_id ?>">
					<div class="form-group">
						<label class="col-sm-3 control-label">ชื่อไฟล์<span class="text-muted" style="color:#FF0000">*</span></label>
						<div class="col-sm-9">
							<input type="text" name="att_name" id="att_name" class="form-control">
						</div>
					</div>
					<!--*/form-group-->
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<label class="col-sm-3 control-label">เลือกไฟล์<span class="text-muted" style="color:#FF0000">*</span></label>
						<div class="col-sm-9">
							<input type="file" name="att_filename" id="att_filename" class="form-control">
						</div>
					</div>
					<!--*/form-group-->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
					<button type="submit" class="btn btn-primary">เพิ่มเอกสาร</button>
				</div>
			</form>
		</div>
	</div>
</div>