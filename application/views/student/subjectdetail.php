<?PHP if (isset($listsubject) && count($listsubject) != 0) {
    foreach ($listsubject as $key => $value) {
        $sub_code             = $value['sub_code'];
        $sub_name             = $value['sub_name'];
        $use_name             = $value['use_name'];
        $use_email             = $value['use_email'];
        $sub_setuse             = $value['sub_setuse'];
        $sub_setless             = $value['sub_setless'];
    }
}
?>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <h3><?=$sub_name;?></h3>
                        <ul class="folder-list m-b-md" style="padding: 0">
                            <li><i class="fa fa-pie-chart"></i> <?=$sub_code;?></li>
                            <li><i class="fa fa-file-text-o"></i> <?=$use_name;?></li>
                        </ul>
                        <p>
                            <b>รายละเอียดวิชา</b>
                            <br>
                            <br>
                            จำนวนอาจารย์ขึ้นสอบปริญญานิพนธ์ :: <?=$sub_setuse;?>
                            <br>
                            <br>
                            <span class="text-muted" style="color:#c0392b">**</span> หากอาจารย์ติดภารกิจในวันขึ้นสอบปริญญานิพนธ์ ต้องมีอาจารย์ขึ้นสอบอย่างน้อย <?=$sub_setless;?> คน
                        </p>
                        
                        <br>
                        <br>
                        <a href="<?=site_url('student/stdsubject');?>" type="button" class="btn btn-outline btn-danger"><i class="fa fa-long-arrow-left"></i> กลับหน้าหลัก</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box">
                <div class="mail-attachment">
                    <p><span><i class="fa fa-paperclip"></i> <?PHP echo count($listattached) ?> ไฟล์แนบ </span></p>

                    <div class="attachment">
                        <?PHP if (count($listattached) != 0) { ?>

                            <?PHP foreach ($listattached as $key => $value) { ?>
                                <div class="file-box">
                                    <div class="file">
                                        <a href="<?=base_url('uploads/attached/'.$value['att_filename']);?>" download>
                                            <span class="corner"></span>

                                            <div class="icon">
                                                <i class="fa fa-file"></i>
                                            </div>
                                            <div class="file-name">
                                                <?=$value['att_name'];?>
                                                <br>
                                                <small><?=$value['att_create_date'];?></small>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            <?PHP } ?>

                        <?PHP } ?>

                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>