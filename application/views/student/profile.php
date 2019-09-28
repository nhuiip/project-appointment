<?
if (isset($liststudent) && count($liststudent) != 0) {
    foreach ($liststudent as $key => $student) {
        $Id               = $student['std_id'];
        $Text_position    = $student['position_name'];
        $IdSub            = $student['sub_id'];
        $Img_std          = $student['std_img'];
        $Tetx_number      = $student['std_number'];
        $Text_title       = $student['std_title'];
        $Text_name        = $student['std_fname'];
        $Text_lastname    = $student['std_lname'];
        $Text_email       = $student['std_email'];
        $Text_emailchang  = $student['std_emailchang'];
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
                    <form action="<?=base_url('profile/update/'.$Id);?>" method="post" enctype="multipart/form-data" name="formStudentProfile" id="formStudentProfile" class="form-horizontal" novalidate>
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Id;?>">
                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="col-lg-12 center">
                                    <div class="picture-container">
                                        <div class="picture">
                                            <?PHP if($Img_std == ""){ ?>
                                                <div style="background: url('<?= base_url('assets/images/noimage.jpg'); ?>');" id="std_imgprefile"></div>
                                            <?PHP }else{?>
                                                <div style="background: url('<?= base_url('uploads/student/'.$Img_std); ?>');" id="std_imgprefile"></div>
                                            <?PHP } ?>
                                            <input type="file" id="std_img" name="std_img" aria-invalid="false" accept="image/*">
                                            <input type="hidden" id="std_img_old" name="std_img_old" value="<?=$Img_std;?>">
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
                                <label class="col-lg-12">อีเมล์</label>
                                <div class="col-lg-9">
                                    <input placeholder="อีเมล์" class="form-control" name="text_email" id="text_email" value="<?=$Text_email;?>" disabled>
                                    <?PHP if(!empty($Text_emailchang)){?>
                                        <p>
                                        <div class="form-group-mgTB">
                                            <b style="color:#c0392b">เปลี่ยนที่อยู่อีเมล์ รอยืนยันผ่านทางอีเมล์ : <span class="underline"><?=$Text_emailchang;?></span></b>
                                        </div>
                                        </p>
                                    <?PHP } ?>
                                </div>
                                <div class="col-lg-3">
                                    <button data-toggle="modal"  type="button" class="btn btn-outline btn-primary btn-lw100" href="#modal-chengemail">เปลี่ยนที่อยู่อีเมล์</button>
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
                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="mgBottom">
                                    <button class="btn btn-primary btn-update-profile btn-lw100" type="submit" ><strong>แก้ไขข้อมูลส่วนตัว</strong></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-book"></i> ข้อมูลปริญญานิพนธ์</h5>
                    <div class="ibox-tools">
                        <button type="button" data-toggle="modal"  class="btn btn-outline btn-primary" href="#modal-addsubject"><i class="fa fa-plus-square-o"></i> เพิ่มข้อมูล</button>
                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal">
                        <p>Sign in today for more expirience.</p>
                        <div class="form-group"><label class="col-lg-2 control-label">Email</label>

                            <div class="col-lg-10"><input type="email" placeholder="Email" class="form-control"> <span class="help-block m-b-none">Example block-level help text here.</span>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label">Password</label>

                            <div class="col-lg-10"><input type="password" placeholder="Password" class="form-control"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks"><label> <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div><i></i> Remember me </label></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-white" type="submit">Sign in</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <form action="<?=base_url('profile/update/'.$Id);?>" method="post" enctype="multipart/form-data" name="formStudentProfile" id="formStudentProfile" class="form-horizontal" novalidate>
<input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
<input type="hidden" name="Id" id="Id" value="<?=$Id;?>">

<div id="modal-student" class="modal fade " aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 b-r"><h3 class="m-t-none m-b"><i class="fa fa-user"></i><span class="nav-label">  ข้อมูลส่วนตัว</span></h3>
                        <hr/>
                        <div class="alert alert-warning alert-dismissable hide" id="formError" style="color:#333">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            กรุณากรอกข้อมูลที่มีเครื่องหมาย <a class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </a> ให้ครบถ้วน.
                        </div>
                        <div class="form-group-mgTB">
                            <label>รหัสนักศึกษา : <?=$Tetx_number;?></label>
                        </div>
                        <div class="form-group-mgTB">
                            <label>ชื่อ<a class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </a></label> 
                            <input placeholder="ชื่อ" class="form-control" name="text_name" id="text_name" value="<?=$Text_name;?>"class="form-control">
                        </div>
                        <div class="form-group-mgTB">
                            <label>นามสกุล<a class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </a></label> 
                            <input placeholder="นามสกุล" class="form-control" name="text_lastname" id="text_lastname" value="<?=$Text_lastname;?>">
                        </div>
                        <div class="form-group-mgTB">
                            <label>อีเมล์<a class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </a></label> 
                            <input placeholder="อีเมล์" class="form-control" name="text_email" id="text_email" value="<?=$Text_email;?>">
                        </div>
                        <div class="form-group-mgTB">
                            <label>เบอร์โทรศัพท์<a class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </a></label> 
                            <input placeholder="เบอร์โทรศัพท์" maxlength="10" class="form-control" name="text_tel" id="text_tel" value="<?=$Tetx_tel;?>">
                        </div>
                        <div class="mgBottom">
                            <button class="btn btn-primary btn-lw100 pull-right m-t-n-xs" type="submit"><strong>แก้ไขข้อมูลส่วนตัว</strong></button>
                        </div>
                    </div>
                    <div class="col-sm-6"><h4>Not a member?</h4>
                        <p>You can create an account:</p>
                        <p class="text-center">
                            <a href=""><i class="fa fa-sign-in big-icon"></i></a>
                        </p>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
</form> -->
<form action="<?=base_url('profile/changemail/'.$Id);?>" method="post" enctype="multipart/form-data" name="formChangemail" id="formChangemail" class="form-horizontal" novalidate>                   
<input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
<input type="hidden" name="Id" id="Id" value="<?=$Id;?>">

<div id="modal-chengemail" class="modal fade" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="m-t-none m-b">เปลี่ยนที่อยู่อีเมล์</h3>
                <p><span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span>เมื่อเปลี่ยนแล้วต้องกดยืนยันที่อยู่อีเมล์ก่อน จึงจะสามารถใช้งานที่อยู่อีเมล์ใหม่ที่เปลี่ยนได้.</p>
                <hr/>
                <div class="alert alert-warning alert-dismissable hide" id="formErrorchangemail" style="color:#333">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    กรุณากรอกข้อมูลอีเมล์ให้ถูกต้อง.
                </div>
                <div class="form-group-mgTB">
                        <input type="email" name="text_email" id="text_email" placeholder="กรอกข้อมูลอีเมล์" class="form-control">
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


<form action="<?=base_url('profile/addsubject/'.$Id);?>" method="post" enctype="multipart/form-data" name="formAddsubject" id="formAddsubject" class="form-horizontal" novalidate>                   
<input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
<input type="hidden" name="Id" id="Id" value="<?=$Id;?>">

<div id="modal-addsubject" class="modal fade" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="m-t-none m-b">ข้อมูลปริญญานิพนธ์</h3>
                <!-- <p><span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span>เมื่อเปลี่ยนแล้วต้องกดยืนยันที่อยู่อีเมล์ก่อน จึงจะสามารถใช้งานที่อยู่อีเมล์ใหม่ที่เปลี่ยนได้.</p> -->
                <hr/>
                <div class="alert alert-warning alert-dismissable hide" id="formErroraddsubject" style="color:#333">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    กรุณากรอกข้อมูลโปรเจค
                </div>
                <div class="form-group-mgTB">
                    <label>ชื่อโปรเจค</label>
                    <input placeholder="ชื่อโปรเจค" class="form-control" name="txt_showcode" id="txt_showcode" value="" disabled>
                </div>
                <div class="mgBottom">
                    <button class="btn btn-lw100 btn-primary" type="submit"><strong>ยืนยันข้อมูลรายวิชาที่ลงทะเบียน</strong></button>
                </div>
                <div style="margin-bottom: 20px;"></div>
            </div>
        </div>
    </div>
</div>
</form>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#std_imgprefile').css('background', 'url(' + e.target.result + ') no-repeat center');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#std_img").change(function() {
        readURL(this);
        console.log(this);
    });

   
</script>
