<?PHP if($position == 'นักศึกษา') { ?>

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
                    <h5>ข้อมูลส่วนตัว</h5>
                    <div class="ibox-tools" data-toggle="modal" href="#modal-student">
                        <a class="" style="color: #f8ac59;">
                            <i class="fa fa-pencil-square"></i>  แก้ไขข้อมูลส่วนตัว
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" >
                        
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="col-lg-12">
                                        <img src=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="col-lg-12">รหัสนักศึกษา : <?=$Tetx_number;?></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-6">
                                    <label class="col-lg-12">ชื่อ</label>
                                    <div class="col-lg-12">
                                        <input placeholder="ชื่อ" class="form-control" value="<?=$Text_name;?>" disabled> 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="col-lg-12">นามสกุล</label>
                                    <div class="col-lg-12">
                                        <input placeholder="นามสกุล"  class="form-control" value="<?=$Text_lastname;?>" disabled> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-6">
                                    <label class="col-lg-12">อีเมล์</label>
                                    <div class="col-lg-12">
                                        <input placeholder="อีเมล์" class="form-control" value="<?=$Text_email;?>" disabled> 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="col-lg-12">เบอร์โทรศัพท์</label>
                                    <div class="col-lg-12">
                                        <input placeholder="เบอร์โทรศัพท์"  class="form-control" value="<?=$Tetx_tel;?>" disabled> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="col-lg-12">เข้าสู่ระบบล่าสุด : <?=$lastlogin;?></div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Horizontal form</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
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

<form action="<?=base_url('profile/update/'.$Id);?>" method="post" enctype="multipart/form-data" name="formStudentProfile" id="formStudentProfile" class="form-horizontal" novalidate>
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
</form>
<?PHP } ?>