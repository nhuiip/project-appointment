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
    <h2>อาจารย์พิเศษ</h2>
    <ol class="breadcrumb">
      <li><a href="<?= site_url('dashboard/index'); ?>">หน้าแรก</a></li>
      <li class="active"><strong>อาจารย์พิเศษ</strong></li>
    </ol>
  </div>
</div>
<!-- End breadcrumb for page -->
<div class="row wrapper white-bg">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-content" style="padding: 15px 0 20px;">
        <div class="info pull-right">
          <div class="badges alt"><span class="content red"><i class="fa fa-info"></i></i></span><span class="tag">หากระบบยังไม่เปิดใช้งานจะไม่สามารถเพิ่มข้อมูลได้</span></div>
        </div>
        <div class="col-md-4 col-md-offset-8" style="padding-left: 0;padding-right: 0;">
          <!-- ปุ่มเพิ่มข้อมูล -->
          <? if ($checkinsert == 'no') { ?>
            <button class="btn btn-outline btn-primary pull-right" disabled><i class="fa fa-plus"></i> เพิ่มข้อมูล</button>
          <? } else { ?>
            <button class="btn btn-outline btn-primary pull-right" data-toggle="modal" data-target="#insert"><i class="fa fa-plus"></i> เพิ่มข้อมูล</button>
          <? } ?>
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
        <? if (count($listdata) != 0) { ?>
          <!-- table ------------------------------------------------------------------------------------------------------->
          <table class="table table-hover table-bordered dataTables-export" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>ชื่อเต็ม</th>
                <th>เพิ่มข้อมูล</th>
                <th>แก้ไขล่าสุด</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?PHP foreach ($listdata as $key => $value) { ?>
                <tr class="gradeX">
                  <td width="5%"><strong><?= "A" . str_pad($value['use_id'], 3, "0", STR_PAD_LEFT); ?></strong></td>
                  <td width="55%"><?= $value['use_name'] ?><br /><small><?= $value['position_name'] ?></small></td>
                  <td width="15%">
                    <?= $value['use_create_name']; ?><br />
                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['use_create_date']); ?> <?= date('h:i A', strtotime($value['use_create_date'])); ?></small>
                  </td>
                  <td width="15%">
                    <?= $value['use_lastedit_name']; ?><br />
                    <small class="text-muted"><i class="fa fa-clock-o"></i> <?= DateThai($value['use_create_date']); ?> <?= date('h:i A', strtotime($value['use_lastedit_date'])); ?></small>
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
                          <a href="#" data-use_id="<?= $value['use_id']; ?>" data-use_name="<?= $value['use_name']; ?>" data-toggle="modal" data-target="#U-update" class="update">
                            <i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;แก้ไขข้อมูล
                          </a>
                        </li>
                        <li><a href="#" class="btn-alert" data-url="<?= site_url('extra/delete/' . $value['use_id']); ?>" data-title="ต้องการลบข้อมูล?"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;ลบข้อมูล</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              <?PHP } ?>
            </tbody>
            <tfoot>
              <tr>
                <th></th>
                <th class="ftinput">ชื่อเต็ม</th>
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
<div class="modal fade" id="insert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มข้อมูลอาจารย์พิเศษ</h4>
      </div>
      <div class="modal-body">
        <form action="<?= site_url('extra/create'); ?>" method="post" enctype="multipart/form-data" name="formExtra_C" id="formExtra_C" class="form-horizontal" novalidate>
          <input type="hidden" name="formcrf" id="formcrfinsert" value="<?= $formcrf; ?>">
          <input type="hidden" name="set_id" id="set_id" value="<? if (isset($set_id)) {
                                                                  echo $set_id;
                                                                } ?>">
          <div class="alert alert-danger" role="alert">
            วันเเวลารายการนี้จะไม่สามารถแก้ไขภายหลังได้ <br>กรุณาตรวจสอบวันเวลาขึ้นสอบให้ถูกต้องก่อนเพิ่มข้อมูล <strong>**</strong>
          </div>
          <div class="form-group row">
            <label class="col-sm-12">ชื่อเต็ม<span class="text-muted" style="color:#c0392b">*</span></label>
            <div class="col-sm-12">
              <input type="text" name="use_name" id="use_name" class="form-control">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-12">ขึ้นสอบวิชา<span class="text-muted" style="color:#c0392b">*</span></label>
            <div class="col-sm-12">
              <select class="form-control" name="text_type" id="text_type">
                <option value="">กรุณาเลือกข้อมูล</option>
                <?PHP foreach ($listsubject as $key => $value) { ?>
                  <option value="<?= $value['sub_type'] ?>"><?= $value['sub_name'] ?></option>
                <?PHP } ?>
              </select>
            </div>
          </div>
          <? if ($checkinsert == 'yes') { ?>
            <div class="form-group row">
              <label class="col-sm-12">วันขึ้นสอบ<span class="text-muted" style="color:#c0392b">*</span></label>
              <div class="col-sm-12">
                <select class="form-control" name="sec_date" id="sec_date">
                  <option value="">กรุณาเลือกข้อมูล</option>
                  <?PHP foreach ($listsec as $key => $value) { ?>
                    <option value="<?= $value['sec_date'] ?>"><?= $value['sec_date'] ?></option>
                  <?PHP } ?>
                </select>
              </div>
            </div>
          <? } ?>
          <div class="form-group row">
            <label class="col-sm-12">เวลาขึ้นสอบ<span class="text-muted" style="color:#c0392b">*</span></label>
            <div class="col-sm-12">
              <select class="form-control" name="text_time" id="text_time">
                <option value="">กรุณาเลือกข้อมูล</option>
              </select>
            </div>
          </div>
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
    $(".use_id").val(use_id);
    $(".use_name").val(use_name);
  });
</script>
<div class="modal fade" id="U-update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลอาจารย์พิเศษ</h4>
      </div>
      <div class="modal-body">
        <form action="<?= site_url('extra/update'); ?>" method="post" enctype="multipart/form-data" name="formAdministrators_Up" id="formAdministrators_Up" class="form-horizontal" novalidate>
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        <button type="submit" class="btn btn-primary">บันทึก</button>
      </div>
      </form>
    </div>
  </div>
</div>