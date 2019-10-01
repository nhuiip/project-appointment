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
            <? if ($sub_type == 1) { ?>
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
                                            <button class="btn btn-xs btn-outline btn-primary">เลือกนัดหมาย <i class="fa fa-check"></i> </button>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            <? } elseif ($sub_type == 2) { ?>
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
                                                <button class="btn btn-xs btn-outline btn-primary btnajax" data-date="<?= $date; ?>" data-time="<?= $value['two']; ?>" data-url="<?= site_url('calendar/jsontimeT'); ?>"> เลือกนัดหมาย <i class="fa fa-long-arrow-right"></i> </button>
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

            <ul class="todo-list m-t ui-sortable" id="listtt">

            </ul>

        </div>
    </div>
</div>

<!-- <script>
    $('.btnajax').click(function() {
        var date = $(this).attr('data-date');
        var time = $(this).attr('data-time');
        var url = $(this).attr('data-url');
        $.ajax({
            method: "POST",
            dataType: "json",
            url: url,
            data: {
                date: date,
                time: time,
            },
            success: function(result) {
                $.each(result.data, function(i, item){
                    console.log(item.id);
                });
            },
            error: function(jqXHR, exception) {
                if (jqXHR.status === 0) {
                    alert('Not connect.\n Verify Network.');
                } else if (jqXHR.status == 404) {
                    alert('Requested page not found. [404]');
                } else if (jqXHR.status == 500) {
                    alert('Internal Server Error [500].');
                } else if (exception === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (exception === 'timeout') {
                    alert('Time out error.');
                } else if (exception === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('Uncaught Error.\n' + jqXHR.responseText);
                }
            }
        });
    });
</script> -->
<!-- list -->
<div class="modal fade" id="listT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body" id="testmodel">
                <input class="use_name">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>