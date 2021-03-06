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
?>
<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><?= $subject[0]['sub_code']; ?> :: <?= $subject[0]['sub_name']; ?></h2>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('dashboard/index'); ?>">หน้าแรก</a></li>
			<li><a href="<?= site_url('subject/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))); ?>">จัดการรายวิชา</a></li>
			<li class="active"><strong>รายการขึ้นสอบ</strong></li>
		</ol>
	</div>
</div>
<!-- End breadcrumb for page -->
<div class="row wrapper white-bg">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content" style="padding: 15px 0 20px;">
				<div class="col-md-3 col-md-offset-8 pull-right" style="padding-left: 0;padding-right: 0;">
					<!-- ถ่้ามีข้อมูล -->
					<? if (count($listmeet) != 0) { ?>
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
                    <? if (count($listmeet) != 0) { ?>
                        <button class=" btn btn-default btn-block" id="btnexport"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp; Excel</button>
                    <? } ?>
                </div>
				<!-- table ------------------------------------------------------------------------------------------------------->
				<? if (count($listmeet) != 0) { ?>
					<table class="table table-hover table-bordered dataTables-export" width="100%" data-filename="meet-data" data-colexport="2,3,4,6,7">
						<thead>
							<tr>
								<th></th>
								<th></th>
								<th>ชื่อปริญญานิพนธ์</th>
								<th>วัน-เวลาสอบ</th>
								<th>
									<center>สถานะปริญญานิพนธ์</center>
								</th>
								<th></th>
								<th class="none">กรรมการสอบ</th>
								<th class="none">ผู้จัดทำ</th>
							</tr>
						</thead>
						<tbody>
							<?PHP foreach ($listmeet as $key => $value) {
									$this->db->select('use_name');
									$this->db->from('tb_meetdetail');
									$this->db->join('tb_user', 'tb_user.use_id = tb_meetdetail.use_id');
									$this->db->where(array('tb_meetdetail.meet_id' => $value['meet_id']));
									$query = $this->db->get();
									$meetuse = $query->result_array();
									$this->db->select('*');

									$this->db->from('tb_projectperson');
									$this->db->join('tb_student', 'tb_student.std_id = tb_projectperson.std_id');
									$this->db->join('tb_project', 'tb_project.project_id = tb_projectperson.project_id');
									$this->db->where(array('tb_projectperson.project_id' => $value['project_id']));
									$querys = $this->db->get();
									$projectperson = $querys->result_array();
									switch ($value['project_status']) {
										case 1:
											$status_text = '<span class="tag">เริ่มต้น</span>';
											break;
										case 2:
											$status_text = '<span class="tag">สอบหัวข้อปริญญานิพนธ์</span><span class="content green">ผ่าน</span>';
											break;
										case 3:
											$status_text = '<span class="tag">สอบหัวข้อปริญญานิพนธ์</span><span class="content orange">ผ่านแบบมีเงื่อนไข</span>';
											break;
										case 4:
											$status_text = '<span class="tag">สอบหัวข้อปริญญานิพนธ์</span><span class="content red">ตก</span>';
											break;
										case 5:
											$status_text = '<span class="tag">สอบป้องกันปริญญานิพนธ์</span><span class="content green">Conference</span>';
											break;
										case 6:
											$status_text = '<span class="tag">สอบป้องกันปริญญานิพนธ์</span><span class="content green">ผ่าน</span>';
											break;
										case 7:
											$status_text = '<span class="tag">สอบป้องกันปริญญานิพนธ์</span><span class="content orange">ผ่านแบบมีเงื่อนไข</span>';
											break;
										case 8:
											$status_text = '<span class="tag">สอบป้องกันปริญญานิพนธ์</span><span class="content red">ตก</span>';
											break;
									}

									?>
									<tr class="gradeX">
										<td width="1%"></td>
										<td width="9%"><strong><?= "PRO" . str_pad($value['meet_id'], 3, "0", STR_PAD_LEFT); ?></strong></td>
										<td width="40%"><?= $value['project_name'] ?></td>
										<td width="15%">
											<?= DateThai($value['meet_date']); ?><br>
											<small class="text-muted"><i class="fa fa-clock-o"></i> <?= $value['meet_time']; ?> น.</small>
										</td>
										<td width="15%">
											<center><div class="badges alt" style="margin-bottom: 10px;"><?= $status_text ?></div></center>
										</td>
										<td width="10%">
											<center class="tooltip-demo">
												<a href="#" class="upstatus" data-project_id="<?= $value['project_id'] ?>" data-project_name="<?= $value['project_name'] ?>" data-project_status="<?= $value['project_status'] ?>" data-toggle="modal" data-target="#Update">
													<button class="btn btn-default" data-toggle="tooltip" data-placement="top" title="อัพเดตข้อมูล">
														<i class="fa fa-chevron-right"></i>
													</button>
												</a>
											</center>
										</td>
										<td>
											<?PHP foreach ($meetuse as $key => $list) { ?>
												<span class="badge">&nbsp;&nbsp;<?= $list['use_name']; ?>&nbsp;&nbsp;</span>
											<? } ?>
										</td>
										<td>
											<?PHP foreach ($projectperson as $key => $list) { ?>
												<span class="badge">&nbsp;&nbsp;<?= $list['std_title'] . '' . $list['std_fname'] . ' ' . $list['std_lname']; ?>&nbsp;&nbsp;</span>
											<? } ?>
										</td>
									</tr>
								<?PHP } ?>
						</tbody>
						<tfoot>
							<tr>
								<th></th>
								<th></th>
								<th class="ftinput">ปริญญานิพนธ์</th>
								<th class="ftinput">วัน-เวลาสอบ</th>
								<th class="ftinput">สถานะปริญญานิพนธ์</th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</tfoot>
					</table>
				<? } else { ?>
					<center>ไม่พบข้อมูล</center>
				<? } ?>
				<!-- */table ----------------------------------------------------------------------------------------------------->
			</div>
		</div>
	</div>
</div>
<!-- model update -->
<script>
	$('.upstatus').click(function() {
		var project_id = $(this).attr('data-project_id');
		var project_name = $(this).attr('data-project_name');
		var project_status = $(this).attr('data-project_status');
		$("#project_id").val(project_id);
		$("#project_name").val(project_name);
		$("#project_status").val(project_status);
	});
</script>
<div class="modal fade" id="Update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลปริญญานิพนธ์</h4>
			</div>
			<div class="modal-body">
				<form action="<?= site_url('project/updateData'); ?>" method="post" enctype="multipart/form-data" name="formProject_Up" id="formProject_Up" class="form-horizontal" novalidate>
					<input type="hidden" name="type" id="type" value="projectmeet">
					<input type="hidden" name="sub_id" id="sub_id" value="<?= $sub_id; ?>">
					<input type="hidden" name="project_id" id="project_id">
					<div class="form-group row">
						<label class="col-sm-12">ชื่อปริญญานิพนธ์<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-12">
							<input type="text" name="project_name" id="project_name" class="form-control" readonly>
						</div>
					</div>
					<!--*/form-group-->
					<div class="form-group row">
						<label class="col-sm-12">สถานะปริญญานิพนธ์<span class="text-muted" style="color:#c0392b">*</span></label>
						<div class="col-sm-12">
							<select class="form-control" name="project_status" id="project_status">
								<option value="">กรุณาเลือกข้อมูล</option>
								<?PHP foreach ($status as $key => $value) { ?>
									<option value="<?= $value['project_status'] ?>"><?= $value['text'] ?></option>
								<?PHP } ?>
							</select>
						</div>
					</div>
					<!--*/form-group-->
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
						<button type="submit" class="btn btn-primary">บันทึก</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>