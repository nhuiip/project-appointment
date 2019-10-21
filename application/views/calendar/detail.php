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
        $sub_name    = $student['sub_name'];
        $sub_code    = $student['sub_code'];
        $sub_setuse  = $student['sub_setuse'];
        $use_name    = $student['use_name'];
    }
} 
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="row">
            <div class="ibox">
                <div class="ibox-content">
                    <center>
                        <h1><strong>วันที่ : <?= DateThai($date); ?></strong></h1>
                    </center>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <? if (isset($sub_type) && $sub_type == 1) { ?>
                <? foreach ($time as $key => $value) { ?>
                    <div class="col-md-6">
                        <div class="ibox">
                            <?
                                    $this->db->select("*");
                                    $this->db->from('tb_meet');
                                    $this->db->join('tb_project', 'tb_project.project_id = tb_meet.project_id');
                                    $this->db->where('meet_date', $date);
                                    $this->db->where('meet_status', 1);
                                    $this->db->where("(meet_time =" . $value['one'] . "OR meet_time =" . $value['two'] . ")", NULL, FALSE);
                                    $query = $this->db->get();
                                    $meet = $query->result_array();
                                    if (count($meet) != 0) {
                                        $this->db->select("*");
                                        $this->db->from('tb_detailmeet');
                                        $this->db->join('tb_user', 'tb_user.use_id = tb_detailmeet.use_id');
                                        $this->db->where(array('meet_id' => $meet[0]['meet_id'], 'dmeet_status' => 1));
                                        $this->db->order_by("dmeet_head", "DESC");
                                        $query = $this->db->get();
                                        $listt = $query->result_array();
                                    }
                                    ?>
                            <div class="ibox-content product-box">
                                <div class="product-desc">
                                    <small class="text-muted" style="font-size:14px">เวลานัด</small>
                                    <a href="#" class="product-name" style="font-size:32px"> <?= $value['one']; ?> น.</a>
                                    <? if (count($meet) != 0) { ?>
                                        <div class="small m-t-xs" style="font-size:14px">
                                            <p><strong>รายการ</strong> : <?= $meet[0]['project_name']; ?></p>
                                            <p><? foreach ($listt as $key => $v) { ?>
                                                    <? if ($v['dmeet_head'] == 1) { ?>
                                                        <span class="label label-danger"><?= $v['use_name']; ?></span>
                                                    <? } else { ?>
                                                        <span class="label label-info"><?= $v['use_name']; ?></span>
                                                    <? } ?>
                                                <? } ?></p>
                                        </div>
                                    <? } ?>
                                    <? if (count($meet) == 0) { ?>
                                        <div class="m-t text-righ">
                                            <button class="btn btn-xs btn-outline btn-primary btnajax"  data-sub="<?=$sub_type; ?>" data-date="<?=$date; ?>" data-time="<?=$value['one']; ?>" data-url="<?= site_url('calendar/jsontimeT'); ?>"> เลือกนัดหมาย <i class="fa fa-long-arrow-right"></i> </button>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            <? } elseif (isset($sub_type) &&  $sub_type) { ?>
                <? foreach ($time as $key => $value) { ?>
                    <? if ($value['two'] != '12.00' && $value['two'] != '16.00') { ?>
                        <div class="col-md-6">
                            <div class="ibox">
                                <?
                                            $this->db->select("*");
                                            $this->db->from('tb_meet');
                                            $this->db->join('tb_project', 'tb_project.project_id = tb_meet.project_id');
                                            $this->db->where('meet_date', $date);
                                            $this->db->where('meet_status', 1);
                                            $this->db->where("(meet_time =" . $value['one'] . "OR meet_time =" . $value['two'] . ")", NULL, FALSE);
                                            $query = $this->db->get();
                                            $meet = $query->result_array();
                                            if (count($meet) != 0) {
                                                $this->db->select("*");
                                                $this->db->from('tb_detailmeet');
                                                $this->db->join('tb_user', 'tb_user.use_id = tb_detailmeet.use_id');
                                                $this->db->where(array('meet_id' => $meet[0]['meet_id'], 'dmeet_status' => 1));
                                                $this->db->order_by("dmeet_head", "DESC");
                                                $query = $this->db->get();
                                                $listt = $query->result_array();
                                            }
                                            ?>
                                <div class="ibox-content product-box">
                                    <div class="product-desc">
                                        <small class="text-muted" style="font-size:14px">เวลานัด</small>
                                        <a href="#" class="product-name" style="font-size:32px"> <?= $value['two']; ?> น.</a>
                                        <? if (count($meet) != 0) { ?>
                                            <div class="small m-t-xs" style="font-size:14px">
                                                <p><strong>รายการ</strong> : <?= $meet[0]['project_name']; ?></p>
                                                <p><? foreach ($listt as $key => $v) { ?>
                                                        <? if ($v['dmeet_head'] == 1) { ?>
                                                            <span class="label label-danger"><?= $v['use_name']; ?></span>
                                                        <? } else { ?>
                                                            <span class="label label-info"><?= $v['use_name']; ?></span>
                                                        <? } ?>
                                                    <? } ?></p>
                                            </div>
                                        <? } ?>
                                        <? if (count($meet) == 0) { ?>
                                            <div class="m-t text-righ">
                                                <button class="btn btn-xs btn-outline btn-primary btnajax"   data-sub="<?=$sub_type; ?>" data-date="<?=$date; ?>" data-time="<?=$value['one']; ?>" data-url="<?= site_url('calendar/jsontimeT'); ?>"> เลือกนัดหมาย <i class="fa fa-long-arrow-right"></i> </button>
                                            </div>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                <? } ?>
            <? } ?>
        </div>
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="border-color: #1c84c6;">
                    <h5><i class="fa fa-calendar-o"></i> &nbsp; <?=$sub_name;?></h5>
                </div>
                <div class="ibox-content">
                    <div>รหัสวิชา : <?=$sub_code;?></div>
                    <div>อาจารย์ประจำวิชา : <?=$use_name;?></div>
                    <div>อาจารย์ขึ้นสอบอย่างน้อย : <?=$sub_setuse;?> คน</div>
                </div>
            </div>
            
            <form action="<?=base_url('calendar/request');?>" method="post" name="formCalendarrequest" id="formCalendarrequest" class="form-horizontal" novalidate>                   

                <input type="hidden" name="txt_date" id="txt_date" value="<?=$date; ?>"/>
                <input type="hidden" name="txt_type" id="txt_type" value="<?=$sub_type; ?>"/>
                <input type="hidden" name="txt_time" id="txt_time" value=""/>

                <ul class="todo-list  ui-sortable" id="listtt">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="alert alert-danger" style="margin-bottom: 0px;">
                                <center>ยังไม่เลือกเวลาสำหรับนัดหมาย</center>
                            </div>
                        </div>
                    </div>
                </ul>
                <div class="todo-list  ui-sortable" id="listtts"></div>
                <br/>

            </form>

        </div>
    </div>
</div>

