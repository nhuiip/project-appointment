
<?
if (isset($listshowproject) && count($listshowproject) != 0) {
    foreach ($listshowproject as $key => $value) {
        $subject_type           = $value['sub_type'];
        $subject_name           = $value['sub_name'];
        $subject_code           = $value['sub_code'];
        $subject_setuse         = $value['sub_setuse'];
        $subject_status         = $value['sub_status'];
        $teacher_fullname       = $value['use_name'];
    }
} 

if (isset($searchStdLogin) && count($searchStdLogin) != 0) {
    foreach ($searchStdLogin as $key => $value) {
        $project_id             = $value['project_id'];
        $project_name           = $value['project_name'];
    }
} 

$this->db->select("std_id");
$query_project = $this->db->get('tb_project');
$listproject = $query_project->result_array();
      
// print_r($listproject);
// die;

$chkstd = explode(",",$listproject[0]['std_id']);
asort($chkstd);
       
// print_r($chkstd);
// die;

foreach ($chkstd as $key => $value) { 
    if($value != ""){
        if($value == $Id){
            $selectsubject  =   $value;
        }
    } 
} 

?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-7">
            
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-book"></i> ข้อมูลปริญญานิพนธ์</h5>
                    <!-- <div class="ibox-tools" >
                        <button type="button" data-toggle="modal"  class="btn btn-outline btn-primary" href="#modal-addsubject"><i class="fa fa-plus-square-o"></i> เพิ่มข้อมูล</button>
                    </div> -->
                </div>
                <div class="ibox-content">
                      
                    <div class="form-group-mgTB grid-two-show-subject">
                        <label>ชื่อปริญญานิพนธ์<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                        <input placeholder="ชื่อโปรเจค" class="form-control" name="txt_projectname" id="txt_projectname" value="<?=$project_name;?>" disabled>
                    </div>
                    <div class="form-group-mgTB grid-two-show-subject">
                        <label>รหัสวิชา</label>
                        <input placeholder="รหัสวิชา" class="form-control" name="txt_showcode" id="txt_showcode" value="<?=$subject_code;?>" disabled>
                    </div>
                    <div class="form-group-mgTB grid-two-show-subject">
                        <label>รายวิชาที่ลงทะเบียน<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
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

                </div>
            </div>
        </div>
        <div class="col-lg-5">
            
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h5>
                    <div class="ibox-tools" >
                        <button type="button" data-toggle="modal" data-target="#modal-addfile" class="btn btn-outline btn-primary"><i class="fa fa-plus-square-o"></i> เพิ่มข้อมูล</button>
                    </div>
                </div>
                <div class="ibox-content">
                    <p><small><span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span> เอกสารปริญญานิพนธ์เพื่อประกอบการพิจารณาการขอขึ้นสอบ <?=$subject_name;?></small></p>
                    <!-- <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3">หน้าปกภาษาไทยและภาษาอังกฤษ</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="txt_01_cov" id="txt_01_cov"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3">ใบรับรองปริญญานิพนธ์</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="txt_02_cer" id="txt_02_cer"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3">บทคัดย่อ</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="txt_03_abs" id="txt_03_abs"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3">กิตติกรรมประกาศ</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="txt_04_ack" id="txt_04_ack"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3">สารบัญ, สารบัญตาราง, สารบัญภาพ</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="txt_05_tcb" id="txt_05_tcb"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3">บทที่ 1</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="txt_06_ch01" id="txt_06_ch01"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3">บทที่ 2</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="txt_06_ch02" id="txt_06_ch02"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3">บทที่ 3</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="txt_06_ch03" id="txt_06_ch03"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3">บทที่ 4</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="txt_06_ch04" id="txt_06_ch04"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3">บทที่ 5</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="txt_06_ch05" id="txt_06_ch05"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3">เอกสารอ้างอิงหรือบรรณานุกรม</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="txt_07_ref" id="txt_07_ref"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3">ภาคผนวก</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="txt_08_app" id="txt_08_app"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3">ประวัติผู้จัดทำ</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="txt_09_bio" id="txt_09_bio"></div>
                    </div> -->
                </div>
            </div>
            
        </div>
    </div>
</div>

<form action="<?=base_url('project/addfile/'.$Id);?>" method="post" enctype="multipart/form-data" name="formaddfile" id="formaddfile1" class="form-horizontal" novalidate>
<input type="hidden" name="formcrf" id="formcrf" value="<?=$formcrf;?>">
<input type="hidden" name="Id" id="Id" value="<?=$Id;?>">    
<input type="hidden" name="projectId" id="projectId" value="<?=$project_id;?>">    

    <div id="modal-addfile" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4><i class="fa fa-file"></i>  เอกสารปริญญานิพนธ์</h4>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-warning alert-dismissable hide" id="formError_addfile" style="color:#333">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                กรุณาเลือกไฟล์ที่มีเครื่องหมาย <span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span> ให้ครบถ้วน.
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4">หน้าปกภาษาไทยและภาษาอังกฤษ<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                        <div class="col-sm-8"><input type="file" class="form-control" name="txt_01_cov" id="txt_01_cov"></div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-4">ใบรับรองปริญญานิพนธ์<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                        <div class="col-sm-8"><input type="file" class="form-control" name="txt_02_cer" id="txt_02_cer"></div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-4">บทคัดย่อ<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                        <div class="col-sm-8"><input type="file" class="form-control" name="txt_03_abs" id="txt_03_abs"></div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-4">กิตติกรรมประกาศ<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                        <div class="col-sm-8"><input type="file" class="form-control" name="txt_04_ack" id="txt_04_ack"></div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-4">สารบัญ, สารบัญตาราง, สารบัญภาพ<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                        <div class="col-sm-8"><input type="file" class="form-control" name="txt_05_tcb" id="txt_05_tcb"></div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-4">บทที่ 1<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                        <div class="col-sm-8"><input type="file" class="form-control" name="txt_06_ch01" id="txt_06_ch01"></div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-4">บทที่ 2<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                        <div class="col-sm-8"><input type="file" class="form-control" name="txt_06_ch02" id="txt_06_ch02"></div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-4">บทที่ 3<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                        <div class="col-sm-8"><input type="file" class="form-control" name="txt_06_ch03" id="txt_06_ch03"></div>
                    </div>
                    <?PHP if($subject_type == 2){?>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-4">บทที่ 4<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                        <div class="col-sm-8"><input type="file" class="form-control" name="txt_06_ch04" id="txt_06_ch04"></div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-4">บทที่ 5<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                        <div class="col-sm-8"><input type="file" class="form-control" name="txt_06_ch05" id="txt_06_ch05"></div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-4">เอกสารอ้างอิงหรือบรรณานุกรม<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                        <div class="col-sm-8"><input type="file" class="form-control" name="txt_07_ref" id="txt_07_ref"></div>
                    </div>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-4">ภาคผนวก<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                        <div class="col-sm-8"><input type="file" class="form-control" name="txt_08_app" id="txt_08_app"></div>
                    </div>
                    <?PHP } ?>
                    <div class="row"><div class="col-sm-12"><div class="hr-line-dashed"></div></div></div>
                    <div class="row">
                        <label class="col-sm-4">ประวัติผู้จัดทำ<span class="alert-link" href="#"> <b style="color:#c0392b">&nbsp;&nbsp;*&nbsp;&nbsp;</b> </span></label>
                        <div class="col-sm-8"><input type="file" class="form-control" name="txt_09_bio" id="txt_09_bio"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-lw100" type="submit"><strong>เพิ่มไฟล์เอกสารปริญญานิพนธ์</strong></button>
            </div>
            </div>

        </div>
    </div>
</form>
