<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Section extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("setting_model", "setting");
        $this->load->model("holiday_model", "holiday");
        $this->load->model("section_model", "section");
        $this->load->model("project_model", "project");
        $this->load->model("administrator_model", "administrator");
        $this->load->model("meet_model", "meet");
        $this->load->model("emailset_model", "emailset");
        $this->load->helper('fileexist');
    }

    public function timecheck($id = '')
    {
        if (!empty($id)) {
            $condition = array();
            $condition['fide'] = "sec_status";
            $condition['where'] = array('sec_id' => $id);
            $listsec = $this->section->listData($condition);
            if ($listsec[0]['sec_status'] == 0) {
                $sec_status = 1;
            } else {
                $sec_status = 0;
            }
            $data = array(
                'sec_id'            => $id,
                'sec_status'        => $sec_status
            );
            $this->section->updateData($data);
            header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
        } else {
            show_404();
        }
    }

    // ว่างเช้า
    public function freeM($date = "", $use_id = "")
    {
        if (!empty($date) && !empty($use_id)) {
            $time = array('9.00', '10.00', '11.00');
            foreach ($time as $key => $value) {
                $condition = array();
                $condition['fide'] = "sec_id, sec_status";
                $condition['where'] = array('use_id' => $use_id, 'sec_date' => $date, 'sec_time_one' => $value);
                $listsec = $this->section->listData($condition);
                if (count($listsec) != 0) {
                    if ($listsec[0]['sec_status'] != 2) {
                        $data = array(
                            'sec_id'            => $listsec[0]['sec_id'],
                            'sec_status'        => 1,
                        );
                        $this->section->updateData($data);
                    }
                }
            }
            header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
        } else {
            show_404();
        }
    }
    // ไม่ว่างเช้า
    public function busyM($date = "", $use_id = "")
    {
        if (!empty($date) && !empty($use_id)) {
            $time = array('9.00', '10.00', '11.00');
            foreach ($time as $key => $value) {
                $condition = array();
                $condition['fide'] = "sec_id, sec_status, sec_time_one, sec_time_two";
                $condition['where'] = array('use_id' => $use_id, 'sec_date' => $date, 'sec_time_one' => $value);
                $listsec = $this->section->listData($condition);
                if (count($listsec) != 0) {
                    // ถ้ามีนัดแล้ว
                    if ($listsec[0]['sec_status'] == 2) {
                        $this->db->select("tb_meet.meet_status, tb_meetdetail.meet_id, tb_meetdetail.dmeet_id, tb_meetdetail.dmeet_status, tb_subject.sub_setless");
                        $this->db->from('tb_meet');
                        $this->db->join('tb_meetdetail', 'tb_meetdetail.meet_id = tb_meet.meet_id');
                        $this->db->join('tb_subject', 'tb_subject.sub_id = tb_meet.sub_id');
                        $this->db->where('tb_meetdetail.use_id', $use_id);
                        $this->db->where('meet_date', $date);
                        $this->db->where("(tb_meet.meet_time=" . $listsec[0]['sec_time_one'] . "OR tb_meet.meet_time=" . $listsec[0]['sec_time_two'] . ")", NULL, FALSE);
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
                                foreach ($countdetail as $key => $value) {
                                    // dmeet_status ของอาจารย์ท่านอื่น = 0
                                    $data = array(
                                        'dmeet_id' => $value['dmeet_id'],
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
                            // ถ้าเป็นนัดที่กำลังดำเนินการ
                        } elseif ($meetdetail[0]['meet_status'] == 2) {
                            // หาจำนวนอาจารย์ขึ้นสอบที่เหลือ
                            $condition = array();
                            $condition['fide'] = "dmeet_id";
                            $condition['where'] = array('meet_id' => $meetdetail[0]['meet_id']);
                            $countdetail = $this->meet->listDatadetail($condition);
                            foreach ($countdetail as $key => $value) {
                                // dmeet_status ของอาจารย์ท่านอื่น = 0
                                $data = array(
                                    'dmeet_id' => $value['dmeet_id'],
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
                    $data = array(
                        'sec_id'            => $listsec[0]['sec_id'],
                        'sec_status'        => 0,
                    );
                    $this->section->updateData($data);
                } else {
                    show_404();
                }
            }
            header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
        } else {
            show_404();
        }
    }

    // ว่างบ่าย
    public function freeA($date = "", $use_id = "")
    {
        if (!empty($date) && !empty($use_id)) {
            $time = array('13.00', '14.00', '15.00');
            foreach ($time as $key => $value) {
                $condition = array();
                $condition['fide'] = "sec_id, sec_status";
                $condition['where'] = array('use_id' => $use_id, 'sec_date' => $date, 'sec_time_one' => $value);
                $listsec = $this->section->listData($condition);
                if (count($listsec) != 0) {
                    if ($listsec[0]['sec_status'] != 2) {
                        $data = array(
                            'sec_id'            => $listsec[0]['sec_id'],
                            'sec_status'        => 1,
                        );
                        $this->section->updateData($data);
                    }
                }
            }
            header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
        } else {
            show_404();
        }
    }
    // ไม่ว่างบ่าย
    public function busyA($date = "", $use_id = "")
    {
        if (!empty($date) && !empty($use_id)) {
            $time = array('13.00', '14.00', '15.00');
            foreach ($time as $key => $value) {
                $condition = array();
                $condition['fide'] = "sec_id, sec_status, sec_time_one, sec_time_two";
                $condition['where'] = array('use_id' => $use_id, 'sec_date' => $date, 'sec_time_one' => $value);
                $listsec = $this->section->listData($condition);

                if (count($listsec) != 0) {
                    // ถ้ามีนัดแล้ว
                    if ($listsec[0]['sec_status'] == 2) {
                        $this->db->select("tb_meet.meet_status, tb_meetdetail.meet_id, tb_meetdetail.dmeet_id, tb_meetdetail.dmeet_status, tb_subject.sub_setless");
                        $this->db->from('tb_meet');
                        $this->db->join('tb_meetdetail', 'tb_meetdetail.meet_id = tb_meet.meet_id');
                        $this->db->join('tb_subject', 'tb_subject.sub_id = tb_meet.sub_id');
                        $this->db->where('tb_meetdetail.use_id', $use_id);
                        $this->db->where('meet_date', $date);
                        $this->db->where("(tb_meet.meet_time=" . $listsec[0]['sec_time_one'] . "OR tb_meet.meet_time=" . $listsec[0]['sec_time_two'] . ")", NULL, FALSE);
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
                                foreach ($countdetail as $key => $value) {
                                    // dmeet_status ของอาจารย์ท่านอื่น = 0
                                    $data = array(
                                        'dmeet_id' => $value['dmeet_id'],
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
                            // ถ้าเป็นนัดที่กำลังดำเนินการ
                        } elseif ($meetdetail[0]['meet_status'] == 2) {
                            // หาจำนวนอาจารย์ขึ้นสอบที่เหลือ
                            $condition = array();
                            $condition['fide'] = "dmeet_id";
                            $condition['where'] = array('meet_id' => $meetdetail[0]['meet_id']);
                            $countdetail = $this->meet->listDatadetail($condition);
                            foreach ($countdetail as $key => $value) {
                                // dmeet_status ของอาจารย์ท่านอื่น = 0
                                $data = array(
                                    'dmeet_id' => $value['dmeet_id'],
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
                    $data = array(
                        'sec_id'            => $listsec[0]['sec_id'],
                        'sec_status'        => 0,
                    );
                    $this->section->updateData($data);
                } else {
                    show_404();
                }
            }
            header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
        } else {
            show_404();
        }
    }

    // ว่างทั้งวัน
    public function freeAllday($date = "", $use_id = "")
    {
        if (!empty($date) && !empty($use_id)) {
            $condition = array();
            $condition['fide'] = "sec_id, sec_status";
            $condition['where'] = array('use_id' => $use_id, 'sec_date' => $date);
            $listsec = $this->section->listData($condition);
            if (count($listsec)) {
                foreach ($listsec as $key => $value) {
                    if ($value['sec_status'] != 2) {
                        $data = array(
                            'sec_id'            => $value['sec_id'],
                            'sec_status'        => 1,
                        );
                        $this->section->updateData($data);
                    }
                }
            }
            header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
        } else {
            show_404();
        }
    }
    // ไม่ว่างทั้งวัน
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
                    
                    // อัพเดคเวลา
                    $data = array(
                        'sec_id'            => $value['sec_id'],
                        'sec_status'        => 0,
                    );
                    $this->section->updateData($data);

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
                                foreach ($countdetail as $key => $value) {
                                    // dmeet_status ของอาจารย์ท่านอื่น = 0
                                    $data = array(
                                        'dmeet_id' => $value['dmeet_id'],
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
                            foreach ($countdetail as $key => $value) {
                                // dmeet_status ของอาจารย์ท่านอื่น = 0
                                $data = array(
                                    'dmeet_id' => $value['dmeet_id'],
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
                }
                header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    //form mail อาจารย์
    public function bodymail_use($data)
    {
        $html = file_get_contents("assets/template_email/teac-meetcancel-email.html");
        $html = str_replace('[DATA-PROJECTNAME] ', $data['project_name'], $html);
        $html = str_replace('[DATA-TIME]', $data['meet_time'], $html);
        $html = str_replace('[DATA-USERNAME]', $data['use_name'], $html);
        $html = str_replace('[DATA-DATE]', $data['strDay'], $html);
        return $html;
    }

    //form mail นักศึกษา
    public function bodymail_std($data)
    {
        $html = file_get_contents("assets/template_email/std-meetcancel-email.html");
        $html = str_replace('[DATA-PROJECTNAME] ', $data['project_name'], $html);
        $html = str_replace('[DATA-TIME]', $data['meet_time'], $html);
        $html = str_replace('[DATA-USERNAME]', $data['use_name'], $html);
        $html = str_replace('[DATA-DATE]', $data['strDay'], $html);
        return $html;
    }

    //ส่งเมลนัดล้มเหลว
    public function sentmail($id = "", $useid = "")
    {
        // setting email
        $condition = array();
        $condition['fide'] = "email_user, email_password";
        $condition['where'] = array('email_status' => 1);
        $listemail = $this->emailset->listData($condition);

        if (!empty($id) && !empty($useid)) {

            $condition = array();
            $condition['fide'] = "meet_date, meet_time, use_email, tb_meet.project_id, project_name";
            $condition['where'] = array('tb_meetdetail.meet_id' => $id);
            $listdata = $this->meet->listjoinData2($condition);

            $condition = array();
            $condition['fide'] = "use_name";
            $condition['where'] = array('use_id' => $useid);
            $usename = $this->administrator->listData($condition);

            $condition = array();
            $condition['fide'] = "std_email";
            $condition['where'] = array('tb_projectperson.project_id' => $listdata[0]['project_id']);
            $liststd = $this->project->listperson($condition);
        }
        if (count($listdata) != 0) {
            //แปลงวันที่
            $strYear = date("Y", strtotime($listdata[0]['meet_date'])) + 543;
            $strMonth = date("n", strtotime($listdata[0]['meet_date']));
            $strDay = date("j", strtotime($listdata[0]['meet_date']));
            $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
            $strMonthThai = $strMonthCut[$strMonth];
            // ข้อมูลไป form mail
            $data = array(
                'project_name'  => $listdata[0]['project_name'],
                'strDay'        => $strDay . '&nbsp;' . $strMonthThai . '&nbsp;' . $strYear,
                'meet_time'     => $listdata[0]['meet_time'],
                'use_name'      => $usename[0]['use_name'],
            );

            //ส่งเมลนัดล้มเหลว อาจารย์
            require_once APPPATH . 'third_party/class.phpmailer.php';
            require_once APPPATH . 'third_party/class.smtp.php';
            $mail = new PHPMailer;

            // ## setting SMTP GMAIL
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Mailer = "smtp";
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->Username = $listemail[0]['email_user'];
            $mail->Password = $listemail[0]['email_password'];
            $mail->setFrom($listemail[0]['email_user'], 'Appoint-IT');

            foreach ($listdata as $key => $value) {
                // $mail->AddAddress($value['use_email']);
                $mail->AddAddress('preedarat.jut@gmail.com');
            }

            $mail->Subject = "มีข้อความติดต่อจาก : Appoint-IT";
            $message = $this->bodymail_use($data);
            $mail->MsgHTML($message);
            $mail->send();

            //ส่งเมลนัดล้มเหลว นักศึกษา
            if (count($liststd) != 0) {

                require_once APPPATH . 'third_party/class.phpmailer.php';
                require_once APPPATH . 'third_party/class.smtp.php';
                $mail = new PHPMailer;

                // ## setting SMTP GMAIL
                $mail->IsSMTP();
                $mail->CharSet = 'UTF-8';
                $mail->Mailer = "smtp";
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "tls";
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 587;
                $mail->Username = $listemail[0]['email_user'];
                $mail->Password = $listemail[0]['email_password'];
                $mail->setFrom($listemail[0]['email_user'], 'Appoint-IT');

                foreach ($liststd as $key => $value) {
                    // $mail->AddAddress($value['use_email']);
                    $mail->AddAddress('yui.napassorn.s@gmail.com');
                }

                $mail->Subject = "มีข้อความติดต่อจาก : Appoint-IT";
                $message = $this->bodymail_std($data);
                $mail->MsgHTML($message);
                $mail->send();
            }
        }
    }
}
