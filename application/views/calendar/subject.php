<!-- show date -->
<?PHP $year = date('Y') + '543'; ?>

<?PHP if($listsubject != 0){ ?>
    <div class="wrapper wrapper-content animated fadeInRight">     
        <div class="ibox float-e-margins">
            <div class="ibox-title" >
                <h5><i class="fa fa-mortar-board"></i>  รายวิชาที่เปิดให้ขึ้นสอบปริญญานิพนธ์ ประจำปี <?PHP echo $year;?></h5>
            </div>
        </div> 
        <div class="row">
            <?PHP foreach ($listsubject as $key => $value) { ?>

                <div class="col-md-3">
                    <a href="<?=base_url('calendar/detail/'.$value['sub_type']."/".$date);?>">
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                <div class="product-desc">
                                    <small class="text-muted"><?=$value['sub_code'];?></small>
                                    <div  class="product-name"> <?=$value['sub_name'];?></div>
                                    <div class="small m-t-xs">
                                        <div style="color: #000;"><?=$value['use_name'];?></div>
                                    </div>
                                    <div class="m-t text-righ">
                                        <div class="btn btn-xs btn-outline btn-primary">ส่งคำขอขึ้นสอบ <i class="fa fa-long-arrow-right"></i> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            <?PHP } ?>
        </div>
    </div>
<?PHP } else {?>

<?PHP } ?>