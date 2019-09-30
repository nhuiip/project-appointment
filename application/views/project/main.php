
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
    <div class="row">
        <div class="col-xs-12">
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
    <div class="row">
        <?PHP if($listproject != []) {?>
        <?PHP foreach ($listproject as $key => $value) { ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="ibox">
                    <div class="ibox-content product-box">
                        <div class="product-desc">
                        
                            <?PHP if($value['project_status'] == 1){ ?>
                                <span class="product-price" style="top: 0px !important; background-color: #23c6c8!important;">ยังไม่สอบโครงงานหนึ่ง</span>
                            <?PHP } else if($value['project_status'] == 2){ ?>
                                <span class="product-price" style="top: 0px !important; background-color: #1ab394!important;">ผ่านโครงงานหนึ่ง</span>
                            <?PHP } else if($value['project_status'] == 3){ ?>
                                <span class="product-price" style="top: 0px !important; background-color: #f8ac59!important;">สอบโครงงานสองแล้วติดแก้ไข</span>
                            <?PHP } else if($value['project_status'] == 4){ ?>
                                <span class="product-price" style="top: 0px !important; background-color: #1c84c6!important;">สอบโครงงานสองผ่าน</span>
                            <?PHP } else if($value['project_status'] == 0){ ?>
                                <span class="product-price" style="top: 0px !important; background-color: #ed5565!important;">เปลี่ยนหัวข้อปริญญานิพนธ์</span>
                            <?PHP } ?>
                            
                            <br/>
                            <a href="<?=base_url('project/detail/'.$value['project_id']);?>" class="product-name" style="height: 40px;"> <?=character_limiter(strip_tags($value['project_name']), 20);?></a>
                            <br/>
                            <div class="small m-t-xs">
                                อาจารย์ที่ปรึกษา <br/><?=character_limiter(strip_tags($value['use_name']), 20);?>
                            </div>
                            <div class="m-t text-righ">
                                <a href="<?=base_url('project/detail/'.$value['project_id']);?>" class="btn btn-xs btn-outline btn-primary">เพิ่มเติม <i class="fa fa-long-arrow-right"></i> </a>
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
