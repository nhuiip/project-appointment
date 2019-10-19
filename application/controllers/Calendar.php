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

    public function detail($sub_type ="" ,$date = "")
    {
        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            if (!empty($sub_type) && $sub_type != '' || !empty($date) && $date != '') {

                $data = array();

                $data = array();
                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('tb_subject.sub_type' => $sub_type);
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
        // echo 'ee';
        // die;
        $sub_type = $this->input->post('sub');
        // $sub_type = 1;

        $condition = array();
        $condition['fide'] = "";
        $condition['where'] = array('set_status' => 2);
        $data['listdata'] = $this->setting->listData($condition);

        $condition['fide'] = "tb_section.use_id, tb_user.use_name, sec_time_one,sec_time_two";
        if ($sub_type == 1) {
            $condition['where'] = array(
                'tb_section.set_id' => $data['listdata'][0]['set_id'],
                'sec_date' => $this->input->post('date'),
                'sec_time_one' => $this->input->post('time'),
                // 'sec_date' => '2019-10-15',
                // 'sec_time_one' => '9.00',
                'sec_status'   => '1'
            );
        } elseif ($sub_type == 2) {
            $condition['where'] = array(
                'tb_section.set_id' => $data['listdata'][0]['set_id'],
                'sec_date' => $this->input->post('date'),
                'sec_time_two' => $this->input->post('time'),
                // 'sec_date' => '2019-10-15',
                // 'sec_time_one' => '9.00',
                'sec_status'   => '1'
            );
        }
        $listsec = $this->section->listjoinData($condition);
        $listJson = array();
        foreach ($listsec as $key => $value) {
            $listJson[$key]['id'] = $value['use_id'];
            $listJson[$key]['name'] = $value['use_name'];
        }
        // echo json_encode(array('data' => $listJson));
        echo json_encode($listJson);
        // echo '<pre>';
        // print_r($listJson);
        // echo '</pre>';
        die;
    }


    public function cart(){

        $userId = $this->input->post('userId');

        $condition = array();
        $condition['fide'] = "";
        $condition['where'] = array('use_id' => $userId);
        $listdata = $this->administrator->listData($condition);


        $data = array(
            'use_id'      				=> $listdata[0]['use_id'],
            'use_name'      				=> $listdata[0]['use_name'],
        );
        echo json_encode($data);
                    
        die;
        
	}

}
