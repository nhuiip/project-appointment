<?php
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
?>
<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>ข้อมูลปริญญานิพนธ์</h2>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('dashboard/index'); ?>">หน้าแรก</a></li>
            <li class="active"><strong>ข้อมูลปริญญานิพนธ์</strong></li>
        </ol>
    </div>
</div>
<!-- End breadcrumb for page -->
<div class="row wrapper white-bg">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content" style="padding: 15px 0 20px;">
                <div class="col-md-3 col-md-offset-8 pull-right" style="padding-left: 0;padding-right: 0;">
                    <!-- ถ่้ามีข้อมูล -->
                    <? if (count($listdata) != 0) { ?>
                        <!-- ค้นหา -->
                        <div class="input-group">
                            <input type="text" placeholder="Search" name="search-input" id="search-input" class="form-control">
                            <span class="input-group-btn">
                                <button type="button" id="search-btn" class="btn btn-default">ค้นหา</button>
                            </span>
                        </div>
                    <? } ?>
                </div>
                <!-- ปุ่ม Export -->
                <div class="col-md-1" style="padding-left: 0;padding-right: 0;">
                    <? if (count($listdata) != 0) { ?>
                        <button class=" btn btn-default btn-block" id="btnexport"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp; Excel</button>
                    <? } ?>
                </div>
                <!-- table ------------------------------------------------------------------------------------------------------->
                <? if (count($listdata) != 0) { ?>
                    <table class="table table-hover table-bordered dataTables-export" width="100%" data-filename="project-data" data-colexport="2,3,4,5,7,8">
                        <thead>
                            <tr>
                                <th></th>
                                <th>รหัสปริญญานิพนธ์</th>
                                <th>ชื่อปริญญานิพนธ์</th>
                                <th>อาจารย์ที่ปรึกษา</th>
                                <th>ผู้จัดทำปริญญานิพนธ์</th>
                                <th>
                                    <center>สถานะปริญญานิพนธ์</center>
                                </th>
                                <th></th>
                                <th class="none">วันที่สร้าง</th>
                                <th class="none">แก้ไขล่าสุด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?PHP foreach ($listdata as $key => $value) {
                                    $this->db->select('*');
                                    $this->db->from('tb_projectperson');
                                    $this->db->join('tb_student', 'tb_student.std_id = tb_projectperson.std_id');
                                    $this->db->join('tb_project', 'tb_project.project_id = tb_projectperson.project_id');
                                    $this->db->where(array('tb_projectperson.project_id' => $value['project_id']));
                                    $query = $this->db->get();
                                    $projectperson = $query->result_array();
                                    switch ($value['project_status']) {
                                        case 0:
                                            $status_text = '<span class="content red">ยกเลิกโปรเจค</span>';
                                            break;
                                        case 1:
                                            $status_text = '<span class="tag">เริ่มต้น</span>';
                                            break;
                                        case 2:
                                            $status_text = '<span class="tag">สอบหัวข้อปริญญานิพนธ์</span><span class="content green">ผ่าน</span>';
                                            break;
                                        case 3:
                                            $status_text = '<span class="tag">สอบหัวข้อปริญญานิพนธ์</span><span class="content orange">ผ่านแบบมีเงื่อนไข</span>';
                                            break;
                                        case 4:
                                            $status_text = '<span class="tag">สอบหัวข้อปริญญานิพนธ์</span><span class="content red">ตก</span>';
                                            break;
                                        case 5:
                                            $status_text = '<span class="tag">สอบป้องกันปริญญานิพนธ์</span><span class="content green">Conference</span>';
                                            break;
                                        case 6:
                                            $status_text = '<span class="tag">สอบป้องกันปริญญานิพนธ์</span><span class="content green">ผ่าน</span>';
                                            break;
                                        case 7:
                                            $status_text = '<span class="tag">สอบป้องกันปริญญานิพนธ์</span><span class="content orange">ผ่านแบบมีเงื่อนไข</span>';
                                            break;
                                        case 8:
                                            $status_text = '<span class="tag">สอบป้องกันปริญญานิพนธ์</span><span class="content red">ตก</span>';
                                            break;
                                    }
                                    ?>
                                    <tr class="gradeX">
                                        <td width="1%"></td>
                                        <td width="9%"><strong><?= "PRO" . str_pad($value['project_id'], 3, "0", STR_PAD_LEFT); ?></strong></td>
                                        <td width="25%"><?= $value['project_name'] ?></td>
                                        <td width="15%"><?= $value['use_name']; ?></td>
                                        <td width="25%">
                                            <?PHP foreach ($projectperson as $key => $list) { ?>
                                                <span class="badges alt"><span class="content gray"><?= $list['std_title'] . '' . $list['std_fname'] . ' ' . $list['std_lname']; ?></span></span>
                                            <? } ?>
                                        </td>
                                        <td width="18%">
                                            <div class="badges alt" style="margin-bottom: 10px;"><?= $status_text ?></div>
                                        </td>
                                        <td width="5%">
                                            <center class="tooltip-demo">
                                                <a href="<?= site_url('project/detail/' . $value['project_id']); ?>">
                                                    <button class="btn btn-default" data-toggle="tooltip" data-placement="top" title="ข้อมูลเพิ่มเติม">
                                                        <i class="fa fa-chevron-right"></i>
                                                    </button>
                                                </a>
                                            </center>
                                        </td>
                                        <td>
                                            <?= $value['project_create_name']; ?>
                                            <small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['project_create_date']); ?> <?= date('h:i A', strtotime($value['project_create_date'])); ?></small>
                                        </td>
                                        <td>
                                            <?= $value['project_lastedit_name']; ?>
                                            <small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['project_lastedit_date']); ?> <?= date('h:i A', strtotime($value['project_lastedit_date'])); ?></small>
                                        </td>

                                    </tr>
                                <?PHP } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th class="ftinput">ปริญญานิพนธ์</th>
                                <th class="ftinput">อาจารย์ที่ปรึกษา</th>
                                <th class="ftinput">ผู้จัดทำ</th>
                                <th class="ftinput">สถานะปริญญานิพนธ์</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                <? } else { ?>
                    <div class="col-lg-12" style="padding-left: 0;padding-right: 0;">
                        <hr>
                        <center>
                            <p>ไม่พบข้อมูล</p>
                        </center>
                    </div>
                <? } ?>
                <!-- */table ----------------------------------------------------------------------------------------------------->
            </div>
        </div>
    </div>
</div>