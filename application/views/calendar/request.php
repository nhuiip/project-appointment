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

<?
if (isset($listsubject) && count($listsubject) != 0) {
    foreach ($listsubject as $key => $student) {
        $sub_id      = $student['sub_id'];
        $use_id      = $student['use_id'];
        $sub_name    = $student['sub_name'];
        $sub_code    = $student['sub_code'];
        $sub_setuse  = $student['sub_setuse'];
        $use_name    = $student['use_name'];
    }
}
?>

<style>
label.error {
    color: #cc5965;
    display: none !important;
    margin-left: 5px;
}
</style>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
       
        <div class="col-md-8">
           
         
            <?PHP 
                $this->db->select("*");
                $this->db->from('tb_meet');
                $this->db->join('tb_project', 'tb_project.project_id = tb_meet.project_id');
                $this->db->join('tb_meetdetail', 'tb_meetdetail.meet_id = tb_meet.meet_id');
                // $this->db->where('meet_date', $date);
                $this->db->where('tb_meetdetail.use_id',$idlogin);
                $this->db->where('tb_meetdetail.dmeet_status',2);
                // $this->db->where("(meet_time=" . $value['one'] . "OR meet_time=" . $value['two'] . ")", NULL, FALSE);
                $querys = $this->db->get();
                $meet = $querys->result_array();

            ?>
             <?PHP if (count($meet) != 0) { ?>
                <?PHP foreach ($meet as $key => $vmeet) { ?>
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                <div class="product-desc">
                                    <small class="text-muted" style="font-size:14px">เวลานัด วันที่ : <?= DateThai($vmeet['meet_date']); ?></small>
                                    <a href="#" class="product-name" style="font-size:32px"> <?=$vmeet['meet_time']; ?> น.</a>
                                     
                                    <?PHP

                                        $this->db->select("*");
                                        $this->db->from('tb_meetdetail');
                                        $this->db->join('tb_user', 'tb_user.use_id = tb_meetdetail.use_id');
                                        $this->db->where(array('meet_id' => $vmeet['meet_id'], 'dmeet_status' => 2));
                                        $this->db->order_by("dmeet_head", "DESC");
                                        $querym = $this->db->get();
                                        $listt = $querym->result_array();

                                    ?>

                                    <div class="small m-t-xs" style="font-size:14px">
                                        <p><strong>รายการ</strong> : <?=$vmeet['project_name']; ?></p>
                                        <p>
                                            <?PHP foreach ($listt as $key => $v) { ?>
                                                <? if ($v['use_id'] == $vmeet['use_id']) { ?>
                                                    <span class="badge badge-danger badge-use"><?= $v['use_name']; ?></span>
                                                <? } elseif ($v['dmeet_head'] == 1) { ?>
                                                    <span class="badge badge-warning badge-use"><?= $v['use_name']; ?></span>
                                                <? } else { ?>
                                                    <span class="badge badge-default badgw-use"><?= $v['use_name']; ?></span>
                                                <? } ?>
                                            <? } ?>
                                        </p>
                                    </div>
                                    <div class="m-t text-righ">
                                        <!-- <button class="btn btn-xs btn-outline btn-danger"> ยืนยันการทำนัด <i class="fa fa-long-arrow-right"></i> </button> -->
                                        <a href="#" type="button" class="btn btn-outline btn-danger btn-alert" data-url="<?=base_url('amcalendar/cancel/'.$vmeet['dmeet_id'].'/'.$idlogin);?>" data-title="ยืนยันยกเลิกการทำนัด">ยกเลิกการทำนัด</a>
                                        <button type="button" class="btn btn-outline btn-success">ยืนยันการทำนัด</button>
                                        <a href="<?=base_url('project/detail/'.$vmeet['project_id']);?>" target="_bank" button type="button" class="btn btn-outline btn-primary">รายละเอียดเพิ่มเติม</a>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                <?PHP } ?>
            <?PHP } else{?>
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
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <span class="badge badge-warning col-sm-2" style="margin-bottom: 5px;">สีเหลือง</span>
                        <div class="col-sm-10" style="margin-bottom: 5px;">คือ ประธานการขึ้นสอบปริญญานิพนธ์</div>
                        <span class="badge badge-danger col-sm-2" style="margin-bottom: 5px;">สีแดง</span>
                        <div class="col-sm-10" style="margin-bottom: 5px;">คือ อาจารย์ประจำวิชา</div>
                        <span class="badge badge-default col-sm-2" style="margin-bottom: 5px;">สีเทา</span>
                        <div class="col-sm-10" style="margin-bottom: 5px;">คือ กรรมการขึ้นปริญญานิพนธ์</div>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
</div>
