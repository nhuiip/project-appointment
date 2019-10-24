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
    <div class="col-lg-8">
        <div class="text-center m">
            <span id="sparkline9"></span>
        </div>
    </div>
    <div class="col-lg-4">
        <h2>สถิติการขึ้นสอบ</h2>
        <small>สถิติการขึ้นสอบของอาจารย์ในสาขา</small>
        <ul class="list-group clear-list m-t">
            <li class="list-group-item fist-item">
                <span class="pull-right label label-primary">
                    5
                </span>
                อาจารย์วิลาวรรณ สุขชนะ
            </li>
            <li class="list-group-item">
                <span class="pull-right label label-primary">
                    3
                </span>
                ดร.นพศักดิ์ ตันติสัตยานนท์
            </li>
            <li class="list-group-item">
                <span class="pull-right label label-primary">
                    4
                </span>
                ดร.คมศัลล์ ศรีวิสุทธิ์
            </li>
            <li class="list-group-item">
                <span class="pull-right label label-primary">
                    2
                </span>
                อาจารย์เอกรินทร์ วิจิตต์พันธ์
            </li>
            <li class="list-group-item">
                <span class="pull-right label label-primary">
                    3
                </span>
                อาจารย์พิสิฐ พรพงศ์เตชวาณิช
            </li>
            <li class="list-group-item">
                <span class="pull-right label label-primary">
                    4
                </span>
                อาจารย์สมพร พึ่งสม
            </li>
            <li class="list-group-item">
                <span class="pull-right label label-primary">
                    2
                </span>
                อาจารย์นภารัตน์ ชูไพร
            </li>
            <li class="list-group-item">
                <span class="pull-right label label-primary">
                    4
                </span>
                อาจารย์คงศักดิ์ นาคทิม
            </li>
        </ul>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>ประเภทการจัดทำปริญญานิพนธ์</h5>
                </div>
                <div class="ibox-content">
                    <div class="flot-chart">
                        <div class="flot-chart-pie-content" id="flot-pie-1"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>สถานะปริญญานิพนธ์</h5>
                </div>
                <div class="ibox-content">
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-line-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {

        var data = [{
            label: "กลุ่ม",
            data: 28,
            color: "#27ae60",
        }, {
            label: "เดี่ยว",
            data: 72,
            color: "#16a085",
        }];

        var plotObj = $.plot($("#flot-pie-1"), data, {
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
                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: false
            }
        });

    });

    $(function() {
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
        var barData = {
            label: "bar",
            data: [
                [1, 34],
                [2, 25],
                [3, 19],
                [4, 34],
                [5, 32],
                [6, 14]
            ]
        };
        $.plot($("#flot-line-chart"), [barData], barOptions);

    });
    $("#sparkline9").sparkline([5, 3, 4, 2, 3, 4, 2, 4], {
        type: 'bar',
        barWidth: 100,
        height: '350px',
        barColor: '#1ab394',
        negBarColor: '#c6c6c6'
    });
</script>