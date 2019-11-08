<div class="row wrapper page-heading">
    <br>
    <? if(isset($listcheckset) && count($listcheckset) != 0){ ?>
    <div class="col-lg-12">
        <div class="ibox-content">
            <div id='calendar' data-url="<?= base_url('calendar/jsoneven'); ?>">
            </div>
        </div>
        <br>
        <br>
    </div>
    <? } else { ?>
        <center><h1>ไม่มีกำหนดการเปิดนัดหมาย</h1></center>
    <? } ?>
</div>