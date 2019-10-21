<?
//ค้นหาโปรเจคที่นักศึกษาสร้างไว้
if (isset($listshowproject) && count($listshowproject) != 0) {
    foreach ($listshowproject as $key => $value) {
        $project_id             = $value['project_id'];
        $project_name           = $value['project_name'];
        $project_status         = $value['project_status'];
        $project_create_name    = $value['project_create_name'];
        $project_create_date    = $value['project_create_date'];
        $project_lastedit_name  = $value['project_lastedit_name'];
        $project_lastedit_date  = $value['project_lastedit_date'];
    }
}

function DateThai($meet_date)
{
    $strYear = date("Y", strtotime($meet_date)) + 543;
    $strMonth = date("n", strtotime($meet_date));
    $strDay = date("j", strtotime($meet_date));
    $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-4">

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-book"></i> ข้อมูลปริญญานิพนธ์</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <p><strong>หัวข้อปริญญานิพนธ์ : </strong> <?=$project_name; ?></p>
                        </div>
                        <div class="col-sm-12">
                            <p><strong>อาจารย์ที่ปรึกษา : </strong> <?=$teacher_fullname; ?></p>
                        </div>
                        <div class="col-sm-12">
                            <p><strong>ผู้จัดทำ : </strong>
                                <? foreach ($listprojectperson as $key => $list) { ?>
                                    <span class="badge">&nbsp;&nbsp;<?= $list['std_title'] . '' . $list['std_fname'] . ' ' . $list['std_lname']; ?>&nbsp;&nbsp;</span>
                                <? } ?>
                            </p>
                        </div>
                        <div class="col-sm-12">
                            <p>
                                <strong>เพิ่มข้อมูล :
                                <?= $project_create_name; ?>&nbsp;&nbsp;
                                <small class="text-muted">
                                    <i class="fa fa-clock-o"></i>
                                    <?= date('d/m/Y h:i A', strtotime($project_create_date)); ?>
                                </small>
                            <p>
                        </div>
                        <div class="col-sm-12">
                            <p>
                                <strong>แก้ไขล่าสุด :
                                <?= $project_lastedit_name; ?>&nbsp;&nbsp;
                                <small class="text-muted">
                                    <i class="fa fa-clock-o"></i>
                                    <?= date('d/m/Y h:i A', strtotime($project_lastedit_date)); ?>
                                </small>
                            <p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4">

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-book"></i> ข้อมูลการขอขึ้นสอบปริญญานิพนธ์</h5>
                </div>
                <div class="ibox-content">

                    <div class="row">
                        <div class="col-sm-12">
                            <p><strong>วันที่ทำการขอขึ้นสอบ : </strong> <?= DateThai($meet_date); ?></p>
                        </div>
                        <div class="col-sm-12">
                            <p><strong>ช่วงเวลาที่ขอขึ้นสอบ : </strong> <?=$meet_time;?> นาฬิกา</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>ข้อมูลอาจารย์ขึ้นสอบปริญญานิพนธ์</h5>
                </div>
                <div class="ibox-content">
                    
                    <?PHP if($meetHeadshow != 0) {?>

                        <?PHP if (count($listmeet) != 0){ ?>
                            <?PHP foreach ($listmeet as $key => $value) { ?>

                                <div>
                                    <label><?=$value['use_name'];?> </label> 
                                    <?PHP if($value['dmeet_head'] == 1){?>
                                        <span class="badge badge-danger">ประธานการสอบ</span>
                                    <?PHP } ?>
                                </div>

                            <?PHP } ?>
                        <?PHP } ?>
                        <br/>
                        <form action="<?=base_url('calendar/sandrequest');?>" name="" id="" method="post" class="form-horizontal" novalidate>

                            <button type="submit" class="btn btn-block btn-outline btn-primary">ส่งคำขอเพื่อขึ้นสอบปริญญานิพนธ์</button>

                        </form>

                    <?PHP } else { ?>

                        <label>กรุณาเลือกประธานสำหรับขึ้นสอบปริญญานิพนธ์</label>
                        <br/>

                        <?PHP if (count($listmeet) != 0){ ?>
                            <?PHP foreach ($listmeet as $key => $value) { ?>

                                <div class="radio radio-success">
                                    <input type="radio" class="btn-checkuserHead" data-url="<?=base_url('calendar/addhead');?>" data-title="อัพเดตข้อมูลประธานการสอบ"  data-meetId="<?=$value['dmeet_id']?>" data-text="<?=$value['use_name']?>" data-id="<?=$value['use_id']?>" name="radio" id="radio-<?=$value['use_id']?>" value="<?=$value['use_id']?>"  >
                                    <label for="radio-<?=$value['use_id']?>"> <?=$value['use_name'];?> </label>
                                </div>

                            <?PHP } ?>
                        <?PHP } ?>

                    <?PHP } ?>

                    
                    <!-- <br/>
                    <button type="submit" class="btn btn-block btn-outline btn-primary">ยืนยันข้อมูล</button> -->
                </div>
            </div>

        </div>
    </div>
</div>