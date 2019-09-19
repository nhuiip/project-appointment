<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2>เปลี่ยนรหัสผ่าน</h2>
		<ol class="breadcrumb">
			<li><a href="#">หน้าแรก</a></li>
			<li><a href="<?=site_url('administrator/main');?>">ผู้ดูแลระบบ</a></li>
			<li class="active"><strong>เปลี่ยนรหัสผ่าน</strong></li>
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
<div class="alert alert-warning alert-dismissable hide" id="formError" style="color:#333"></div>            
<form action="<?=site_url('administrator/changepassword');?>" method="post" enctype="multipart/form-data" name="formRepass" id="formRepass" class="form-horizontal" novalidate>
	<input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
	<input type="hidden" name="Id" id="Id" value="<?=$Id?>">
	<div class="form-group">
		<label class="col-sm-2 control-label">รหัสผ่าน<span class="text-muted" style="color:#FF0000">*</span></label>
		<div class="col-sm-10">
			<input type="password" name="use_pass" id="use_pass" class="form-control">
		</div>
	</div><!--*/form-group-->
	<div class="hr-line-dashed"></div>
	<div class="form-group">
		<label class="col-sm-2 control-label">ยืนยัน รหัสผ่าน<span class="text-muted" style="color:#FF0000">*</span></label>
		<div class="col-sm-10">
			<input type="password" name="use_confirmPassword" id="use_confirmPassword" class="form-control">
		</div>
	</div><!--*/form-group-->
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
