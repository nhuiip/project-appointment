
<div class="wrapper wrapper-content animated fadeInRight">   
    <div class="row">
        <?PHP if (count($listsubject) != 0) { ?>

            <?PHP foreach ($listsubject as $key => $value) { ?>

                <div class="col-md-6">
                    <a href="<?=base_url('student/stdsubjectdetail/'.$value['sub_id']);?>">
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                <div class="product-desc">
                                    <h4 class="text-muted"><?=$value['sub_code'];?></h4>
                                    <div  class="product-name"> <h2><?=$value['sub_name'];?></h2></div>
                                    <div class="small m-t-xs">
                                        <div style="color: #000;"><h4><?=$value['use_name'];?></h4></div>
                                    </div>
                                    <div class="m-t text-righ">
                                        <div class="btn  btn-outline btn-primary">รายละเอียดเพิ่มเติม <i class="fa fa-long-arrow-right"></i> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            <?PHP } ?>
        <?PHP } ?>
    </div>
</div>


<!-- <div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <h3>ข้อมูลเอกสารรายวิชา</h3>
                        <ul class="folder-list m-b-md" style="padding: 0">
                            <?PHP if (count($listsubject) != 0) { ?>
                                <?PHP foreach ($listsubject as $key => $value) { ?>
                                    <li><a href="<?=base_url('student/stdsubjectdetail/'.$value['sub_id']);?>"> <i class="fa fa-file-text-o"></i> <?=$value['sub_name'];?> </a></li>
                                <?PHP } ?>
                            <?PHP }else{ ?>
                                <i><i class="fa fa-trash-o"></i> ยังไม่มีข้อมูล</i>
                            <?PHP } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box">
                <div class="mail-body">
                    <br/>
                    <p><center><h3>เลือกรายวิชา เพื่อดูรายละเอียด</h3></center></p>
                    <br/>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div> -->

