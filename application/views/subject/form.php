<?
if (isset($listdata) && count($listdata) != 0) {
    foreach ($listdata as $key => $value) {
        $id               = $value['sub_id'];
        $sub_name         = $value['sub_name'];
        $sub_code         = $value['sub_code'];
        $use_id           = $value['use_id'];
        $sub_setuse       = $value['sub_setuse'];
        $sub_setless      = $value['sub_setless'];
        $sub_type         = $value['sub_type'];
    }
    $title          = "แก้ไขข้อมูลรายวิชา";
    $actionUrl      = site_url('subject/update');
} else {
    $title          = "เพิ่มข้อมูลรายวิชา";
    $actionUrl      = site_url('subject/create');
}
?>
<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><?= $title; ?></h2>
        <ol class="breadcrumb">
            <li><a href="<?=site_url('dashboard/index');?>">หน้าแรก</a></li>
            <li><a href="<?= site_url('subject/index'); ?>">จัดการรายวิชา</a></li>
            <li class="active"><strong><?= $title; ?></strong></li>
        </ol>
    </div>
</div>

<!-- End breadcrumb for page -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <!-- form ------------------------------------------------------------------------------------------------------->
                    <form action="<?= $actionUrl ?>" method="post" enctype="multipart/form-data" name="formSubject" id="formSubject" class="form-horizontal" novalidate>
                        <input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
                        <input type="hidden" name="Id" id="Id" value="<? if (isset($id)) {echo $id;} ?>">
                        <input type="hidden" name="set_id" id="set_id" value="<? if (isset($set_id)) {echo $set_id;} ?>">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ชื่อวิชา<span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" name="sub_name" id="sub_name" value="<? if (isset($sub_name)) {echo $sub_name;} ?>" class="form-control" maxlength="255">
                            </div>
                            <label class="col-sm-1 control-label">รหัสวิชา<span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" name="sub_code" id="sub_code" value="<? if (isset($sub_code)) {echo $sub_code;} ?>" class="form-control" maxlength="255">
                            </div>
                        </div>
                        <!--*/form-group-->
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">อาจารย์ผู้สอน<span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-sm-3">
                                <select class="select2 form-control" name="use_id" id="use_id">
                                    <option></option>
                                    <? foreach ($user as $key => $value) { ?>
                                    <option value="<?=$value['use_id'];?>" <? if(isset($use_id) && $use_id == $value['use_id']){echo 'selected';} ?>><?=$value['use_name'];?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">จำนวนอาจารย์ขึ้นสอบ<span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-sm-3">
                                <input class="touchspin form-control"type="text" name="sub_setuse" id="sub_setuse" value="<? if (isset($sub_setuse)) {echo $sub_setuse;} ?>">
                            </div>
                            <label class="col-sm-1 control-label">อาจารย์ขึ้นสอบอย่างน้อย<span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-sm-3">
                                <input class="touchspin form-control" type="text" name="sub_setless" id="sub_setless" value="<? if (isset($sub_setless)) {echo $sub_setless;} ?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ประเภทวิชา<span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-sm-8">
                            <div class="radio radio-success radio-inline">
								<input type="radio" value="1" name="sub_type" id="sub_type" <? if (isset($sub_type) && $sub_type == '1'){echo 'checked';} ?>>
								<label for=""> โครงการ 1 </label>
							</div>
							<div class="radio radio-success radio-inline">
								<input type="radio" value="2" name="sub_type" id="sub_type" <? if (isset($sub_type) && $sub_type == '2'){echo 'checked';} ?>>
								<label for=""> โครงการ 2 </label>
							</div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-4">
                                <a href="<?= site_url('subject/index'); ?>">
                                    <button class="btn btn-w-m btn-danger" type="button">ยกเลิก</button>
                                </a>
                                <button class="btn btn-w-m btn-primary" type="submit">บันทึก</button>
                            </div>
                        </div>
                        <!--*/form-group-->
                    </form>
                    <!-- */form ----------------------------------------------------------------------------------------------------->
                </div>
            </div>
        </div>
    </div>
</div>