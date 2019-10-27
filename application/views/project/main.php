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
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="ibox-tools">

                    </div>
                </div>
                < class="ibox-content">
                    <!-- table ------------------------------------------------------------------------------------------------------->
                    <? if (count($listdata) != 0) { ?>
                        <table class="table table-striped table-hover dataTables-export" data-colexport="1,2,3,4,5" data-filename="export-project" width="100%">
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
                                                $status_text = '<span class="badge badge-danger">&nbsp;&nbsp;ยกเลิกโปรเจค&nbsp;&nbsp;</span>';
                                                break;
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
                                        <tr class="gradeX">
                                            <td width="1%"></td>
                                            <td width="9%"><strong><?= "PRO" . str_pad($value['project_id'], 3, "0", STR_PAD_LEFT); ?></strong></td>
                                            <td width="30%"><?= $value['project_name'] ?></td>
                                            <td width="15%"><?= $value['use_name']; ?></td>
                                            <td width="25%">
                                                <?PHP foreach ($projectperson as $key => $list) { ?>
                                                    <span class="badge">&nbsp;&nbsp;<?= $list['std_title'] . '' . $list['std_fname'] . ' ' . $list['std_lname']; ?>&nbsp;&nbsp;</span>
                                                <? } ?>
                                            </td>
                                            <td width="15%">
                                                <center><?= $status_text ?></center>
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
                                                <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['project_create_date'])); ?></small>
                                            </td>
                                            <td>
                                                <?= $value['project_lastedit_name']; ?>
                                                <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['project_lastedit_date'])); ?></small>
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
                        <center>ไม่พบข้อมูล</center>
                    <? } ?>
                    <!-- */table ----------------------------------------------------------------------------------------------------->
            </div>
        </div>
    </div>
</div>
</div>