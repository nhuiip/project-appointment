<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>ข้อมูลปริญญานิพนธ์</h2>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('project/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))); ?>">หน้าแรก</a></li>
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
                <div class="ibox-content">
                    <!-- table ------------------------------------------------------------------------------------------------------->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-export" data-colexport="0,1,2,3,4" data-filename="export-project" width="100%">
                            <thead>
                                <tr>
                                    <th>รหัสปริญญานิพนธ์</th>
                                    <th>ชื่อปริญญานิพนธ์</th>
                                    <th>ผู้จัดทำปริญญานิพนธ์</th>
                                    <th>สถานะปริญญานิพนธ์</th>
                                    <th>วันที่สร้าง</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?PHP foreach ($listdata as $key => $value) { ?>
                                    <tr class="gradeX">
                                        <td width="5%" style="vertical-align:top"><strong><?= "PRO" . str_pad($value['project_id'], 5, "0", STR_PAD_LEFT); ?></strong></td>
                                        <td width="10%" style="vertical-align:top"><?= $value['project_name'] ?></td>
                                        <td width="15%" style="vertical-align:top">
                                            <?PHP
                                                if ($value['std_id']  != '') {
                                                    $stypesVal = explode(",", $value['std_id']);
                                                } else {
                                                    $stypesVal = '';
                                                }

                                                if (count($stypesVal) != 0) {
                                                    foreach ($stypesVal as $key => $values) {

                                                        $this->db->select('std_id,std_number,std_title,std_fname,std_lname');
                                                        $this->db->where(array('std_id' => $values));
                                                        $query_student = $this->db->get('tb_student');
                                                        $liststudent = $query_student->result_array();
                                                        ?>
                                                    <div class="form-group">
                                                        <label><?= $liststudent[0]['std_number'] ?> <?= $liststudent[0]['std_title'] ?><?= $liststudent[0]['std_fname'] ?> <?= $liststudent[0]['std_lname'] ?></label>
                                                    </div>
                                            <?PHP
                                                    }
                                                }
                                                ?>
                                        </td>
                                        <td width="10%" style="vertical-align:top">
                                            <?PHP if ($value['project_status'] == 1) { ?>
                                                ยังไม่สอบโครงงานหนึ่ง
                                            <?PHP } else if ($value['project_status'] == 2) { ?>
                                                ผ่านโครงงานหนึ่ง
                                            <?PHP } else if ($value['project_status'] == 3) { ?>
                                                สอบโครงงานสองแล้วติดแก้ไข
                                            <?PHP } else if ($value['project_status'] == 4) { ?>
                                                สอบโครงงานสองผ่าน
                                            <?PHP } else if ($value['project_status'] == 0) { ?>
                                                เปลี่ยนหัวข้อปริญญานิพนธ์
                                            <?PHP } ?>
                                        </td>
                                        <td width="10%" style="vertical-align:top"><?= $value['project_create_name'] ?><br /><?= $value['project_create_date'] ?></td>
                                    </tr>
                                <?PHP } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="ftinput">ปริญญานิพนธ์</th>
                                    <th class="ftinput">ชื่อ-สกุล นักศึกษา</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- */table ----------------------------------------------------------------------------------------------------->
                </div>
            </div>
        </div>
    </div>
</div>