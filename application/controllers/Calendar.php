<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Calendar extends MX_Controller
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

    public function index($id = "")
    {
        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            if ($id == "") {
                show_404();
            } else {

                $data = array();
                $data['formcrf'] = $this->tokens->token('formcrf');
                $this->template->backend('calendar/main', $data);
            }
        }
    }

    public function subject($sec_id = "", $date = "")
    {
        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            if ($sec_id == "") {
                show_404();
            } else {
                if ($date == "") {
                    show_404();
                } else {

                    $data = array();
                    $condition = array();
                    $condition['fide'] = "*";
                    $condition['where'] = array('tb_section.sec_date' => $date, 'tb_settings.set_status' => 2);
                    $listsection = $this->section->listjoinData($condition);
                    if (count($listsection) == 0) {
                        show_404();
                    } else {

                        $data = array();
                        $condition = array();
                        $condition['fide'] = "*";
                        $condition['where'] = array('sub_status' => 1);
                        $data['listsubject'] = $this->subject->listjoinData($condition);

                        // $condition = array();
                        // $condition['fide'] = "*";
                        // $condition['where'] = array('tb_projectperson.std_id' => $idlogin);
                        // $listprojectperson = $this->project->listjoinData($condition);

                        // $data['project_id'] = $listprojectperson[0]['project_id'];

                        $data['date'] = $date;

                        $data['formcrf'] = $this->tokens->token('formcrf');
                        $this->template->backend('calendar/subject', $data);
                    }
                }
            }
        }
    }

    public function detail($sub_id = "", $sub_type = "", $date = "")
    {
        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            if (!empty($sub_type) && $sub_type != '' || !empty($date) && $date != '') {

                $data = array();
                $condition = array();
                $condition['fide'] = "tb_projectperson.std_id,tb_projectperson.project_id, tb_project.use_id";
                $condition['where'] = array(
                    'tb_projectperson.std_id' => $this->encryption->decrypt($this->input->cookie('sysli')),
                    'tb_project.project_status !=' => 0
                );
                $projectperson = $this->project->listjoinData($condition);

                $project_id  = $projectperson[0]['project_id'];

                $condition = array();
                $condition['fide'] = "tb_meet.project_id";
                $condition['where'] = array('tb_meet.project_id' => $project_id);
                $projectrequest = $this->meet->listData($condition);

                if (count($projectrequest) == "") {
                    $data['chkprojectrequest'] = 0;
                } else {
                    $data['chkprojectrequest'] = 1;
                }

                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('tb_subject.sub_id' => $sub_id);
                $data['listsubject'] = $this->subject->listjoinData($condition);

                $time = array();
                $time[0] = array('one' => '9.00', 'two' => '9.00');
                $time[1] = array('one' => '10.00', 'two' => '10.30');
                $time[2] = array('one' => '11.00', 'two' => '12.00');
                $time[3] = array('one' => '13.00', 'two' => '13.00');
                $time[4] = array('one' => '14.00', 'two' => '14.30');
                $time[5] = array('one' => '15.00', 'two' => '16.00');

                $data['time'] = $time;
                if (!empty($sub_type)) {
                    $data['sub_type'] = $sub_type;
                }

                $data['project_use'] = $projectperson[0]['use_id'];
                $data['date'] = $date;
                $data['formcrf'] = $this->tokens->token('formcrf');
                $this->template->backend('calendar/detail', $data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    public function jsoneven()
    {
        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('set_status' => 2);
        $data['listdata'] = $this->setting->listData($condition);

        $condition['fide'] = "*";
        $condition['where'] = array('set_id' => $data['listdata'][0]['set_id']);
        $condition['groupby'] = "sec_date";
        $listsec = $this->section->listData($condition);

        $listJson = array();
        foreach ($listsec as $key => $value) {
            $listJson[$key]['title'] = "นัดสอบ";
            $listJson[$key]['start'] = $value['sec_date'];
            $listJson[$key]['color'] = "#16a085";
            $listJson[$key]['url'] = site_url('calendar/subject/' . $value['set_id'] . "/" . $value['sec_date']);
        }

        echo json_encode($listJson);
    }

    public function jsontimeT()
    {
        $sub_type = $this->input->post('sub');
        $date = $this->input->post('date');
        $time = $this->input->post('time');

        // $sub_type = 2;
        // $date = "2019-10-07";
        // $time = '10.00';
        if (empty($sub_type) || empty($date) || empty($time)) {
            show_404();
        }

        $condition = array();
        $condition['fide'] = "";
        $condition['where'] = array('set_status' => 2);
        $data['listdata'] = $this->setting->listData($condition);

        $condition['fide'] = "tb_section.use_id, tb_user.use_name, sec_time_one,sec_time_two,tb_user.position_id";
        if ($sub_type == 1) {
            $condition['where'] = array(
                'tb_section.set_id' => $data['listdata'][0]['set_id'],
                'sec_date' => $date,
                'sec_time_one' => $time,
                'sec_status'   => '1'
            );
            $listsec = $this->section->listjoinData($condition);
        } elseif ($sub_type == 2) {
            $condition['where'] = array(
                'tb_section.set_id' => $data['listdata'][0]['set_id'],
                'sec_date' => $date,
                'sec_time_two' => $time,
                'sec_status'   => '1'
            );
            $listsec = $this->section->listjoinData($condition);
        }

        //เช็คอาจารย์ประจำวิชา
        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('sub_id' => $sub_type);
        $listdatasubject = $this->subject->listData($condition);

        //เช็คอาจารย์ที่ปรึกษา
        $condition = array();
        $condition['fide'] = "tb_projectperson.std_id,tb_projectperson.project_id,tb_project.use_id,tb_user.position_id";
        $condition['where'] = array('tb_projectperson.std_id' => $this->encryption->decrypt($this->input->cookie('sysli')));
        $projectperson = $this->project->listjoinData($condition);

        $listJson = array();
        foreach ($listsec as $key => $value) {
            $listJson[$key]['id'] = $value['use_id'];
            $listJson[$key]['name'] = $value['use_name'];
            $listJson[$key]['time'] = $time;
            
            if ($listdatasubject[0]['use_id'] == $value['use_id']) {

                //อาจารย์ประจำวิชา

                $listJson[$key]['subjectUserId'] = 'checked=""  disabled';
                $listJson[$key]['subjectUserstatus'] = '&nbsp;[อาจารย์ประจำวิชา]';
                $listJson[$key]['checkuserHidden'] = '<input type="hidden" value="' . $value['use_id'] . '" name="checkUser[]" id="checkUser"/> ';
            } else{
                $listJson[$key]['subjectUserId'] = '';
                $listJson[$key]['checkuserHidden'] = '';
                $listJson[$key]['subjectUserstatus'] = '';
            }

            if ($projectperson[0]['use_id'] == $value['use_id']) {

                //เช็คอาจารย์ที่ปรึกษา

                $listJson[$key]['subjectUserId'] = 'checked=""  disabled';
                $listJson[$key]['subjectUserstatus'] = '&nbsp;[อาจารย์ที่ปรึกษา]';
                $listJson[$key]['checkuserHidden'] = '<input type="hidden" value="' . $value['use_id'] . '" name="checkUser[]" id="checkUser"/>';
            }

            //เช็คอาจารย์พิเศษ
            if ($value['position_id'] == 5) {
                
                $listJson[$key]['subjectPositionstatus'] = '&nbsp;[อาจารย์พิเศษ]';

            }else{
                $listJson[$key]['subjectPositionstatus'] = '';
            }

            //เลือกประธาน
            if ($listdatasubject[0]['use_id'] != $value['use_id']) {

                if ($projectperson[0]['use_id'] != $value['use_id']) {

                    $checked = "checked";

                    $listJson[$key]['rediouserHidden'] = '<div id="'.$value['use_id'].'" class="radio chkheadProject" style="display: none;" >&nbsp;<input  type="radio" name="radioHeadproject" id="radio' . $value['use_id'] . '" value="' . $value['use_id'] . '" ><label for="radio' . $value['use_id'] . '">เลือกเป็นประธานขึ้นสอบ </label></<div>';
                } else {
                    $listJson[$key]['rediouserHidden'] = '';
                }

                if ($value['position_id'] == 5) {
                
                    $listJson[$key]['rediouserHidden'] = '';
    
                }

            } else {

                $listJson[$key]['rediouserHidden'] = '';
            }
        }
        echo json_encode($listJson);
        die;
    }
    
    public function request()
    {

        $date  =  $this->input->post('txt_date'); //วันที่เลือกทำนัด
        $sub_id  =  $this->input->post('txt_subId'); //1: โครงการหนึ่ง, 2: โครงการสอง
        $time  =  $this->input->post('txt_time'); //เวลา

        //เช็คว่าค่าที่เลือกมาน้อยกว่าที่กำหนดหรือไม่
        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('sub_id' => $sub_id);
        $listsubject = $this->subject->listData($condition);
        if(count($this->input->post('checkUser')) != $listsubject[0]['sub_setuse']){
            $result = array(
                'error' => true,
                'title' => "",
                'msg'  => "กรุณาเลือกจำนวนอาจารย์ขึ้นสอบให้ถูกต้องตามที่กำหนด",
                // 'url' => site_url('calendar/detail/'.$sub_id.'/'.$listsubject[0]['sub_type'].'/'.$date, 'refresh')
            );
            echo json_encode($result);
            die;
        }


        // $date  =  '2019-10-07';//วันที่เลือกทำนัด
        // $type  =  1; //1: โครงการหนึ่ง, 2: โครงการสอง
        // $time  =  '10.00'; //เวลา
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli')); //รหัสนักศึกษา

        $condition = array();
        $condition['fide'] = "sec_id,sec_date,set_id";
        $condition['where'] = array('sec_date' => $date);
        $listsection = $this->section->listData($condition);

        $sec_id  =  $listsection[0]['sec_id']; //Id เวลา
        $set_id  =  $listsection[0]['set_id']; //การตั้งค่า

        $condition = array();
        $condition['fide'] = "tb_projectperson.project_id";
        $condition['where'] = array('tb_projectperson.std_id' => $idlogin, 'tb_project.project_status !=' => 0);
        $liststudent = $this->project->listjoinData($condition);

        $project_id  =  $liststudent[0]['project_id']; //รหัสโปรเจค
        $sub_setuse  =  $listsubject[0]['sub_setuse']; //จำนวนอาจารย์ขึ้นสอบอย่างน้อย

        if ($this->tokens->verify('formcrf')) {
            
            if (count($this->input->post('checkUser')) == $sub_setuse) {

                // insert meet
                $data = array(
                    'set_id'             => $set_id,
                    'project_id'         => $project_id,
                    'sub_id'             => $sub_id,
                    'meet_date'          => $date,
                    'meet_time'          => $time,
                    'meet_status'        => 2,
                    'meet_create_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                    'meet_create_date'   => date('Y-m-d H:i:s'),
                    'meet_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                    'meet_lastedit_date' => date('Y-m-d H:i:s'),
                );

                $meetId = $this->meet->insertData($data);

                // insert meetdetail
                $other = array();
                for ($i = 0; $i < count($this->input->post('checkUser')); $i++) {

                    $other['meet_id']             = $meetId;
                    $other['use_id']             = $this->input->post('checkUser')[$i];
                    $other['dmeet_status']         = 2;
                    $other['dmeet_head']         = 0;
                    $other['sec_id']             = $sec_id;

                    $dmeet_id  = $this->meet->insertDetail($other);
                }

                //update head project
                $condition = array();
                $condition['fide'] = "tb_meetdetail.dmeet_id,tb_meetdetail.use_id,tb_meetdetail.dmeet_head";
                $condition['where'] = array('tb_meetdetail.use_id' => $this->input->post('radioHeadproject'));
                $listmeetdetail = $this->meet->listjoinData2($condition);

                $datas = array(
                    'dmeet_id'            => $listmeetdetail[0]['dmeet_id'],
                    'dmeet_head'          => 1,
                );
                $this->meet->updateDetail($datas);

                //update status อาจารย์พิเศษต้องเท่ากับ 1
                for ($i = 0; $i < count($this->input->post('checkUser')); $i++) {
        
                    $condition = array();
                    $condition['fide'] = "tb_user.use_id,tb_user.position_id,tb_meetdetail.dmeet_id";
                    $condition['where'] = array('tb_user.use_id' => $this->input->post('checkUser')[$i]);
                    $listuser = $this->meet->listjoinData2($condition);
        
                    
                    if($listuser[0]['position_id'] == 5){
        
                        $datas = array(
                            'dmeet_id'            => $listuser[0]['dmeet_id'],
                            'dmeet_status'          => 1,
                        );
                        $this->meet->updateDetail($datas);
        
                    }
                }

                // select detailmeet
                $condition = array();
                $condition['fide'] = "tb_meetdetail.dmeet_id,tb_meetdetail.meet_id,tb_meetdetail.dmeet_status,tb_meetdetail.use_id,tb_meet.meet_date,tb_meet.meet_time,";
                $condition['where'] = array('tb_meetdetail.meet_id' => $meetId);
                $listmeetdetail = $this->meet->listjoinData2($condition);

                //select id subject in meet
                $condition = array();
                $condition['fide'] = "tb_meet.meet_id,tb_meet.sub_id";
                $condition['where'] = array('tb_meet.meet_id' => $meetId);
                $listmeetsub = $this->meet->listjoinData($condition);

                //select subject type in tb_subject
                $condition = array();
                $condition['fide'] = "sub_id,sub_type";
                $condition['where'] = array('sub_id' => $listmeetsub[0]['sub_id']);
                $listprojectsubType = $this->subject->listData($condition);

                //อัพเดตข้อมูลเวลาว่างของอาจารย์
                foreach ($listmeetdetail as $key => $value) {

                    if ($listprojectsubType[0]['sub_id'] == 1) {

                        $condition['fide'] = "*";
                        $condition['where'] = array('use_id' => $value['use_id'], 'sec_date' => $value['meet_date'], 'sec_time_one' => $value['meet_time']);
                        $listmeet = $this->section->listData($condition);

                        // print_r('sec_time_one');

                        foreach ($listmeet as $key => $values) {

                            $othersection['sec_id']         = $values['sec_id'];
                            $othersection['sec_status']     = 2;

                            $this->section->updateData($othersection);
                        }
                    } else {

                        $condition['fide'] = "*";
                        $condition['where'] = array('use_id' => $value['use_id'], 'sec_date' => $value['meet_date'], 'sec_time_two' => $value['meet_time']);
                        $listmeet = $this->section->listData($condition);

                        // print_r('sec_time_two');
                        foreach ($listmeet as $key => $values) {


                            $othersection['sec_id']         = $values['sec_id'];
                            $othersection['sec_status']     = 2;

                            $this->section->updateData($othersection);
                        }
                    }
                }

                $this->sandrequest($meetId);
            }
        }
    }

    public function addhead()
    {

        $userId = $this->input->post('id');

        $data = array();
        $condition = array();
        $condition['fide'] = "tb_meetdetail.use_id,tb_meetdetail.dmeet_id,tb_meetdetail.meet_id";
        $condition['where'] = array('tb_meetdetail.use_id' => $userId);
        $listsubject = $this->meet->listjoinData2($condition);

        $dmeet_id  =  $listsubject[0]['dmeet_id'];
        $meetId    = $listsubject[0]['meet_id'];

        $data = array(
            'dmeet_id'      => $dmeet_id,
            'dmeet_head'    => 1
        );

        $this->meet->updateDetail($data);

        $datas = array(
            'meet_id'      => $meetId,
        );

        echo json_encode($datas);

        die;
    }

    public function chkrequest($meetId = "")
    {

        $data = array();

        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('tb_meet.meet_id' => $meetId);
        $data['listshowproject'] = $this->meet->listjoinData($condition);

        $project_id  =  $data['listshowproject'][0]['project_id'];
        $meet_id     =  $data['listshowproject'][0]['meet_id'];
        $sub_id      =  $data['listshowproject'][0]['sub_id'];
        $data['meet_date']     =  $data['listshowproject'][0]['meet_date'];
        $data['meet_time']     =  $data['listshowproject'][0]['meet_time'];

        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('tb_project.project_id' => $project_id);
        $listproject = $this->project->listjoinData($condition);

        $data['teacher_fullname']  =  $listproject[0]['use_name'];

        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('tb_projectperson.project_id' => $project_id);
        $data['listprojectperson'] = $this->project->listperson($condition);

        $condition = array();
        $condition['fide'] = "tb_meet.project_id,tb_meetdetail.use_id,tb_meetdetail.dmeet_id,tb_meetdetail.dmeet_head,tb_user.use_name";
        $condition['where'] = array('tb_meet.meet_id' => $meet_id);
        $data['listmeet'] = $this->meet->listjoinData2($condition);

        foreach ($data['listmeet'] as $key => $value) {

            if ($value['dmeet_head'] == 1) {

                $data['meetHeadshow'] = 1;
            } else {

                $data['meetHeadshow'] = 0;
            }
        }

        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('tb_subject.sub_id' => $sub_id);
        $data['listsubject'] = $this->subject->listjoinData($condition);

        $data['formcrf'] = $this->tokens->token('formcrf');
        $this->template->backend('calendar/chkrequest', $data);
    }

    public function showcalendar($meetId = "")
    {

        $data = array();

        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('tb_meet.meet_id' => $meetId);
        $data['listshowproject'] = $this->meet->listjoinData($condition);

        $project_id  =  $data['listshowproject'][0]['project_id'];
        $meet_id     =  $data['listshowproject'][0]['meet_id'];
        $sub_id      =  $data['listshowproject'][0]['sub_id'];
        $data['meet_date']     =  $data['listshowproject'][0]['meet_date'];
        $data['meet_time']     =  $data['listshowproject'][0]['meet_time'];

        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('tb_project.project_id' => $project_id);
        $listproject = $this->project->listjoinData($condition);

        $data['teacher_fullname']  =  $listproject[0]['use_name'];

        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('tb_projectperson.project_id' => $project_id);
        $data['listprojectperson'] = $this->project->listperson($condition);

        $condition = array();
        $condition['fide'] = "tb_meet.meet_id,tb_meet.project_id,tb_meetdetail.use_id,tb_meetdetail.dmeet_id,tb_meetdetail.dmeet_head,tb_user.use_name";
        $condition['where'] = array('tb_meet.project_id' => $meet_id);
        $condition['orderby'] = "dmeet_head desc";
        $data['listmeet'] = $this->meet->listjoinData2($condition);

        $data['meetHeadshow'] = 1;

        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('tb_subject.sub_id' => $sub_id);
        $data['listsubject'] = $this->subject->listjoinData($condition);

        $data['formcrf'] = $this->tokens->token('formcrf');
        $this->template->backend('calendar/chkrequest', $data);
    }

    public function message_verify($data, $userid, $use_name)
    {

        $burl = site_url('student/showdetailproject/' . $data['project_id'] . '/' . $userid);
        $html = file_get_contents("assets/template_email/teac-meet-email.html");
        $html = str_replace('[DATA-LINK]', $burl, $html);
        $html = str_replace('[DATA-PROJECTNAME] ', $data['project_name'], $html);
        $html = str_replace('[DATA-FULLNAME]', $use_name, $html);
        $html = str_replace('[DATA-TIME]', $data['meet_time'], $html);
        $html = str_replace('[DATA-DATE]', $data['strDay'], $html);
        $html = str_replace('[DATA-PROJECDETAIL]', $data['detail'], $html);
        // $html = str_replace('[DATA-USERID]', $userid, $html);
        return $html;
    }

    public function messagestd_verify($data, $userid, $use_name)
    {

        $burl = site_url('student/showdetailproject/' . $data['project_id'] . '/' . $userid);
        $html = file_get_contents("assets/template_email/std-meet-email.html");
        $html = str_replace('[DATA-LINK]', $burl, $html);
        $html = str_replace('[DATA-PROJECTNAME]', $data['project_name'], $html);
        $html = str_replace('[DATA-FULLNAME]', $use_name, $html);
        $html = str_replace('[DATA-TIME]', $data['meet_time'], $html);
        $html = str_replace('[DATA-DATE]', $data['strDay'], $html);
        $html = str_replace('[DATA-PROJECDETAIL]', $data['detail'], $html);
        // $html = str_replace('[DATA-USERID]', $userid, $html);
        return $html;
    }

    public function sandrequest($meetId = "")
    {

        if (!empty($meetId)) {

            //select project
            $condition = array();
            $condition['fide'] = "tb_meet.meet_id,tb_meet.meet_date,tb_meet.meet_time,tb_project.project_id,tb_project.project_name";
            $condition['where'] = array('tb_meet.meet_id' => $meetId);
            $listmeet = $this->meet->listjoinData2($condition);

            $meet_id        =  $listmeet[0]['meet_id'];
            $project_id     =  $listmeet[0]['project_id'];
            $project_name   =  $listmeet[0]['project_name'];
            $meet_date      =  $listmeet[0]['meet_date'];
            $meet_time      =  $listmeet[0]['meet_time'];

            $strYear = date("Y", strtotime($meet_date)) + 543;
            $strMonth = date("n", strtotime($meet_date));
            $strDay = date("j", strtotime($meet_date));
            $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
            $strMonthThai = $strMonthCut[$strMonth];

            //select email user
            $condition = array();
            $condition['fide'] = "tb_meetdetail.meet_id,tb_meetdetail.use_id,tb_user.use_email,tb_user.use_name";
            $condition['where'] = array('tb_meetdetail.meet_id' => $meet_id,'tb_user.position_id !=' => 5);
            $listemailuser = $this->meet->listjoinData2($condition);

            // if (count($listemailuser) != 0) {
            //     $data = array(
            //         'project_id'      => $project_id,
            //         'project_name'    => $project_name,
            //         'meet_time'       => $meet_time . '&nbsp;',
            //         'strDay'          => $strDay . '&nbsp;' . $strMonthThai . '&nbsp;' . $strYear,
            //     );

            //     foreach ($listemailuser as $key => $value) {

            //         $use_fullname   =   "เรียน&nbsp;" . $value['use_name'];

            //         require_once APPPATH . 'third_party/class.phpmailer.php';
            //         require_once APPPATH . 'third_party/class.smtp.php';
            //         $mail = new PHPMailer;
            //         $mail->SMTPOptions = array(
            //             'ssl' => array(
            //                 'verify_peer' => false,
            //                 'verify_peer_name' => false,
            //                 'allow_self_signed' => true
            //             )
            //         );
            //         $mail->CharSet = "utf-8";
            //         $mail->IsSMTP();
            //         $mail->SMTPDebug = 0;
            //         $mail->SMTPAuth = true;

            //         $mail->Host = "27.254.131.201";
            //         $mail->Port = 25;
            //         $mail->Username = "admin@preedarat-cv.com";
            //         $mail->Password = "M!1p1H79";
            //         $mail->setFrom('admin@preedarat-cv.com', 'Appoint-IT');

            //         // $mail->AddAddress($value['use_email']);

            //         // $mail->AddAddress('preedarat.jut@gmail.com');
            //         $mail->AddAddress('yui.napassorn.s@gmail.com');
            //         $mail->Subject = "มีข้อความติดต่อจาก : Appoint-IT";

            //         $message = $this->message_verify($data, $value['use_id'], $use_fullname);

            //         $mail->MsgHTML($message);
            //         // $mail->send();
            //         if (!$mail->send()) {
            //             echo $mail->ErrorInfo . '<br>';
            //         } else {
            //             echo 'Send<br>';
            //         }
            //     }
            // }

            //sand std project
            // $condition = array();
            // $condition['fide'] = "tb_projectperson.project_id,tb_student.std_id,tb_student.std_title,tb_student.std_fname,tb_student.std_lname,tb_student.std_email";
            // $condition['where'] = array('tb_projectperson.project_id' => $project_id);
            // $listemailstd = $this->project->listjoinData($condition);

            // if (count($listemailstd) != 0) {

            //     $data = array(
            //         'project_id'      => $project_id,
            //         'project_name'    => $project_name,
            //         'meet_time'       => $meet_time,
            //         'strDay'          => $strDay . '&nbsp;' . $strMonthThai . '&nbsp;' . $strYear,
            //     );

            //     foreach ($listemailstd as $key => $value) {

            //         $std_fullname   = '&nbsp;' . $value['std_title'] . '' . $value['std_fname'] . '&nbsp;&nbsp;' . $value['std_lname'];

            //         require_once APPPATH . 'third_party/class.phpmailer.php';
            //         require_once APPPATH . 'third_party/class.smtp.php';
            //         $mail = new PHPMailer;
            //         $mail->SMTPOptions = array(
            //             'ssl' => array(
            //                 'verify_peer' => false,
            //                 'verify_peer_name' => false,
            //                 'allow_self_signed' => true
            //             )
            //         );
            //         $mail->CharSet = "utf-8";
            //         $mail->IsSMTP();
            //         $mail->SMTPDebug = 0;
            //         $mail->SMTPAuth = true;

            //         $mail->Host = "27.254.131.201";
            //         $mail->Port = 25;
            //         $mail->Username = "admin@preedarat-cv.com";
            //         $mail->Password = "M!1p1H79";
            //         $mail->setFrom('admin@preedarat-cv.com', 'Appoint-IT');

            //         // $mail->AddAddress($value['std_email']);
            //         $mail->AddAddress('yui.napassorn.s@gmail.com');
            //         // $mail->AddAddress('preedarat.jut@gmail.com');
            //         $mail->Subject = "มีข้อความติดต่อจาก : Appoint-IT";
            //         $message = $this->messagestd_verify($data, $value['std_id'], $std_fullname);

            //         $mail->MsgHTML($message);
            //         // $mail->send();
            //         if (!$mail->send()) {
            //             echo $mail->ErrorInfo . '<br>';
            //         } else {
            //             echo 'Send<br>';
            //         }
            //     }
            //     $result = array(
            //         'error' => false,
            //         'msg' => 'ส่งคำขอเรียบร้อยแล้ว',
            //         'url' =>  site_url('calendar/succeedrequest')
            //     );
            //     echo json_encode($result);
            //     die;
            // } else {
            //     show_404();
            // }
        } else {
            show_404();
        }
    }


    public function succeedrequest()
    {
        $this->load->view('page/succeed-request');
    }

}
