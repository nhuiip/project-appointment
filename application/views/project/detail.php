<?PHP
//แสดงข้อมูล project
if (isset($showproject) && count($showproject) != 0) {
    foreach ($showproject as $key => $value) {
        $project_id         = $value['project_id'];
        $project_name       = $value['project_name'];
        $project_status     = $value['project_status'];
        $subject_Id         = $value['sub_id'];
        $subject_code       = $value['sub_code'];
        $subject_name       = $value['sub_name'];
        $subject_type       = $value['sub_type'];
    }
} 

//แสดงข้อมูลอาจารย์ผู้สอน
$this->db->select('*');
$this->db->from('tb_subject');
$this->db->join('tb_user', 'tb_user.use_id = tb_subject.use_id');
$this->db->where(array('tb_subject.sub_id' => $subject_Id));
$query_showteacher= $this->db->get();
$listteacher = $query_showteacher->result_array();

$teacher_fullname  =  $listteacher[0]['use_name'];

//แสดงข้อมูลอาจารย์ที่ปรึกษา
$this->db->select('*');
$this->db->from('tb_project');
$this->db->join('tb_user', 'tb_user.use_id = tb_project.use_id');
$this->db->where(array('tb_project.project_id' => $project_id));
$query_projectteacher= $this->db->get();
$listprojectteacher = $query_projectteacher->result_array();

$projectteacher_fullname  =  $listprojectteacher[0]['use_name'];

//แสดงข้อมูลนักศึกษาที่ทำ project
if (isset($showproject2) && count($showproject2) != 0) {
    foreach ($showproject2 as $key => $value) {
        $project_studentId       = $value['std_id'];
    }
} 


?>
<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>ข้อมูลปริญญานิพนธ์</h2>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('project/index/'.$this->encryption->decrypt($this->input->cookie('sysli'))); ?>">หน้าแรก</a></li>
            <li>ข้อมูลปริญญานิพนธ์</li>
            <li class="active"><strong><?=$project_name;?></strong></li>
        </ol>
    </div>
</div>
<!-- End breadcrumb for page -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-7">
            
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-book"></i> ข้อมูลปริญญานิพนธ์ </h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group-mgTB grid-two-show-subject">
                        <label>หัวข้อปริญญานิพนธ์</label>
                        <label><?=$project_name;?></label>
                    </div>
                    <div class="form-group-mgTB grid-two-show-subject">
                        <label>รหัสวิชา</label>
                        <label><?=$subject_code;?></label>
                    </div>
                    <div class="form-group-mgTB grid-two-show-subject">
                        <label>รายวิชาที่ลงทะเบียน</label>
                        <label><?=$subject_name;?></label>
                    </div>
                    <?PHP if($teacher_fullname == $projectteacher_fullname){ ?>
                        <div class="form-group-mgTB grid-two-show-subject">
                            <label>อาจารย์ผู้สอน / อาจารย์ที่ปรึกษา</label>
                            <label><?=$teacher_fullname;?></label>
                        </div>
                    <?PHP }else{ ?>
                    <div class="form-group-mgTB grid-two-show-subject">
                        <label>อาจารย์ผู้สอน</label>
                        <label><?=$teacher_fullname;?></label>
                    </div>
                    <div class="form-group-mgTB grid-two-show-subject">
                        <label>อาจารย์ที่ปรึกษา</label>
                        <label><?=$projectteacher_fullname;?></label>
                    </div>
                    <?PHP } ?>
                    <div class="form-group-mgTB grid-two-show-subject">
                        <label>สถานะปริญญานิพนธ์</label>
                        <?PHP if($project_status == 1){ ?>
                            <p><span class="label label-info" style="font-size: 13px;">ยังไม่สอบโครงงานหนึ่ง</span></p>
                        <?PHP } else if($project_status == 2){ ?>
                            <p><span class="label label-primary" style="font-size: 13px;">ผ่านโครงงานหนึ่ง</span></p>
                        <?PHP } else if($project_status == 3){ ?>
                            <p><span class="label label-warning" style="font-size: 13px;">สอบโครงงานสองแล้วติดแก้ไข</span></p>
                        <?PHP } else if($project_status == 4){ ?>
                            <p><span class="label label-success" style="font-size: 13px;">สอบโครงงานสองผ่าน</span></p>
                        <?PHP } else if($project_status == 0){ ?>
                            <p><span class="label label-danger" style="font-size: 12px;">เปลี่ยนหัวข้อปริญญานิพนธ์</span></p>
                        <?PHP } ?>
                    </div>
                    <div class="form-group-mgTB grid-two-show-subject">
                        <label>ผู้จัดทำปริญญานิพนธ์</label>
                        <div>
                            <!-- ================================================================ แตกสตริงออกเป็นสตริงย่อย ผลลัพธ์ที่คืนกลับมาจะเป็นรูปแบบ array -->
                            <?PHP
                        if($project_studentId != ''){
                            $stypesVal = explode(",", $project_studentId);
                        } else {
                            $stypesVal = '';
                        }

                        $i = 1;
                        if (count($stypesVal) != 0) {
                            foreach ($stypesVal as $key => $value) { 

                            $this->db->select('std_id,std_number,std_title,std_fname,std_lname');
                            $this->db->where(array('std_id' => $value));
                            $query_student = $this->db->get('tb_student');
                            $liststudent = $query_student->result_array();
                        ?>
                            <div class="form-group">
                                <label><?=$i;?>. <?=$liststudent[0]['std_number']?> <?=$liststudent[0]['std_title']?><?=$liststudent[0]['std_fname']?>  <?=$liststudent[0]['std_lname']?></label>
                            </div>
                        <?PHP
                            $i++; } 
                        } 
                        ?>
                        <!-- ================================================================ ./แตกสตริงออกเป็นสตริงย่อย ผลลัพธ์ที่คืนกลับมาจะเป็นรูปแบบ array -->
                        </div>
                    </div>
                    <div class="form-group-mgTB">
                        <a href="<?= site_url('project/index/'.$this->encryption->decrypt($this->input->cookie('sysli'))); ?>"><button type="button" class="btn btn-outline btn-danger">ย้อนกลับหน้าหลัก</button></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <label class="col-sm-5 control-label">หน้าปกภาษาไทยและภาษาอังกฤษ</label>
                        <div class="col-sm-6">
                            <?PHP if(!empty($project_filecov)){?>
                                <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filecov);?>"><?=$project_filecov;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?PHP }else{?>
                                ยังไม่มีการอัพโหลดไฟล์
                            <?PHP } ?>
                        </div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-5 control-label">ใบรับรองปริญญานิพนธ์</label>
                        <div class="col-sm-6">
                            <?PHP if(!empty($project_filecer)){?>
                                <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filecer);?>"><?=$project_filecer;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?PHP }else{?>
                                ยังไม่มีการอัพโหลดไฟล์
                            <?PHP } ?>
                        </div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-5 control-label">บทคัดย่อ</label>
                        <div class="col-sm-6">
                            <?PHP if(!empty($project_fileabs)){?>
                                <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_fileabs);?>"><?=$project_fileabs;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?PHP }else{?>
                                ยังไม่มีการอัพโหลดไฟล์
                            <?PHP } ?>
                        </div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-5 control-label">กิตติกรรมประกาศ</label>
                        <div class="col-sm-6">
                            <?PHP if(!empty($project_fileack)){?>
                                <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_fileack);?>"><?=$project_fileack;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?PHP }else{?>
                                ยังไม่มีการอัพโหลดไฟล์
                            <?PHP } ?>
                        </div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-5 control-label">สารบัญ, สารบัญตาราง, สารบัญภาพ</label>
                        <div class="col-sm-6">
                            <?PHP if(!empty($project_filetbc)){?>
                                <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filetbc);?>"><?=$project_filetbc;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?PHP }else{?>
                                ยังไม่มีการอัพโหลดไฟล์
                            <?PHP } ?>
                        </div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-5 control-label">บทที่ 1</label>
                        <div class="col-sm-6">
                            <?PHP if(!empty($project_filechone)){?>
                                <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filechone);?>"><?=$project_filechone;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?PHP }else{?>
                                ยังไม่มีการอัพโหลดไฟล์
                            <?PHP } ?>
                        </div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-5 control-label">บทที่ 2</label>
                        <div class="col-sm-6">
                            <?PHP if(!empty($project_filechtwo)){?>
                                <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filechtwo);?>"><?=$project_filechtwo;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?PHP }else{?>
                                ยังไม่มีการอัพโหลดไฟล์
                            <?PHP } ?>
                        </div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-5 control-label">บทที่ 3</label>
                        <div class="col-sm-6">
                            <?PHP if(!empty($project_filechthree)){?>
                                <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filechthree);?>"><?=$project_filechthree;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?PHP }else{?>
                                ยังไม่มีการอัพโหลดไฟล์
                            <?PHP } ?>
                        </div>
                    </div>
                    <?PHP if($subject_type == 2){ ?>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-5 control-label">บทที่ 4</label>
                        <div class="col-sm-6">
                            <?PHP if(!empty($project_filechfour)){?>
                                <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filechfour);?>"><?=$project_filechfour;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?PHP }else{?>
                                ยังไม่มีการอัพโหลดไฟล์
                            <?PHP } ?>
                            <input type="hidden" class="form-control" name="txt_06_ch04" id="txt_06_ch04" value="<?=$project_filechfour;?>">
                        </div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-5 control-label">บทที่ 5</label>
                        <div class="col-sm-6">
                            <?PHP if(!empty($project_filechfive)){?>
                                <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filechfive);?>"><?=$project_filechfive;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?PHP }else{?>
                                ยังไม่มีการอัพโหลดไฟล์
                            <?PHP } ?>
                        </div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-5 control-label">เอกสารอ้างอิงหรือบรรณานุกรม</label>
                        <div class="col-sm-6">
                            <?PHP if(!empty($project_fileref)){?>
                                <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_fileref);?>"><?=$project_fileref;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?PHP }else{?>
                                ยังไม่มีการอัพโหลดไฟล์
                            <?PHP } ?>
                        </div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-5 control-label">ภาคผนวก</label>
                        <div class="col-sm-6">
                            <?PHP if(!empty($project_fileappone)){?>
                                <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_fileappone);?>"><?=$project_fileappone;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?PHP }else{?>
                                ยังไม่มีการอัพโหลดไฟล์
                            <?PHP } ?>
                        </div>
                    </div>
                    <?PHP } ?>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-5 control-label">ประวัติผู้จัดทำ</label>
                        <div class="col-sm-6">
                            <?PHP if(!empty($project_filebio)){?>
                                <a target="_bank" href="<?=base_url('uploads/fileproject/'.$project_id.'/'.$project_filebio);?>"><?=$project_filebio;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?PHP }else{?>
                                ยังไม่มีการอัพโหลดไฟล์
                            <?PHP } ?>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

