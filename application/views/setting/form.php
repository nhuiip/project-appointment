<?
if (isset($listdata) && count($listdata) != 0) {
	foreach ($listdata as $key => $value) {
		$id           	= $value['set_id'];
		$set_year		= $value['set_year'];
		$set_term		= $value['set_term'];
		$set_open		= $value['set_open'];
		$set_close		= $value['set_close'];
		$set_option_sat	= $value['set_option_sat'];
		$set_option_sun	= $value['set_option_sun'];
	}
	$title          = "แก้ไขข้อมูลการตั้งค่าระบบ";
	$actionUrl      = site_url('setting/update');
} else {
	$title          = "เพิ่มข้อมูลการตั้งค่าระบบ";
	$actionUrl      = site_url('setting/create');
}
?>
<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><?= $title; ?></h2>
		<ol class="breadcrumb">
			<li><a href="#">หน้าแรก</a></li>
			<li><a href="<?= site_url('setting/index'); ?>">ตั้งค่าระบบ</a></li>
			<li class="active"><strong><?= $title; ?></strong></li>
		</ol>
	</div>
</div>
<hr>
<!-- End breadcrumb for page -->
<div class="tabs-container">
	<ul class="nav nav-tabs">
		<li <? if ($type == 1) {echo 'class="active"';} ?>><a data-toggle="tab" href="#tab-1" aria-expanded="true"> ตั้งค่าระบบ</a></li>
		<? if(!empty($id)){?>
			<li <? if ($type == 2) {echo 'class="active"';} ?>><a data-toggle="tab" href="#tab-2" aria-expanded="false">ข้อมูลวันหยุด</a></li>
		<? } ?>
	</ul>
	<div class="tab-content">
		<div id="tab-1" class="tab-pane <? if ($type == 1) {echo 'active';} ?>">
			<div class="panel-body">
				<form action="<?= $actionUrl ?>" method="post" enctype="multipart/form-data" name="formSetting" id="formSetting" class="form-horizontal" novalidate>
					<input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
					<input type="hidden" name="Id" id="Id" value="<? if (isset($id)) {echo $id;} ?>">
					<div class="form-group">
						<label class="col-sm-2 control-label">ปีการศึกษา<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-1">
							<input type="text" name="set_year" id="set_year" value="<? if (isset($set_year)) {echo $set_year;} ?>" class="form-control" maxlength="4">
						</div>
						<div class="col-sm-8">
							<div class="radio radio-success radio-inline">
								<input type="radio" value="เทอม 1" name="set_term" <? if (isset($set_term) && $set_term == 'เทอม 1'){echo 'checked';} ?>>
								<label for=""> เทอม 1 </label>
							</div>
							<div class="radio radio-success radio-inline">
								<input type="radio" value="เทอม 2" name="set_term" <? if (isset($set_term) && $set_term == 'เทอม 2'){echo 'checked';} ?>>
								<label for=""> เทอม 2 </label>
							</div>
						</div>
					</div>
					<!--*/form-group-->
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<label class="col-sm-2 control-label">วันที่เปิดนัด<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-3">
							<div class="input-group date">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input type="text" name="set_open" id="set_open" value="<? if (isset($set_open)) {echo $set_open;} ?>" class="form-control datepicker">
							</div>
						</div>
						<label class="col-sm-1 control-label">วันที่ปิดนัด<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-3">
							<div class="input-group date">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="set_close" id="set_close" value="<? if (isset($set_close)) {echo $set_close;} ?>" class="form-control datepicker">
							</div>
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<label class="col-sm-2 control-label">ตัวเลือก<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-3">
								<div class="checkbox checkbox-success checkbox-inline">
										<input type="checkbox" id="set_option_sat" name="set_option_sat" value="1" <? if (isset($set_option_sat) && $set_option_sat == '1') {echo 'checked';} ?>>
										<label for=""> เปิดนัดวันเสาร์ </label>
								</div>
								<div class="checkbox checkbox-success checkbox-inline">
										<input type="checkbox" id="set_option_sun" name="set_option_sun" value="1" <? if (isset($set_option_sun) && $set_option_sun == '1') {echo 'checked';} ?>>
										<label for=""> เปิดนัดวันอาทิตย์ </label>
								</div>
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-4">
							<a href="<?= site_url('setting/index'); ?>">
								<button class="btn btn-w-m btn-danger" type="button">ยกเลิก</button>
							</a>
							<button class="btn btn-w-m btn-primary" type="submit">บันทึก</button>
						</div>
					</div>
					<!--*/form-group-->
				</form>
			</div>
		</div>
		<? if(!empty($id)){?>
		<div id="tab-2" class="tab-pane <? if ($type == 2) {echo 'active';} ?>">
			<div class="panel-body">
				<div class="row col-sm-12" style="text-align:right">
					<a href="#" style="color:#27ae60" data-toggle="modal" data-target="#createHol">
						<i class="fa fa-plus"></i> เพิ่มข้อมูล
					</a>
				</div>
				<br>
				<br>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables" width="100%">
						<thead>
							<tr>
								<th>#</th>
								<th>วันหยุด</th>
								<th>วันที่</th>
								<th>เพิ่มข้อมูล</th>
								<th>แก้ไขล่าสุด</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?PHP foreach ($listholiday as $key => $value) { ?>
								<tr class="gradeX">
									<td width="5%"><strong><?= "H" . str_pad($value['hol_id'], 5, "0", STR_PAD_LEFT); ?></strong></td>
									<td width="30%"><?= $value['hol_name'] ?></td>
									<td width="25%"><?= $value['hol_date'] ?></td>
									<td width="15%">
										<?= $value['hol_create_name']; ?><br />
										<small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['hol_create_date'])); ?></small>
									</td>
									<td width="15%">
										<?= $value['hol_lastedit_name']; ?><br />
										<small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['hol_lastedit_date'])); ?></small>
									</td>
									<td width="5%">
										<button 
										class="btn btn-warning fa fa-edit updateHol" 
										type="button" 
										data-holid="<?= $value['hol_id'] ?>" 
										data-holname="<?= $value['hol_name'] ?>" 
										data-holdate="<?= $value['hol_date'] ?>"
										data-toggle="modal" 
										data-target="#updateHol">&nbsp;&nbsp;&nbsp;แก้ไขข้อมูล</button>
									</td>
									<td width="5%">
										<button class="btn btn-danger fa fa-trash btn-alert" type="button" data-url="<?= site_url('setting/deleteHol/' . $value['set_id'].'/'.$value['hol_id']); ?>" data-text="ต้องการลบข้อมูล?">&nbsp;&nbsp;&nbsp;ลบข้อมูล</button>
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
								<th></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<? } ?>
	</div>
</div>
<div class="modal fade" id="createHol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ข้อมูลวันหยุด</h4>
      </div>
			<form action="<?=site_url('setting/createHol')?>" method="post" enctype="multipart/form-data" name="formCHoliday" id="formCHoliday" class="form-horizontal" novalidate>
      <div class="modal-body">
					<input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
					<input type="hidden" name="Id" id="Id" value="<? if (isset($id)) {echo $id;} ?>">
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
							<input type="text" name="hol_date" id="hol_date" class="form-control datepicker">
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
<script>
$('.updateHol').click(function(){
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
			<form action="<?=site_url('setting/updateHol')?>" method="post" enctype="multipart/form-data" name="formEHoliday" id="formEHoliday" class="form-horizontal" novalidate>
      <div class="modal-body">
					<input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
					<input type="hidden" name="Id" id="Id" value="<? if (isset($id)) {echo $id;} ?>">
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
							<input type="text" name="hol_date" id="hol_date" class="form-control datepicker hol_date" value="">
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