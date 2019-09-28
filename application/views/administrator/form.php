<?
  if(isset($listdata) && count($listdata) != 0) {
    foreach ($listdata as $key => $value) {
      $id           = $value['use_id'];
      $use_name  	= $value['use_name'];
      $position_id  = $value['position_id'];
      $use_email   = $value['use_email'];
    }
    $title          = "แก้ไขข้อมูลผู้ดูแลระบบ";
	$actionUrl      = site_url('administrator/update');
	$form 			= 'Up';
  } else {
    $title          = "เพิ่มข้อมูลผู้ดูแลระบบ";
	$actionUrl      = site_url('administrator/create');
	$form 			= 'C';
  }
?>
<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><?=$title;?></h2>
		<ol class="breadcrumb">
			<li><a href="<?=site_url('dashboard/index');?>">หน้าแรก</a></li>
			<li><a href="<?=site_url('administrator/main');?>">ผู้ดูแลระบบ</a></li>
			<li class="active"><strong><?=$title;?></strong></li>
		</ol>
	</div>
</div>
<!-- End breadcrumb for page -->

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-content">
<!-- contents ----------------------------------------------------------------------------------------------------->            
<form action="<?=$actionUrl?>" method="post" enctype="multipart/form-data" name="formAdministrators_<?=$form?>" id="formAdministrators_<?=$form?>" class="form-horizontal" novalidate>
	<input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
	<input type="hidden" name="Id" id="Id" value="<?PHP if (isset($id)) {echo $id;}?>">
	<div class="form-group">
		<label class="col-sm-2 control-label">ชื่อเต็ม<span class="text-muted" style="color:#c0392b">*</span></label>
		<div class="col-sm-8">
			<input type="text" name="use_name" id="use_name" value="<?PHP if (isset($use_name)) {echo $use_name;}?>" class="form-control">
		</div>
	</div><!--*/form-group-->
	<div class="hr-line-dashed"></div>
	<?PHP if(count($listposition) != 0){?>
	<div class="form-group">
		<label class="col-sm-2 control-label">ระดับผู้ใช้<span class="text-muted" style="color:#c0392b">*</span></label>
		<div class="col-sm-8">
			<select class="form-control" name="position_id">
				<option value="">กรุณาเลือกข้อมูล</option>
				<?PHP foreach ($listposition as $key => $value) {?>
				<option value="<?=$value['position_id']?>" <?PHP if(isset($position_id) && $position_id == $value['position_id']){echo 'selected';} ?>><?=$value['position_name']?></option>
				<?PHP }?>
			</select>
		</div>
	</div><!--*/form-group-->
	<?PHP }?>
	<div class="hr-line-dashed"></div>
	<div class="form-group">
		<label class="col-sm-2 control-label">อีเมล<span class="text-muted" style="color:#c0392b">*</span></label>
		<div class="col-sm-8">
			<input type="text" name="use_email" id="use_email" data-url="<?=site_url('administrator/checkemail');?>" class="form-control" value="<?PHP if (isset($use_email)) {echo $use_email;}?>">
		</div>
	</div><!--*/form-group-->
	<?PHP if(empty($id)){?>
	<div class="hr-line-dashed"></div>
	<div class="form-group">
		<label class="col-sm-2 control-label">รหัสผ่าน<span class="text-muted" style="color:#c0392b">*</span></label>
		<div class="col-sm-8">
			<input type="password" name="use_pass" id="use_pass" class="form-control">
		</div>
	</div><!--*/form-group-->
	<div class="hr-line-dashed"></div>
	<div class="form-group">
		<label class="col-sm-2 control-label">ยืนยันรหัสผ่าน<span class="text-muted" style="color:#c0392b">*</span></label>
		<div class="col-sm-8">
			<input type="password" name="use_confirmPassword" id="use_confirmPassword" class="form-control">
		</div>
	</div><!--*/form-group-->
	<?PHP }?>
	<div class="hr-line-dashed"></div>
	<div class="form-group">
		<div class="col-sm-6 col-sm-offset-4">
			<a href="<?=site_url('administrator/main');?>">
				<button class="btn btn-w-m btn-danger" type="button">ยกเลิก</button>
			</a>
			<button class="btn btn-w-m btn-primary" type="submit">บันทึก</button>
		</div>
	</div><!--*/form-group-->
</form>
<!-- */contents ----------------------------------------------------------------------------------------------------->
        </div>
      </div>
    </div>
	</div>
</div>
