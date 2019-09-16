<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2>ตั้งค่าระบบ</h2>
		<ol class="breadcrumb">
			<li><a href="#">หน้าแรก</a></li>
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
						<?if($checkinsert == 'no') { ?>
							<a class="btn btn-outline btn-white btn-bitbucket">
								<i class="fa fa-times" style="color:#ed5565"></i> &nbsp;&nbsp;กรุณาปิดระบบการนัดหมายเดิมก่อนเพิ่มข้อมูลกำหนดการนัดหมายใหม่
							</a>
						<? } ?>
						<a href="<?= site_url('setting/form/1/'); ?>" style="color:#27ae60">
							<button type="button" class="btn btn-outline btn-primary" <?if($checkinsert == 'no') { echo 'disabled';}?>><i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล</button>
						</a>
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
									<th><center>สถานะ</center></th>
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
													<? if ($value['set_status'] != 0) { ?>
														<li><a href="<?= site_url('setting/form/1/' . $value['set_id']); ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;แก้ไขข้อมูล</a></li>
														<li><a href="<?= site_url('setting/form/2/' . $value['set_id']); ?>"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;จัดการวันหยุด</a></li>
													<? } ?>
													<? if ($value['set_status'] == 1) { ?>
														<li><a href="<?= site_url('setting/form/1/' . $value['set_id']); ?>"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;เปิดระบบ</a></li>
													<? } ?>
													<? if ($value['set_status'] == 2) { ?>
														<li><a href="<?= site_url('setting/form/1/' . $value['set_id']); ?>"><i class="fa fa-times"></i>&nbsp;&nbsp;&nbsp;ปิดระบบ</a></li>
													<? } ?>
													<? if ($value['set_status'] != 2) { ?>
														<li><a href="#" class="btn-alert" data-url="<?= site_url('setting/delete/' . $value['set_id']); ?>" data-text="ต้องการลบข้อมูล?"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;ลบข้อมูล</a></li>
													<? } ?>
												</ul>
											</div>
										</td>
										<td width="15%">
											<i class="fa fa-clock-o"></i> <?= date('d/m/Y', strtotime($value['set_open'])); ?> - <?= date('d/m/Y', strtotime($value['set_close'])); ?>
										</td>
										<td width="10%">
											<center>
												<? if($value['set_status'] == 0){ ?>
													<span class="badge badge-danger">ปิดนัดหมาย</span>
												<? }elseif($value['set_status'] == 1){ ?>
													<span class="badge badge-warning">รอเปิดนัดหมาย</span>
												<? }elseif($value['set_status'] == 2){ ?>
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