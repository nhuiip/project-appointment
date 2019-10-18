<?
//ค้นหาโปรเจคที่นักศึกษาสร้างไว้
if (isset($searchProject) && count($searchProject) != 0) {
    foreach ($searchProject as $key => $value) {
        $project_id             = $value['project_id'];
        $project_name           = $value['project_name'];
        $project_status         = $value['project_status'];
        $project_studentId      = $value['std_id'];
        $teacher_fullname       = $value['use_name'];
        $teacher_id             = $value['use_id'];
        $project_create_name    = $value['project_create_name'];
        $project_create_date    = $value['project_create_date'];
        $project_lastedit_name  = $value['project_lastedit_name'];
        $project_lastedit_date  = $value['project_lastedit_date'];
    }
    $this->db->select('*');
    $this->db->from('tb_projectperson');
    $this->db->join('tb_student', 'tb_student.std_id = tb_projectperson.std_id');
    $this->db->join('tb_project', 'tb_project.project_id = tb_projectperson.project_id');
    $this->db->where(array('tb_projectperson.project_id' => $project_id));
    $query_person = $this->db->get();
    $listprojectperson = $query_person->result_array();

    $this->db->select('*');
    $this->db->from('tb_projectfile');
    $this->db->join('tb_project', 'tb_project.project_id = tb_projectfile.project_id');
    $this->db->where(array('tb_projectfile.project_id' => $project_id));
    $query_file = $this->db->get();
    $listfile = $query_file->result_array();
}


?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-6">
            <?PHP if (count($searchProject) != 0) { ?>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-book"></i> &nbsp;&nbsp;ข้อมูลปริญญานิพนธ์</h5>

                        <div class="ibox-tools">
                            <button class="btn btn-outline btn-warning btn-sm" data-toggle="modal" data-target="#ProjectStd_Up">แก้ไขข้อมูล</button>
                            <button class="btn btn-outline btn-danger btn-sm btn-alert" data-url="<?= site_url('student/stdprojectdel/' . $project_id); ?>" data-title="ต้องการยกเลิกหัวข้อปริญญานิพนธ์ ?">ลบข้อมูล</button>
                        </div>

                    </div>
                    <div class="ibox-content">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <?
                                    switch ($project_status) {
                                        case 1:
                                            $status_text = '<span class="badge">&nbsp;&nbsp;เริ่มต้น&nbsp;&nbsp;</span>';
                                            break;
                                        case 2:
                                            $status_text = '<span class="badge badge-primary">&nbsp;&nbsp;ผ่านโครงการสารสนเทศ 1&nbsp;&nbsp;</span>';
                                            break;
                                        case 3:
                                            $status_text = '<span class="badge badge-warning">&nbsp;&nbsp;ติดแก้ไขโครงการสารสนเทศ 2&nbsp;&nbsp;</span>';
                                            break;
                                        case 4:
                                            $status_text = '<span class="badge badge-primary">&nbsp;&nbsp;ผ่านโครงการสารสนเทศ 2&nbsp;&nbsp;</span>';
                                            break;
                                        case 5:
                                            $status_text = '<span class="badge badge-info">&nbsp;&nbsp;ผ่านโครงการสารสนเทศ 2 (conference)&nbsp;&nbsp;</span>';
                                            break;
                                    }
                                    ?>
                                    <?= $status_text ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p><strong>หัวข้อปริญญานิพนธ์ : </strong> <?= $project_name; ?></p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong>อาจารย์ที่ปรึกษา : </strong> <?= $teacher_fullname; ?></p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong>ผู้จัดทำ : </strong>
                                                <? foreach ($listprojectperson as $key => $list) { ?>
                                                    <span class="badge">&nbsp;&nbsp;<?= $list['std_title'] . '' . $list['std_fname'] . ' ' . $list['std_lname']; ?>&nbsp;&nbsp;</span>
                                                <? } ?>
                                            </p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong>เพิ่มข้อมูล :
                                                    <?= $project_create_name; ?>&nbsp;&nbsp;
                                                    <small class="text-muted">
                                                        <i class="fa fa-clock-o"></i>
                                                        <?= date('d/m/Y h:i A', strtotime($project_create_date)); ?>
                                                    </small>
                                                    <p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong>แก้ไขล่าสุด :
                                                    <?= $project_lastedit_name; ?>&nbsp;&nbsp;
                                                    <small class="text-muted">
                                                        <i class="fa fa-clock-o"></i>
                                                        <?= date('d/m/Y h:i A', strtotime($project_lastedit_date)); ?>
                                                    </small>
                                                    <p>
                                        </div>
                                    </div>
                            </li>
                        </ul>
                    </div>
                </div>
            <?PHP } else { ?>
                <form action="<?= base_url('student/stdprojectadd'); ?>" method="post" enctype="multipart/form-data" name="formProjectStd_Add" id="formProjectStd_Add" class="form-horizontal" novalidate>
                    <input type="hidden" name="formcrfaddproject" id="formcrfaddproject" value="<?= $formcrfaddproject; ?>">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><i class="fa fa-book"></i> &nbsp;&nbsp;เพิ่มข้อมูลปริญญานิพนธ์</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">หัวข้อปริญญานิพนธ์ :<span class="text-muted" style="color:#c0392b">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="project_name" id="project_name" class="form-control" maxlength="255">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">อาจารย์ที่ปรึกษา :<span class="text-muted" style="color:#c0392b">*</span></label>
                                <div class="col-sm-9">
                                    <select name="use_id" id="use_id" class="form-control">
                                        <option value="">กรุณาเลือกอาจารย์ที่ปรึกษา</option>
                                        <?PHP foreach ($listuser as $key => $value) { ?>
                                            <option value="<?= $value['use_id']; ?>"><?= $value['use_name']; ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">ผู้จัดทำ :<span class="text-muted" style="color:#c0392b">*</span></label>
                                <div class="col-sm-9">
                                    <select name="std_id[]" id="std_id" class="form-control select2" data-placeholder="กรุณาเลือกที่ผู้จัดทำ" multiple>
                                        <?PHP foreach ($liststd as $key => $value) { ?>
                                            <option value="<?= $value['std_id']; ?>"><?= $value['std_fname'] . ' ' . $value['std_lname']; ?></option>
                                        <? } ?>
                                    </select>
                                    <label class="error"> สามารถเลือกได้มากกว่า 1 คน **</label>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <button type="submit" class="btn btn-primary btn-block">บันทึก</button>
                        </div>
                    </div>
                </form>
            <? } ?>

            <? if (count($lastProject) != 0) { ?>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-book"></i> &nbsp;&nbsp;ประวัติปริญญานิพนธ์</h5>
                    </div>
                    <div class="ibox-content">
                        <ul class="list-group">
                            <?PHP foreach ($lastProject as $key => $v) {
                                    $this->db->select('*');
                                    $this->db->from('tb_projectperson');
                                    $this->db->join('tb_student', 'tb_student.std_id = tb_projectperson.std_id');
                                    $this->db->join('tb_project', 'tb_project.project_id = tb_projectperson.project_id');
                                    $this->db->where(array('tb_projectperson.project_id' => $v['project_id']));
                                    $query = $this->db->get();
                                    $projectperson = $query->result_array();
                                    ?>
                                <li class="list-group-item">
                                    <span class="badge badge-danger">&nbsp;&nbsp;ยกเลิกโปรเจค&nbsp;&nbsp;</span>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p><strong>หัวข้อปริญญานิพนธ์ : </strong> <?= $v['project_name']; ?></p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong>อาจารย์ที่ปรึกษา : </strong> <?= $v['use_name']; ?></p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong>ผู้จัดทำ : </strong>
                                                <?PHP foreach ($projectperson as $key => $list) { ?>
                                                    <span class="badge">&nbsp;&nbsp;<?= $list['std_title'] . '' . $list['std_fname'] . ' ' . $list['std_lname']; ?>&nbsp;&nbsp;</span>
                                                <? } ?>
                                            </p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong>เพิ่มข้อมูล :
                                                    <?= $v['project_create_name']; ?>&nbsp;&nbsp;
                                                    <small class="text-muted">
                                                        <i class="fa fa-clock-o"></i>
                                                        <?= date('d/m/Y h:i A', strtotime($v['project_create_date'])); ?>
                                                    </small>
                                                    <p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p><strong>แก้ไขล่าสุด :
                                                    <?= $v['project_lastedit_name']; ?>&nbsp;&nbsp;
                                                    <small class="text-muted">
                                                        <i class="fa fa-clock-o"></i>
                                                        <?= date('d/m/Y h:i A', strtotime($v['project_lastedit_date'])); ?>
                                                    </small>
                                                    <p>
                                        </div>
                                    </div>
                                </li>
                            <? } ?>
                        </ul>
                    </div>
                </div>
            <? } ?>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-book"></i> &nbsp;&nbsp;ข้อมูลเอกสาร</h5>

                    <div class="ibox-tools">
                        <button class="btn btn-outline btn-primary btn-sm" data-toggle="modal" data-target="#ProjectfileStd_Add">เพิ่มเอกสาร</button>
                    </div>

                </div>
                <div class="ibox-content">
                    <? if (count($listfile) != 0) { ?>
                        <ul class="list-group">
                            <? foreach ($listfile as $key => $value) {
                                    $this->db->select('*');
                                    $this->db->from('tb_trace');
                                    $this->db->join('tb_projectfile', 'tb_projectfile.file_id = tb_trace.file_id');
                                    $this->db->join('tb_user', 'tb_user.use_id = tb_trace.use_id');
                                    $this->db->where(array('tb_trace.file_id' => $value['file_id']));
                                    $query_tag = $this->db->get();
                                    $listtag = $query_tag->result_array();
                                    ?>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <h4>
                                                <?= $value['file_name']; ?><br>
                                            </h4>
                                            <div class="tagfile tooltip-demo">
                                                <ul>
                                                    <? foreach ($listtag as $key => $tag) { ?>
                                                        <li data-toggle="tooltip" data-placement="bottom" title="<?=$tag['use_name'];?>"><a href="#"><?= substr($tag['use_email'], 0, 1); ?></a></li>
                                                    <? } ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-warning"><i class="fa fa-refresh"></i></i></i></button>
                                            <button class="btn btn-danger"><i class="fa fa-trash-o"></i></i></i></button>
                                        </div>
                                    </div>
                                </li>    
                            <? } ?>
                        </ul>
                    <? } else { ?>
                        <center>ไม่มีพบเอกสาร</center>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="<?= base_url('student/stdprojectupdate'); ?>" method="post" enctype="multipart/form-data" name="formProjectStd_Up" id="formProjectStd_Up" class="form-horizontal" novalidate>
    <div class="modal fade" id="ProjectStd_Up" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลปริญญานิพนธ์</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="formcrfupproject" id="formcrfupproject" value="<?= $formcrfupproject; ?>">
                    <input type="hidden" name="project_id" id="project_id" value="<?= $project_id; ?>">
                    <div class="form-group row">
                        <label class="col-sm-12">ข้อมูลปริญญานิพนธ์<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" name="project_name" id="project_name" class="form-control" maxlength="255" value="<?= $project_name; ?>">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">อาจารย์ที่ปรึกษา<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <select name="use_id" id="use_id" class="form-control">
                                <?PHP foreach ($listuser as $key => $value) { ?>
                                    <option value="<?= $value['use_id']; ?>" <? if ($teacher_id == $value['use_id']) {
                                                                                        echo 'selected';
                                                                                    } ?>><?= $value['use_name']; ?></option>
                                <? } ?>
                            </select>
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

<form action="<?= base_url('student/stdprojectaddfile'); ?>" method="post" enctype="multipart/form-data" name="formProjectfileStd_Add" id="formProjectfileStd_Add" class="form-horizontal" novalidate>
    <div class="modal fade" id="ProjectfileStd_Add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">เพิ่มเอกสาร</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="formcrffileproject" id="formcrffileproject" value="<?= $formcrffileproject; ?>">
                    <input type="hidden" name="project_id" id="project_id" value="<?= $project_id; ?>">
                    <div class="form-group row">
                        <label class="col-sm-12">เลือกไฟล์<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input type="file" name="file_name" id="file_name" class="form-control" accept="application/pdf">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">ชื่อไฟล์<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <select name="proformat_name" id="proformat_name" class="form-control">
                                <option value="">กรุณาเลือกชื่อไฟล์</option>
                                <?PHP foreach ($listformat as $key => $value) { ?>
                                    <option value="<?= $value['proformat_name']; ?>"><?= $value['proformat_name']; ?></option>
                                <? } ?>
                            </select>
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