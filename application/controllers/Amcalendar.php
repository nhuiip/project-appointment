<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Amcalendar extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("project_model", "project");
        $this->load->model("student_model", "student");
        $this->load->model("subject_model", "subject");
        $this->load->model("setting_model", "setting");
        $this->load->model("section_model", "section");
        $this->load->model("meet_model", "meet");
        $this->load->model("administrator_model", "administrator");
        $this->load->library('cart');
        $this->load->library('session');
    }

    public function index()
    {
        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            $data = array();

            $condition['fide'] = "*";
            $condition['where'] = array('tb_settings.set_status' => 2);
            $condition['groupby'] = "sec_date";
            $data['listsec'] = $this->section->listjoinData($condition);
            
            $time = array();
            $time[0] = array('one' => '9.00', 'two' => '9.00');
            $time[1] = array('one' => '10.00', 'two' => '10.30');
            $time[2] = array('one' => '11.00', 'two' => '12.00');
            $time[3] = array('one' => '13.00', 'two' => '13.00');
            $time[4] = array('one' => '14.00', 'two' => '14.30');
            $time[5] = array('one' => '15.00', 'two' => '16.00');

            $data['time'] = $time;
            $this->template->backend('calendar/adminmain', $data);
        } else {
            show_404();
        }
    }

    public function request(){

        

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
          
            $data = array();
           
            $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
            $data['idlogin']    = $this->encryption->decrypt($this->input->cookie('sysli'));

            // $condition = array();
            // $condition['fide'] = "*";
            // $condition['where'] = array('tb_meetdetail.use_id' => $idlogin);
            // $data['meet'] = $this->meet->listjoinData2($condition);

            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('calendar/request', $data);
            
        }

    }

    //ยืนยันการนัดหมาย
    public function submit($dmeet_id = '', $use_id = ''){


        //อัพเดตสถานะเป็น 1 คือการยอมรับนัดหมาย
        $data = array(
            'dmeet_id'         => $dmeet_id,
            'use_id'          => $use_id,
            'dmeet_status'    => 1,
        );
        $this->meet->updateDetail($data);

        //ค้นหาในตารางเวลา เพื่ออัพเดตค่าเวลาเป็น 0 เท่ากับไม่ว่าง (ของยุ้ย)
        //ค้นหาในตารางเวลา เพื่ออัพเดตค่าเวลาเป็น 2 เท่ากับมีนัดแล้ว (หนุ่ยแก้)
        $condition = array();
        $condition['fide'] = "tb_meet.meet_id,tb_meet.sub_id,tb_meetdetail.dmeet_id,tb_meet.meet_date,tb_meet.meet_time, tb_project.project_id,, tb_project.project_name";
        $condition['where'] = array('tb_meetdetail.dmeet_id' => $dmeet_id);
        $selectmeetsec = $this->meet->listjoinData2($condition);

        $meet_id   = $selectmeetsec[0]['meet_id'];
        $sub_id    = $selectmeetsec[0]['sub_id'];
        $meet_date = $selectmeetsec[0]['meet_date'];
        $meet_time = $selectmeetsec[0]['meet_time'];
        $project_id = $selectmeetsec[0]['project_id'];
        $project_name = $selectmeetsec[0]['project_name'];

        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('sec_date' => $meet_date,'sec_time_one' => $meet_time,'use_id' => $use_id, );
        $selectsection = $this->section->listData($condition);
        if(count($selectsection ) == 0){
            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array('sec_date' => $meet_date,'sec_time_two' => $meet_time,'use_id' => $use_id, );
            $selectsection = $this->section->listData($condition);

            $data = array(
                'sec_id'         => $selectsection[0]['sec_id'],
                'sec_status'     => 2,
            );
            $this->section->updateData($data);

        }else{

            $data = array(
                'sec_id'         => $selectsection[0]['sec_id'],
                'sec_status'     => 2,
            );
            $this->section->updateData($data);

        }

        //เช็คจำนวนคนที่กดยอมรับว่าครบที่กำหนดไหม หากครบ นัดต้องเป็น 1
        $condition = array();
        $condition['fide'] = "tb_meetdetail.meet_id,tb_meetdetail.dmeet_id,tb_meetdetail.use_id,tb_meet.meet_date,tb_meet.meet_time";
        $condition['where'] = array('tb_meetdetail.meet_id' => $meet_id, 'tb_meetdetail.dmeet_status' => 1);
        $selectmeetuser = $this->meet->listjoinData2($condition);

        $condition = array();
        $condition['fide'] = "tb_subject.sub_id,tb_subject.sub_setuse";
        $condition['where'] = array('tb_subject.sub_id' => $sub_id);
        $selectsubject = $this->meet->listjoinData($condition);

        //หากจำนวนอาจารย์ที่ทำนัดยอมรับครบตามที่กำหนด ต้องอัพเดตสถานะ user เป็น 0
        if(count($selectmeetuser) == $selectsubject[0]['sub_setuse'] ){

            //อัพเดตในตาราง tb_meerdetail เป็น use_id = 1 [สำเร็จ]
            foreach ($selectmeetuser as $key => $value) {

                $data = array(
                    'dmeet_id'         => $value['dmeet_id'],
                    'use_id'          => $value['use_id'],
                    'dmeet_status'    => 1,
                );
                $this->meet->updateDetail($data);

                //ค้นหาในตารางเวลา เพื่ออัพเดตค่าเวลาเป็น 0 = ไม่ว่าง
                $condition = array();
                $condition['fide'] = "tb_meet.meet_id,tb_meet.sub_id,tb_meetdetail.dmeet_id,tb_meet.meet_date,tb_meet.meet_time";
                $condition['where'] = array('tb_meetdetail.dmeet_id' => $dmeet_id);
                $selectmeetsec = $this->meet->listjoinData2($condition);

                $meet_id   = $selectmeetsec[0]['meet_id'];
                $sub_id    = $selectmeetsec[0]['sub_id'];
                $meet_date = $selectmeetsec[0]['meet_date'];
                $meet_time = $selectmeetsec[0]['meet_time'];

                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('sec_date' => $meet_date,'sec_time_one' => $meet_time,'use_id' => $use_id, );
                $selectsection = $this->section->listData($condition);
                if(count($selectsection ) == 0){
                    $condition = array();
                    $condition['fide'] = "*";
                    $condition['where'] = array('sec_date' => $meet_date,'sec_time_two' => $meet_time,'use_id' => $use_id, );
                    $selectsection = $this->section->listData($condition);

                    $data = array(
                        'sec_id'         => $selectsection[0]['sec_id'],
                        'sec_status'     => 2,
                    );
                    $this->section->updateData($data);

                }else{

                    $data = array(
                        'sec_id'         => $selectsection[0]['sec_id'],
                        'sec_status'     => 2,
                    );
                    $this->section->updateData($data);

                }

            }

            //อัพเดตสถานะนัดเป็น 1
            $data = array(
                'meet_id'         => $selectmeetuser[0]['meet_id'],
                'meet_status'    => 1,
            );
            $this->meet->updateData2($data);

        }
        

        //แปลงวันที่
        $strYear = date("Y", strtotime($meet_date)) + 543;
        $strMonth = date("n", strtotime($meet_date));
        $strDay = date("j", strtotime($meet_date));
        $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];

        //ส่งเมล์แจ้งสถานะการยกเลิกนัด แจ้งไปยังอาจารย์
        $condition = array();
        $condition['fide'] = "use_id,use_name,use_email";
        $condition['where'] = array('use_id' => $use_id);
        $selectuser = $this->administrator->listData($condition);

        $data = array(
            // 'fullname'        => $selectuser[0]['use_name'],
            // 'project_name'    => $project_name,
            // 'meet_time'       => $meet_time,
            // 'strDay'          => $strDay . '&nbsp;' . $strMonthThai . '&nbsp;' . $strYear,
            'detail'          => 'คุณได้กดยืนยันการนัดหมายให้ขึ้นสอบปริญญานิพนธ์ หัวข้อ '. $project_name .'ในวันที่ '.$strDay . '&nbsp;' . $strMonthThai . '&nbsp;' . $strYear.'&nbsp;เวลา '.$meet_time.'&nbsp; น.&nbsp; แล้ว หากนัดหมายนี้สำเร็จ ระบบจะแจ้งเตือนวันที่นัดหมายในหน้าแรกของคุณ',
        );
        
        require_once APPPATH . 'third_party/class.phpmailer.php';
        require_once APPPATH . 'third_party/class.smtp.php';
        $mail = new PHPMailer;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->CharSet = "utf-8";
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;

        $mail->Host = "27.254.131.201";
        $mail->Port = 25;
        $mail->Username = "system@preedarat-cv.com";
        $mail->Password = "r4c!H3w0";
        $mail->setFrom('system@preedarat-cv.com', 'Appoint-IT');

        // $mail->AddAddress($selectuser[0]['use_email']);
        // $mail->AddAddress('yui.napassorn.s@gmail.com');
        $mail->AddAddress('preedarat.jut@gmail.com');
        $mail->Subject = "มีข้อความติดต่อจาก : Appoint-IT";
        $message = $this->messageteacsubmit_verify($data,$selectuser[0]['use_name']);

        $mail->MsgHTML($message);

        $mail->send();


        // ===============================================================================

        //ส่งอีเมล์แจ้งเตือนนักศึกษา สถานะการยกเลิกนัด 
        $condition = array();
        $condition['fide'] = "tb_projectperson.project_id,tb_student.std_id,tb_student.std_title,tb_student.std_fname,tb_student.std_lname,tb_student.std_email";
        $condition['where'] = array('tb_projectperson.project_id' => $project_id);
        $selectstd = $this->project->listperson($condition);

        $datastd = array(
            'detail'          => $selectuser[0]['use_name'].' ได้กดยืนยันการนัดหมายขึ้นสอบปริญญานิพนธ์ หัวข้อ '. $project_name .'ในวันที่ '.$strDay . '&nbsp;' . $strMonthThai . '&nbsp;' . $strYear.'&nbsp;เวลา '.$meet_time.'&nbsp; น.&nbsp; แล้ว หากนัดหมายนี้สำเร็จ ระบบจะแจ้งเตือนวันที่นัดหมายในหน้าแรกของคุณ',
        );

        foreach ($selectstd as $key => $value) {

            $std_fullname   = '&nbsp;' . $value['std_title'] . '' . $value['std_fname'] . '&nbsp;&nbsp;' . $value['std_lname'];

            require_once APPPATH . 'third_party/class.phpmailer.php';
            require_once APPPATH . 'third_party/class.smtp.php';
            $mail = new PHPMailer;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->CharSet = "utf-8";
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;

            $mail->Host = "27.254.131.201";
            $mail->Port = 25;
            $mail->Username = "system@preedarat-cv.com";
            $mail->Password = "r4c!H3w0";
            $mail->setFrom('system@preedarat-cv.com', 'Appoint-IT');

            // $mail->AddAddress($value['std_email']);
            // $mail->AddAddress('yui.napassorn.s@gmail.com');
            $mail->AddAddress('preedarat.jut@gmail.com');
            $mail->Subject = "มีข้อความติดต่อจาก : Appoint-IT";
            $message = $this->messageteacsubmit_verify($datastd, $std_fullname);

            $mail->MsgHTML($message);
            $mail->send();
        }

        header("location:" . site_url('amcalendar/request/2'));     

    }

    public function messageteacsubmit_verify($data,$fullname)
    {

        $html = file_get_contents("assets/template_email/submit-meet-email.html");
        $html = str_replace('[DATA-FULLNAME]', $fullname, $html);
        // $html = str_replace('[DATA-TIME]', $data['meet_time'], $html);
        // $html = str_replace('[DATA-DATE]', $data['strDay'], $html);
        $html = str_replace('[DATA-DETAIL]', $data['detail'], $html);
        return $html;
    }

    //ยกเลิกการนัดหมาย
    public function cancel($dmeet_id = '', $use_id = '')
    {

        //อัพเดตสถานะเป็น 0
        $data = array(
            'dmeet_id'         => $dmeet_id,
            'use_id'          => $use_id,
            'dmeet_status'    => 0,
        );
        $this->meet->updateDetail($data);

        //ค้นหาในตารางเวลา เพื่ออัพเดตค่าเวลาเป็น 1
        $condition = array();
        $condition['fide'] = "tb_meet.meet_id,tb_meet.sub_id,tb_meetdetail.dmeet_id,tb_meet.meet_date,tb_meet.meet_time, tb_project.project_id,, tb_project.project_name";
        $condition['where'] = array('tb_meetdetail.dmeet_id' => $dmeet_id);
        $selectmeetsec = $this->meet->listjoinData2($condition);

        $meet_id   = $selectmeetsec[0]['meet_id'];
        $sub_id    = $selectmeetsec[0]['sub_id'];
        $meet_date = $selectmeetsec[0]['meet_date'];
        $meet_time = $selectmeetsec[0]['meet_time'];
        $project_id = $selectmeetsec[0]['project_id'];
        $project_name = $selectmeetsec[0]['project_name'];

        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('sec_date' => $meet_date,'sec_time_one' => $meet_time,'use_id' => $use_id, );
        $selectsection = $this->section->listData($condition);
        if(count($selectsection ) == 0){
            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array('sec_date' => $meet_date,'sec_time_two' => $meet_time,'use_id' => $use_id, );
            $selectsection = $this->section->listData($condition);

            $data = array(
                'sec_id'         => $selectsection[0]['sec_id'],
                'sec_status'     => 1,
            );
            $this->section->updateData($data);

        }else{

            $data = array(
                'sec_id'         => $selectsection[0]['sec_id'],
                'sec_status'     => 1,
            );
            $this->section->updateData($data);

        }
        
        //เช็คจำนวนคนที่กดยกเลิกว่าเกินที่กำหนดไหม หากเกิน นัดต้องยกเลิกเป็น 0
        $condition = array();
        $condition['fide'] = "tb_meetdetail.meet_id,tb_meetdetail.dmeet_id,tb_meetdetail.use_id,tb_meet.meet_date,tb_meet.meet_time";
        $condition['where'] = array('tb_meetdetail.meet_id' => $meet_id, 'tb_meetdetail.dmeet_status !=' => 0);
        $selectmeetuser = $this->meet->listjoinData2($condition);

        $condition = array();
        $condition['fide'] = "tb_subject.sub_id,tb_subject.sub_setuse";
        $condition['where'] = array('tb_subject.sub_id' => $sub_id);
        $selectsubject = $this->meet->listjoinData($condition);

        //หากจำนวนอาจารย์ที่ทำนัดน้อยกว่าที่กำหนด ต้องอัพเดตสถานะ user เป็น 0
        if(count($selectmeetuser) != 0){
            if(count($selectmeetuser) < $selectsubject[0]['sub_setuse'] ){

                //อัพเดตในตาราง tb_meerdetail เป็น use_id = 0
                foreach ($selectmeetuser as $key => $value) {

                    $data = array(
                        'dmeet_id'         => $value['dmeet_id'],
                        'use_id'          => $value['use_id'],
                        'dmeet_status'    => 0,
                    );
                    $this->meet->updateDetail($data);

                    //ค้นหาในตารางเวลา เพื่ออัพเดตค่าเวลาเป็น 1
                    $condition = array();
                    $condition['fide'] = "tb_meet.meet_id,tb_meet.sub_id,tb_meetdetail.dmeet_id,tb_meet.meet_date,tb_meet.meet_time";
                    $condition['where'] = array('tb_meetdetail.dmeet_id' => $dmeet_id);
                    $selectmeetsec = $this->meet->listjoinData2($condition);

                    $meet_id   = $selectmeetsec[0]['meet_id'];
                    $sub_id    = $selectmeetsec[0]['sub_id'];
                    $meet_date = $selectmeetsec[0]['meet_date'];
                    $meet_time = $selectmeetsec[0]['meet_time'];

                    $condition = array();
                    $condition['fide'] = "*";
                    $condition['where'] = array('sec_date' => $meet_date,'sec_time_one' => $meet_time,'use_id' => $use_id, );
                    $selectsection = $this->section->listData($condition);
                    if(count($selectsection ) == 0){
                        $condition = array();
                        $condition['fide'] = "*";
                        $condition['where'] = array('sec_date' => $meet_date,'sec_time_two' => $meet_time,'use_id' => $use_id, );
                        $selectsection = $this->section->listData($condition);

                        $data = array(
                            'sec_id'         => $selectsection[0]['sec_id'],
                            'sec_status'     => 0,
                        );
                        $this->section->updateData($data);

                    }else{

                        $data = array(
                            'sec_id'         => $selectsection[0]['sec_id'],
                            'sec_status'     => 0,
                        );
                        $this->section->updateData($data);

                    }

                }

                //อัพเดตสถานะนัดเป็น 1
                $data = array(
                    'meet_id'         => $selectmeetuser[0]['meet_id'],
                    'meet_status'    => 0,
                );
                $this->meet->updateData2($data);
            }

        }

        //แปลงวันที่
        $strYear = date("Y", strtotime($meet_date)) + 543;
        $strMonth = date("n", strtotime($meet_date));
        $strDay = date("j", strtotime($meet_date));
        $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];

        //ส่งเมล์แจ้งสถานะการยกเลิกนัด แจ้งไปยังอาจารย์
        $condition = array();
        $condition['fide'] = "use_id,use_name,use_email";
        $condition['where'] = array('use_id' => $use_id);
        $selectuser = $this->administrator->listData($condition);

        $data = array(
            'project_id'      => $project_id,
            'project_name'    => $project_name,
            'meet_time'       => $meet_time,
            'strDay'          => $strDay . '&nbsp;' . $strMonthThai . '&nbsp;' . $strYear,
        );

        require_once APPPATH . 'third_party/class.phpmailer.php';
        require_once APPPATH . 'third_party/class.smtp.php';
        $mail = new PHPMailer;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->CharSet = "utf-8";
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;

        $mail->Host = "27.254.131.201";
        $mail->Port = 25;
        $mail->Username = "system@preedarat-cv.com";
        $mail->Password = "r4c!H3w0";
        $mail->setFrom('system@preedarat-cv.com', 'Appoint-IT');

        // $mail->AddAddress($selectuser[0]['use_email']);
        // $mail->AddAddress('yui.napassorn.s@gmail.com');
        $mail->AddAddress('preedarat.jut@gmail.com');
        $mail->Subject = "มีข้อความติดต่อจาก : Appoint-IT";
        $message = $this->messagetea_verify($data, $use_id, $selectuser[0]['use_name']);

        $mail->MsgHTML($message);

        $mail->send();

        // ===============================================================================

        //ส่งอีเมล์แจ้งเตือนนักศึกษา สถานะการยกเลิกนัด 
        $condition = array();
        $condition['fide'] = "tb_projectperson.project_id,tb_student.std_id,tb_student.std_title,tb_student.std_fname,tb_student.std_lname,tb_student.std_email";
        $condition['where'] = array('tb_projectperson.project_id' => $project_id);
        $selectstd = $this->project->listperson($condition);

        $datastd = array(
            'project_id'      => $project_id,
            'project_name'    => $project_name,
            'meet_time'       => $meet_time,
            'strDay'          => $strDay . '&nbsp;' . $strMonthThai . '&nbsp;' . $strYear,
            'use_name'          => $selectuser[0]['use_name'],
        );

        foreach ($selectstd as $key => $value) {

            $std_fullname   = '&nbsp;' . $value['std_title'] . '' . $value['std_fname'] . '&nbsp;&nbsp;' . $value['std_lname'];

            require_once APPPATH . 'third_party/class.phpmailer.php';
            require_once APPPATH . 'third_party/class.smtp.php';
            $mail = new PHPMailer;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->CharSet = "utf-8";
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;

            $mail->Host = "27.254.131.201";
            $mail->Port = 25;
            $mail->Username = "system@preedarat-cv.com";
            $mail->Password = "r4c!H3w0";
            $mail->setFrom('system@preedarat-cv.com', 'Appoint-IT');

            // $mail->AddAddress($value['std_email']);
            // $mail->AddAddress('yui.napassorn.s@gmail.com');
            $mail->AddAddress('preedarat.jut@gmail.com');
            $mail->Subject = "มีข้อความติดต่อจาก : Appoint-IT";
            $message = $this->messagestd_verify($datastd, $value['std_id'], $std_fullname);

            $mail->MsgHTML($message);
            $mail->send();
        }
        

        header("location:" . site_url('amcalendar/request/2'));
    }

    public function messagetea_verify($data, $userid, $use_name)
    {

        $burl = site_url('student/showdetailproject/' . $data['project_id'] . '/' . $userid);
        $html = file_get_contents("assets/template_email/teac-meetcancel-email.html");
        $html = str_replace('[DATA-LINK]', $burl, $html);
        $html = str_replace('[DATA-PROJECTNAME] ', $data['project_name'], $html);
        $html = str_replace('[DATA-FULLNAME]', $use_name, $html);
        $html = str_replace('[DATA-TIME]', $data['meet_time'], $html);
        $html = str_replace('[DATA-DATE]', $data['strDay'], $html);
        $html = str_replace('[DATA-DATE]', $data['strDay'], $html);
        return $html;
    }

    public function messagestd_verify($data, $userid, $use_name)
    {

        $burl = site_url('student/showdetailproject/' . $data['project_id'] . '/' . $userid);
        $html = file_get_contents("assets/template_email/std-meetcancel-email.html");
        $html = str_replace('[DATA-LINK]', $burl, $html);
        $html = str_replace('[DATA-PROJECTNAME] ', $data['project_name'], $html);
        $html = str_replace('[DATA-FULLNAME]', $use_name, $html);
        $html = str_replace('[DATA-TIME]', $data['meet_time'], $html);
        $html = str_replace('[DATA-USERNAME]', $data['use_name'], $html);
        return $html;
    }

}
