<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>ข้อมูลนักศึกษา</h2>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('student/index'); ?>">หน้าแรก</a></li>
            <li class="active"><strong>ข้อมูลนักศึกษา</strong></li>
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

                    </div>
                </div>
                <div class="ibox-content">
                    <!-- table ------------------------------------------------------------------------------------------------------->
                    <!-- <div class="table-responsive"> -->
                        <table class="table table-striped table-hover dataTables-export" data-colexport="0,1,2,3,4" data-filename="export-student" width="100%">
                            <thead>
                                <tr>
                                    <th>รหัสนักศึกษา</th>
                                    <th>ชื่อ - สกุล</th>
                                    <th>เบอร์โทรศัพท์</th>
                                    <th>อีเมล์</th>
                                    <th>สถานะการศึกษา</th>
                                    <th>เพิ่มข้อมูล</th>
                                    <th>แก้ไขล่าสุด</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?PHP foreach ($listdata as $key => $value) { ?>
                                    <tr class="gradeX">
                                        <td width="10%"><?= $value['std_number'] ?></td>
                                        <td width="15%"><?= $value['std_title'] ?><?= $value['std_fname'] ?> <?= $value['std_lname'] ?></td>
                                        <td width="10%"><?= $value['std_tel'] ?></td>
                                        <td width="15%"><?= $value['std_email'] ?></td>
                                        <td width="10%">
                                            <center>
                                                <?PHP if ($value['std_status'] == 1) { ?>
                                                    <p><span class="label label-success" style="font-size: 12px;">จบการศึกษาแล้ว</span></p>
                                                <?PHP } else { ?>
                                                    <p><span class="label label-primary" style="font-size: 12px;">กำลังศึกษาอยู่</span></p>
                                                <?PHP } ?>
                                            </center>

                                        </td>
                                        <td width="10%">
                                            <? if ($value['std_create_name'] != '0') { ?>
                                                <?= $value['std_create_name']; ?><? } ?><br />
                                                <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['std_create_date'])); ?></small>
                                        </td>
                                        <td width="10%">
                                            <? if ($value['std_lastedit_name'] != '0') { ?>
                                                <?= $value['std_lastedit_name']; ?>
                                            <? } ?>
                                            <br />
                                            <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['std_lastedit_date'])); ?></small>
                                        </td>
                                        <td width="10%">
                                            <div class="btn-group" style="width:100%">
                                                <button class="btn btn-sm btn-primary " type="button" style="width:70%">จัดการ</button>
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:30%;">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" style="width:100%">
                                                    <li><a href="#" data-toggle="modal" data-target="#studentUpdate" class="update" data-stdid="<?= $value['std_id']; ?>" data-number="<?= $value['std_number']; ?>" data-tel="<?= $value['std_tel']; ?>" data-emailstd="<?= $value['std_email']; ?>" data-fname="<?= $value['std_fname']; ?>" data-lname="<?= $value['std_lname']; ?>"><i class="fa fa-edit"></i>&nbsp;&nbsp;&nbsp;แก้ไขข้อมูลนักศึกษา</a></li>
                                                    <li><a href="#" data-toggle="modal" data-target="#emailUpdate" class="updateemail" data-stdid="<?= $value['std_id']; ?>" data-email="<?= $value['std_email']; ?>" data-fullname="<?= $value['std_title']; ?><?= $value['std_fname']; ?> <?= $value['std_lname']; ?>"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;&nbsp;เปลี่ยนที่อยู่อีเมล์</a></li>
                                                    <li><a href="#" data-toggle="modal" data-target="#passwordUpdate" class="updatepass" data-stdid="<?= $value['std_id']; ?>" data-fullname="<?= $value['std_title']; ?><?= $value['std_fname']; ?> <?= $value['std_lname']; ?>"><i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;&nbsp;เปลี่ยนรหัสผ่าน</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?PHP } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="ftinput">ค้นหารหัสนักศึกษา</th>
                                    <th class="ftinput">ค้นหาชื่อ-สกุล นักศึกษา</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    <!-- </div> -->
                    <!-- */table ----------------------------------------------------------------------------------------------------->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.updateemail').click(function() {
        var stdid = $(this).attr('data-stdid');
        var fullname = $(this).attr('data-fullname');
        var emailstd = $(this).attr('data-email');
        $("#Idmail").val(stdid);
        $("#email_fullname").html(fullname);
        $("#email_std").val(emailstd);
    });

    $('.updatepass').click(function() {
        var stdid = $(this).attr('data-stdid');
        var fullname = $(this).attr('data-fullname');
        $("#Id2").val(stdid);
        $("#text_fullname").html(fullname);
    });

    $('.update').click(function() {
        var stdid = $(this).attr('data-stdid');
        var stdnumber = $(this).attr('data-number');
        var fname = $(this).attr('data-fname');
        var lname = $(this).attr('data-lname');
        var telstd = $(this).attr('data-tel');

        $("#Idstd_up").val(stdid);
        $("#stdnumber_up").val(stdnumber);
        $("#text_name").val(fname);
        $("#text_lastname").val(lname);
        $("#text_tel").val(telstd);
    });
</script>


<!-- model update student -->
<form action="<?= base_url('student/updatestd'); ?>" method="post" name="formStudentProfile" id="formStudentProfile" class="form-horizontal" novalidate>
    <div class="modal fade" id="studentUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลนักศึกษา</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="formcrfstudent" id="formcrfstudent" value="<?= $formcrfstudent; ?>">
                    <input type="hidden" name="Idstd_up" id="Idstd_up" value="">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="col-lg-12">รหัสนักศึกษา</div>
                            <div class="col-lg-12">
                                <input placeholder="รหัสนักศึกษา" name="stdnumber_up" id="stdnumber_up" class="form-control" value="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-6">
                            <label class="col-lg-12">ชื่อ<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                            <div class="col-lg-12">
                                <input placeholder="ชื่อ" class="form-control" name="text_name" id="text_name" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="col-lg-12">นามสกุล<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                            <div class="col-lg-12">
                                <input placeholder="นามสกุล" class="form-control" name="text_lastname" id="text_lastname" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="col-lg-12">เบอร์โทรศัพท์<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                            <div class="col-lg-12">
                                <input placeholder="เบอร์โทรศัพท์" maxlength="10" class="form-control" name="text_tel" id="text_tel" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- model changemail -->
<form action="<?= base_url('student/changemailstd'); ?>" method="post" name="formChangemailstd" id="formChangemailstd" class="form-horizontal" novalidate>
    <div class="modal fade" id="emailUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">เปลี่ยนที่อยู่อีเมล์ : <span id="email_fullname"></span></h4>
                </div>
                <div class="modal-body">
                    <br />
                    <input type="hidden" name="formcrfmail" id="formcrfmail" value="<?= $formcrfmail; ?>">
                    <input type="hidden" name="Idmail" id="Idmail" value="">
                    <input type="email" name="std_email" id="std_email" placeholder="กรอกข้อมูลอีเมล์" class="form-control" data-url="<?= site_url('profile/checkemail'); ?>" value="">
                    <br />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- model changepassword -->
<form action="<?= base_url('student/changepasswordstd'); ?>" method="post" name="formChangepasswordstd" id="formChangepasswordstd" class="form-horizontal" novalidate>
    <input type="hidden" name="formcrfpassword" id="formcrfpassword" value="<?= $formcrfpassword; ?>">
    <input type="hidden" name="Id2" id="Id2" value="">
    <div class="modal fade" id="passwordUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">เปลี่ยนรหัสผ่าน : <span id="text_fullname"></span></h4>
                </div>
                <div class="modal-body">
                    <br />
                    <input type="password" name="std_password" id="std_password" placeholder="กรุณากรอกรหัสผ่าน" class="form-control">
                    <br />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</form>