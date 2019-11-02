<?PHP if ($listsubject != 0) { ?>
    <!-- heading -->
    <div class="row wrapper white-bg page-heading">
        <div class="col-lg-12">
            <center>
                <h1>รายวิชาที่เปิดให้ขึ้นสอบปริญญานิพนธ์</h1>
            </center>
        </div>
    </div>
    <br>
    <div class="row wrapper page-heading">
        <?PHP foreach ($listsubject as $key => $value) { ?>
            <div class="col-md-6">
                <a href="<?= base_url('calendar/detail/' . $value['sub_id'] . "/" . $value['sub_type'] . "/" . $date); ?>">
                    <div class="ibox">
                        <div class="ibox-content product-box">
                            <div class="product-desc">
                                <h4 class="text-muted"><?= $value['sub_code']; ?></h4>
                                <div class="product-name">
                                    <h2><?= $value['sub_name']; ?></h2>
                                </div>
                                <div class="small m-t-xs">
                                    <div style="color: #000;">
                                        <h4><?= $value['use_name']; ?></h4>
                                    </div>
                                </div>
                                <div class="m-t text-righ">
                                    <div class="btn  btn-outline btn-primary">ส่งคำขอขึ้นสอบ <i class="fa fa-long-arrow-right"></i> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?PHP } ?>
    </div>
<?PHP } ?>