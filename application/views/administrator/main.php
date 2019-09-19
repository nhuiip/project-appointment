<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-12">
    <h2>ผู้ดูแลระบบ</h2>
    <ol class="breadcrumb">
      <li><a href="#">หน้าแรก</a></li>
      <li class="active"><strong>ผู้ดูแลระบบ</strong></li>
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
            <a href="<?= site_url('administrator/form'); ?>">
                <button type="button" class="btn btn-outline btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล</button>
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
                    <td width="5%"><strong><?= "A" . str_pad($value['use_id'], 5, "0", STR_PAD_LEFT); ?></strong></td>
                    <td width="20%"><?= $value['use_name'] ?><br /><small><?= $value['position_name'] ?></small></td>
                    <td width="20%"><?= $value['use_email'] ?></td>
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
                            <li><a href="<?= site_url('administrator/form/' . $value['use_id']); ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;แก้ไขข้อมูล</a></li>
                            <li><a href="<?= site_url('administrator/formpassword/' . $value['use_id']); ?>"><i class="fa fa-repeat"></i>&nbsp;&nbsp;&nbsp;เปลี่ยนรหัสผ่าน</a></li>
                            <li><a href="#" class="btn-alert" data-url="<?= site_url('administrator/delete/' . $value['use_id']); ?>" data-text="ต้องการลบข้อมูล?"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;ลบข้อมูล</a></li>
                        </ul>
                      </div>
                    </td>
                    <td width="15%">
                      <?PHP if ($value['use_lastlogin'] != "0000-00-00 00:00:00") { ?>
                        <i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['use_lastlogin'])); ?> <?PHP } else { ?> - <?PHP } ?>
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
          </div>
          <!-- */table ----------------------------------------------------------------------------------------------------->
        </div>
      </div>
    </div>
  </div>
</div>