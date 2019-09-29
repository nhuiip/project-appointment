<?
    $this->db->select('*');
    $this->db->from('tb_subject');
    $this->db->join('tb_user', 'tb_user.use_id = tb_subject.use_id');
    $this->db->join('tb_student', 'tb_student.sub_id = tb_subject.sub_id');
    $this->db->where(array('tb_student.std_id' => $Idstd));
    $query_subject = $this->db->get();
    $listsubject = $query_subject->result_array();

    //แสดงข้อมูลรายวิชาที่ลงทะเบียนเรียน
    if (isset($listsubject) && count($listsubject) != 0) {
        foreach ($listsubject as $key => $value) {
            $subject_type           = $value['sub_type'];
            $subject_name           = $value['sub_name'];
            $subject_code           = $value['sub_code'];
            $subject_setuse         = $value['sub_setuse'];
            $subject_status         = $value['sub_status'];
            $teacher_id             = $value['use_id'];
            $teacher_fullname       = $value['use_name'];
        }
    } 
    //ค้นหาโปรเจคที่นักศึกษาสร้างไว้
    if (isset($searchProject) && count($searchProject) != 0) {
        foreach ($searchProject as $key => $value) {
            $project_id             = $value['project_id'];
            $project_name           = $value['project_name'];
            $project_filecov        = $value['project_filecov'];
            $project_filecer        = $value['project_filecer'];
            $project_fileabs        = $value['project_fileabs'];
            $project_fileack        = $value['project_fileack'];
            $project_filetbc        = $value['project_filetbc'];
            $project_filechone      = $value['project_filechone'];
            $project_filechtwo      = $value['project_filechtwo'];
            $project_filechthree    = $value['project_filechthree'];
            $project_filechfour     = $value['project_filechfour'];
            $project_filechfive     = $value['project_filechfive'];
            $project_fileref        = $value['project_fileref'];
            $project_fileappone     = $value['project_fileappone'];
            $project_fileapptwo     = $value['project_fileapptwo'];
            $project_filebio        = $value['project_filebio'];
            $project_status         = $value['project_status'];
        }
    } 

    ?>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-7">
                
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-book"></i> ข้อมูลปริญญานิพนธ์</h5>
                        <?PHP if(count($searchProject) != 0){ ?>
                        <?PHP if($project_status != 0){ ?>
                        <div class="ibox-tools">
                            <button class="btn btn-outline btn-danger btn-alert" data-url="<?=site_url('project/updatestdproject/'.$project_id);?>" data-title="ต้องการเปลี่ยนหัวข้อปริญญานิพนธ์ ?" >เปลี่ยนหัวข้อปริญญานิพนธ์</button>
                        </div>
                        <?PHP } ?>
                        <?PHP } ?>
                    </div>
                    <div class="ibox-content">
                        <?PHP if(count($searchProject) != 0){ ?>
                            <?PHP if($project_status != 0){ ?>
                            <div class="form-group-mgTB grid-two-show-subject">
                                <label>ชื่อปริญญานิพนธ์</label>
                                <input placeholder="ชื่อโปรเจค" class="form-control" name="txt_projectname" id="txt_projectname" value="<?=$project_name;?>" disabled>
                            </div>
                            <?PHP } ?>
                        <?PHP } ?>
                        <div class="form-group-mgTB grid-two-show-subject">
                            <label>รหัสวิชา</label>
                            <input placeholder="รหัสวิชา" class="form-control" name="txt_showcode" id="txt_showcode" value="<?=$subject_code;?>" disabled>
                        </div>
                        <div class="form-group-mgTB grid-two-show-subject">
                            <label>รายวิชาที่ลงทะเบียน</label>
                            <input placeholder="รายวิชาที่ลงทะเบียน" class="form-control" name="txt_subject" id="txt_subject" value="<?=$subject_name;?>" disabled>
                        </div>
                        <div class="form-group-mgTB grid-two-show-subject">
                            <label>อาจารย์ผู้สอน</label>
                            <input placeholder="อาจารย์ผู้สอน" class="form-control" name="txt_use_name" id="txt_use_name" value="<?=$teacher_fullname;?>" disabled>
                        </div>
                        <div class="form-group-mgTB grid-two-show-subject">
                            <label>จำนวนอาจารย์ขึ้นสอบ</label>
                            <div class="grid-three-show-subject">
                                <input placeholder="จำนวนอาจารย์ขึ้นสอบ" class="form-control" name="txt_sub_setuse" id="txt_sub_setuse" value="<?=$subject_setuse;?>" disabled>
                                <label>คน</label>
                            </div>
                        </div>
                        <?PHP if(count($searchProject) != 0){ ?>
                            <?PHP if($project_status != 0){ ?>
                            <div class="form-group-mgTB grid-two-show-subject">
                                <label>สถานะปริญญานิพนธ์</label>
                                <?PHP if($project_status == 1){ ?>
                                    <input class="form-control" value="ยังไม่สอบโครงงานหนึ่ง" disabled>
                                <?PHP } else if($project_status == 2){ ?>
                                    <input class="form-control" value="ผ่านโครงงานหนึ่ง" disabled>
                                <?PHP } else if($project_status == 3){ ?>
                                    <input class="form-control" value="สอบโครงงานสองแล้วติดแก้ไข" disabled>
                                <?PHP } else if($project_status == 4){ ?>
                                    <input class="form-control" value="สอบโครงงานสองผ่าน" disabled>
                                <?PHP } ?>
                            </div>
                            <?PHP } ?>
                        <?PHP } ?>

                    </div>
                </div>

                    <?PHP if(!empty($project_status)){ ?>
                        <?PHP if($project_status == 0){ ?>
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5><i class="fa fa-book"></i> ข้อมูลผู้จัดทำปริญญานิพนธ์</h5>
                                </div>
                                <div class="ibox-content">  
                                    <form action="<?=base_url('project/addproject/'.$Idstd);?>" method="post" enctype="multipart/form-data" name="formStudentAddproject" id="formStudentAddproject" class="form-horizontal" novalidate>
                                        <input type="hidden" class="form-control" name="Idstd" id="Idstd" value="<?=$Idstd;?>">
                                        <input type="hidden" class="form-control" name="formcrfaddproject" id="formcrfaddproject" value="<?=$formcrfaddproject;?>">
                                        <input type="hidden" class="form-control" name="teacher_id" id="teacher_id" value="<?=$teacher_id;?>">

                                        <div class="form-group-mgTB grid-two-show-subject">
                                            <label>ชื่อปริญญานิพนธ์</label>
                                            <div>
                                                <input placeholder="ชื่อปริญญานิพนธ์" class="form-control" name="txt_projectname" id="txt_projectname" value="" >
                                            </div>
                                        </div>
                                        <div class="form-group-mgTB grid-two-show-subject">
                                            <label>ผู้จัดทำปริญญานิพนธ์</label>
                                            <div>
                                                <div class="radio radio-info radio-inline">
                                                    <input type="radio" onclick="javascript:yesnoCheck();" id="inlineRadio1" value="1" name="radioInline" checked="">
                                                    <label for="inlineRadio1"> จัดทำแบบเดี่ยว </label>
                                                </div>
                                                <div class="radio radio-info radio-inline">
                                                    <input type="radio" onclick="javascript:yesnoCheck();" id="inlineRadio2" value="2" name="radioInline">
                                                    <label for="inlineRadio2"> จัดทำแบบกลุ่ม </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group-mgTB grid-two-show-subject">
                                            <label></label>
                                            <div id="ifYes" style="display:none">
                                                <p>
                                                    <input type="text" class="hide-input-border form-control font-20" name="txt_std_id" placeholder="โปรดเลือกนักศึกษา" /> 
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group-mgTB">
                                            <br/>
                                            <button class="btn btn-primary btn-update-profile btn-lw100" type="submit" ><strong>แก้ไขข้อมูลส่วนตัว</strong></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?PHP } ?>
                    <?PHP } else {?>
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5><i class="fa fa-book"></i> ข้อมูลผู้จัดทำปริญญานิพนธ์</h5>
                            </div>
                            <div class="ibox-content">  
                                <form action="<?=base_url('project/addproject/'.$Idstd);?>" method="post" enctype="multipart/form-data" name="formStudentAddproject" id="formStudentAddproject" class="form-horizontal" novalidate>
                                    <input type="hidden" class="form-control" name="Idstd" id="Idstd" value="<?=$Idstd;?>">
                                    <input type="hidden" class="form-control" name="formcrfaddproject" id="formcrfaddproject" value="<?=$formcrfaddproject;?>">
                                    <input type="hidden" class="form-control" name="teacher_id" id="teacher_id" value="<?=$teacher_id;?>">

                                    <div class="form-group-mgTB grid-two-show-subject">
                                        <label>ชื่อปริญญานิพนธ์</label>
                                        <div>
                                            <input placeholder="ชื่อปริญญานิพนธ์" class="form-control" name="txt_projectname" id="txt_projectname" value="" >
                                        </div>
                                    </div>
                                    <div class="form-group-mgTB grid-two-show-subject">
                                        <label>ผู้จัดทำปริญญานิพนธ์</label>
                                        <div>
                                            <div class="radio radio-info radio-inline">
                                                <input type="radio" onclick="javascript:yesnoCheck();" id="inlineRadio1" value="1" name="radioInline" checked="">
                                                <label for="inlineRadio1"> จัดทำแบบเดี่ยว </label>
                                            </div>
                                            <div class="radio radio-info radio-inline">
                                                <input type="radio" onclick="javascript:yesnoCheck();" id="inlineRadio2" value="2" name="radioInline">
                                                <label for="inlineRadio2"> จัดทำแบบกลุ่ม </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-mgTB grid-two-show-subject">
                                        <label></label>
                                        <div id="ifYes" style="display:none">
                                            <p>
                                                <input type="text" class="hide-input-border form-control font-20" name="txt_std_id" placeholder="โปรดเลือกนักศึกษา" /> 
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group-mgTB">
                                        <br/>
                                        <button class="btn btn-primary btn-update-profile btn-lw100" type="submit" ><strong>เพิ่มข้อมูลปริญญานิพนธ์</strong></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?PHP } ?>
            </div>
            <div class="col-lg-5">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h5>
                    </div>
                    <div class="ibox-content">

                        <?PHP if(count($searchProject) != 0){ ?>
                            <div class="row">
                                <label class="col-sm-5 control-label">หน้าปกภาษาไทยและภาษาอังกฤษ</label>
                                <div class="col-sm-5">
                                    <?PHP if(!empty($project_filecov)){?>
                                        <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filecov);?>"><?=$project_filecov;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?PHP }else{?>
                                        ยังไม่มีการอัพโหลดไฟล์
                                    <?PHP } ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" data-toggle="modal" href="#modal_01_cov" class="btn btn-outline btn-success"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                            <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                            <div class="row">
                                <label class="col-sm-5 control-label">ใบรับรองปริญญานิพนธ์</label>
                                <div class="col-sm-5">
                                    <?PHP if(!empty($project_filecer)){?>
                                        <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filecer);?>"><?=$project_filecer;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?PHP }else{?>
                                        ยังไม่มีการอัพโหลดไฟล์
                                    <?PHP } ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" data-toggle="modal" href="#modal_02_cer" class="btn btn-outline btn-success"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                            <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                            <div class="row">
                                <label class="col-sm-5 control-label">บทคัดย่อ</label>
                                <div class="col-sm-5">
                                    <?PHP if(!empty($project_fileabs)){?>
                                        <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_fileabs);?>"><?=$project_fileabs;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?PHP }else{?>
                                        ยังไม่มีการอัพโหลดไฟล์
                                    <?PHP } ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" data-toggle="modal" href="#modal_03_abs" class="btn btn-outline btn-success"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                            <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                            <div class="row">
                                <label class="col-sm-5 control-label">กิตติกรรมประกาศ</label>
                                <div class="col-sm-5">
                                    <?PHP if(!empty($project_fileack)){?>
                                        <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_fileack);?>"><?=$project_fileack;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?PHP }else{?>
                                        ยังไม่มีการอัพโหลดไฟล์
                                    <?PHP } ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" data-toggle="modal" href="#modal_04_ack" class="btn btn-outline btn-success"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                            <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                            <div class="row">
                                <label class="col-sm-5 control-label">สารบัญ, สารบัญตาราง, สารบัญภาพ</label>
                                <div class="col-sm-5">
                                    <?PHP if(!empty($project_filetbc)){?>
                                        <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filetbc);?>"><?=$project_filetbc;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?PHP }else{?>
                                        ยังไม่มีการอัพโหลดไฟล์
                                    <?PHP } ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" data-toggle="modal" href="#modal_05_tcb" class="btn btn-outline btn-success"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                            <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                            <div class="row">
                                <label class="col-sm-5 control-label">บทที่ 1</label>
                                <div class="col-sm-5">
                                    <?PHP if(!empty($project_filechone)){?>
                                        <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filechone);?>"><?=$project_filechone;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?PHP }else{?>
                                        ยังไม่มีการอัพโหลดไฟล์
                                    <?PHP } ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" data-toggle="modal" href="#modal_06_ch01" class="btn btn-outline btn-success"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                            <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                            <div class="row">
                                <label class="col-sm-5 control-label">บทที่ 2</label>
                                <div class="col-sm-5">
                                    <?PHP if(!empty($project_filechtwo)){?>
                                        <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filechtwo);?>"><?=$project_filechtwo;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?PHP }else{?>
                                        ยังไม่มีการอัพโหลดไฟล์
                                    <?PHP } ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" data-toggle="modal" href="#modal_06_ch02" class="btn btn-outline btn-success"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                            <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                            <div class="row">
                                <label class="col-sm-5 control-label">บทที่ 3</label>
                                <div class="col-sm-5">
                                    <?PHP if(!empty($project_filechthree)){?>
                                        <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filechthree);?>"><?=$project_filechthree;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?PHP }else{?>
                                        ยังไม่มีการอัพโหลดไฟล์
                                    <?PHP } ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" data-toggle="modal" href="#modal_06_ch03" class="btn btn-outline btn-success"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                            <?PHP if($subject_type == 2){ ?>
                            <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                            <div class="row">
                                <label class="col-sm-5 control-label">บทที่ 4</label>
                                <div class="col-sm-5">
                                    <?PHP if(!empty($project_filechfour)){?>
                                        <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filechfour);?>"><?=$project_filechfour;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?PHP }else{?>
                                        ยังไม่มีการอัพโหลดไฟล์
                                    <?PHP } ?>
                                    <input type="hidden" class="form-control" name="txt_06_ch04" id="txt_06_ch04" value="<?=$project_filechfour;?>">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" data-toggle="modal" href="#modal_06_ch04" class="btn btn-outline btn-success"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                            <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                            <div class="row">
                                <label class="col-sm-5 control-label">บทที่ 5</label>
                                <div class="col-sm-5">
                                    <?PHP if(!empty($project_filechfive)){?>
                                        <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filechfive);?>"><?=$project_filechfive;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?PHP }else{?>
                                        ยังไม่มีการอัพโหลดไฟล์
                                    <?PHP } ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" data-toggle="modal" href="#modal_06_ch05" class="btn btn-outline btn-success"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                            <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                            <div class="row">
                                <label class="col-sm-5 control-label">เอกสารอ้างอิงหรือบรรณานุกรม</label>
                                <div class="col-sm-5">
                                    <?PHP if(!empty($project_fileref)){?>
                                        <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_fileref);?>"><?=$project_fileref;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?PHP }else{?>
                                        ยังไม่มีการอัพโหลดไฟล์
                                    <?PHP } ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" data-toggle="modal" href="#modal_07_ref" class="btn btn-outline btn-success"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                            <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                            <div class="row">
                                <label class="col-sm-5 control-label">ภาคผนวก</label>
                                <div class="col-sm-5">
                                    <?PHP if(!empty($project_fileappone)){?>
                                        <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_fileappone);?>"><?=$project_fileappone;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?PHP }else{?>
                                        ยังไม่มีการอัพโหลดไฟล์
                                    <?PHP } ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" data-toggle="modal" href="#modal_08_app" class="btn btn-outline btn-success"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                            <?PHP } ?>
                            <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                            <div class="row">
                                <label class="col-sm-5 control-label">ประวัติผู้จัดทำ</label>
                                <div class="col-sm-5">
                                    <?PHP if(!empty($project_filebio)){?>
                                        <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filebio);?>"><?=$project_filebio;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?PHP }else{?>
                                        ยังไม่มีการอัพโหลดไฟล์
                                    <?PHP } ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" data-toggle="modal" href="#modal_09_bio" class="btn btn-outline btn-success"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                        <?PHP }else{ ?>
                            <br/>
                            <br/>
                            <center>
                            <label>เอกสารประกอบการพิจารณาการขึ้นสอบปริญญานิพนธ์</label>
                            <br/>
                            <br/>
                            <label><span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span>ยังไม่มีหัวข้อโปรเจค<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                            </center>
                            <br/>
                            <br/>
                        <?PHP }?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- =======================================  upload file project  =======================================   -->
    <?PHP if(count($searchProject) != 0){ ?>
        <!-- modal update file -->

        <form action="<?=base_url('project/add01_cov');?>" method="post" enctype="multipart/form-data" name="add01_cov" id="add01_cov" class="form-horizontal" novalidate> 
            <input type="hidden" class="form-control" name="txt_01_cov" id="txt_01_cov" value="<?=$project_filecer;?>">
            <div id="modal_01_cov" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Idstd;?>">    
                        <input type="hidden" name="projectId" id="projectId" value="<?=$project_id;?>">   

                            <br/>
                            <div class="row">
                                <label class="col-sm-12">หน้าปกภาษาไทยและภาษาอังกฤษ<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                                <div class="col-sm-12"><br/></div>
                                <div class="col-sm-12"><input type="file" class="form-control" name="txt_01_cov" id="txt_01_cov" accept=".pdf"></div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-lw100" type="submit"><strong>เพิ่มไฟล์เอกสารปริญญานิพนธ์</strong></button>
                    </div>
                    </div>

                </div>
            </div>
        </form>

        <form action="<?=base_url('project/add02_cer');?>" method="post" enctype="multipart/form-data" name="add02_cer" id="add02_cer" class="form-horizontal" novalidate> 
            <input type="hidden" class="form-control" name="txt_02_cer" id="txt_02_cer" value="<?=$project_filecer;?>">
            <div id="modal_02_cer" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Idstd;?>">    
                        <input type="hidden" name="projectId" id="projectId" value="<?=$project_id;?>">   

                            <br/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning alert-dismissable hide" id="formError_addfile_02" style="color:#333">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        กรุณาเลือกไฟล์เอกสาร .pdf
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12">ใบรับรองปริญญานิพนธ์<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                                <div class="col-sm-12"><br/></div>
                                <div class="col-sm-12"><input type="file" class="form-control" name="txt_02_cer" id="txt_02_cer" accept=".pdf"></div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-lw100" type="submit"><strong>เพิ่มไฟล์เอกสารปริญญานิพนธ์</strong></button>
                    </div>
                    </div>

                </div>
            </div>
        </form>

        <form action="<?=base_url('project/add03_abs');?>" method="post" enctype="multipart/form-data" name="add03_abs" id="add03_abs" class="form-horizontal" novalidate> 
            <input type="hidden" class="form-control" name="txt_03_abs" id="txt_03_abs" value="<?=$project_fileabs;?>">
            <div id="modal_03_abs" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Idstd;?>">    
                        <input type="hidden" name="projectId" id="projectId" value="<?=$project_id;?>">   

                            <br/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning alert-dismissable hide" id="formError_addfile_03_abs" style="color:#333">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        กรุณาเลือกไฟล์เอกสาร .pdf
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12">บทคัดย่อ<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                                <div class="col-sm-12"><br/></div>
                                <div class="col-sm-12"><input type="file" class="form-control" name="txt_03_abs" id="txt_03_abs" accept=".pdf"></div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-lw100" type="submit"><strong>เพิ่มไฟล์เอกสารปริญญานิพนธ์</strong></button>
                    </div>
                    </div>

                </div>
            </div>
        </form>

        <form action="<?=base_url('project/add04_ack');?>" method="post" enctype="multipart/form-data" name="add04_ack" id="add04_ack" class="form-horizontal" novalidate> 
            <input type="hidden" class="form-control" name="txt_04_ack" id="txt_04_ack" value="<?=$project_fileack;?>">
            <div id="modal_04_ack" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Idstd;?>">    
                        <input type="hidden" name="projectId" id="projectId" value="<?=$project_id;?>">   

                            <br/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning alert-dismissable hide" id="formError_add04_ack" style="color:#333">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        กรุณาเลือกไฟล์เอกสาร .pdf
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12">กิตติกรรมประกาศ<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                                <div class="col-sm-12"><br/></div>
                                <div class="col-sm-12"><input type="file" class="form-control" name="txt_04_ack" id="txt_04_ack" accept=".pdf"></div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-lw100" type="submit"><strong>เพิ่มไฟล์เอกสารปริญญานิพนธ์</strong></button>
                    </div>
                    </div>

                </div>
            </div>
        </form>

        <form action="<?=base_url('project/add05_tcb');?>" method="post" enctype="multipart/form-data" name="add05_tcb" id="add05_tcb" class="form-horizontal" novalidate> 
            <input type="hidden" class="form-control" name="txt_05_tcb" id="txt_05_tcb" value="<?=$project_filetbc;?>">
            <div id="modal_05_tcb" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Idstd;?>">    
                        <input type="hidden" name="projectId" id="projectId" value="<?=$project_id;?>">   

                            <br/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning alert-dismissable hide" id="formError_add05_tcb" style="color:#333">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        กรุณาเลือกไฟล์เอกสาร .pdf
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12">สารบัญ, สารบัญตาราง, สารบัญภาพ<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                                <div class="col-sm-12"><br/></div>
                                <div class="col-sm-12"><input type="file" class="form-control" name="txt_05_tcb" id="txt_05_tcb" accept=".pdf"></div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-lw100" type="submit"><strong>เพิ่มไฟล์เอกสารปริญญานิพนธ์</strong></button>
                    </div>
                    </div>

                </div>
            </div>
        </form>

        <form action="<?=base_url('project/add06_ch01');?>" method="post" enctype="multipart/form-data" name="add06_ch01" id="add06_ch01" class="form-horizontal" novalidate> 
            <input type="hidden" class="form-control" name="txt_06_ch01" id="txt_06_ch01" value="<?=$project_filechone;?>">
            <div id="modal_06_ch01" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Idstd;?>">    
                        <input type="hidden" name="projectId" id="projectId" value="<?=$project_id;?>">   

                            <br/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning alert-dismissable hide" id="formError_add06_ch01" style="color:#333">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        กรุณาเลือกไฟล์เอกสาร .pdf
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12">บทที่ 1<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                                <div class="col-sm-12"><br/></div>
                                <div class="col-sm-12"><input type="file" class="form-control" name="txt_06_ch01" id="txt_06_ch01" accept=".pdf"></div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-lw100" type="submit"><strong>เพิ่มไฟล์เอกสารปริญญานิพนธ์</strong></button>
                    </div>
                    </div>

                </div>
            </div>
        </form>

        <form action="<?=base_url('project/add06_ch02');?>" method="post" enctype="multipart/form-data" name="add06_ch02" id="add06_ch02" class="form-horizontal" novalidate> 
            <input type="hidden" class="form-control" name="txt_06_ch02" id="txt_06_ch02" value="<?=$project_filechtwo;?>">
            <div id="modal_06_ch02" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Idstd;?>">    
                        <input type="hidden" name="projectId" id="projectId" value="<?=$project_id;?>">   

                            <br/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning alert-dismissable hide" id="formError_add06_ch02" style="color:#333">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        กรุณาเลือกไฟล์เอกสาร .pdf
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12">บทที่ 2<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                                <div class="col-sm-12"><br/></div>
                                <div class="col-sm-12"><input type="file" class="form-control" name="txt_06_ch02" id="txt_06_ch02" accept=".pdf"></div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-lw100" type="submit"><strong>เพิ่มไฟล์เอกสารปริญญานิพนธ์</strong></button>
                    </div>
                    </div>

                </div>
            </div>
        </form>

        <form action="<?=base_url('project/add06_ch03');?>" method="post" enctype="multipart/form-data" name="add06_ch03" id="add06_ch03" class="form-horizontal" novalidate> 
            <input type="hidden" class="form-control" name="txt_06_ch03" id="txt_06_ch03" value="<?=$project_filechthree;?>">
            <div id="modal_06_ch03" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Idstd;?>">    
                        <input type="hidden" name="projectId" id="projectId" value="<?=$project_id;?>">   

                            <br/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning alert-dismissable hide" id="formError_add06_ch03" style="color:#333">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        กรุณาเลือกไฟล์เอกสาร .pdf
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12">บทที่ 3<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                                <div class="col-sm-12"><br/></div>
                                <div class="col-sm-12"><input type="file" class="form-control" name="txt_06_ch03" id="txt_06_ch03" accept=".pdf"></div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-lw100" type="submit"><strong>เพิ่มไฟล์เอกสารปริญญานิพนธ์</strong></button>
                    </div>
                    </div>

                </div>
            </div>
        </form>

        <form action="<?=base_url('project/add06_ch04');?>" method="post" enctype="multipart/form-data" name="add06_ch04" id="add06_ch04" class="form-horizontal" novalidate> 
            <input type="hidden" class="form-control" name="txt_06_ch04" id="txt_06_ch04" value="<?=$project_filechfour;?>">
            <div id="modal_06_ch04" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Idstd;?>">    
                        <input type="hidden" name="projectId" id="projectId" value="<?=$project_id;?>">   

                            <br/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning alert-dismissable hide" id="formError_addfile_06_ch04" style="color:#333">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        กรุณาเลือกไฟล์เอกสาร .pdf
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12">บทที่ 4<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                                <div class="col-sm-12"><br/></div>
                                <div class="col-sm-12"><input type="file" class="form-control" name="txt_06_ch04" id="txt_06_ch04" accept=".pdf"></div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-lw100" type="submit"><strong>เพิ่มไฟล์เอกสารปริญญานิพนธ์</strong></button>
                    </div>
                    </div>

                </div>
            </div>
        </form>

        <form action="<?=base_url('project/add06_ch05');?>" method="post" enctype="multipart/form-data" name="add06_ch05" id="add06_ch05" class="form-horizontal" novalidate> 
            <input type="hidden" class="form-control" name="txt_06_ch05" id="txt_06_ch05" value="<?=$project_filechfive;?>">
            <div id="modal_06_ch05" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Idstd;?>">    
                        <input type="hidden" name="projectId" id="projectId" value="<?=$project_id;?>">   

                            <br/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning alert-dismissable hide" id="formError_addfile_06_ch05" style="color:#333">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        กรุณาเลือกไฟล์เอกสาร .pdf
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12">บทที่ 5<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                                <div class="col-sm-12"><br/></div>
                                <div class="col-sm-12"><input type="file" class="form-control" name="txt_06_ch05" id="txt_06_ch05" accept=".pdf"></div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-lw100" type="submit"><strong>เพิ่มไฟล์เอกสารปริญญานิพนธ์</strong></button>
                    </div>
                    </div>

                </div>
            </div>
        </form>

        <form action="<?=base_url('project/add07_ref');?>" method="post" enctype="multipart/form-data" name="add07_ref" id="add07_ref" class="form-horizontal" novalidate> 
            <input type="hidden" class="form-control" name="txt_07_ref" id="txt_07_ref" value="<?=$project_fileref;?>">
            <div id="modal_07_ref" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Idstd;?>">    
                        <input type="hidden" name="projectId" id="projectId" value="<?=$project_id;?>">   

                            <br/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning alert-dismissable hide" id="formError_add07_ref" style="color:#333">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        กรุณาเลือกไฟล์เอกสาร .pdf
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12">เอกสารอ้างอิงหรือบรรณานุกรม<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                                <div class="col-sm-12"><br/></div>
                                <div class="col-sm-12"><input type="file" class="form-control" name="txt_07_ref" id="txt_07_ref" accept=".pdf"></div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-lw100" type="submit"><strong>เพิ่มไฟล์เอกสารปริญญานิพนธ์</strong></button>
                    </div>
                    </div>

                </div>
            </div>
        </form>

        <form action="<?=base_url('project/add08_app');?>" method="post" enctype="multipart/form-data" name="add08_app" id="add08_app" class="form-horizontal" novalidate> 
            <input type="hidden" class="form-control" name="txt_08_app" id="txt_08_app" value="<?=$project_fileappone;?>">
            <div id="modal_08_app" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Idstd;?>">    
                        <input type="hidden" name="projectId" id="projectId" value="<?=$project_id;?>">   

                            <br/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning alert-dismissable hide" id="formError_add08_app" style="color:#333">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        กรุณาเลือกไฟล์เอกสาร .pdf
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12">ภาคผนวก<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                                <div class="col-sm-12"><br/></div>
                                <div class="col-sm-12"><input type="file" class="form-control" name="txt_08_app" id="txt_08_app" accept=".pdf"></div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-lw100" type="submit"><strong>เพิ่มไฟล์เอกสารปริญญานิพนธ์</strong></button>
                    </div>
                    </div>

                </div>
            </div>
        </form>

        <form action="<?=base_url('project/add09_bio');?>" method="post" enctype="multipart/form-data" name="add09_bio" id="add09_bio" class="form-horizontal" novalidate> 
            <input type="hidden" class="form-control" name="txt_09_bio" id="txt_09_bio" value="<?=$project_filebio;?>">
            <div id="modal_09_bio" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
                        <input type="hidden" name="Id" id="Id" value="<?=$Idstd;?>">    
                        <input type="hidden" name="projectId" id="projectId" value="<?=$project_id;?>">   

                            <br/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning alert-dismissable hide" id="formError_addfile_09_bio" style="color:#333">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        กรุณาเลือกไฟล์เอกสาร .pdf
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12">ประวัติผู้จัดทำ<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                                <div class="col-sm-12"><br/></div>
                                <div class="col-sm-12"><input type="file" class="form-control" name="txt_09_bio" id="txt_09_bio" accept=".pdf"></div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-lw100" type="submit"><strong>เพิ่มไฟล์เอกสารปริญญานิพนธ์</strong></button>
                    </div>
                    </div>

                </div>
            </div>
        </form>
    <?PHP } ?>
<!-- =======================================  upload file project  =======================================   -->

<script type="text/javascript">

    function yesnoCheck() {
        if (document.getElementById('inlineRadio2').checked) {
            document.getElementById('ifYes').style.display = 'block';
        }
        else document.getElementById('ifYes').style.display = 'none';

    }

</script>