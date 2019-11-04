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

// echo '<pre>';
// print_r($listuser);
// echo '</pre>';
?>
<!-- Breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>หน้าแรก</h2>
        <ol class="breadcrumb">
            <li class="active"><strong>หน้าแรก</strong></li>
        </ol>
    </div>
</div>
<!-- End breadcrumb for page -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <div style="width: 100%">
            <canvas id="countChart" height="400" width="600" data-url="<?= site_url('dashboard/countmeet'); ?>"></canvas>
        </div>
    </div>
    <? if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), array("หัวหน้าสาขา", "อาจารย์ผู้สอน"))) { ?>
        <div class="col-lg-2">
        <? } ?>
        <? if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), array("ผู้ดูแลระบบ"))) { ?>
            <div class="col-lg-6">
            <? } ?>
            <h2>สถิติการขึ้นสอบ</h2>
            <small>สถิติการขึ้นสอบของอาจารย์ในสาขา</small>
            <ul class="list-group clear-list m-t">
                <?
                $users = array();
                $count = array();
                if (isset($listuser) && count($listuser) != 0) {
                    foreach ($listuser as $key => $value) {
                        $this->db->select("*");
                        $this->db->from('tb_meet');
                        $this->db->join('tb_meetdetail', 'tb_meetdetail.meet_id = tb_meet.meet_id');
                        $this->db->where('tb_meet.meet_status', 1);
                        $this->db->where('tb_meetdetail.dmeet_status', 1);
                        $this->db->where('tb_meetdetail.use_id', $value['use_id']);
                        $query_c = $this->db->get();
                        $listcount = $query_c->result_array();
                        ?>
                        <li class="list-group-item fist-item">
                            <span class="pull-right label label-primary">
                                <?= count($listcount); ?>
                            </span>
                            <?= $value['use_name']; ?>
                            <input type="hidden" class="js_user" value="<?= $value['use_name']; ?>">
                            <input type="hidden" class="js_conut" value="<?= count($listcount); ?>">
                        </li>
                <? }
                } ?>
                <input type="hidden">
            </ul>
            </div>
            <? if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), array("หัวหน้าสาขา", "อาจารย์ผู้สอน"))) { ?>
                <div class="col-lg-4">
                    <h2>รายการนัดหมาย</h2>
                    <small>.</small>
                    <ul class="list-group clear-list m-t">
                        <? if (isset($listmeet) && count($listmeet) != 0) {
                                foreach ($listmeet as $key => $value) { ?>
                                <li class="list-group-item fist-item" >
                                    <a href="#" data-toggle="modal" data-target="#meetUpdate" class="meetUpdate">
                                        <span class="pull-right label label-primary">
                                            <?= $value['meet_time']; ?>
                                        </span>
                                        <span class="pull-right label label-primary" style="margin-right: 5px;">
                                            <?= DateThai($value['meet_date']); ?>
                                        </span>
                                        <div style="color: #000;" ><?= $value['project_name']; ?></div>
                                    </a>
                                </li>
                        <? }
                            } ?>
                    </ul>
                </div>
            <? } ?>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>ประเภทการจัดทำปริญญานิพนธ์</h5>
                        </div>
                        <div class="ibox-content">
                            <? if (isset($listproject) && count($listproject) != 0) { ?>
                                <div class="flot-chart">
                                    <div class="flot-chart-pie-content" id="flot-pie" data-url="<?= site_url('dashboard/typeproject'); ?>"></div>
                                </div>
                            <? } else { ?>
                                <center>
                                    <p class="background"><span>ไม่พบข้อมูล</span></p>
                                </center>
                            <? } ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>สถานะปริญญานิพนธ์</h5>
                        </div>
                        <div class="ibox-content">
                            <? if (isset($listproject) && count($listproject) != 0) { ?>
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="flot-line-chart" data-url="<?= site_url('dashboard/statusproject'); ?>"></div>
                                </div>
                            <? } else { ?>
                                <center>
                                    <p class="background"><span>ไม่พบข้อมูล</span></p>
                                </center>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? if (isset($listproject) && count($listproject) != 0) { ?>
            <script>
                $(document).ready(function() {

                    var url1 = $('#flot-pie').attr("data-url");
                    var url2 = $('#flot-line-chart').attr("data-url");

                    $.ajax({
                        type: "GET",
                        contentType: 'application/json; charset=utf-8',
                        dataType: 'json',
                        url: url1,
                        error: function() {
                            alert("An error occurred.");
                        },
                        success: function(data) {
                            // alert("Success.");
                            // console.log(data);
                            var plotObj = $.plot($("#flot-pie"), data, {
                                series: {
                                    pie: {
                                        show: true
                                    }
                                },
                                grid: {
                                    hoverable: true
                                },
                                tooltip: true,
                                tooltipOpts: {
                                    content: "%p.0%, %s",
                                    shifts: {
                                        x: 20,
                                        y: 0
                                    },
                                    defaultTheme: false
                                }
                            });
                        }
                    });

                    $.ajax({
                        type: "GET",
                        contentType: 'application/json; charset=utf-8',
                        dataType: 'json',
                        url: url2,
                        error: function() {
                            alert("An error occurred.");
                        },
                        success: function(databar) {
                            // alert("Success.");
                            // console.log(data);
                            var barOptions = {
                                series: {
                                    lines: {
                                        show: true,
                                        lineWidth: 2,
                                        fill: true,
                                        fillColor: {
                                            colors: [{
                                                opacity: 0.0
                                            }, {
                                                opacity: 0.0
                                            }]
                                        }
                                    }
                                },
                                xaxis: {
                                    tickDecimals: 0,
                                    position: 'bottom',
                                    ticks: [
                                        [1, 'เริ่มต้น'],
                                        [2, 'ผ่านโครงงานหนึ่ง'],
                                        [3, 'ติดแก้ไขโครงงานสอง'],
                                        [4, 'ผ่านโครงงานสอง'],
                                        [5, 'Conference'],
                                        [6, 'ยกเลิกโปรเจค']
                                    ]
                                },
                                colors: ["#1ab394"],
                                grid: {
                                    color: "#999999",
                                    hoverable: true,
                                    clickable: true,
                                    tickColor: "#D4D4D4",
                                    borderWidth: 0
                                },
                                legend: {
                                    show: false
                                },
                                tooltip: true,
                                tooltipOpts: {
                                    content: "x: %x, y: %y"
                                }
                            };
                            $.plot($("#flot-line-chart"), [databar], barOptions);

                        }
                    });

                });
            </script>
        <? } ?>
        <? if (isset($listmeet) && count($listmeet) != 0) { ?>
            <script>
                $(document).ready(function() {
                    var url3 = $('#canvas').attr("data-url");
                    var js_conut = Array();
                    var js_user = Array();

                    $(".js_conut").each(function() {
                        js_conut.push($(this).val());
                    });
                    $(".js_user").each(function() {
                        js_user.push($(this).val());
                    });
                    var barChartData = {
                        labels: js_user,
                        datasets: [{
                            fillColor: "rgba(220,220,220,0.5)",
                            strokeColor: "rgba(220,220,220,0.8)",
                            highlightFill: "rgba(220,220,220,0.75)",
                            highlightStroke: "rgba(220,220,220,1)",
                            data: js_conut
                        }]
                    };
                    window.onload = function() {
                        var ctx = document.getElementById("countChart").getContext("2d");
                        var chart = new Chart(ctx).HorizontalBar(barChartData, {
                            responsive: true,
                            barShowStroke: false
                        });
                    };
                });
            </script>
        <? } ?>

        <div id="meetUpdate" class="modal fade" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6 b-r"><h3 class="m-t-none m-b">Sign in</h3>

                                <p>Sign in today for more expirience.</p>

                                <form role="form">
                                    <div class="form-group"><label>Email</label> <input type="email" placeholder="Enter email" class="form-control"></div>
                                    <div class="form-group"><label>Password</label> <input type="password" placeholder="Password" class="form-control"></div>
                                    <div>
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Log in</strong></button>
                                        <label> <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> Remember me </label>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-6"><h4>Not a member?</h4>
                                <p>You can create an account:</p>
                                <p class="text-center">
                                    <a href=""><i class="fa fa-sign-in big-icon"></i></a>
                                </p>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>