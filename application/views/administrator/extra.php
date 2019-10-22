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
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <div class="ibox-tools">
            <button type="button" class="btn btn-outline btn-primary" data-toggle="modal" data-target="#U-insert">
              <i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล
            </button>
          </div>
        </div>
        <div class="ibox-content">
          <!-- table ------------------------------------------------------------------------------------------------------->
          <?if(count($listdata) != 0) { ?>
            <table class="table table-striped table-bordered table-hover dataTables" width="100%">
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
                    <td width="5%"><strong><?= "A" . str_pad($value['use_id'], 5, "0", STR_PAD_LEFT); ?></strong></td>
                    <td width="55%"><?= $value['use_name'] ?><br /><small><?= $value['position_name'] ?></small></td>
                    <td width="15%">
                      <?= $value['use_create_name']; ?><br />
                      <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['use_create_date'])); ?></small>
                    </td>
                    <td width="15%">
                      <?= $value['use_lastedit_name']; ?><br />
                      <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['use_lastedit_date'])); ?></small>
                    </td>
                    <td width="10%">
                      <div class="btn-group" style="width:100%">
                        <button class="btn btn-sm btn-primary " type="button" style="width:70%">จัดการ</button>
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:30%;">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" style="width:100%">
                          <li>
                            <a href="#" data-use_id="<?= $value['use_id']; ?>" data-use_name="<?= $value['use_name']; ?>" data-toggle="modal" data-target="#U-update" class="update">
                              <i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;แก้ไขข้อมูล
                            </a>
                          </li>
                          <!-- <li><a href="#" data-use_id="<?= $value['use_id']; ?>" data-toggle="modal" data-target="#U-repass" class="btnrepass"><i class="fa fa-repeat"></i>&nbsp;&nbsp;&nbsp;เปลี่ยนรหัสผ่าน</a></li> -->
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
                      <? } else { ?>
                         <center><h4>ไม่ข้อมูล</h4></center>
                      <? } ?>
          <!-- */table ----------------------------------------------------------------------------------------------------->
        </div>
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
        <form action="<?= site_url('extra/create'); ?>" method="post" enctype="multipart/form-data" name="formAdministrators_C" id="formAdministrators_C" class="form-horizontal" novalidate>
          <input type="hidden" name="formcrf" id="formcrfinsert" value="<?= $formcrf; ?>">
          <div class="form-group row">
            <label class="col-sm-12">ชื่อเต็ม<span class="text-muted" style="color:#c0392b">*</span></label>
            <div class="col-sm-12">
              <input type="text" name="use_name" value="" class="form-control">
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
        <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลผู้ใช้</h4>
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