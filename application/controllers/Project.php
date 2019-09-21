<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Project extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("project_model", "project");
        $this->load->model("student_model", "student");
        $this->load->model("subject_model", "subject");
    }

    public function index()
    {
        if($this->encryption->decrypt($this->input->cookie('sysp')) != 'นักศึกษา'){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->input->cookie('sysp')) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "*";
            $data['liststudent'] = $this->student->listjoinData($condition);

            $condition = array();
            $condition['fide'] = "*";
            $data['listsubject'] = $this->subject->listData($condition);

            $condition = array();
            $condition['fide'] = "*";
            $checkstdproject = $this->project->listjoinData($condition);

            $user_chk = explode(" ",$checkstdproject[0]['std_id']);
            asort($user_chk);
            $data['user_chk'] =   $user_chk;
                                        
            $data['position'] =   $this->encryption->decrypt($this->input->cookie('sysp'));   

            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('student/project', $data);

        }

    }

    public function addsubject($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->input->cookie('sysp')) == 'นักศึกษา'){


            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if($this->tokens->verify('crform')){
                    
                    $data = array(
                        'std_id'                => $this->input->post('Id'),
                        'project_name'          => $this->input->post('txt_projectname'),
                        'use_id'                => $this->input->post('use_id'),
                        'std_id'                => $this->input->post('Id'),
                        'project_status'        => '1',
                        'project_create_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_create_date'   => date('Y-m-d H:i:s'),
                        'project_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date' => date('Y-m-d H:i:s'),
                    );
                    
                    $Id = $this->project->insertData($data);
                        
                    $result = array(
                        'error' => false,
                        'msg' => 'เพิ่มข้อมูลเรียบร้อยแล้ว',
                        'url' => site_url('project/index/')
                    );
                    echo json_encode($result);
                }else{
                    $result = array(
                        'error' => true,
                        'title' => "ล้มเหลว",
                        'msg' => "อัพเดตข้อมูลไม่สำเร็จ"
                    );
                    
                    echo json_encode($result);
                }
            }
        }
    }

    public function showsubject(){

		$subjectId = $this->input->post('subjectId');

        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('tb_subject.sub_id' => $subjectId, 'tb_subject.sub_status' => 1);
        $listsubject = $this->subject->listjoinData($condition);

        $data = array(
            'sub_code'      				=> $listsubject[0]['sub_code'],
            'use_name'      				=> $listsubject[0]['use_name'],
            'use_id'      				    => $listsubject[0]['use_id'],
            'sub_setuse'      				=> $listsubject[0]['sub_setuse'],
        );

		echo json_encode($data);
				
		
	}

}
