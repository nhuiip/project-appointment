<?php
function DateThai($strDate)
{
	$strYear = date("Y", strtotime($strDate)) + 543;
	$strMonth = date("n", strtotime($strDate));
	$strDay = date("j", strtotime($strDate));
	$strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$strMonthThai = $strMonthCut[$strMonth];
	return "$strDay $strMonthThai $strYear";
}
?>
<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2>จัดการวันหยุด</h2>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('dashboard/index'); ?>">หน้าแรก</a></li>
			<li><a href="<?= site_url('setting/index'); ?>">ตั้งค่าระบบ</a></li>
			<li class="active"><strong>จัดการวันหยุด</strong></li>
		</ol>
	</div>
</div>
<!-- End breadcrumb for page -->
<div class="row wrapper white-bg">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content" style="padding: 15px 0 20px;">
				<div class="col-md-4 col-md-offset-8" style="padding-left: 0;padding-right: 0;">
					<!-- ปุ่มเพิ่มข้อมูล -->
					<button type="button" class="btn btn-outline btn-primary pull-right" data-toggle="modal" data-target="#createHol"><i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล</button>
					<!-- ค้นหา -->
					<? if (count($listholiday) != 0) { ?>
						<div class="input-group">
							<input type="text" placeholder="Search" name="search-input" id="search-input" class="form-control">
							<span class="input-group-btn">
								<button type="button" id="search-btn" class="btn btn-default">ค้นหา</button>
							</span>
						</div>
					<? } ?>
				</div>
				<? if (count($listholiday) != 0) { ?>
					<!-- table ------------------------------------------------------------------------------------------------------->
					<table class="table table-hover table-bordered dataTables-export" width="100%">
						<thead>
							<tr>
								<th>#</th>
								<th>วันหยุด</th>
								<th>วันที่</th>
								<th>เพิ่มข้อมูล</th>
								<th></th>
								<th>แก้ไขล่าสุด</th>
							</tr>
						</thead>
						<tbody>
							<?PHP foreach ($listholiday as $key => $value) { ?>
								<tr class="gradeX">
									<td width="5%"><strong><?= "H" . str_pad($value['hol_id'], 3, "0", STR_PAD_LEFT); ?></strong></td>
									<td width="30%"><?= $value['hol_name'] ?></td>
									<td width="25%"><?= DateThai($value['hol_date']); ?></td>
									<td width="15%">
										<?= $value['hol_create_name']; ?><br />
										<small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['hol_create_date']); ?> <?= date('h:i A', strtotime($value['hol_create_date'])); ?></small>
									</td>
									<td width="10%">
										<div class="btn-group" style="width:100%">
											<button class="btn btn-sm btn-default " type="button" style="width:70%">จัดการ</button>
											<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:30%;">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<ul class="dropdown-menu" style="width:100%">
												<li><a href="#" data-toggle="modal" class="updateHol" data-holid="<?= $value['hol_id'] ?>" data-holname="<?= $value['hol_name'] ?>" data-holdate="<?= $value['hol_date'] ?>" data-toggle="modal" data-target="#updateHol"><i class=" fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;แก้ไขข้อมูล</a></li>
												<li><a href="#" class="btn-alert" data-url="<?= site_url('holiday/delete/' . $value['set_id'] . '/' . $value['hol_id']); ?>" data-title="ต้องการลบข้อมูล?"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;ลบข้อมูล</a></li>
											</ul>
										</div>
									</td>
									<td width="15%">
										<?= $value['hol_lastedit_name']; ?><br />
										<small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['hol_lastedit_date']); ?> <?= date('h:i A', strtotime($value['hol_lastedit_date'])); ?></small>
									</td>
								</tr>
							<?PHP } ?>
						</tbody>
						<tfoot>
							<tr>
								<th></th>
								<th class="ftinput">วันหยุด</th>
								<th class="ftinput">วันที่</th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</tfoot>
					</table>
					<!-- table ------------------------------------------------------------------------------------------------------->
				<? } else { ?>
					<div class="col-lg-12" style="padding-left: 0;padding-right: 0;">
						<hr>
						<center>
							<p>ไม่พบข้อมูล</p>
						</center>
					</div>
				<? } ?>
			</div>
		</div>
	</div>
</div>

<!-- model insert -->
<div class="modal fade" id="createHol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">ข้อมูลวันหยุด</h4>
			</div>
			<form action="<?= site_url('holiday/create') ?>" method="post" enctype="multipart/form-data" name="formCHoliday" id="formCHoliday" class="form-horizontal" novalidate>
				<div class="modal-body">
					<input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
					<input type="hidden" name="set_id" id="set_id" value="<?= $set_id ?>">
					<div class="form-group row">
						<label class="col-sm-2 control-label">วันหยุด<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="hol_name" id="hol_name" class="form-control" maxlength="255">
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group row">
						<label class="col-sm-2 control-label">วันที่<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="hol_date" id="hol_date" class="form-control datepicker" data-url="<?= site_url('holiday/checkdate'); ?>">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-w-m btn-danger" type="button" data-dismiss="modal">ยกเลิก</button>
					<button class="btn btn-w-m btn-primary" type="submit">บันทึก</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- model update -->
<script>
	$('.updateHol').click(function() {
		var holid = $(this).attr('data-holid');
		var holname = $(this).attr('data-holname');
		var holdate = $(this).attr('data-holdate');
		$(".hol_id").val(holid);
		$(".hol_name").val(holname);
		$(".hol_date").val(holdate);
	});
</script>
<div class="modal fade" id="updateHol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">ข้อมูลวันหยุด</h4>
			</div>
			<form action="<?= site_url('holiday/update') ?>" method="post" enctype="multipart/form-data" name="formEHoliday" id="formEHoliday" class="form-horizontal" novalidate>
				<div class="modal-body">
					<input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
					<input type="hidden" name="set_id" id="set_id_up" value="<?= $set_id ?>">
					<input type="hidden" name="hol_id" id="hol_id" class="hol_id">
					<div class="form-group row">
						<label class="col-sm-2 control-label">วันหยุด<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="hol_name" id="hol_name" class="form-control hol_name" maxlength="255" value="">
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group row">
						<label class="col-sm-2 control-label">วันที่<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="hol_date" id="hol_date_up" class="form-control datepicker hol_date" data-url="<?= site_url('holiday/checkdate'); ?>">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-w-m btn-danger" type="button" data-dismiss="modal">ยกเลิก</button>
					<button class="btn btn-w-m btn-primary" type="submit">บันทึก</button>
				</div>
			</form>
		</div>
	</div>
</div>