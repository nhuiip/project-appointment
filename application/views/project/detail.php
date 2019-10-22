<?
//ค้นหาโปรเจคที่นักศึกษาสร้างไว้
if (isset($listProject) && count($listProject) != 0) {
    foreach ($listProject as $key => $value) {
        $project_id             = $value['project_id'];
        $project_name           = $value['project_name'];
        $project_status         = $value['project_status'];
        $teacher_fullname       = $value['use_name'];
        $teacher_id             = $value['use_id'];
        $project_create_name    = $value['project_create_name'];
        $project_create_date    = $value['project_create_date'];
        $project_lastedit_name  = $value['project_lastedit_name'];
        $project_lastedit_date  = $value['project_lastedit_date'];
    }
}
?>
<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>ข้อมูล :: <?= $project_name; ?></h2>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('dashboard/index') ?>">หน้าแรก</a></li>
            <li class="active"><strong>รายปริญญานิพนธ์</strong></li>
        </ol>
    </div>
</div>
<!-- End breadcrumb for page -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-6">
            <!-- now project -->
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-book"></i> &nbsp;&nbsp;ข้อมูลปริญญานิพนธ์</h5>
                </div>
                <div class="ibox-content">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <?
                            switch ($project_status) {
                                case 1:
                                    $status_text = '<span class="badge" style="margin-bottom: 15px;">&nbsp;&nbsp;เริ่มต้น&nbsp;&nbsp;</span>';
                                    break;
                                case 2:
                                    $status_text = '<span class="badge badge-primary" style="margin-bottom: 15px;">&nbsp;&nbsp;ผ่านโครงการสารสนเทศ 1&nbsp;&nbsp;</span>';
                                    break;
                                case 3:
                                    $status_text = '<span class="badge badge-warning" style="margin-bottom: 15px;">&nbsp;&nbsp;ติดแก้ไขโครงการสารสนเทศ 2&nbsp;&nbsp;</span>';
                                    break;
                                case 4:
                                    $status_text = '<span class="badge badge-primary" style="margin-bottom: 15px;">&nbsp;&nbsp;ผ่านโครงการสารสนเทศ 2&nbsp;&nbsp;</span>';
                                    break;
                                case 5:
                                    $status_text = '<span class="badge badge-info" style="margin-bottom: 15px;">&nbsp;&nbsp;ผ่านโครงการสารสนเทศ 2 (conference)&nbsp;&nbsp;</span>';
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
                                            <? foreach ($listPerson as $key => $list) { ?>
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
            <!-- conference data -->
            <? if ($project_status == 5) { ?>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-book"></i> &nbsp;&nbsp;Conference</h5>
                    </div>
                    <div class="ibox-content">
                        <ul class="list-group">
                            <li class="list-group-item">
                            </li>
                        </ul>
                    </div>
                </div>
            <? } ?>
        </div>
        <div class="col-md-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-book"></i> &nbsp;&nbsp;ข้อมูลเอกสาร</h5>

                    <div class="ibox-tools">
                        <button class="btn btn-outline btn-primary btn-sm" data-toggle="modal" data-target="#ProjectfileStd_Add">เพิ่มเอกสาร</button>
                    </div>

                </div>
                <div class="ibox-content">
                    <? if (count($listFile) != 0) { ?>
                        <ul class="list-group">
                            <? foreach ($listFile as $key => $value) {
                                    $this->db->select('*');
                                    $this->db->from('tb_trace');
                                    $this->db->join('tb_projectfile', 'tb_projectfile.file_id = tb_trace.file_id');
                                    $this->db->join('tb_user', 'tb_user.use_id = tb_trace.use_id');
                                    $this->db->where(array('tb_trace.file_id' => $value['file_id']));
                                    $query_tag = $this->db->get();
                                    $listtag = $query_tag->result_array();

                                    $position = $this->encryption->decrypt($this->input->cookie('sysp'));
                                    $useid = $this->encryption->decrypt($this->input->cookie('sysli'));

                                    ?>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <h3 style="margin-top: 15px;">
                                                <?= $value['file_name']; ?><br>
                                            </h3>
                                        </div>
                                        <div class="col-sm-5" style="text-align: right;">
                                            <? if ($position == 'หัวหน้าสาขา' || $position == 'อาจารย์ผู้สอน') { ?>
                                                <button class="btn btn-white btn-trace" data-geturl="<?= base_url('uploads/fileproject/Project_' . $project_id . '/' . $value['file_name']); ?>" data-url="<?= site_url('project/loadfile/' . $value['file_id'] . '/' . $useid); ?>">
                                                    <i class="fa fa-download"></i>
                                                </button>
                                            <? } ?>
                                            <? if ($position == 'ผู้ดูแลระบบ') { ?>
                                                <a href="<?= base_url('uploads/fileproject/Project_' . $project_id . '/' . $value['file_name']); ?>"></a>
                                            <? } ?>
                                        </div>
                                        <? if (count($listtag) != 0) { ?>
                                            <div class="col-sm-12 tooltip-demo" style="background-color: aliceblue;padding-top: 5px;padding-bottom: 5px;">
                                                <? foreach ($listtag as $key => $tag) { ?>
                                                    <span class="label label-success" style="text-transform: uppercase;margin-right:3px" data-toggle="tooltip" data-placement="bottom" title="<?= $tag['use_name']; ?>">
                                                        <?= substr($tag['use_email'], 0, 1); ?>
                                                    </span>
                                                <? } ?>
                                            </div>
                                        <? } ?>
                                    </div>
                                </li>
                            <? } ?>
                        </ul>
                    <? } else { ?>
                        <center>ไม่พบเอกสาร</center>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</div>