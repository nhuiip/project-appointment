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
        <h2>ตั้งค่า Email</h2>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('dashboard/index'); ?>">หน้าแรก</a></li>
            <li class="active"><strong>ตั้งค่า Email</strong></li>
        </ol>
    </div>
</div>
<!-- End breadcrumb for page -->
<div class="row wrapper white-bg">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content" style="padding: 15px 0 20px;">
                <div class="col-md-4 col-md-offset-8" style="padding-left: 0;padding-right: 0;">
                    <!-- ปุ่มเพิ่มข้อมูล -->
                    <button type="button" data-toggle="modal" data-target="#U-insert" class="btn btn-outline btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล</button>
                    <? if (count($listdata) != 0) { ?>
                        <div class="input-group">
                            <input type="text" placeholder="Search" name="search-input" id="search-input" class="form-control">
                            <span class="input-group-btn">
                                <button type="button" id="search-btn" class="btn btn-default">ค้นหา</button>
                            </span>
                        </div>
                    <? } ?>
                </div>
                <!-- table ------------------------------------------------------------------------------------------------------->
                <? if (count($listdata) != 0) { ?>
                    <table class="table table-hover table-bordered dataTables-export" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Email Address</th>
                                <th>App Password</th>
                                <th>เพิ่มข้อมูล</th>
                                <th>แก้ไขล่าสุด</th>
                                <th></th>
                                <th>
                                    <center>สถานะ</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($listdata as $key => $value) { ?>
                                <tr class="gradeX">
                                    <td width="5%"><strong><?= "S" . str_pad($value['email_id'], 3, "0", STR_PAD_LEFT); ?></strong></td>
                                    <td width="30%"><?= $value['email_user'] ?></td>
                                    <td width="15%"><?= $value['email_password'] ?></td>
                                    <td width="15%">
                                        <?= $value['email_create_name']; ?><br />
                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['email_create_date']); ?> <?= date('h:i A', strtotime($value['email_create_date'])); ?></small>
                                    </td>
                                    <td width="15%">
                                        <?= $value['email_lastedit_name']; ?><br />
                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['email_lastedit_date']); ?> <?= date('h:i A', strtotime($value['email_lastedit_date'])); ?></small>
                                    </td>
                                    <td width="10%">
                                        <div class="btn-group" style="width:100%">
                                            <button class="btn btn-sm btn-default " type="button" style="width:70%">จัดการ</button>
                                            <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:30%;">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" style="width:100%">
                                                <li><a href="#" data-toggle="modal" data-target="#Update" class="update" data-email_id="<?= $value['email_id']; ?>" data-email_user="<?= $value['email_user']; ?>" data-email_password="<?= $value['email_password']; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;แก้ไขข้อมูล</a></li>
                                                <li><a href="#" data-toggle="modal" data-target="#Testmail" class="testmail" data-email_id="<?= $value['email_id']; ?>"><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;ทดสอบส่ง Email</a></li>
                                                <li><a href="#" class="btn-alert" data-url="<?= site_url('emailset/setmail/' . $value['email_id']); ?>" data-title="ต้องการเปลี่ยนอีเมล?"><i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp;เปลี่ยนอีเมล</a></li>
                                                <li><a href="#" class="btn-alert" data-url="<?= site_url('emailset/delete/' . $value['email_id']); ?>" data-title="ต้องการลบข้อมูล?"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;ลบข้อมูล</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td width="10%">
                                        <center>
                                            <? if ($value['email_status'] == 0) { ?>
                                                <div class="badges alt"><span class="content red">ไม่ใช้</span></div>
                                            <? } elseif ($value['email_status'] == 1) { ?>
                                                <div class="badges alt"><span class="content green">ใช้งาน</span></div>
                                            <? } ?>
                                        </center>
                                    </td>
                                </tr>
                            <? } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th class="ftinput">Email Address</th>
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
<form action="<?= site_url('emailset/create'); ?>" method="post" enctype="multipart/form-data" name="FormEmailset" id="FormEmailset" class="form-horizontal" novalidate>
    <div class="modal fade" id="U-insert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">เพิ่ม Email</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
                    <div class="form-group row">
                        <label class="col-sm-12">Email Address<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" name="email_user" id="email_user" data-url="<?= site_url('emailset/checkemail'); ?>" class="form-control" maxlength="255">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">App Password<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" name="email_password" id="email_password" class="form-control" maxlength="255">
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

<!-- model update -->
<script>
    $('.update').click(function() {
        var email_id = $(this).attr('data-email_id');
        var email_user = $(this).attr('data-email_user');
        var email_password = $(this).attr('data-email_password');
        $(".email_id").val(email_id);
        $(".email_user").val(email_user);
        $(".email_password").val(email_password);
    });
</script>
<form action="<?= site_url('emailset/update'); ?>" method="post" enctype="multipart/form-data" name="FormEmailset_Up" id="FormEmailset_Up" class="form-horizontal" novalidate>
    <div class="modal fade" id="Update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">แก้ไข Email</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
                    <input type="hidden" name="email_id" id="email_id" class="email_id">
                    <div class="form-group row">
                        <label class="col-sm-12">Email Address<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" name="email_user" id="email_user" class="form-control email_user" maxlength="255" data-url="<?= site_url('emailset/checkemailUp'); ?>">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">App Password<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" name="email_password" id="email_password" class="form-control email_password" maxlength="255">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- model testmail -->
<script>
    $('.testmail').click(function() {
        var email_id = $(this).attr('data-email_id');
        $("#email_id_test").val(email_id);
    });
</script>
<form action="<?= site_url('emailset/testmail'); ?>" method="post" enctype="multipart/form-data" name="FormEmailset_T" id="FormEmailset_T" class="form-horizontal" novalidate>
    <div class="modal fade" id="Testmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">ทดสอบส่ง Email</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
                    <input type="hidden" name="email_id" id="email_id_test">
                    <div class="form-group row">
                        <label class="col-sm-12">Email ปลายทาง<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" name="email_test" id="email_test" class="form-control" maxlength="255">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>