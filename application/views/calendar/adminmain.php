<?
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
        <h2>ข้อมูลการนัดหมาย</h2>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('dashboard/index'); ?>">หน้าแรก</a></li>
            <li class="active"><strong>ข้อมูลการนัดหมาย</strong></li>
        </ol>
    </div>
</div>
<!-- End breadcrumb for page -->
<? if (count($listsec) != 0) { ?>
    <? foreach ($listsec as $key => $v) {
            $sec_date = $v['sec_date']
            ?>
        <br>
        <div class="ibox collapsed">
            <div class="ibox-title">
                <h3>
                    <?= DateThai($v['sec_date']); ?>
                </h3>
            </div>
        </div>
        <div class="" style="display: grid;grid-template-columns: 33.33333333% 33.33333333% 33.33333333%;">
            <? foreach ($time as $key => $value) {
                        $numcol = 1;
                        $this->db->select("*");
                        $this->db->from('tb_meet');
                        $this->db->join('tb_project', 'tb_project.project_id = tb_meet.project_id');
                        $this->db->join('tb_subject', 'tb_subject.sub_id = tb_meet.sub_id');
                        $this->db->where('meet_date', $sec_date);
                        $this->db->where('meet_status !=', 0);
                        $this->db->where("(meet_time=" . $value['one'] . "OR meet_time=" . $value['two'] . ")", NULL, FALSE);
                        $query = $this->db->get();
                        $meet = $query->result_array();
                        if (count($meet) != 0) {
                            $this->db->select("*");
                            $this->db->from('tb_meetdetail');
                            $this->db->join('tb_user', 'tb_user.use_id = tb_meetdetail.use_id');
                            $this->db->join('tb_meet', 'tb_meet.meet_id = tb_meetdetail.meet_id');
                            $this->db->where(array('tb_meetdetail.meet_id' => $meet[0]['meet_id'], 'tb_meetdetail.dmeet_status !=' => 0));
                            $this->db->order_by("use_name", "asc");
                            $query = $this->db->get();
                            $listt = $query->result_array();
                        }
                        ?>
                <div class="" style="">
                    <div class="ibox">
                        <div class="ibox-content product-box">
                            <div class="product-desc">
                                <small class="text-muted" style="font-size:14px">เวลานัด</small>
                                <a href="#" class="product-name" style="font-size:16px"> <?= $value['one']; ?> น. , <?= $value['two']; ?> น.</a>
                                <? if (count($meet) != 0) { ?>
                                    <div class="small m-t-xs" style="font-size:14px">
                                        <p style="margin: 0 0 0;"></p><strong>รายการ</strong> : <?= $meet[0]['project_name']; ?></p>
                                        <p style="margin: 0 0 0;"><strong>เวลา</strong> : <?= $meet[0]['meet_time']; ?> น.</p>
                                        <p style="margin: 0 0 5px;"><strong>วิชา</strong> : <?= $meet[0]['sub_code'] . ' ' . $meet[0]['sub_name']; ?> น.</p>
                                        <p><? foreach ($listt as $key => $v) { ?>
                                                <? if ($v['use_id'] == $meet[0]['use_id']) { ?>
                                                    <div class="badges alt"><span class="tag"><?= $v['use_name']; ?></span><span class="content red">ที่ปรึกษา</span></div>
                                                <? } elseif ($v['dmeet_head'] == 1) { ?>
                                                    <div class="badges alt"><span class="tag"><?= $v['use_name']; ?></span><span class="content orange">ประธาน</span></div>
                                                <? } else { ?>
                                                    <div class="badges alt"><span class="tag"><?= $v['use_name']; ?></span></div>
                                                <? } ?>
                                            <? } ?></p>
                                    </div>
                                <? } else { ?>
                                    <br>
                                    <div class="alert alert-success">
                                        เวลานัดหมาย <a class="alert-link" href="#">ว่าง</a>.
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    <? } ?>
<? } else { ?>
    <center>
        <h1>ไม่พบรายการนัดหมาย</h1>
    </center>
<? } ?>