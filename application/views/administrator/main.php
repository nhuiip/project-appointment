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
    <h2>จัดการข้อมูลผู้ใช้</h2>
    <ol class="breadcrumb">
      <li><a href="<?= site_url('dashboard/index'); ?>">หน้าแรก</a></li>
      <li class="active"><strong>จัดการข้อมูลผู้ใช้</strong></li>
    </ol>
  </div>
</div>
<!-- End breadcrumb for page -->
<div class="row wrapper white-bg">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-content" style="padding: 15px 0 20px;">
        <div class="col-md-4 col-md-offset-7 pull-right" style="padding-left: 0;padding-right: 0;">
          <!-- ปุ่มเพิ่มข้อมูล -->
          <button type="button" class="btn btn-outline btn-primary pull-right" data-toggle="modal" data-target="#U-insert">
            <i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล
          </button>
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
          <table class="table table-hover table-bordered dataTables-export" width="100%" data-filename="user-data" data-colexport="1,2,3,4,6">
            <thead>
              <tr>
                <th>#</th>
                <th>ชื่อเต็ม</th>
                <th>Email</th>
                <th>เพิ่มข้อมูล</th>
                <th>แก้ไขล่าสุด</th>
                <th></th>
                <th>เข้าใช้ล่าสุด</th>
              </tr>
            </thead>
            <tbody>
              <?PHP foreach ($listdata as $key => $value) { ?>
                <tr class="gradeX">
                  <td width="5%"><strong><?= "A" . str_pad($value['use_id'], 3, "0", STR_PAD_LEFT); ?></strong></td>
                  <td width="20%"><?= $value['use_name'] ?><br /><small><?= $value['position_name'] ?></small></td>
                  <td width="20%"><?= $value['use_email'] ?></td>
                  <td width="15%">
                    <?= $value['use_create_name']; ?><br />
                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['use_create_date']); ?> <?= date('h:i A', strtotime($value['use_create_date'])); ?></small>
                  </td>
                  <td width="15%">
                    <?= $value['use_lastedit_name']; ?><br />
                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['use_lastedit_date']); ?> <?= date('h:i A', strtotime($value['use_lastedit_date'])); ?></small>
                  </td>
                  <td width="10%">
                    <div class="btn-group" style="width:100%">
                      <button class="btn btn-sm btn-default " type="button" style="width:70%">จัดการ</button>
                      <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:30%;">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" style="width:100%">
                        <li>
                          <a href="#" data-use_id="<?= $value['use_id']; ?>" data-use_name="<?= $value['use_name']; ?>" data-position_id="<?= $value['position_id']; ?>" data-use_email="<?= $value['use_email']; ?>" data-toggle="modal" data-target="#U-update" class="update">
                            <i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;แก้ไขข้อมูล
                          </a>
                        </li>
                        <li><a href="#" data-use_id="<?= $value['use_id']; ?>" data-toggle="modal" data-target="#U-repass" class="btnrepass"><i class="fa fa-repeat"></i>&nbsp;&nbsp;&nbsp;เปลี่ยนรหัสผ่าน</a></li>
                        <li><a href="#" class="btn-alert" data-url="<?= site_url('administrator/delete/' . $value['use_id']); ?>" data-title="ต้องการลบข้อมูล?"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;ลบข้อมูล</a></li>
                      </ul>
                    </div>
                  </td>
                  <td width="15%">
                    <?PHP if ($value['use_lastlogin'] != "0000-00-00 00:00:00") { ?>
                      <i class="fa fa-clock-o"></i> <?= DateThai($value['use_lastlogin']); ?> <?= date('h:i A', strtotime($value['use_lastlogin'])); ?> <?PHP } else { ?> - <?PHP } ?>
                  </td>
                </tr>
              <?PHP } ?>
            </tbody>
            <tfoot>
              <tr>
                <th></th>
                <th class="ftinput">ชื่อเต็ม</th>
                <th class="ftinput">Email</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </tfoot>
          </table>
          <!-- */table ----------------------------------------------------------------------------------------------------->
        <? } else { ?>
          <div class="col-lg-12" style="padding-left: 0;padding-right: 0;">
            <hr>
            <center>
              <p>ไม่พบข้อมูล</p>
            </center>
          </div>
        <? } ?>
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
        <h4 class="modal-title" id="myModalLabel">เพิ่มข้อมูลผู้ใช้</h4>
      </div>
      <div class="modal-body">
        <form action="<?= site_url('administrator/create'); ?>" method="post" enctype="multipart/form-data" name="formAdministrators_C" id="formAdministrators_C" class="form-horizontal" novalidate>
          <input type="hidden" name="formcrf" id="formcrfinsert" value="<?= $formcrf; ?>">
          <div class="form-group row">
            <label class="col-sm-12">ชื่อเต็ม<span class="text-muted" style="color:#c0392b">*</span></label>
            <div class="col-sm-12">
              <input type="text" name="use_name" value="" class="form-control">
            </div>
          </div>
          <!--*/form-group-->
          <?PHP if (count($listposition) != 0) { ?>
            <div class="form-group row">
              <label class="col-sm-12">ระดับผู้ใช้<span class="text-muted" style="color:#c0392b">*</span></label>
              <div class="col-sm-12">
                <select class="form-control" name="position_id">
                  <option value="">กรุณาเลือกข้อมูล</option>
                  <?PHP foreach ($listposition as $key => $value) { ?>
                    <option value="<?= $value['position_id'] ?>"><?= $value['position_name'] ?></option>
                  <?PHP } ?>
                </select>
              </div>
            </div>
            <!--*/form-group-->
          <?PHP } ?>
          <div class="form-group row">
            <label class="col-sm-12">อีเมล<span class="text-muted" style="color:#c0392b">*</span></label>
            <div class="col-sm-12">
              <input type="text" name="use_email" id="use_email" data-url="<?= site_url('administrator/checkemail'); ?>" class="form-control" value="">
            </div>
          </div>
          <!--*/form-group-->
          <div class="form-group row">
            <label class="col-sm-12">รหัสผ่าน<span class="text-muted" style="color:#c0392b">*</span></label>
            <div class="col-sm-12">
              <input type="password" name="use_pass" id="use_pass" class="form-control">
            </div>
          </div>
          <!--*/form-group-->
          <div class="form-group row">
            <label class="col-sm-12">ยืนยันรหัสผ่าน<span class="text-muted" style="color:#c0392b">*</span></label>
            <div class="col-sm-12">
              <input type="password" name="use_confirmPassword" id="use_confirmPassword" class="form-control">
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
    var use_id = $(this).attr('data-use_id');
    var use_name = $(this).attr('data-use_name');
    var position_id = $(this).attr('data-position_id');
    var use_email = $(this).attr('data-use_email');
    $(".use_id").val(use_id);
    $(".use_name").val(use_name);
    $(".position_id").val(position_id);
    $(".use_email").val(use_email);
  });
</script>
<div class="modal fade" id="U-update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลผู้ใช้</h4>
      </div>
      <div class="modal-body">
        <form action="<?= site_url('administrator/update'); ?>" method="post" enctype="multipart/form-data" name="formAdministrators_Up" id="formAdministrators_Up" class="form-horizontal" novalidate>
          <input type="hidden" name="formcrf" id="formcrfup" value="<?= $formcrf; ?>">
          <input type="hidden" name="Id" id="use_id" class="use_id">
          <input type="hidden" name="type" value="AM">
          <div class="form-group row">
            <label class="col-sm-12">ชื่อเต็ม<span class="text-muted" style="color:#c0392b">*</span></label>
            <div class="col-sm-12">
              <input type="text" name="use_name" id="use_name" value="" class="form-control use_name">
            </div>
          </div>
          <!--*/form-group-->
          <?PHP if (count($listposition) != 0) { ?>
            <div class="form-group row">
              <label class="col-sm-12">ระดับผู้ใช้<span class="text-muted" style="color:#c0392b">*</span></label>
              <div class="col-sm-12">
                <select class="form-control position_id" name="position_id">
                  <option value="">กรุณาเลือกข้อมูล</option>
                  <?PHP foreach ($listposition as $key => $value) { ?>
                    <option value="<?= $value['position_id'] ?>"><?= $value['position_name'] ?></option>
                  <?PHP } ?>
                </select>
              </div>
            </div>
            <!--*/form-group-->
          <?PHP } ?>
          <div class="form-group row">
            <label class="col-sm-12">อีเมล<span class="text-muted" style="color:#c0392b">*</span></label>
            <div class="col-sm-12">
              <input type="text" name="use_email" id="use_email_up" data-url="<?= site_url('administrator/checkemailup'); ?>" class="form-control use_email" value="">
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

<!-- model repass -->
<script>
  $('.btnrepass').click(function() {
    var use_id = $(this).attr('data-use_id');
    $(".useid").val(use_id);
  });
</script>

<div class="modal fade" id="U-repass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เปลี่ยนรหัสผ่าน</h4>
      </div>
      <div class="modal-body">
        <form action="<?= site_url('administrator/changepassword'); ?>" method="post" enctype="multipart/form-data" name="formRepass" id="formRepass" class="form-horizontal" novalidate>
          <input type="hidden" name="formcrf" id="formcrfpass" value="<?= $formcrf; ?>">
          <input type="hidden" name="Id" class="useid">
          <input type="hidden" name="type" value="AM">
          <div class="form-group row">
            <label class="col-sm-12">รหัสผ่าน<span class="text-muted" style="color:#c0392b">*</span></label>
            <div class="col-sm-12">
              <input type="password" name="use_pass" id="use_pass" class="form-control">
            </div>
          </div>
          <!--*/form-group-->
          <div class="form-group row">
            <label class="col-sm-12">ยืนยันรหัสผ่าน<span class="text-muted" style="color:#c0392b">*</span></label>
            <div class="col-sm-12">
              <input type="password" name="use_confirmPassword" id="use_confirmPassword" class="form-control">
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