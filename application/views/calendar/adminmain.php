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
    <? foreach ($listsec as $key => $value) { ?>
        <br>
        <div class="ibox collapsed">
            <div class="ibox-title">
                <h3>
                    <?= DateThai($value['sec_date']); ?>
                </h3>
            </div>
        </div>
        <div class="row">
            <?
                    $this->db->select("*");
                    $this->db->where(array(
                        'set_id' => $set_id,
                        'sec_date' => $value['sec_date'],
                        'use_id' => $this->encryption->decrypt($this->input->cookie('sysli'))
                    ));
                    $query = $this->db->get('tb_section');
                    $listusersec = $query->result_array();
                    ?>
        </div>
    <? } ?>
<? } else { ?>
    <center>
        <h1>ไม่มีรายการนัดหมาย</h1>
    </center>
<? } ?>