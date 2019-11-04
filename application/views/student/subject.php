<br>
<div class="row wrapper page-heading">
    <?PHP if (count($listsubject) != 0) { ?>

        <?PHP foreach ($listsubject as $key => $value) { ?>

            <div class="col-md-6">
                <!-- <a href="<?= base_url('student/stdsubjectdetail/' . $value['sub_id']); ?>"> -->
                    <div class="ibox">
                        <div class="ibox-content product-box">
                            <div class="product-desc">
                                <h4 class="text-muted"><?= $value['sub_code']; ?></h4>
                                <div class="product-name">
                                    <h2><?= $value['sub_name']; ?></h2>
                                </div>
                                <div class="small m-t-xs">
                                    <div style="color: #000;">
                                        <h4><?= $value['use_name']; ?></h4>
                                    </div>
                                </div>
                                <div class="m-t text-righ">
                                    <div class="btn  btn-outline btn-primary" onclick="myFunction_<?=$value['sub_id'];?>()">แสดงเอกสาร <i class="fa fa-long-arrow-right"></i> </div>
                                </div>

                                <div id="showdetailfile<?=$value['sub_id'];?>" style="display: none;">
                                    <br/>

                                    <?PHP

                                        $this->db->select('*');
                                        $this->db->from('tb_attached');
                                        $this->db->join('tb_subject', 'tb_subject.sub_id = tb_attached.sub_id');
                                        $this->db->where(array('tb_subject.sub_id' => $value['sub_id']));
                                        $query = $this->db->get();
                                        $listattached = $query->result_array();


                                      
                                    ?>

                                <div class="ibox float-e-margins">
                                    <div class="ibox-content no-padding">
                                        <ul class="list-group">
                                                <?PHP if (count($listattached) != 0) { ?>

                                                    <?PHP foreach ($listattached as $key => $value) { ?>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">
                                                            <a href="<?=base_url('uploads/attached/'.$value['att_filename']);?>" download style="color: #FFF;"><i class="fa fa-arrow-circle-down"></i> ดาวน์โหลด</a>
                                                            </span>
                                                            <i class="fa fa-file-text"></i> <?=$value['att_name'];?>
                                                        </li>
                                                    <?PHP } ?>

                                                <?PHP } else {?>
                                                    <br/>
                                                    <center>ยังไม่มีเอกสารดาวน์โหลด</center>
                                                <?PHP } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <br/>
                                </div>

                                <script>
                                    function myFunction_<?=$value['sub_id'];?>() {
                                        var x = document.getElementById("showdetailfile<?=$value['sub_id'];?>");
                                        if (x.style.display === "none") {
                                            x.style.display = "block";
                                        } else {
                                            x.style.display = "none";
                                        }
                                    }
                                </script>

                            </div>
                        </div>
                    </div>
                <!-- </a> -->
            </div>

        <?PHP } ?>
    <?PHP } ?>
</div>

