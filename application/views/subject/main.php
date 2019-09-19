<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>จัดการรายวิชา</h2>
        <ol class="breadcrumb">
            <li><a href="#">หน้าแรก</a></li>
            <li class="active"><strong>จัดการรายวิชา</strong></li>
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
                        <? if ($checkinsert == 'no') { ?>
                            <a class="btn btn-outline btn-white btn-bitbucket">
                                <i class="fa fa-times" style="color:#ed5565"></i> &nbsp;&nbsp;ระบบยังไม่เปิดใช้งานไม่สามารถเพิ่่มข้อมูลได้
                            </a>
                        <? } ?>
                        <a href="<?= site_url('subject/form/'); ?>" style="color:#27ae60">
                            <button type="button" class="btn btn-outline btn-primary" <? if ($checkinsert == 'no') {echo 'disabled';} ?>><i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล</button>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <!-- table ------------------------------------------------------------------------------------------------------->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>วิชา</th>
                                    <th>อาจารย์ผู้สอน</th>
                                    <th>เพิ่มข้อมูล</th>
                                    <th>แก้ไขล่าสุด</th>
                                    <th></th>
                                    <th><center>ประเภท</center></th>
                                    <th>
                                        <center>สถานะ</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($listdata as $key => $value) { ?>
                                    <tr class="gradeX">
                                        <td width="5%"><strong><?= "S" . str_pad($value['sub_id'], 5, "0", STR_PAD_LEFT); ?></strong></td>
                                        <td width="20%"><?= $value['sub_name'] ?><br /><small><?= $value['sub_code'] ?></small></td>
                                        <td width="15%"><?= $value['use_name'] ?></td>
                                        <td width="15%">
                                            <?= $value['sub_create_name']; ?><br />
                                            <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['sub_create_date'])); ?></small>
                                        </td>
                                        <td width="15%">
                                            <?= $value['sub_lastedit_name']; ?><br />
                                            <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['sub_lastedit_date'])); ?></small>
                                        </td>
                                        <td width="10%">
                                            <div class="btn-group" style="width:100%">
                                                <button class="btn btn-sm btn-primary " type="button" style="width:70%">จัดการ</button>
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:30%;">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" style="width:100%">
                                                    <? if ($value['use_id'] == $this->encryption->decrypt($this->input->cookie('sysi')) || $this->encryption->decrypt($this->input->cookie('sysp')) == 'ผู้ดูแลระบบ' || $this->encryption->decrypt($this->input->cookie('sysp')) == 'ฉุกเฉิน') { ?>
                                                        <li><a href="<?= site_url('subject/form/' . $value['sub_id']); ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;แก้ไขข้อมูล</a></li>
                                                        <li><a href="#" class="btn-alert" data-url="<?= site_url('subject/delete/' . $value['sub_id']); ?>" data-text="ต้องการลบข้อมูล?"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;ลบข้อมูล</a></li>
                                                    <? } ?>
                                                </ul>
                                            </div>
                                        </td>
                                        <td width="10%">
                                            <center>
                                                <? if ($value['sub_type'] == 1) { ?>
                                                    <span class="badge">โครงการ 1</span>
                                                <? } elseif ($value['sub_type'] == 2) { ?>
                                                    <span class="badge">โครงการ 2</span>
                                                <? } ?>
                                            </center>
                                        </td>
                                        <td width="10%">
                                            <center>
                                                <? if ($value['sub_status'] == 0) { ?>
                                                    <span class="badge badge-danger">ปิด</span>
                                                <? } elseif ($value['sub_status'] == 1) { ?>
                                                    <span class="badge badge-warning">เปิดสอนอยู๋</span>
                                                <? } ?>
                                            </center>
                                        </td>
                                    </tr>
                                <? } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="ftinput">วิชา</th>
                                    <th class="ftinput">อาจารย์ผู้สอน</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="ftinput">ประเภท</th>
                                    <th class="ftinput">สถานะ</th>
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
