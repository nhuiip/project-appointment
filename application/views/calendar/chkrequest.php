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
        <div class="col-lg-2"> </div>
        <div class="col-lg-8 animated fadeInRight">
            <div class="mail-box-header">
                <div class="pull-right tooltip-demo">
                    <!-- <a href="mail_compose.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Reply"><i class="fa fa-reply"></i> Reply</a>
                    <a href="#" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Print email"><i class="fa fa-print"></i> </a>
                    <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </a> -->
                </div>
                <h2> <?=$project_name; ?>  </h2>
                <div class="mail-tools tooltip-demo m-t-md">

                    <div class="row">
                        <div class="col-sm-8">
                            <h4>
                                <span class="font-noraml"><strong>รหัสวิชา : </strong> </span> <?=$sub_code; ?>
                            </h4>
                            <h4>
                                <span class="font-noraml"><strong>รายวิชา : </strong> </span> <?=$sub_name; ?>
                            </h4>
                            <h4>
                                <span class="font-noraml"><strong>อาจารย์ที่ปรึกษา : </strong> </span> <?=$teacher_fullname; ?>
                            </h4>
                        </div>
                        <div class="col-sm-4">
                            <h4><strong>วันที่ขอขึ้นสอบ : </strong> <?= DateThai($meet_date); ?></h4>
                        
                            <h4><strong>ช่วงเวลาที่ขอขึ้นสอบ : </strong> <?=$meet_time;?> นาฬิกา</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mail-box">
                <div class="mail-body">
                    

                <?PHP if($meetHeadshow != 0) {?>

                    <h3>รายชื่ออาจารย์ที่ทำการขึ้นสอบปริญญานิพนธ์</h3>
                    <div class="row">
                    <?PHP if (count($listmeet) != 0){ ?>
                        <?PHP foreach ($listmeet as $key => $value) { ?>
                            <div class="col-sm-2">
                                <?PHP if($value['dmeet_head'] == 1){?>
                                    <b>ประธานการสอบ</b>
                                <?PHP } else{?>
                                    <b>กรรมการสอบ</b>
                                <?PHP } ?>
                            </div>
                            <div class="col-sm-10"> <?=$value['use_name'];?> </div>

                        <?PHP } ?>
                    <?PHP } ?>
                    </div>

                <?PHP } else { ?>

                    <div class="alert alert-danger">
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
                    </div>

                <?PHP } ?>

                </div>
                <!-- <div class="mail-attachment">
                    <p>
                        <center>
                            มหาวิทยาลัยเทคโนโลยีราชมงคลรัตนโกสินทร์ วิทยาเขตวังไกลกังวล คณะอุตสาหกรรมและเทคโนโลยี สาขาเทคโนโลยีสารสนเทศ<br>
                            ถนนเพชรเกษม ตำบล หนองแก อำเภอหัวหิน ประจวบคีรีขันธ์ 7711
                        </center>
                    </p>

                    <div class="clearfix"></div>
                </div> -->
                <?PHP if($meetHeadshow != 0) {?>
                <div class="mail-body text-right tooltip-demo">
                    <!-- <a class="btn btn-sm btn-white" href="mail_compose.html"><i class="fa fa-reply"></i> Reply</a> -->
                    <form action="<?=base_url('calendar/sandrequest');?>" name="" id="" method="post" class="form-horizontal" novalidate>

                        <button type="submit" class="btn btn-outline btn-primary"> <i class="fa fa-arrow-right"></i> ส่งคำขอขึ้นสอบปริญญานิพนธ์</button>

                    </form>
                    <!-- <a class="btn btn-sm btn-white" href="mail_compose.html"><i class="fa fa-arrow-right"></i> ส่งคำขอขึ้นสอบปริญญานิพนธ์</a> -->
                    <!-- <button title="" data-placement="top" data-toggle="tooltip" type="button" data-original-title="Print" class="btn btn-sm btn-white"><i class="fa fa-print"></i> Print</button> -->
                    <!-- <button title="" data-placement="top" data-toggle="tooltip" data-original-title="Trash" class="btn btn-sm btn-white"><i class="fa fa-trash-o"></i> Remove</button> -->
                </div>
                <?PHP } ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-lg-2"> </div>

    </div>
</div>