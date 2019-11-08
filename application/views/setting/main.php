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
		<h2>ตั้งค่าระบบ</h2>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('dashboard/index'); ?>">หน้าแรก</a></li>
			<li class="active"><strong>ตั้งค่าระบบ</strong></li>
		</ol>
	</div>
</div>
<!-- End breadcrumb for page -->
<div class="row wrapper white-bg">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content" style="padding: 15px 0 20px;">
				<div class="info pull-right">
					<div class="badges alt"><span class="content red"><i class="fa fa-info"></i></i></span><span class="tag">กรุณาปิดระบบการนัดหมายเดิมก่อนเพิ่มข้อมูลกำหนดการนัดหมายใหม่</span></div>
					<div class="badges alt"><span class="content red"><i class="fa fa-info"></i></i></span><span class="tag">ใน 1 เทอมสามารถเปิดระบบได้ 1 ครั้งเท่านั้น</span></div>
				</div>
				<div class="col-md-4 col-md-offset-7 pull-right" style="padding-left: 0;padding-right: 0;">
					<!-- ปุ่มเพิ่มข้อมูล -->
					<? if ($checkinsert == 'no') { ?>
						<button class="btn btn-outline btn-primary pull-right" disabled><i class="fa fa-plus"></i> เพิ่มข้อมูล</button>
					<? } else { ?>
						<button class="btn btn-outline btn-primary pull-right" data-toggle="modal" data-target="#insert"><i class="fa fa-plus"></i> เพิ่มข้อมูล</button>
					<? } ?>
					<!-- ถ่้ามีข้อมูล -->
					<? if (count($listdata) != 0) { ?>
						<!-- ค้นหา -->
						<div class="input-group">
							<input type="text" placeholder="Search" name="search-input" id="search-input" class="form-control">
							<span class="input-group-btn">
								<button type="button" id="search-btn" class="btn btn-default">ค้นหา</button>
							</span>
						</div>
					<? } ?>
				</div>
				<!-- ปุ่ม Export -->
				<div class="col-md-1" style="padding-left: 0;padding-right: 0;">
					<? if (count($listdata) != 0) { ?>
						<button class=" btn btn-default btn-block" id="btnexport"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp; Excel</button>
					<? } ?>
				</div>
				<!-- table ------------------------------------------------------------------------------------------------------->
				<? if (count($listdata) != 0) { ?>
					<table class="table table-hover table-bordered dataTables-export" width="100%" data-filename="setting-data" data-colexport="1,2,3,4,6,7">
						<thead>
							<tr>
								<th>#</th>
								<th>ปีการศึกษา</th>
								<th>เทอม</th>
								<th>เพิ่มข้อมูล</th>
								<th>แก้ไขล่าสุด</th>
								<th></th>
								<th>วันที่เปิดนัด</th>
								<th>
									<center>สถานะ</center>
								</th>
							</tr>
						</thead>
						<tbody>
							<?PHP foreach ($listdata as $key => $value) { ?>
								<tr class="gradeX">
									<td width="10%"><strong><?= "S" . str_pad($value['set_id'], 5, "0", STR_PAD_LEFT); ?></strong></td>
									<td width="10%"><?= $value['set_year'] ?></td>
									<td width="10%"><?= $value['set_term'] ?></td>
									<td width="15%">
										<?= $value['set_create_name']; ?><br />
										<small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['set_create_date']); ?> <?= date('h:i A', strtotime($value['set_create_date'])); ?></small>
									</td>
									<td width="15%">
										<?= $value['set_lastedit_name']; ?><br />
										<small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['set_lastedit_date']); ?> <?= date('h:i A', strtotime($value['set_lastedit_date'])); ?></small>
									</td>
									<td width="10%">
										<div class="btn-group" style="width:100%">
											<button class="btn btn-sm btn-default " type="button" style="width:70%">จัดการ</button>
											<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:30%;">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<ul class="dropdown-menu" style="width:100%">
												<? if ($value['set_status'] != 0 && $value['set_status'] != 2) { ?>
													<li><a href="#" data-toggle="modal" data-target="#U_update" class="update" data-set_id="<?= $value['set_id']; ?>" data-set_year="<?= $value['set_year']; ?>" data-set_term="<?= $value['set_term']; ?>" data-set_open="<?= $value['set_open']; ?>" data-set_close="<?= $value['set_close']; ?>" data-set_option_sat="<?= $value['set_option_sat']; ?>" data-set_option_sun="<?= $value['set_option_sun']; ?>" "><i class=" fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;แก้ไขข้อมูล</a></li>
													<li><a href="<?= site_url('setting/form/' . $value['set_id']); ?>"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;จัดการวันหยุด</a></li>
												<? } ?>
												<? if ($value['set_status'] == 1) { ?>
													<li><a class="btn-alert" href="#" data-url="<?= site_url('setting/opensection/' . $value['set_id']); ?>" data-title="ต้องการเปิดระบบนัดหมาย?"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;เปิดระบบ</a></li>
												<? } ?>
												<? if ($value['set_status'] == 2) { ?>
													<li><a class="btn-alert" href="#" data-url="<?= site_url('setting/updatesetting/' . $value['set_id']); ?>" data-title="ต้องการปิดระบบนัดหมาย?"><i class="fa fa-times"></i>&nbsp;&nbsp;&nbsp;ปิดระบบ</a></li>
												<? } ?>
												<? if ($value['set_status'] != 2) { ?>
													<li><a href="#" class="btn-alert" data-url="<?= site_url('setting/delete/' . $value['set_id']); ?>" data-title="ต้องการลบข้อมูล?"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;ลบข้อมูล</a></li>
												<? } ?>
											</ul>
										</div>
									</td>
									<td width="20%">
										<i class="fa fa-calendar"></i> <?= DateThai($value['set_open']); ?> - <?= DateThai($value['set_close']); ?>
									</td>
									<td width="10%">
										<center>
											<? if ($value['set_status'] == 0) { ?>
												<div class="badges alt"><span class="content red">ปิดนัดหมาย</span></div>
											<? } elseif ($value['set_status'] == 1) { ?>
												<div class="badges alt"><span class="content orange">รอเปิดนัดหมาย</span></div>
											<? } elseif ($value['set_status'] == 2) { ?>
												<div class="badges alt"><span class="content green">เปิดนัดหมาย</span></div>
											<? } ?>
										</center>
									</td>
								</tr>
							<?PHP } ?>
						</tbody>
						<tfoot>
							<tr>
								<th></th>
								<th class="ftinput">ปีการศึกษา</th>
								<th class="ftinput">เทอม</th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</tfoot>
					</table>
					<!-- */table ----------------------------------------------------------------------------------------------------->
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
<div class="modal fade" id="insert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">เพิ่มข้อมูลการตั้งค่าระบบ</h4>
			</div>
			<div class="modal-body">
				<form action="<?= site_url('setting/create'); ?>" method="post" enctype="multipart/form-data" name="formSetting_up" id="formSetting_up" class="form-horizontal" novalidate>
					<input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
					<div class="form-group row">
						<label class="col-sm-12">ปีการศึกษา<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-12">
							<input type="text" name="set_year" id="set_year" value="" class="form-control" maxlength="4">
						</div>
					</div>
					<!--*/form-group-->
					<div class="form-group row">
						<label class="col-sm-12">เทอม<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-12">
							<select class="form-control" name="set_term" id="set_term">
								<option value="">กรุณาเลือกข้อมูล</option>
								<option value="เทอม1">เทอม1</option>
								<option value="เทอม2">เทอม2</option>
							</select>
						</div>
					</div>
					<!--*/form-group-->
					<div class="form-group row">
						<label class="col-sm-12">วันที่เปิดนัด<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-12">
							<input type="text" name="set_open" id="set_open" value="" class="form-control datepicker">
						</div>
					</div>
					<!--*/form-group-->
					<div class="form-group row">
						<label class="col-sm-12">วันที่ปิดนัด<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-12">
							<input type="text" name="set_close" id="set_close" value="" class="form-control datepicker">
						</div>
					</div>
					<!--*/form-group-->
					<div class="form-group row">
						<label class="col-sm-12">ตัวเลือก<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-12">
							<div class="checkbox checkbox-success checkbox-inline">
								<input type="checkbox" id="set_option_sat" name="set_option_sat" value="1">
								<label for=""> เปิดนัดวันเสาร์ </label>
							</div>
							<div class="checkbox checkbox-success checkbox-inline">
								<input type="checkbox" id="set_option_sun" name="set_option_sun" value="1">
								<label for=""> เปิดนัดวันอาทิตย์ </label>
							</div>
						</div>
					</div>
					<!--*/form-group-->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
				<button type="submit" class="btn btn-primary">บันทึก</button>
			</div>
			</form>
		</div>
	</div>
</div>

<!-- model update -->
<script>
	$('.update').click(function() {
		var set_id = $(this).attr('data-set_id');
		var set_year = $(this).attr('data-set_year');
		var set_term = $(this).attr('data-set_term');
		var set_open = $(this).attr('data-set_open');
		var set_close = $(this).attr('data-set_close');
		var set_option_sat = $(this).attr('data-set_option_sat');
		var set_option_sun = $(this).attr('data-set_option_sun');
		console.log(set_term);
		$(".set_id").val(set_id);
		$(".set_year").val(set_year);
		$(".set_term").val(set_term);
		$(".set_open").val(set_open);
		$(".set_close").val(set_close);
		if (set_option_sat == 1) {
			$(".set_option_sat").prop('checked', true);
		}
		if (set_option_sun == 1) {
			$(".set_option_sun").prop('checked', true);
		}
	});
</script>
<div class="modal fade" id="U_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลการตั้งค่าระบบ</h4>
			</div>
			<div class="modal-body">
				<form action="<?= site_url('setting/update'); ?>" method="post" enctype="multipart/form-data" name="formSetting" id="formSetting" class="form-horizontal" novalidate>
					<input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
					<input type="hidden" name="Id" id="Id" value="" class="set_id">
					<div class="form-group row">
						<label class="col-sm-12">ปีการศึกษา<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-12">
							<input type="text" name="set_year" id="set_year" value="" class="form-control set_year" maxlength="4">
						</div>
					</div>
					<!--*/form-group-->
					<div class="form-group row">
						<label class="col-sm-12">เทอม<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-12">
							<select class="form-control set_term" name="set_term" id="set_term">
								<option value="">กรุณาเลือกข้อมูล</option>
								<option value="เทอม1">เทอม1</option>
								<option value="เทอม2">เทอม2</option>
							</select>
						</div>
					</div>
					<!--*/form-group-->
					<div class="form-group row">
						<label class="col-sm-12">วันที่เปิดนัด<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-12">
							<input type="text" name="set_open" id="set_open" value="" class="form-control datepicker set_open">
						</div>
					</div>
					<!--*/form-group-->
					<div class="form-group row">
						<label class="col-sm-12">วันที่ปิดนัด<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-12">
							<input type="text" name="set_close" id="set_close" value="" class="form-control datepicker set_close">
						</div>
					</div>
					<!--*/form-group-->
					<div class="form-group row">
						<label class="col-sm-12">ตัวเลือก<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-12">
							<div class="checkbox checkbox-success checkbox-inline">
								<input type="checkbox" id="set_option_sat" name="set_option_sat" value="1" class="set_option_sat">
								<label for=""> เปิดนัดวันเสาร์ </label>
							</div>
							<div class="checkbox checkbox-success checkbox-inline">
								<input type="checkbox" id="set_option_sun" name="set_option_sun" value="1" class="set_option_sun">
								<label for=""> เปิดนัดวันอาทิตย์ </label>
							</div>
						</div>
					</div>
					<!--*/form-group-->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
				<button type="submit" class="btn btn-primary">บันทึก</button>
			</div>
			</form>
		</div>
	</div>
</div>