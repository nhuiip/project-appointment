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
            <li><a href="<?= site_url('project/index') ?>">ข้อมูลปริญญานิพนธ์</a></li>
            <li class="active"><strong>รายละเอียดปริญญานิพนธ์</strong></li>
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
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-gears"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="upstatus" data-project_id="<?= $project_id ?>" data-project_name="<?= $project_name ?>" data-project_status="<?= $project_status ?>" data-toggle="modal" data-target="#Update"><i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp;แก้ไขสถานะ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="ibox-content">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <?
                            switch ($project_status) {
                                case 0:
                                    $status_text = '<span class="badge badge-danger">&nbsp;&nbsp;ยกเลิกโปรเจค&nbsp;&nbsp;</span>';
                                    break;
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
            <? if (isset($project_status) && $project_status == 5) { ?>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-book"></i> &nbsp;&nbsp;Conference</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-gears"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <? if (isset($listCon) && count($listCon) == 0) { ?>
                                    <li>
                                        <a href="#" class="ChooseType" data-toggle="modal" data-target="#ChooseType" data-project="<?=$project_id;?>">
                                            <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;เพิ่มข้อมูล conference
                                        </a>
                                    </li>
                                <? } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <? if (isset($listCon) && count($listCon) != 0) {
                                foreach ($listCon as $key => $value) {
                                    $conf_id            = $value['conf_id'];
                                    $conftype_id        = $value['conftype_id'];
                                    $conf_year          = $value['conf_year'];
                                    $conf_title         = $value['conf_title'];
                                    $conf_subtitle      = $value['conf_subtitle'];
                                    $conf_number        = $value['conf_number'];
                                    $conf_datepresent   = $value['conf_datepresent'];
                                    $conf_nopage        = $value['conf_nopage'];
                                    $conf_weight        = $value['conf_weight'];
                                    $conf_data          = $value['conf_data'];
                                    $conf_place         = $value['conf_place'];
                                    $conf_publisher     = $value['conf_publisher'];
                                }

                                $conf_year_text         = 'ปีที่พิมพ์';
                                $conf_weight_text       = 'ค่าน้ำหนัก';
                                $conf_publisher_text    = 'สำนักพิมพ์';
                            if($conftype_id == 1 || $conftype_id == 2){
                                $conf_title_text        = 'ชื่อบทความ';
                                $conf_subtitle_text     = 'ชื่อวารสาร';
                                $conf_number_text       = 'ปีที่ (ฉบับที่)';
                                $conf_datepresent_text  = 'เดือน ปี';
                                $conf_nopage_text       = 'เลขหน้า';
                                $conf_data_text         = 'ฐานข้อมูล';
                            } elseif ($conftype_id == 3 || $conftype_id == 4) {
                                $conf_title_text        = 'ชื่อเรื่อง';
                                $conf_subtitle_text     = 'ชื่อการประชุม';
                                $conf_datepresent_text  = 'วัน เดือน ปี ที่นำเสนอ';
                                $conf_nopage_text       = 'เลขหน้า';
                                $conf_place_text        = 'สถานที่จัด';
                            } elseif ($conftype_id == 5) {
                                $conf_title_text        = 'ชื่อหนังสือ';
                                $conf_number_text       = 'ครั้งที่พิมพ์';
                                $conf_nopage_text       = 'จำนานหน้า';
                                $conf_place_text        = 'สถานที่พิมพ์';
                                $conf_publisher_text    = 'สำนักพิมพ์';
                            } elseif ($conftype_id == 6) {
                                $conf_title_text        = 'ชื่อผลงาน';
                                $conf_datepresent_text  = 'เดือน ปี';
                                $conf_data_text         = 'แหล่งเผยแพร่ผลงาน';
                                $conf_place_text         = 'สถานที่เผยแพร่ผลงาน';
                            }
                        ?>
                            <ul class="list-group">
                                <li class="list-group-item">
                                </li>
                            </ul>
                        <? } else { ?>
                            <center>ไม่พบข้อมูล Conference</center>
                        <? } ?>

                    </div>
                </div>
            <? } ?>
        </div>
        <div class="col-md-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-book"></i> &nbsp;&nbsp;ข้อมูลเอกสาร</h5>
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
                                                <a class="btn btn-white btn-trace" data-geturl="<?= site_url('uploads/fileproject/Project_' . $value['project_id'] . '/' . $value['file_name']); ?>" data-title="ยืนยันการดาวน์โหลดไฟล์เอกสาร" data-url="<?= site_url('project/loadfile/' . $value['file_id'] . '/' . $useid); ?>">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            <? } ?>
                                            <? if ($position == 'ผู้ดูแลระบบ') { ?>
                                                <a href="<?= base_url('uploads/fileproject/Project_' . $project_id . '/' . $value['file_name']); ?>">
                                                    <button class="btn btn-white"><i class="fa fa-download"></i></button>
                                                </a>
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
<!-- model update -->
<script>
    $('.upstatus').click(function() {
        var project_id = $(this).attr('data-project_id');
        var project_name = $(this).attr('data-project_name');
        var project_status = $(this).attr('data-project_status');
        $("#project_id").val(project_id);
        $("#project_name").val(project_name);
        $("#project_status").val(project_status);
    });
</script>
<div class="modal fade" id="Update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลปริญญานิพนธ์</h4>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('project/updateData'); ?>" method="post" enctype="multipart/form-data" name="formProject_Up" id="formProject_Up" class="form-horizontal" novalidate>
                    <input type="hidden" name="type" id="type" value="projectdetail">
                    <input type="hidden" name="project_id" id="project_id">
                    <div class="form-group row">
                        <label class="col-sm-12">ชื่อปริญญานิพนธ์<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" name="project_name" id="project_name" class="form-control" readonly>
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">สถานะปริญญานิพนธ์<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="project_status" id="project_status">
                                <option value="">กรุณาเลือกข้อมูล</option>
                                <?PHP foreach ($status as $key => $value) { ?>
                                    <option value="<?= $value['project_status'] ?>"><?= $value['text'] ?></option>
                                <?PHP } ?>
                            </select>
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('.ChooseType').click(function() {
        var project = $(this).attr('data-project');
        $("#project_id_2").val(project);
    });
</script>
<div class="modal fade" id="ChooseType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">เพิ่มข้อมูล Conference</h4>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('conference/insertData'); ?>" method="post" enctype="multipart/form-data" name="formChooseType" id="formChooseType" class="form-horizontal" novalidate>
                    <input type="hidden" name="project_id" id="project_id_2">
                    <div class="form-group row">
                        <label class="col-sm-12">ประเภท Conference<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="project_status" id="project_status">
                                <option value="">กรุณาเลือกประเภท Conference</option>
                                <?PHP foreach ($listType as $key => $value) { ?>
                                    <option value="<?= $value['conftype_id'] ?>"><?= $value['conftype_name'] ?></option>
                                <?PHP } ?>
                            </select>
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>