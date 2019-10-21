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
            } else{
                
                    $data = array();
                    $data['formcrf'] = $this->tokens->token('formcrf');
                    $this->template->backend('calendar/main', $data);
            }
        }
    }

    public function subject($sec_id ="", $date = "")
    {
        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            if ($sec_id == "") {
                show_404();
            } else{
                if ($date == "") {
                    show_404();
                } else{

                    $data = array();
                    $condition = array();
                    $condition['fide'] = "*";
                    $condition['where'] = array('tb_section.sec_date' => $date, 'tb_settings.set_status' => 2);
                    $listsection = $this->section->listjoinData($condition);
                    if(count($listsection) == 0){
                        show_404();
                    }else{
                    
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

    public function detail($sub_id = "", $sub_type ="" ,$date = "")
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

                if(count($projectrequest) == ""){
                    $data['chkprojectrequest'] = 0;
                }else{
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
                if(!empty($sub_type)){
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
            $listJson[$key]['url'] = site_url('calendar/subject/' .$value['set_id'] ."/". $value['sec_date']);
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
        if(empty($sub_type) || empty($date) || empty($time)){
            show_404();
        }

        $condition = array();
        $condition['fide'] = "";
        $condition['where'] = array('set_status' => 2);
        $data['listdata'] = $this->setting->listData($condition);

        $condition['fide'] = "tb_section.use_id, tb_user.use_name, sec_time_one,sec_time_two";
        if($sub_type == 1){
            $condition['where'] = array(
                'tb_section.set_id' => $data['listdata'][0]['set_id'],
                'sec_date' => $date,
                'sec_time_one' => $time,
                'sec_status'   => '1'
            );
            $listsec = $this->section->listjoinData($condition);
        } elseif($sub_type == 2){
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
        $condition['fide'] = "";
        $condition['where'] = array('sub_id' => $sub_type);
        $listdatasubject = $this->subject->listData($condition);

        //เช็คอาจารย์ที่ปรึกษา
        $condition = array();
        $condition['fide'] = "tb_projectperson.std_id,tb_projectperson.project_id,tb_project.use_id";
        $condition['where'] = array('tb_projectperson.std_id' => $this->encryption->decrypt($this->input->cookie('sysli')));
        $projectperson = $this->project->listjoinData($condition);

        $listJson = array();
        foreach ($listsec as $key => $value) {
            $listJson[$key]['id'] = $value['use_id'];
            $listJson[$key]['name'] = $value['use_name'];
            $listJson[$key]['time'] = $time;
            //อาจารย์ประจำวิชา
            if($listdatasubject[0]['use_id'] == $value['use_id'] ){
                $listJson[$key]['subjectUserId'] = 'checked=""  disabled';
                $listJson[$key]['checkuserHidden'] = '<input type="hidden" value="'.$value['use_id'].'" name="checkUser[]" id="checkUser"/>';
            }
            //เช็คอาจารย์ที่ปรึกษา
            if($projectperson[0]['use_id'] == $value['use_id'] ){
                $listJson[$key]['subjectUserId'] = 'checked=""  disabled';
                $listJson[$key]['checkuserHidden'] = '<input type="hidden" value="'.$value['use_id'].'" name="checkUser[]" id="checkUser"/>';
            }

        }
        echo json_encode($listJson);
        die;
    }


    public function cart(){

        $userId = $this->input->post('userId');

        $k = 0;

		if($k == 0){

            $condition = array();
            $condition['fide'] = "";
            $condition['where'] = array('use_id' => $userId);
            $listdata = $this->administrator->listData($condition);

            $data = array(
                'use_id'      	=> $listdata[0]['use_id'],
                'use_name'      => $listdata[0]['use_name'],
            );

            $this->cart->insert($data);

            $data['total'] = $this->cart->total_items();
            $data['totalprice'] = $this->cart->total();
            $data['typeaction'] = 'insert';
            echo json_encode($data);
			
        }	
        

        // $userId = $this->input->post('userId');

        // $condition = array();
        // $condition['fide'] = "";
        // $condition['where'] = array('use_id' => $userId);
        // $listdata = $this->administrator->listData($condition);

        // $data = array(
        //     'use_id'      				=> $listdata[0]['use_id'],
        //     'use_name'      				=> $listdata[0]['use_name'],
        // );
        // echo json_encode($data);
                    
        die;
        
    }

    public function request(){

        $date  =  $this->input->post('txt_date'); //วันที่เลือกทำนัด
        $type  =  $this->input->post('txt_type'); //1: โครงการหนึ่ง, 2: โครงการสอง
        $time  =  $this->input->post('txt_time'); //เวลา

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

        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('sub_id' => $type);
        $listsubject = $this->subject->listData($condition);

        $sub_setless  =  $listsubject[0]['sub_setless']; //จำนวนอาจารย์ขึ้นสอบอย่างน้อย

       //เช็คว่าค่าที่เลือกมาน้อยกว่าที่กำหนดหรือไม่
        if(count($this->input->post('checkUser')) >= $sub_setless){

            // insert meet
            $data = array(
                'set_id'             => $set_id,
                'project_id'         => $project_id,
                'sub_id'             => $type,
                'meet_date'          => $date,
                'meet_time'          => $time,
                'meet_status'        => 1,
                'meet_create_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                'meet_create_date'   => date('Y-m-d H:i:s'),
                'meet_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'meet_lastedit_date' => date('Y-m-d H:i:s'),
            );
            
            $meetId = $this->meet->insertData($data);
            
            // insert meetdetail
            $other = array();
            for($i=0;$i<count($this->input->post('checkUser'));$i++){

                $other['meet_id'] 	        = $meetId;
                $other['use_id'] 		    = $this->input->post('checkUser')[$i];
                $other['dmeet_status'] 		= 1;
                $other['dmeet_head'] 		= 0;
                $other['sec_id'] 		    = $sec_id;

                $this->meet->insertDetail($other);
            }          

            // redirect('calendar/chkrequest/'.$meetId);

            print_r('มากกว่า');

        }else{
           
            print_r('น้อยกว่า');

        }

    }

    public function addhead(){
        
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

            if($value['dmeet_head'] == 1){

                $data['meetHeadshow'] = 1;

            }else{

                $data['meetHeadshow'] = 0;

            }

        }

        $data['formcrf'] = $this->tokens->token('formcrf');
        $this->template->backend('calendar/chkrequest',$data);
        
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

        $data['formcrf'] = $this->tokens->token('formcrf');
        $this->template->backend('calendar/chkrequest',$data);
        
    }

    public function message_verify($data)
    {

        $burl = site_url('student/sandrequest');
        $html = file_get_contents("assets/template_email/sandrequest.html");
        // $html = str_replace('[DATA-LINK]', $burl, $html);
        // $html = str_replace('[DATA-TITLE]', $data['std_title'], $html);
        // $html = str_replace('[DATA-FNAME]', $data['std_fname'], $html);
        // $html = str_replace('[DATA-LNAME]', $data['std_lname'], $html);
        // $html = str_replace('[DATA-EMAIL]', $data['std_email'], $html);
        return $html;
    }

    public function sandrequest(){

        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        //select project
        $condition = array();
        $condition['fide'] = "tb_projectperson.project_id,tb_student.std_id,tb_project.project_status";
        $condition['where'] = array('tb_student.std_id' => $idlogin, 'tb_project.project_status !=' => 0);
        $listproject = $this->project->listperson($condition);

        $project_id  =  $listproject[0]['project_id'];

        //select project student
        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('tb_project.project_id' => $project_id);
        $listproject = $this->project->listjoinData($condition);

        $data = array(
            'project_id'    => $project_id,

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
        $mail->Host = "smtp.hostinger.in.th";
        $mail->Port = 587;
        $mail->Username = "appoint@preedarat-cv.com";
        $mail->Password = "1s1F]59H";
        $mail->setFrom('appoint@preedarat-cv.com', 'Appoint-IT');
        // $mail->AddAddress($data['std_email']);
        $mail->AddAddress('yui.napassorn.s@gmail.com');
        $mail->Subject = "มีข้อความติดต่อจาก : Appoint-IT";
        // $message = '<html lang="en">';
        // $message .= '<head>';
        // $message .= '<title>คำขอขึ้นสอบปริญญานิพนธ์</title>';
        // $message .= '</head>';
        // $message .= '<body>';
        // $message .= '<div>';
        // $message .= '111';
        // $message .= '</div>';
        // $message .= '</body>';
        // $message .= '</html>';
                        
        $message = $this->message_verify($data);

        print_r($message);
        die;

        $mail->MsgHTML($message);
        $mail->send();
        $result = array(
            'error' => false,
            'msg' => 'ลงทะเบียนสำเร็จ',
            'url' => site_url('student/succeedreg')
        );

        // print_r('<pre>');
        // print_r($listproject);
        // print_r('</pre>');

        die;

    }

   
}
