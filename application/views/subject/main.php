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
        <h2>จัดการรายวิชา</h2>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('dashboard/index'); ?>">หน้าแรก</a></li>
            <li class="active"><strong>จัดการรายวิชา</strong></li>
        </ol>
    </div>
</div>
<!-- End breadcrumb for page -->
<div class="row wrapper white-bg">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content" style="padding: 15px 0 20px;">
                <div class="col-md-4 col-md-offset-7 pull-right" style="padding-left: 0;padding-right: 0;">
                    <!-- ปุ่มเพิ่มข้อมูล -->
                    <button type="button" data-toggle="modal" data-target="#U-insert" class="btn btn-outline btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล</button>
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
                    <table class="table table-hover table-bordered dataTables-export" width="100%" data-filename="subject-data" data-colexport="1,2,3,4,6,7">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>วิชา</th>
                                <th>อาจารย์ผู้สอน</th>
                                <th>เพิ่มข้อมูล</th>
                                <th>แก้ไขล่าสุด</th>
                                <th></th>
                                <th>
                                    <center>ประเภท</center>
                                </th>
                                <th>
                                    <center>สถานะ</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($listdata as $key => $value) { ?>
                                <tr class="gradeX">
                                    <td width="5%"><strong><?= "S" . str_pad($value['sub_id'], 3, "0", STR_PAD_LEFT); ?></strong></td>
                                    <td width="20%"><?= $value['sub_name'] ?><br /><small><?= $value['sub_code'] ?></small></td>
                                    <td width="15%"><?= $value['use_name'] ?></td>
                                    <td width="15%">
                                        <?= $value['sub_create_name']; ?><br />
                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['sub_create_date']); ?> <?= date('h:i A', strtotime($value['sub_create_date'])); ?></small>
                                    </td>
                                    <td width="15%">
                                        <?= $value['sub_lastedit_name']; ?><br />
                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['sub_lastedit_date']); ?> <?= date('h:i A', strtotime($value['sub_lastedit_date'])); ?></small>
                                    </td>
                                    <td width="10%">
                                        <div class="btn-group" style="width:100%">
                                            <button class="btn btn-sm btn-default " type="button" style="width:70%">จัดการ</button>
                                            <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:30%;">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" style="width:100%">
                                                <? if ($value['use_id'] == $this->encryption->decrypt($this->input->cookie('sysli')) || $this->encryption->decrypt($this->input->cookie('sysp')) == 'ผู้ดูแลระบบ') { ?>
                                                    <li><a href="<?= site_url('subject/detail/' . $value['sub_id']); ?>"><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;รายละเอียด</a></li>
                                                    <li><a href="<?= site_url('project/projectmeet/' . $value['sub_id']); ?>"><i class="fa fa-tasks"></i>&nbsp;&nbsp;&nbsp;รายการขึ้นสอบ</a></li>
                                                    <?PHP if ($value['sub_status'] != 0) { ?>
                                                        <li><a class="btn-alert" href="#" data-url="<?= site_url('subject/updateclose/' . $value['sub_id']); ?>" data-title="ต้องการปิดรายวิชา?"><i class="fa fa-times"></i>&nbsp;&nbsp;&nbsp;ปิดรายวิชา</a></li>
                                                    <?PHP } else { ?>
                                                        <li><a class="btn-alert" href="#" data-url="<?= site_url('subject/updateopen/' . $value['sub_id']); ?>" data-title="ต้องการเปิดรายวิชา?"><i class="fa fa-times"></i>&nbsp;&nbsp;&nbsp;เปิดรายวิชา</a></li>
                                                    <?PHP } ?>
                                                    <li><a href="#" class="btn-alert" data-url="<?= site_url('subject/delete/' . $value['sub_id']); ?>" data-title="ต้องการลบข้อมูล?"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;ลบข้อมูล</a></li>
                                                <? } ?>
                                            </ul>
                                        </div>
                                    </td>
                                    <td width="10%">
                                        <center>
                                            <? if ($value['sub_type'] == 1) { ?>
                                                <div class="badges alt"><span class="content gray">โครงการ 1</span></div>
                                            <? } elseif ($value['sub_type'] == 2) { ?>
                                                <div class="badges alt"><span class="content gray">โครงการ 2</span></div>
                                            <? } ?>
                                        </center>
                                    </td>
                                    <td width="10%">
                                        <center>
                                            <? if ($value['sub_status'] == 0) { ?>
                                                <div class="badges alt"><span class="content red">ปิดรายวิชา</span></div>
                                            <? } elseif ($value['sub_status'] == 1) { ?>
                                                <div class="badges alt"><span class="content green">เปิดสอนอยู่</span></div>
                                            <? } ?>
                                        </center>
                                    </td>
                                </tr>
                            <? } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th class="ftinput">วิชา</th>
                                <th class="ftinput">อาจารย์ผู้สอน</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="ftinput">ประเภท</th>
                                <th class="ftinput">สถานะ</th>
                            </tr>
                        </tfoot>
                    </table>
                <? } else { ?>
                    <div class="col-lg-12" style="padding-left: 0;padding-right: 0;">
                        <hr>
                        <center>
                            <p>ไม่พบข้อมูล</p>
                        </center>
                    </div>
                <? } ?>
                <!-- */table ----------------------------------------------------------------------------------------------------->
            </div>
        </div>
    </div>
</div>

<!-- model insert -->
<form action="<?= site_url('subject/create'); ?>" method="post" enctype="multipart/form-data" name="formSubject" id="formSubject" class="form-horizontal" novalidate>
    <div class="modal fade" id="U-insert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">เพิ่มข้อมูลรายวิชา</h4>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('subject/create'); ?>" method="post" enctype="multipart/form-data" name="formSubject" id="formSubject" class="form-horizontal" novalidate>
                        <input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
                        <div class="form-group row">
                            <label class="col-sm-12">ชื่อวิชา<span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" name="sub_name" id="sub_name" value="" class="form-control" maxlength="255">
                            </div>
                        </div>
                        <!--*/form-group-->
                        <div class="form-group row">
                            <label class="col-sm-12">รหัสวิชา<span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" name="sub_code" id="sub_code" value="" class="form-control" maxlength="255">
                            </div>
                        </div>
                        <!--*/form-group-->
                        <div class="form-group row">
                            <label class="col-sm-12">อาจารย์ผู้สอน<span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-sm-12">
                                <select class="form-control" name="use_id" id="use_id">
                                    <option value="">กรุณาเลือกข้อมูล</option>
                                    <?PHP foreach ($user as $key => $value) { ?>
                                        <option value="<?= $value['use_id'] ?>"><?= $value['use_name'] ?></option>
                                    <?PHP } ?>
                                </select>
                            </div>
                        </div>
                        <!--*/form-group-->
                        <div class="form-group row">
                            <label class="col-sm-12">จำนวนอาจารย์ขึ้นสอบ<span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-sm-12">
                                <input class="form-control" type="number" name="sub_setuse" id="sub_setuse" value="">
                            </div>
                        </div>
                        <!--*/form-group-->
                        <div class="form-group row">
                            <label class="col-sm-12">อาจารย์ขึ้นสอบอย่างน้อย<span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-sm-12">
                                <input class="form-control" type="number" name="sub_setless" id="sub_setless" value="">
                            </div>
                        </div>
                        <!--*/form-group-->
                        <div class="form-group row">
                            <label class="col-sm-12">ประเภทวิชา<span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-sm-12">
                                <select class="form-control" name="sub_type" id="sub_type">
                                    <option value="">กรุณาเลือกข้อมูล</option>
                                    <option value="1">โครงการ 1</option>
                                    <option value="2">โครงการ 2</option>
                                </select>
                            </div>
                        </div>
                        <!--*/form-group-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</form>