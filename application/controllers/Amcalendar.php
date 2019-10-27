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

        //เช็คจำนวนคนที่กดยอมรับว่าครบที่กำหนดไหม หากครบ นัดต้องเป็น 1
        $condition = array();
        $condition['fide'] = "tb_meetdetail.meet_id,tb_meetdetail.dmeet_id,tb_meetdetail.use_id,tb_meet.meet_date,tb_meet.meet_time";
        $condition['where'] = array('tb_meetdetail.meet_id' => $meet_id, 'tb_meetdetail.dmeet_status' => 1);
        $selectmeetuser = $this->meet->listjoinData2($condition);

        $condition = array();
        $condition['fide'] = "tb_subject.sub_id,tb_subject.sub_setuse";
        $condition['where'] = array('tb_subject.sub_id' => $sub_id);
        $selectsubject = $this->meet->listjoinData($condition);

        //หากจำนวนอาจารย์ที่ทำนัดยอมรับครบตสมที่กำหนด ต้องอัพเดตสถานะ user เป็น 0
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

            //อัพเดตสถานะนัดเป็น 0
            $data = array(
                'meet_id'         => $selectmeetuser[0]['meet_id'],
                'meet_status'    => 1,
            );
            $this->meet->updateData2($data);

        }
        
        header("location:" . site_url('amcalendar/request/2'));

        

    }
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
                'meet_status'    => 1,
            );
            $this->meet->updateData2($data);

        }

        header("location:" . site_url('amcalendar/request/2'));
    }
}
