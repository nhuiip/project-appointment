<?
if (isset($liststudent) && count($liststudent) != 0) {
    foreach ($liststudent as $key => $student) {
        $Id               = $student['std_id'];
        $Text_position    = $student['position_name'];
        $Img_std          = $student['std_img'];
        $Tetx_number      = $student['std_number'];
        $Text_title       = $student['std_title'];
        $Text_name        = $student['std_fname'];
        $Text_lastname    = $student['std_lname'];
        $Text_email       = $student['std_email'];
        $Text_password    = $student['std_pass'];
        $Tetx_tel         = $student['std_tel'];
        $Text_checkemail  = $student['std_checkmail'];
        $lastlogin        = $student['std_lastlogin'];
        $create_name      = $student['std_create_name'];
        $create_date      = $student['std_create_date'];
        $lastedit_name    = $student['std_lastedit_name'];
        $lastedit_date    = $student['std_lastedit_date'];
    }
} 

?>
<style>
    .picture input[type="file"] {
        cursor: pointer;
        display: block;
        height: 100%;
        left: 0;
        opacity: 0 !important;
        position: absolute;
        top: 0;
        width: 100%;
        margin-top: 10px !important;
    }
    #std_imgpre {
        width: 200px;
        height: 200px;
        background-size: cover !important;
        display: inline-block;
        border-radius: 100px;
        margin-bottom: 10px;
        -webkit-border-radius: 100px;
        -moz-border-radius: 100px;
    }
</style>
<form action="<?=base_url('student/stdupdate/');?>" method="post" enctype="multipart/form-data" name="formStudentProfile" id="formStudentProfile" class="form-horizontal" novalidate>
<input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
<input type="hidden" name="Id" id="Id" value="<?=$Id;?>">
                        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-7">
            
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-user"></i> ข้อมูลส่วนตัว</h5>
                    <div class="ibox-tools" >
                        <a class="" style="color: #f8ac59;">
                            <i class="fa fa-pencil-square"></i>  แก้ไขข้อมูลส่วนตัว
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="col-lg-12 center">
                                <div class="picture-container">
                                    <div class="picture">
                                        <?PHP if($Img_std == ""){ ?>
                                            <div style="background: url('<?= base_url('assets/images/noimage.jpg'); ?>');" id="std_imgpre"></div>
                                        <?PHP }else{?>
                                            <div style="background: url('<?= base_url('uploads/student/'.$Img_std); ?>');" id="std_imgpre"></div>
                                        <?PHP } ?>
                                        <input type="file" id="std_img" aria-invalid="false" accept="image/*">
                                        <input type="hidden" id="std_img2" name="std_img">
                                    </div>
                                    <h6 class="description">เปลี่ยนรูปภาพ</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="col-lg-12">รหัสนักศึกษา</div>
                            <div class="col-lg-12">
                                <input placeholder="รหัสนักศึกษา" class="form-control" value="<?=$Tetx_number;?>" disabled>
                                <input type="hidden" name="std_number" id="std_number" placeholder="รหัสนักศึกษา" class="form-control" value="<?=$Tetx_number;?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-6">
                            <label class="col-lg-12">ชื่อ<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                            <div class="col-lg-12">
                                <input placeholder="ชื่อ" class="form-control" name="text_name" id="text_name" value="<?=$Text_name;?>"class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="col-lg-12">นามสกุล<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                            <div class="col-lg-12">
                                <input placeholder="นามสกุล" class="form-control" name="text_lastname" id="text_lastname" value="<?=$Text_lastname;?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="col-lg-12">เบอร์โทรศัพท์<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                            <div class="col-lg-12">
                                <input placeholder="เบอร์โทรศัพท์" maxlength="10" class="form-control" name="text_tel" id="text_tel" value="<?=$Tetx_tel;?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="mgBottom">
                                <button class="btn btn-primary btn-update-profile btn-lw100" type="submit" ><strong>แก้ไขข้อมูลส่วนตัว</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-book"></i> ข้อมูลการเข้าสู่ระบบ</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="col-md-12 col-lg-12">อีเมล์</label>
                            <div class="col-md-9 col-lg-9">
                                <input placeholder="อีเมล์" class="form-control" name="text_email" id="text_email" value="<?=$Text_email;?>" disabled>
                                <?PHP if(!empty($Text_emailchang)){?>
                                    <p>
                                    <div class="form-group-mgTB">
                                        <b style="color:#c0392b">เปลี่ยนที่อยู่อีเมล์ รอยืนยันผ่านทางอีเมล์ : <span class="underline"><?=$Text_emailchang;?></span></b>
                                    </div>
                                    </p>
                                <?PHP } ?>
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <button data-toggle="modal"  type="button" class="btn btn-outline btn-primary btn-lw100" href="#modal-chengemail">เปลี่ยนที่อยู่อีเมล์</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-outline btn-warning" data-toggle="modal" href="#modal-chengpassword">เปลี่ยนรหัสผ่าน</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="col-lg-12"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="col-lg-12">เข้าสู่ระบบล่าสุด : <?=$lastlogin;?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</form>

<form action="<?=base_url('student/stdchangemail');?>" method="post" enctype="multipart/form-data" name="formChangemailstd" id="formChangemailstd" class="form-horizontal" novalidate>                   
    <input type="hidden" name="formcrfmail" id="formcrfmail" value="<?=$formcrfmail;?>">
    <input type="hidden" name="Idmail" id="Idmail" value="<?=$Id;?>">

    <div id="modal-chengemail" class="modal fade" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="m-t-none m-b">เปลี่ยนที่อยู่อีเมล์</h3>
                    <p><span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span>เมื่อเปลี่ยนอีเมล์แล้วต้องเข้าสู่ระบบใหม่อีกครั้ง.</p>
                    <hr/>
                    <div class="form-group-mgTB">
                        <input type="email" name="std_email" id="std_email" placeholder="กรอกข้อมูลอีเมล์" class="form-control"  data-url="<?=site_url('student/checkemail');?>" >
                    </div>
                    <div class="mgBottom">
                        <button class="btn btn-lw100 btn-primary" type="submit"><strong>ยืนยันการเปลี่ยนที่อยู่อีเมล์</strong></button>
                    </div>
                    <div style="margin-bottom: 20px;"></div>
                </div>
            </div>
        </div>
    </div>
</form>

<form action="<?=base_url('student/stdchangepassword');?>" method="post" enctype="multipart/form-data" name="formChangepasswordstd" id="formChangepasswordstd" class="form-horizontal" novalidate>                   
    <input type="hidden" name="formcrfpassword" id="formcrfpassword" value="<?=$formcrfpassword;?>">
    <input type="hidden" name="Id2" id="Id2" value="<?=$Id;?>">
    <div id="modal-chengpassword" class="modal fade" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="m-t-none m-b">เปลี่ยนรหัสผ่าน</h3>
                    <hr/>
                    <div class="form-group-mgTB">
                        <input type="password" name="std_password" id="std_password" placeholder="กรุณากรอกรหัสผ่าน" class="form-control">
                    </div>
                    <div class="mgBottom">
                        <button class="btn btn-lw100 btn-primary" type="submit"><strong>ยืนยันการเปลี่ยนรหัสผ่าน</strong></button>
                    </div>
                    <div style="margin-bottom: 20px;"></div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- แสดงภาพก่อนอัพโหลด -->
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader({
                type: 'image/png'
            });
            reader.onload = function(e) {
                $('#std_imgpre').css('background', 'url(' + e.target.result + ') no-repeat center');
                var img = e.target.result;
                $("#std_img2").val(img);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#std_img").change(function() {
        readURL(this);
    });
</script>
