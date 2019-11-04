<br>
<div class="row wrapper page-heading">
    <?PHP if (count($listsubject) != 0) { ?>

        <?PHP foreach ($listsubject as $key => $value) { ?>

            <div class="col-md-6">
                <a href="<?= base_url('student/stdsubjectdetail/' . $value['sub_id']); ?>">
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