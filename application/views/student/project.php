
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

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-7">
            
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-user"></i> ข้อมูลโปรเจค</h5>
                    <div class="ibox-tools" >
                        <?php
                        if (isset($user_chk) && count($user_chk) != 0) {
                            foreach ($user_chk as $key => $usechk) {
                                echo  $usechk;
                            }
                        } 
                        ?>
                        <button type="button" data-toggle="modal"  class="btn btn-outline btn-primary" href="#modal-addsubject"><i class="fa fa-plus-square-o"></i> เพิ่มข้อมูล</button>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="<?=base_url('profile/update/'.$Id);?>" method="post" enctype="multipart/form-data" name="formStudentProfile" id="formStudentProfile" class="form-horizontal" novalidate>
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Id;?>">
                      
                        <!-- <div class="mgBottom">
                            <button class="btn btn-primary btn-lw100" type="button" ><strong>แก้ไขข้อมูลส่วนตัว</strong></button>
                        </div> -->
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

<form action="<?=base_url('project/addsubject/'.$Id);?>" method="post" enctype="multipart/form-data" name="formAddsubject" id="formAddsubject" class="form-horizontal" novalidate>                   
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
                    กรุณากรอกข้อมูลให้ครบถ้วน
                </div>
                <div class="form-group-mgTB grid-two-show-subject">
                    <label>ชื่อปริญญานิพนธ์<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                    <input placeholder="ชื่อโปรเจค" class="form-control" name="txt_projectname" id="txt_projectname" value="">
                </div>
                <div class="form-group-mgTB grid-two-show-subject">
                    <label>รายวิชาที่ลงทะเบียน<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                    <select class="form-control" name="select_subject" id="select_subject" onchange="ShowdataSubject(this);" >
                        <option value="">กรุณาเลือกรายวิชาที่ลงทะเบียน</option>
                        <?PHP if(count($listsubject)){ ?>
                        <?PHP foreach($listsubject as $key => $value){  ?>
                        <option value="<?=$value['sub_id'];?>"><?=$value['sub_name'];?></option>
                        <?PHP } ?>
                        <?PHP } ?>
                    </select>
                </div>
                <div class="form-group-mgTB grid-two-show-subject">
                    <label>รหัสวิชา</label>
                    <input placeholder="รหัสวิชา" class="form-control" name="txt_showcode" id="txt_showcode" value="" disabled>
                </div>
                <div class="form-group-mgTB grid-two-show-subject">
                    <label>อาจารย์ผู้สอน</label>
                    <input placeholder="อาจารย์ผู้สอน" class="form-control" name="txt_use_name" id="txt_use_name" value="" disabled>
                    <input type="hidden" class="form-control" name="use_id" id="use_id" value="" >
                </div>
                <div class="form-group-mgTB grid-three-show-subject">
                    <label>จำนวนอาจารย์ขึ้นสอบ</label>
                    <input placeholder="จำนวนอาจารย์ขึ้นสอบ" class="form-control" name="txt_sub_setuse" id="txt_sub_setuse" value="" disabled>
                    <label>คน</label>
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
