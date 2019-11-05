<ul class="list-group">
    <? foreach ($listmeetnow as $key => $value) { ?>
        <?
            $this->db->select("tb_user.use_name, tb_meetdetail.use_id, tb_meetdetail.dmeet_head, dmeet_status");
            $this->db->from('tb_meetdetail');
            $this->db->join('tb_user', 'tb_user.use_id = tb_meetdetail.use_id');
            $this->db->join('tb_meet', 'tb_meet.meet_id = tb_meetdetail.meet_id');
            $this->db->where(array('tb_meetdetail.meet_id' => $value['meet_id']));
            $this->db->order_by("use_name", "ASC");
            $query = $this->db->get();
            $listt = $query->result_array();
            ?>
        <?
            switch ($value['meet_status']) {
                case 0:
                    $status_text = '<div class="badges alt"><span class="content red">ล้มเหลว</span></div>';
                    break;
                case 1:
                    $status_text = '<div class="badges alt"><span class="content green">สำเร็จ</span></div>';
                    break;
                case 2:
                    $status_text = '<div class="badges alt"><span class="content orange">รอดำเนินการ</span></div>';
                    break;
            }
            ?>

            <li class="list-group-item" style="text-align: right;">
                <?= $status_text ?>
                <div class="row">
                    <div class="col-sm-12">
                        <p style="margin: 10px 0 0"><strong>วิชา : <?= $value['sub_code'] . ' ' . $value['sub_name']; ?></p>
                    </div>
                    <div class="col-sm-12">
                        <p><strong>ปีการศึกษา : </strong> <?= $value['set_year']; ?> <?= $value['set_term']; ?></p>
                    </div>
                    <?PHP if ($project_status == 1) { ?>
                        <div class="col-sm-12">
                            <p><strong>วันที่สอบ : <?= DateThai($value['meet_date']); ?> เวลา : </strong> <?= $value['meet_time']; ?> น.</p>
                        </div>
                    <?PHP } ?>
                    <div class="col-sm-12">
                        <table class="table table-hover">
                            <tbody>
                                <? foreach ($listt as $key => $v) { ?>
                                    <tr>
                                        <td width="70%" style="text-align: left;">
                                            <? if ($v['use_id'] == $value['use_id']) { ?>
                                                <div class="badges alt"><span class="tag"><?= $v['use_name']; ?></span><span class="content red">ที่ปรึกษา</span></div>
                                            <? } elseif ($v['dmeet_head'] == 1) { ?>
                                                <div class="badges alt"><span class="tag"><?= $v['use_name']; ?></span><span class="content orange">ประธาน</span></div>
                                            <? } else { ?>
                                                <div class="badges alt"><span class="tag"><?= $v['use_name']; ?></span></div>
                                            <? } ?>
                                        </td>
                                        <td width="30%" style="padding-right: 0;">
                                            <? if ($v['dmeet_status'] == 1) { ?>
                                                <div class="badges alt"><span class="content green">ยอมรับ</span></div>
                                            <? } elseif ($v['dmeet_status'] == 2) { ?>
                                                <div class="badges alt"><span class="content orange">รอดำเนินการ</span></div>
                                            <? } elseif ($v['dmeet_status'] == 0) { ?>
                                                <div class="badges alt"><span class="content red">ปฏิเสธ</span></div>
                                            <? } ?>
                                        </td>
                                    </tr>
                                <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </li>
        <? } ?>
</ul>