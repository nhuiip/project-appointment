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

<!-- loading -->
<div class="loading">Loading&#8230;</div>
<!-- heading -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <center>
            <h1><strong>วันที่ : <?= DateThai($date); ?></strong></h1>
        </center>
    </div>
</div>
<br>
<!-- body -->
<div class="row wrapper white-bg page-heading">
    <br>
    <!-- time -->
    <div class="col-md-8">
        <!-- sub_type = 1 -->
        <? if ($sub_type == 1) { ?>
            <? foreach ($time as $key => $value) { ?>
                <?
                        $this->db->select("sec_status");
                        $this->db->where('use_id', $use_id);
                        $this->db->where('sec_date', $date);
                        $this->db->where('sec_status', 1);
                        $this->db->where("(sec_time_one=" . $value['one'] . "OR sec_time_two=" . $value['two'] . ")", NULL, FALSE);
                        $query_section = $this->db->get('tb_section');
                        $section_sub = $query_section->result_array();

                        $this->db->select("sec_status");
                        $this->db->where('use_id', $project_use);
                        $this->db->where('sec_date', $date);
                        $this->db->where('sec_status', 1);
                        $this->db->where("(sec_time_one=" . $value['one'] . "OR sec_time_two=" . $value['two'] . ")", NULL, FALSE);
                        $query_pro = $this->db->get('tb_section');
                        $section_pro = $query_pro->result_array();

                        $this->db->select("*");
                        $this->db->from('tb_meet');
                        $this->db->join('tb_project', 'tb_project.project_id = tb_meet.project_id');
                        $this->db->where('meet_date', $date);
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
                            $this->db->order_by("dmeet_head", "DESC");
                            $query = $this->db->get();
                            $listt = $query->result_array();
                        }

                        ?>
                <div class="col-md-6">
                    <div class="ibox">
                        <div class="ibox-content product-box">
                            <div class="product-desc">
                                <small class="text-muted" style="font-size:14px">เวลานัด</small>
                                <a href="#" class="product-name" style="font-size:32px"> <?= $value['one']; ?> น.</a>
                                <? if (count($meet) != 0) { ?>
                                    <div class="small m-t-xs" style="font-size:14px">
                                        <p><strong>รายการ</strong> : <?= $meet[0]['project_name']; ?></p>
                                        <p><? foreach ($listt as $key => $v) { ?>
                                                <? if ($v['use_id'] == $meet[0]['use_id']) { ?>
                                                    <span class="badge badge-danger badge-use"><?= $v['use_name']; ?></span>
                                                <? } elseif ($v['dmeet_head'] == 1) { ?>
                                                    <span class="badge badge-warning badge-use"><?= $v['use_name']; ?></span>
                                                <? } else { ?>
                                                    <span class="badge badge-default badgw-use"><?= $v['use_name']; ?></span>
                                                <? } ?>
                                            <? } ?></p>
                                    </div>
                                <? } ?>
                                <? if (count($meet) == 0) { ?>
                                    <? if ($chkprojectrequest == 0) { ?>
                                        <? if (count($section_sub) != 0 && count($section_pro) != 0) { ?>
                                            <div class="m-t text-righ">
                                                <button class="btn btn-xs btn-outline btn-primary btnajax" data-subid="<?= $sub_id; ?>" data-sub="<?= $sub_type; ?>" data-date="<?= $date; ?>" data-time="<?= $value['one']; ?>" data-url="<?= site_url('calendar/jsontimeT'); ?>"> เลือกนัดหมาย <i class="fa fa-long-arrow-right"></i> </button>
                                            </div>
                                        <? } else { ?>
                                            <div class="m-t text-righ">
                                                <button class="btn btn-xs btn-outline btn-danger"> ไม่สามารถทำนัดได้ <i class="fa fa-long-arrow-right"></i> </button>
                                            </div>
                                        <? } ?>
                                    <? } ?>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
        <? } ?>
        <!-- sub_type = 2 -->
        <? if ($sub_type == 2) { ?>
            <? foreach ($time as $key => $value) { ?>
                <? if ($value['two'] != '12.00' && $value['two'] != '16.00') { ?>
                    <?
                                $this->db->select("sec_status");
                                $this->db->where('use_id', $use_id);
                                $this->db->where('sec_date', $date);
                                $this->db->where('sec_status', 1);
                                $this->db->where("(sec_time_one=" . $value['one'] . "OR sec_time_two=" . $value['two'] . ")", NULL, FALSE);
                                $query_section = $this->db->get('tb_section');
                                $section_sub = $query_section->result_array();

                                $this->db->select("sec_status");
                                $this->db->where('use_id', $project_use);
                                $this->db->where('sec_date', $date);
                                $this->db->where('sec_status', 1);
                                $this->db->where("(sec_time_one=" . $value['one'] . "OR sec_time_two=" . $value['two'] . ")", NULL, FALSE);
                                $query_pro = $this->db->get('tb_section');
                                $section_pro = $query_pro->result_array();

                                $this->db->select("*");
                                $this->db->from('tb_meet');
                                $this->db->join('tb_project', 'tb_project.project_id = tb_meet.project_id');
                                $this->db->where('meet_date', $date);
                                $this->db->where('meet_status !=', 0);
                                $this->db->where("(meet_time=" . $value['one'] . "OR meet_time=" . $value['two'] . ")", NULL, FALSE);
                                $querys = $this->db->get();
                                $meet = $querys->result_array();

                                if (count($meet) != 0) {
                                    $this->db->select("*");
                                    $this->db->from('tb_meetdetail');
                                    $this->db->join('tb_user', 'tb_user.use_id = tb_meetdetail.use_id');
                                    $this->db->where(array('meet_id' => $meet[0]['meet_id'], 'dmeet_status !=' => 0));
                                    $this->db->order_by("dmeet_head", "DESC");
                                    $querym = $this->db->get();
                                    $listt = $querym->result_array();
                                }
                                ?>

                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                <div class="product-desc">
                                    <small class="text-muted" style="font-size:14px">เวลานัด</small>
                                    <a href="#" class="product-name" style="font-size:32px"> <?= $value['two']; ?> น.</a>
                                    <? if (count($meet) != 0) { ?>
                                        <div class="small m-t-xs" style="font-size:14px">
                                            <p><strong>รายการ</strong> : <?= $meet[0]['project_name']; ?></p>
                                            <p><? foreach ($listt as $key => $v) { ?>
                                                    <? if ($v['use_id'] == $meet[0]['use_id']) { ?>
                                                        <span class="badge badge-danger badge-use"><?= $v['use_name']; ?></span>
                                                    <? } elseif ($v['dmeet_head'] == 1) { ?>
                                                        <span class="badge badge-warning badge-use"><?= $v['use_name']; ?></span>
                                                    <? } else { ?>
                                                        <span class="badge badge-default badgw-use"><?= $v['use_name']; ?></span>
                                                    <? } ?>
                                                <? } ?></p>
                                        </div>
                                    <? } ?>
                                    <? if (count($meet) == 0) { ?>
                                        <? if ($chkprojectrequest == 0) { ?>
                                            <? if (count($section_sub) != 0 && count($section_pro) != 0) { ?>
                                                <div class="m-t text-righ">
                                                    <button class="btn btn-xs btn-outline btn-primary btnajax" data-subid="<?= $sub_id; ?>" data-sub="<?= $sub_type; ?>" data-date="<?= $date; ?>" data-time="<?= $value['two']; ?>" data-url="<?= site_url('calendar/jsontimeT'); ?>"> เลือกนัดหมาย <i class="fa fa-long-arrow-right"></i> </button>
                                                </div>
                                            <? } else { ?>
                                                <div class="m-t text-righ">
                                                    <button class="btn btn-xs btn-outline btn-danger"> ไม่สามารถทำนัดได้ <i class="fa fa-long-arrow-right"></i> </button>
                                                </div>
                                            <? } ?>
                                        <? } ?>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            <? } ?>
        <? } ?>
    </div>
    <!-- meet -->
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="border-color: #1c84c6;">
                <h5><i class="fa fa-calendar-o"></i> &nbsp; <?= $sub_name; ?></h5>
            </div>
            <div class="ibox-content">
                <div>รหัสวิชา : <?= $sub_code; ?></div>
                <div>อาจารย์ประจำวิชา : <?= $use_name; ?></div>
                <div>จำนวนอาจารย์ขึ้นสอบ : <?= $sub_setuse; ?> คน</div>
            </div>
        </div>

        <form action="<?= base_url('calendar/request'); ?>" method="post" name="formCalendarrequest" id="formCalendarrequest" class="form-horizontal" novalidate>
            <input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
            <input type="hidden" name="txt_date" id="txt_date" value="<?= $date; ?>" />
            <input type="hidden" name="txt_subId" id="txt_subId" value="<?= $sub_id; ?>" />
            <input type="hidden" name="txt_time" id="txt_time" value="" />
            <input type="hidden" name="checkuse" id="checkuse" value="<?= $sub_setuse; ?>" />

            <?PHP if ($chkprojectrequest == 0) { ?>
                <div class="todo-list  ui-sortable" id="listttbutton"></div>
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
                <br />
            <?PHP } else { ?>
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <?PHP

                            $this->db->select("tb_projectperson.std_id,tb_projectperson.project_id");
                            $this->db->from('tb_projectperson');
                            $this->db->where('tb_projectperson.std_id', $this->encryption->decrypt($this->input->cookie('sysli')));
                            $query_projectperson = $this->db->get();
                            $projectperson = $query_projectperson->result_array();

                            $project_id  = $projectperson[0]['project_id'];

                            $this->db->select("*");
                            $this->db->from('tb_meet');
                            $this->db->join('tb_project', 'tb_project.project_id = tb_meet.project_id');
                            $this->db->where('tb_meet.project_id', $project_id);
                            $this->db->where('meet_status !=', 0);
                            $querysmeet = $this->db->get();
                            $listdata_meet = $querysmeet->result_array();

                            if (count($listdata_meet) != 0) {
                                $this->db->select("*");
                                $this->db->from('tb_meetdetail');
                                $this->db->join('tb_user', 'tb_user.use_id = tb_meetdetail.use_id');
                                $this->db->where(array('meet_id' => $listdata_meet[0]['meet_id'], 'dmeet_status !=' => 0));
                                $this->db->order_by("dmeet_head", "DESC");
                                $query_showrequest = $this->db->get();
                                $list_showrequest = $query_showrequest->result_array();
                            }

                        ?>

                        <? if (count($listdata_meet) != 0) { ?>
                            <div class="small m-t-xs" style="font-size:14px">
                                <p><strong><?= $listdata_meet[0]['project_name']; ?></strong> </p>
                                <p><? foreach ($list_showrequest as $key => $v) { ?>
                                        <? if ($v['use_id'] == $listdata_meet[0]['use_id']) { ?>
                                            <span class="badge badge-danger badge-use"><?= $v['use_name']; ?></span>
                                        <? } elseif ($v['dmeet_head'] == 1) { ?>
                                            <span class="badge badge-warning badge-use"><?= $v['use_name']; ?></span>
                                        <? } else { ?>
                                            <span class="badge badge-default badgw-use"><?= $v['use_name']; ?></span>
                                        <? } ?>
                                    <? } ?></p>
                            </div>
                        <? } ?>

                    </div>
                </div>
            <?PHP } ?>
        </form>
    </div>
</div>
