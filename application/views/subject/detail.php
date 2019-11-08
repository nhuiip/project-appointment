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
<?
if (isset($listsubject) && count($listsubject) != 0) {
    foreach ($listsubject as $key => $value) {
        $sub_id = $value['sub_id'];
        $sub_name = $value['sub_name'];
        $sub_code = $value['sub_code'];
        $sub_setuse = $value['sub_setuse'];
        $sub_setless = $value['sub_setless'];
        $sub_type = $value['sub_type'];
        $use_id = $value['use_id'];
    }
}
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><?= $sub_code; ?> :: <?= $sub_name; ?></h2>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('dashboard/index'); ?>">หน้าแรก</a></li>
            <li><a href="<?= site_url('subject/index'); ?>">จัดการรายวิชา</a></li>
            <li class="active"><strong>รายละเอียดวิชา</strong></li>
        </ol>
    </div>
</div>
<div class="row wrapper white-bg">
    <div class="col-lg-4">
        <?PHP if (count($listsubject) != 0) { ?>
            <div class="ibox float-e-margins">
                <div class="ibox-content" style="padding: 15px 0 20px;">
                    <h2>ข้อมูลทั่วไป</h2>
                    <hr>
                    <form action="<?= site_url('subject/update'); ?>" method="post" enctype="multipart/form-data" name="formSubject_Up" id="formSubject_Up" class="form-horizontal" novalidate>
                        <input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
                        <input type="hidden" name="Id" id="Id" value="<?= $sub_id; ?>">
                        <div class="form-group row">
                            <label class="col-md-12">ชื่อวิชา <span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?= $sub_name; ?>" name="sub_name" id="sub_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12">รหัสวิชา <span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="<?= $sub_code; ?>" name="sub_code" id="sub_code">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12">อาจารย์ผู้สอน <span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-md-12">
                                <select class="form-control use_id" name="use_id" id="use_id">
                                    <option value="">กรุณาเลือกข้อมูล</option>
                                    <?PHP foreach ($user as $key => $value) { ?>
                                        <option value="<?= $value['use_id'] ?>" <? if ($value['use_id'] == $use_id) {
                                                                                            echo 'selected';
                                                                                        } ?>><?= $value['use_name'] ?></option>
                                    <?PHP } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12">ประเภทวิชา <span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-md-12">
                                <select class="form-control" name="sub_type" id="sub_type">
                                    <option value="">กรุณาเลือกข้อมูล</option>
                                    <option value="1" <? if ($sub_type == 1) {
                                                                echo 'selected';
                                                            } ?>>โครงการ 1</option>
                                    <option value="2" <? if ($sub_type == 2) {
                                                                echo 'selected';
                                                            } ?>>โครงการ 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12">จำนวนอาจารย์ขึ้นสอบ <span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-md-12">
                                <input type="number" class="form-control" value="<?= $sub_setuse; ?>" name="sub_setuse" id="sub_setuse">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12">อาจารย์ขึ้นสอบอย่างน้อย <span class="text-muted" style="color:#c0392b">*</span></label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" value="<?= $sub_setless; ?>" name="sub_setless" id="sub_setless">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-outline btn-primary btn-block"><i class="fa fa-check"></i>&nbsp;&nbsp;อัพเดตข้อมูล</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <? } ?>
    </div>
    <div class="col-lg-8">

        <div class="ibox float-e-margins">
            <div class="ibox-content" style="padding: 15px 0 20px;">
                <h2>เอกสารประกอบวิชา</h2>
                <hr>
                <div class="col-md-6 col-md-offset-6 pull-right" style="padding-left: 0;padding-right: 0;">
                    <!-- ปุ่มเพิ่มข้อมูล -->
                    <button type="button" data-toggle="modal" data-target="#upfile" class="btn btn-outline btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มเอกสาร</button>
                    <!-- ถ่้ามีข้อมูล -->
                    <? if (count($listatt) != 0) { ?>
                        <!-- ค้นหา -->
                        <div class="input-group">
                            <input type="text" placeholder="Search" name="search-input" id="search-input" class="form-control">
                            <span class="input-group-btn">
                                <button type="button" id="search-btn" class="btn btn-default">ค้นหา</button>
                            </span>
                        </div>
                    <? } ?>
                </div>
                <? if (!empty($listatt)  && count($listatt) != 0) { ?>
                    <table class="table table-hover table-bordered dataTables-export" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ชื่อไฟล์</th>
                                <th>เพิ่มข้อมูล</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? $numrows = 1;
                                foreach ($listatt as $key => $value) { ?>

                                <tr>
                                    <td style="width:10%"><?= "F" . str_pad($numrows, 3, "0", STR_PAD_LEFT); ?></td>
                                    <td style="width:55%"><?= $value['att_name']; ?></td>
                                    <td style="width:25%">
                                        <?= $value['att_create_name']; ?><br />
                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['att_create_date']); ?> <?= date('h:i A', strtotime($value['att_create_date'])); ?></small>
                                    </td>
                                    <td style="width:5%">
                                        <a href="<?= base_url('uploads/attached/' . $value['att_filename']); ?>" download type="button" class="btn btn-sm btn-white"><i class="fa fa-download"></i></a>
                                    </td>
                                    <td style="width:5%">
                                        <button type="button" class="btn btn-sm btn-danger btn-alert" data-url="<?= site_url('attached/delete/' . $value['att_id']); ?>" data-title="ต้องการลบข้อมูล?"><i class="fa fa-remove"></i></button>
                                    </td>
                                </tr>
                            <? $numrows++;
                                } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                <? } else { ?>
                    <div class="col-lg-12" style="padding-left: 0;padding-right: 0;">
                        <center>
                            <p>ไม่พบข้อมูล</p>
                        </center>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
</div>

<!-- model upfile -->
<div class="modal fade" id="upfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">เพิ่มเอกสาร</h4>
            </div>
            <form action="<?= site_url('attached/create'); ?>" method="post" enctype="multipart/form-data" name="formAttached" id="formAttached" class="form-horizontal" novalidate>
                <div class="modal-body">
                    <input type="hidden" name="formcrf" id="formcrf3" value="<?= $formcrf; ?>">
                    <input type="hidden" name="sub_id" id="sub_id" value="<?PHP if (isset($sub_id)) {
                                                                                echo $sub_id;
                                                                            } ?>">
                    <input type="hidden" name="use_id" value="<?PHP if (isset($use_id)) {
                                                                    echo $use_id;
                                                                } ?>">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">ชื่อไฟล์<span class="text-muted" style="color:#FF0000">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" name="att_name" id="att_name" class="form-control">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">เลือกไฟล์<span class="text-muted" style="color:#FF0000">*</span></label>
                        <div class="col-sm-9">
                            <input type="file" name="att_filename" id="att_filename" class="form-control">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">เพิ่มเอกสาร</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>