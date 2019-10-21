
<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>ข้อมูลปริญญานิพนธ์</h2>
        <ol class="breadcrumb">
            <li><a href="<?=site_url('project/index/'.$this->encryption->decrypt($this->input->cookie('sysli'))); ?>">หน้าแรก</a></li>
            <li class="active"><strong>ข้อมูลปริญญานิพนธ์</strong></li>
        </ol>
    </div>
</div>
<!-- End breadcrumb for page -->
<div class="wrapper wrapper-content animated fadeInRight">

<style>
.btn-show-project{
    width: 100%;
    background: #fff;
    padding: 10px 15px !important;    
}
.nav-pills>li.active {
    border-left: 4px solid #19aa8d;
    background: #293846;
}
.nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
    color: #fff;
    background-color: #337ab7;
}
.nav-pills>li>a {
    border-radius: 0px;
}

</style>

    <div class="row">
        <div class="col-xs-12" style="padding-right: 30px;padding-left: 30px;">
            <!-- Nav tabs -->
            <ul class="nav nav-pills" style="margin-bottom: 10px;">
                <li role="presentation" class="active"><a href="#work"data-toggle="pill"  class="btn-show-project"><i class="fa fa-laptop"></i></a></li>
                <li role="presentation"><a href="#hire"  data-toggle="pill" class="btn-show-project"><i class="fa fa-list"></i></a></li>
            </ul>
        </div>
    </div>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="work">
            <div class="row">
                <div class="col-xs-12" style="padding-right: 30px;padding-left: 30px;">
                    <div class="ibox-content m-b-sm border-bottom">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <form action="<?=base_url('project/search');?>" method="post" role="form" class="notopmargin nobottommargin" novalidate="novalidate">
                                        <div class="grid-two-show-search">
                                            <input type="text" id="product_name" name="product_name" value="" placeholder="ค้นหาปริญญานิพนธ์" class="form-control">
                                            <button style="width: 100%;" type="submit" class="btn btn-w-m btn-primary">ค้นหาปริญญานิพนธ์</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <form action="<?=base_url('project/searchteacher');?>" method="post" role="form" >
                                        <select name="teacher" id="teacher" class="form-control"  onchange="this.form.submit()">
                                            <option value="" selected="">ค้นหาจากอาจารย์ที่ปรึกษาปริญญานิพนธ์</option>
                                            <?PHP foreach ($listuser as $key => $value) { ?>
                                            <option value="<?=$value['use_id'];?>" ><?=$value['use_name'];?></option>
                                            <?PHP } ?>
                                        </select>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form action="<?=base_url('project/searchstatus');?>" role="form" method="post" >
                                    <div class="form-group">
                                        <select name="type" id="type" class="form-control" onchange="this.form.submit()">
                                            <option value="" selected="">ค้นหาจากสถานะปริญญานิพจน์</option>
                                            <option value="1" >ยังไม่สอบโครงงานหนึ่ง</option>
                                            <option value="2">ผ่านโครงงานหนึ่ง</option>
                                            <option value="3">สอบโครงงานสองแล้วติดแก้ไข</option>
                                            <option value="4">สอบโครงงานสองผ่าน</option>
                                            <option value="0">เปลี่ยนหัวข้อปริญญานิพนธ์</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row coutomrow">
                <?PHP if($listproject != []) {?>
                <?PHP foreach ($listproject as $key => $value) { ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                <div class="product-desc">
                                    <a href="<?=base_url('project/detail/'.$this->encryption->decrypt($this->input->cookie('sysli')).'/'.$value['project_id']);?>" class="product-name" style="height: 40px;"> <?=$value['project_name'];?></a>
                                    <br/>
                                    <div class="small m-t-xs">
                                        อาจารย์ที่ปรึกษา <br/><?=$value['use_name'];?>
                                    </div>
                                    <br/>
                                    <div class="display-grid-project">
                                        <a href="<?=base_url('project/detail/'.$this->encryption->decrypt($this->input->cookie('sysli')).'/'.$value['project_id']);?>" class="btn btn-xs btn-outline btn-primary">เพิ่มเติม <i class="fa fa-long-arrow-right"></i> </a>
                                        <div>
                                            <?PHP if($value['project_status'] == 1){ ?>
                                                <div class="message-data" >
                                                    <span class="message-data-name"><i class="fa fa-circle online" style="color: #23c6c8!important;"></i>&nbsp; &nbsp;ยังไม่สอบโครงงานหนึ่ง</span>
                                                </div>
                                            <?PHP } else if($value['project_status'] == 2){ ?>
                                                <div class="message-data">
                                                    <span class="message-data-name"><i class="fa fa-circle online" style="color: #1ab394!important;"></i>&nbsp; &nbsp;ผ่านโครงงานหนึ่ง</span>
                                                </div>
                                            <?PHP } else if($value['project_status'] == 3){ ?>
                                                <div class="message-data" >
                                                    <span class="message-data-name"><i class="fa fa-circle online" style="color: #f8ac59!important;"></i>&nbsp; &nbsp;สอบโครงงานสองแล้วติดแก้ไข</span>
                                                </div>
                                            <?PHP } else if($value['project_status'] == 4){ ?>
                                                <div class="message-data" >
                                                    <span class="message-data-name"><i class="fa fa-circle online" style="color: #1c84c6!important;"></i>&nbsp; &nbsp;สอบโครงงานสองผ่าน</span>
                                                </div>
                                            <?PHP } else if($value['project_status'] == 0){ ?>
                                                <div class="message-data" >
                                                    <span class="message-data-name"><i class="fa fa-circle online" style="color: #ed5565!important;"></i>&nbsp; &nbsp;เปลี่ยนหัวข้อปริญญานิพนธ์</span>
                                                </div>
                                            <?PHP } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?PHP } ?>
                <?PHP } else{?>
                    <div class="col-sm-12">
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                <div class="product-desc">
                                
                                <br/>
                                <center>ไม่พบผลลัพธ์ที่ต้องการค้นหา</center>
                                <br/>

                                </div>
                            </div>
                        </div>
                    </div>
                <?PHP } ?>
            </div>
            <?php if (isset($pagination)) { ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div style="text-align: right;">
                            <?=$pagination; ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="hire">
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
                                                <td width="10%" style="vertical-align:top"><?=$value['project_name'] ?></td>
                                                <td width="15%" style="vertical-align:top">
                                                    <?PHP
                                                        if($value['std_id']  != ''){
                                                            $stypesVal = explode(",", $value['std_id'] );
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
                                                                <label><?=$liststudent[0]['std_number']?> <?=$liststudent[0]['std_title']?><?=$liststudent[0]['std_fname']?>  <?=$liststudent[0]['std_lname']?></label>
                                                            </div>
                                                        <?PHP
                                                            } 
                                                        } 
                                                    ?>    
                                                </td>
                                                <td width="10%" style="vertical-align:top">
                                                    <?PHP if($value['project_status'] == 1){ ?>
                                                        ยังไม่สอบโครงงานหนึ่ง
                                                    <?PHP } else if($value['project_status'] == 2){ ?>
                                                        ผ่านโครงงานหนึ่ง
                                                    <?PHP } else if($value['project_status'] == 3){ ?>
                                                        สอบโครงงานสองแล้วติดแก้ไข
                                                    <?PHP } else if($value['project_status'] == 4){ ?>
                                                        สอบโครงงานสองผ่าน
                                                    <?PHP } else if($value['project_status'] == 0){ ?>
                                                        เปลี่ยนหัวข้อปริญญานิพนธ์
                                                    <?PHP } ?>
                                                </td>
                                                <td width="10%" style="vertical-align:top"><?=$value['project_create_name']?><br/><?=$value['project_create_date']?></td>
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
    </div>



    
</div>
