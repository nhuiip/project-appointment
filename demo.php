<?
public function busyAllday($date = "", $use_id = "")
    {
        // die;
        if (!empty($date) && !empty($use_id)) {
            $condition = array();
            $condition['fide'] = "sec_id, sec_status, sec_time_one, sec_time_two";
            $condition['where'] = array('use_id' => $use_id, 'sec_date' => $date);
            $listsec = $this->section->listData($condition);
            if (count($listsec) != 0) {
                foreach ($listsec as $key => $value) {

                    // ถ้ามีนัดแล้ว
                    if ($value['sec_status'] == 2) {
                        $this->db->select("tb_meet.meet_status, tb_meetdetail.meet_id, tb_meetdetail.dmeet_id, tb_meetdetail.dmeet_status, tb_subject.sub_setless");
                        $this->db->from('tb_meet');
                        $this->db->join('tb_meetdetail', 'tb_meetdetail.meet_id = tb_meet.meet_id');
                        $this->db->join('tb_subject', 'tb_subject.sub_id = tb_meet.sub_id');
                        $this->db->where('tb_meetdetail.use_id', $use_id);
                        $this->db->where('meet_date', $date);
                        $this->db->where("(tb_meet.meet_time=" . $value['sec_time_one'] . "OR tb_meet.meet_time=" . $value['sec_time_two'] . ")", NULL, FALSE);
                        $query = $this->db->get();
                        $meetdetail = $query->result_array();

                        // ถ้าเป็นนัดที่กดรับมาแล้ว
                        if ($meetdetail[0]['meet_status'] == 1) {
                            // dmeet_status ของตัวเอง = 0
                            $data = array(
                                'dmeet_id' => $meetdetail[0]['dmeet_id'],
                                'dmeet_status' => 0
                            );
                            $this->meet->updateDetail($data);

                            // หาจำนวนอาจารย์ขึ้นสอบที่เหลืออยู่
                            $condition = array();
                            $condition['fide'] = "dmeet_id";
                            $condition['where'] = array('meet_id' => $meetdetail[0]['meet_id'], 'dmeet_status' => 1);
                            $countdetail = $this->meet->listDatadetail($condition);

                            // ถ้าอาจารย์น้อยกว่าจำนวนน้อยที่สุดที่ขึ้นสอบได้
                            if (count($countdetail) < $meetdetail[0]['sub_setless']) {
                                foreach ($countdetail as $key => $cdetail) {
                                    // dmeet_status ของอาจารย์ท่านอื่น = 0
                                    $data = array(
                                        'dmeet_id' => $cdetail['dmeet_id'],
                                        'dmeet_status' => 0
                                    );
                                    $this->meet->updateDetail($data);
                                }
                                // meet_status = 0 **เท่ากับนัดนั้นยกเลิก
                                $data = array(
                                    'meet_id' => $meetdetail[0]['meet_id'],
                                    'meet_status' => 0
                                );
                                $this->meet->updateData2($data);

                                // ส่งเมล
                                $this->sentmail($meetdetail[0]['meet_id'], $use_id);
                            }
                        }
                        // ถ้าเป็นนัดที่ยังไม่รับ
                        elseif ($meetdetail[0]['meet_status'] == 2) {
                            // หาจำนวนอาจารย์ขึ้นสอบที่เหลือ
                            $condition = array();
                            $condition['fide'] = "dmeet_id";
                            $condition['where'] = array('meet_id' => $meetdetail[0]['meet_id']);
                            $countdetail = $this->meet->listDatadetail($condition);
                            foreach ($countdetail as $key => $cdetail) {
                                // dmeet_status ของอาจารย์ท่านอื่น = 0
                                $data = array(
                                    'dmeet_id' => $cdetail['dmeet_id'],
                                    'dmeet_status' => 0
                                );
                                $this->meet->updateDetail($data);
                                // meet_status = 0 **เท่ากับนัดนั้นยกเลิก
                                $data = array(
                                    'meet_id' => $meetdetail[0]['meet_id'],
                                    'meet_status' => 0
                                );
                                $this->meet->updateData2($data);
                            }
                            // ส่งเมล
                            $this->sentmail($meetdetail[0]['meet_id'], $use_id);
                        }
                    }
                    // อัพเดคเวลา
                    $data = array(
                        'sec_id'            => $value['sec_id'],
                        'sec_status'        => 0,
                    );
                    $this->section->updateData($data);
                }
                header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }
    ?>
