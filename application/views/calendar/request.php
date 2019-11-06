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

<style>
label.error {
    color: #cc5965;
    display: none !important;
    margin-left: 5px;
}
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>คำขอนัดหมายขึ้นสอบ</h2>
        <ol class="breadcrumb">
            <li>หน้าแรก</li>
            <li class="active"><strong>คำขอนัดหมายขึ้นสอบปริญญานิพนธ์</strong></li>
        </ol>
    </div>
</div>
<br>
<div class="row wrapper page-heading">    
        <div class="col-md-12">
             <?PHP if (count($meet) != 0) { ?>
                <?PHP foreach ($meet as $key => $vmeet) { ?>
                    <div class="col-md-4">
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                <div class="product-desc">
                                    <small class="text-muted" style="font-size:14px">เวลานัด วันที่ : <?= DateThai($vmeet['meet_date']); ?></small>
                                    <a href="#" class="product-name" style="font-size:32px"> <?=$vmeet['meet_time']; ?> น.</a>
                                     
                                    <?PHP

                                        $this->db->select("*");
                                        $this->db->from('tb_meetdetail');
                                        $this->db->join('tb_user', 'tb_user.use_id = tb_meetdetail.use_id');
                                        $this->db->where(array('meet_id' => $vmeet['meet_id']));
                                        $this->db->order_by("dmeet_head", "DESC");
                                        $querym = $this->db->get();
                                        $listt = $querym->result_array();

                                    ?>

                                    <div class="small m-t-xs" style="font-size:14px">
                                        <p><strong>รายการ</strong> : <?=$vmeet['project_name']; ?></p>
                                        <p>
                                            <?PHP foreach ($listt as $key => $v) { ?>
                                                <? if ($v['use_id'] == $vmeet['use_id']) { ?>
                                                    <div class="badges alt"><span class="tag"><?= $v['use_name']; ?></span><span class="content red">ที่ปรึกษา</span></div>
                                                <? } elseif ($v['dmeet_head'] == 1) { ?>
                                                    <div class="badges alt"><span class="tag"><?= $v['use_name']; ?></span><span class="content orange">ประธาน</span></div>
                                                <? } else { ?>
                                                    <div class="badges alt"><span class="tag"><?= $v['use_name']; ?></span></div>
                                                <? } ?>
                                            <? } ?>
                                        </p>
                                    </div>
                                    <div class="m-t text-righ">
                                        <a href="#" type="button" class="btn btn-outline btn-danger btn-reloadmeet" data-url="<?=base_url('amcalendar/cancel/'.$vmeet['dmeet_id'].'/'.$idlogin);?>" data-title="ยืนยันยกเลิกการทำนัด" data-text="<?=$vmeet['project_name']; ?>">ยกเลิกการทำนัด</a>
                                        <a href="#" type="button" class="btn btn-outline btn-success btn-reloadmeet" data-url="<?=base_url('amcalendar/submit/'.$vmeet['dmeet_id'].'/'.$idlogin);?>" data-title="ยืนยันการทำนัดหมายนี้" data-text="<?=$vmeet['project_name']; ?>">ยืนยันการทำนัด</a>
                                        <a href="<?=base_url('project/detail/'.$vmeet['project_id']);?>" target="_bank" button type="button" class="btn btn-outline btn-primary">รายละเอียดเพิ่มเติม</a>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                <?PHP } ?>
            <?PHP } else { ?>
                <div class="col-md-12">
                    <div class="ibox">
                        <div class="ibox-content">
                            <center>
                                <h1><strong>ยังไม่มีคำขอนัดหมายขึ้นสอบปริญญานิพนธ์</strong></h1>
                            </center>
                        </div>
                    </div>
                </div>
            <?PHP } ?>
        </div>
</div>
