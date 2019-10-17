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

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<div class="ibox-tools">
						<? if ($checkinsert == 'no') { ?>
							<a class="btn btn-outline btn-white btn-bitbucket">
								<i class="fa fa-times" style="color:#ed5565"></i> &nbsp;&nbsp;กรุณาปิดระบบการนัดหมายเดิมก่อนเพิ่มข้อมูลกำหนดการนัดหมายใหม่
							</a>
						<? } ?>
						<? if ($checkinsert == 'no') { ?>
							<button type="button" class="btn btn-outline btn-primary" disabled><i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล</button>
						<? } else { ?>
							<button type="button" class="btn btn-outline btn-primary" data-toggle="modal" data-target="#insert"><i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล</button>
						<? } ?>
					</div>
				</div>
				<div class="ibox-content">
					<!-- table ------------------------------------------------------------------------------------------------------->
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-export" data-colexport="0,1,2,3,4,6" data-filename="export-setting" width="100%">
							<thead>
								<tr>
									<th>#</th>
									<th>ปีการศึกษา</th>
									<th>เทอม</th>
									<th>เพิ่มข้อมูล</th>
									<th>แก้ไขล่าสุด</th>
									<th></th>
									<th>วันที่</th>
									<th>
										<center>สถานะ</center>
									</th>
								</tr>
							</thead>
							<tbody>
								<?PHP foreach ($listdata as $key => $value) { ?>
									<tr class="gradeX">
										<td width="5%"><strong><?= "S" . str_pad($value['set_id'], 5, "0", STR_PAD_LEFT); ?></strong></td>
										<td width="15%"><?= $value['set_year'] ?></td>
										<td width="15%"><?= $value['set_term'] ?></td>
										<td width="15%">
											<?= $value['set_create_name']; ?><br />
											<small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['set_create_date'])); ?></small>
										</td>
										<td width="15%">
											<?= $value['set_lastedit_name']; ?><br />
											<small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['set_lastedit_date'])); ?></small>
										</td>
										<td width="10%">
											<div class="btn-group" style="width:100%">
												<button class="btn btn-sm btn-primary " type="button" style="width:70%">จัดการ</button>
												<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:30%;">
													<span class="caret"></span>
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<ul class="dropdown-menu" style="width:100%">
													<? if ($value['set_status'] != 0 && $value['set_status'] != 2) { ?>
														<li><a href="#" data-toggle="modal" data-target="#U_update" class="update"
														data-set_id="<?=$value['set_option_sun'];?>" data-set_year="<?=$value['set_year'];?>" data-set_term="<?=$value['set_term'];?>"
														data-set_open="<?=$value['set_open'];?>" data-set_close="<?=$value['set_close'];?>" data-set_option_sat="<?=$value['set_option_sat'];?>" data-set_option_sun="<?=$value['set_option_sun'];?>"
														"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;แก้ไขข้อมูล</a></li>
														<li><a href="<?= site_url('setting/form/' . $value['set_id']); ?>"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;จัดการวันหยุด</a></li>
													<? } ?>
													<? if ($value['set_status'] == 1) { ?>
														<li><a class="btn-alert" href="#" data-url="<?= site_url('setting/opensection/' . $value['set_id']); ?>" data-title="ต้องการเปิดระบบนัดหมาย?"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;เปิดระบบ</a></li>
													<? } ?>
													<? if ($value['set_status'] == 2) { ?>
														<li><a href="<?= site_url('setting/form/1/' . $value['set_id']); ?>"><i class="fa fa-times"></i>&nbsp;&nbsp;&nbsp;ปิดระบบ</a></li>
													<? } ?>
													<? if ($value['set_status'] != 2) { ?>
														<li><a href="#" class="btn-alert" data-url="<?= site_url('setting/delete/' . $value['set_id']); ?>" data-title="ต้องการลบข้อมูล?"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;ลบข้อมูล</a></li>
													<? } ?>
												</ul>
											</div>
										</td>
										<td width="15%">
											<i class="fa fa-clock-o"></i> <?= date('d/m/Y', strtotime($value['set_open'])); ?> - <?= date('d/m/Y', strtotime($value['set_close'])); ?>
										</td>
										<td width="10%">
											<center>
												<? if ($value['set_status'] == 0) { ?>
													<span class="badge badge-danger">ปิดนัดหมาย</span>
												<? } elseif ($value['set_status'] == 1) { ?>
													<span class="badge badge-warning">รอเปิดนัดหมาย</span>
												<? } elseif ($value['set_status'] == 2) { ?>
													<span class="badge badge-primary">เปิดนัดหมาย</span>
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
					</div>
					<!-- */table ----------------------------------------------------------------------------------------------------->
				</div>
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
				<form action="<?= site_url('setting/create'); ?>" method="post" enctype="multipart/form-data" name="formSetting" id="formSetting" class="form-horizontal" novalidate>
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
								<option value="เทอม 1">เทอม 1</option>
								<option value="เทอม 2">เทอม 2</option>
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
		if(set_option_sat == 1){
			$(".set_option_sat").prop('checked', true);
		}
		if(set_option_sun == 1){
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
				<form action="<?= site_url('setting/create'); ?>" method="post" enctype="multipart/form-data" name="formSetting" id="formSetting" class="form-horizontal" novalidate>
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
								<option value="เทอม 1">เทอม 1</option>
								<option value="เทอม 2">เทอม 2</option>
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