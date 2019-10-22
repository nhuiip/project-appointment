<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>จัดการรายวิชา</h2>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('dashboard/index'); ?>">หน้าแรก</a></li>
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
                                <i class="fa fa-times" style="color:#ed5565"></i> &nbsp;&nbsp;ระบบยังไม่เปิดใช้งานไม่สามารถเพิ่มข้อมูลได้
                            </a>
                        <? } ?>
                        <? if ($checkinsert == 'no') { ?>
                            <button type="button" class="btn btn-outline btn-primary" disabled><i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล</button>
                        <? } else { ?>
                            <button type="button" data-toggle="modal" data-target="#U-insert" class="btn btn-outline btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล</button>
                        <? } ?> 
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
                                    <th>
                                        <center>ประเภท</center>
                                    </th>
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
                                                    <? if ($value['use_id'] == $this->encryption->decrypt($this->input->cookie('sysli')) || $this->encryption->decrypt($this->input->cookie('sysp')) == 'ผู้ดูแลระบบ') { ?>
                                                        <li><a href="#" data-toggle="modal" data-target="#U-update" class="update" data-sub_id="<?= $value['sub_id']; ?>" data-sub_name="<?= $value['sub_name']; ?>" data-sub_code="<?= $value['sub_code']; ?>" data-use_id="<?= $value['use_id']; ?>" data-sub_setuse="<?= $value['sub_setuse']; ?>" data-sub_setless="<?= $value['sub_setless']; ?>" data-sub_type="<?= $value['sub_type']; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;แก้ไขข้อมูล</a></li>
                                                        <?PHP if($value['sub_status'] != 0){ ?>
                                                        <li><a class="btn-alert" href="#" data-url="<?=site_url('subject/updateclose/' . $value['sub_id']); ?>" data-title="ต้องการปิดรายวิชา?"><i class="fa fa-times"></i>&nbsp;&nbsp;&nbsp;ปิดรายวิชา</a></li>
                                                        <?PHP }else{?>
                                                            <li><a class="btn-alert" href="#" data-url="<?=site_url('subject/updateopen/' . $value['sub_id']); ?>" data-title="ต้องการเปิดรายวิชา?"><i class="fa fa-times"></i>&nbsp;&nbsp;&nbsp;เปิดรายวิชา</a></li>   
                                                        <?PHP } ?>
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
                                                    <span class="badge badge-danger">ปิดรายวิชา</span>
                                                <? } elseif ($value['sub_status'] == 1) { ?>
                                                    <span class="badge badge-warning">เปิดสอนอยู่</span>
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

<!-- model insert -->
<div class="modal fade" id="U-insert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">เพิ่มข้อมูลรายวิชา</h4>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('subject/create'); ?>" method="post" enctype="multipart/form-data" name="formSubject" id="formSubject" class="form-horizontal" novalidate>
                    <input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
                    <input type="hidden" name="set_id" id="set_id" value="<?= $set_id; ?>">
                    <div class="form-group row">
                        <label class="col-sm-12">ชื่อวิชา<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" name="sub_name" id="sub_name" value="" class="form-control" maxlength="255">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">รหัสวิชา<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" name="sub_code" id="sub_code" value="" class="form-control" maxlength="255">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">อาจารย์ผู้สอน<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="use_id" id="use_id">
                                <option value="">กรุณาเลือกข้อมูล</option>
                                <?PHP foreach ($user as $key => $value) { ?>
                                    <option value="<?= $value['use_id'] ?>"><?= $value['use_name'] ?></option>
                                <?PHP } ?>
                            </select>
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">จำนวนอาจารย์ขึ้นสอบ<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input class="form-control" type="number" name="sub_setuse" id="sub_setuse" value="">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">อาจารย์ขึ้นสอบอย่างน้อย<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input class="form-control" type="number" name="sub_setless" id="sub_setless" value="">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">ประเภทวิชา<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="sub_type" id="sub_type">
                                <option value="">กรุณาเลือกข้อมูล</option>
                                <option value="1">โครงการ 1</option>
                                <option value="2">โครงการ 2</option>
                            </select>
                        </div>
                    </div>
                    <!--*/form-group-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary">บันทึก</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- model update -->
<script>
    $('.update').click(function() {
        var sub_id = $(this).attr('data-sub_id');
        var sub_name = $(this).attr('data-sub_name');
        var sub_code = $(this).attr('data-sub_code');
        var use_id = $(this).attr('data-use_id');
        var sub_setuse = $(this).attr('data-sub_setuse');
        var sub_setless = $(this).attr('data-sub_setless');
        var sub_type = $(this).attr('data-sub_type');
        $(".sub_id").val(sub_id);
        $(".sub_name").val(sub_name);
        $(".sub_code").val(sub_code);
        $(".use_id").val(use_id);
        $(".sub_setuse").val(sub_setuse);
        $(".sub_setless").val(sub_setless);
        $(".sub_type").val(sub_type);
    });
</script>
<div class="modal fade" id="U-update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลรายวิชา</h4>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('subject/update'); ?>" method="post" enctype="multipart/form-data" name="formSubject_Up" id="formSubject_Up" class="form-horizontal" novalidate>
                    <input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
                    <input type="hidden" name="Id" id="Id" value="" class="sub_id">
                    <div class="form-group row">
                        <label class="col-sm-12">ชื่อวิชา<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" name="sub_name" id="sub_name" value="" class="form-control sub_name" maxlength="255">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">รหัสวิชา<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" name="sub_code" id="sub_code" value="" class="form-control sub_code" maxlength="255">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">อาจารย์ผู้สอน<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <select class="form-control use_id" name="use_id" id="use_id">
                                <option value="">กรุณาเลือกข้อมูล</option>
                                <?PHP foreach ($user as $key => $value) { ?>
                                    <option value="<?= $value['use_id'] ?>"><?= $value['use_name'] ?></option>
                                <?PHP } ?>
                            </select>
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">จำนวนอาจารย์ขึ้นสอบ<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input class="form-control sub_setuse" type="number" name="sub_setuse" id="sub_setuse" value="">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">อาจารย์ขึ้นสอบอย่างน้อย<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <input class="form-control sub_setless" type="number" name="sub_setless" id="sub_setless" value="">
                        </div>
                    </div>
                    <!--*/form-group-->
                    <div class="form-group row">
                        <label class="col-sm-12">ประเภทวิชา<span class="text-muted" style="color:#c0392b">*</span></label>
                        <div class="col-sm-12">
                            <select class="form-control sub_type" name="sub_type" id="sub_type">
                                <option value="">กรุณาเลือกข้อมูล</option>
                                <option value="1">โครงการ 1</option>
                                <option value="2">โครงการ 2</option>
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