<form action="<?= base_url('student/stdprojectadd'); ?>" method="post" enctype="multipart/form-data" name="formProjectStd_Add" id="formProjectStd_Add" class="form-horizontal" novalidate>
    <input type="hidden" name="formcrfaddproject" id="formcrfaddproject" value="<?= $formcrfaddproject; ?>">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><i class="fa fa-book"></i> &nbsp;&nbsp;เพิ่มข้อมูลปริญญานิพนธ์</h5>
        </div>
        <div class="ibox-content">
            <div class="form-group">
                <label class="col-sm-3 control-label">หัวข้อปริญญานิพนธ์ :<span class="text-muted" style="color:#c0392b">*</span></label>
                <div class="col-sm-9">
                    <input type="text" name="project_name" id="project_name" class="form-control" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">อาจารย์ที่ปรึกษา :<span class="text-muted" style="color:#c0392b">*</span></label>
                <div class="col-sm-9">
                    <select name="use_id" id="use_id" class="form-control">
                        <option value="">กรุณาเลือกอาจารย์ที่ปรึกษา</option>
                        <?PHP foreach ($listuser as $key => $value) { ?>
                            <option value="<?= $value['use_id']; ?>"><?= $value['use_name']; ?></option>
                        <? } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">ผู้จัดทำ :<span class="text-muted" style="color:#c0392b">*</span></label>
                <div class="col-sm-9">
                    <select name="std_id[]" id="std_id" class="form-control select2" data-placeholder="กรุณาเลือกที่ผู้จัดทำ" multiple>
                        <?PHP foreach ($liststd as $key => $value) { ?>
                            <option value="<?= $value['std_id']; ?>"><?= $value['std_fname'] . ' ' . $value['std_lname']; ?></option>
                        <? } ?>
                    </select>
                    <label class="error"> สามารถเลือกได้มากกว่า 1 คน **</label>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <button type="submit" class="btn btn-primary btn-block">บันทึก</button>
        </div>
    </div>
</form>