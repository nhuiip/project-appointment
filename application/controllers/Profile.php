<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profile extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("student_model", "student");
        $this->load->model("subject_model", "subject");
    }

    public function index($loginid = "")
    {

        if($loginid == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->input->cookie('sysp')) == 'นักศึกษา'){


            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $loginid);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                $condition = array();
                $condition['fide'] = "*";
                $data['liststudent'] = $this->student->listjoinData($condition);

                $data['position'] =   $this->encryption->decrypt($this->input->cookie('sysp'));
    
                $data['formcrf'] = $this->tokens->token('formcrf');
                $this->template->backend('student/profile', $data);

            }
        }

       

    }

    public function update($Id = "")
    {
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

                if ($this->tokens->verify('formcrf')) {
                    $data = array(
                        'std_id'                => $this->input->post('Id'),
                        'std_fname'             => $this->input->post('text_name'),
                        'std_lname'             => $this->input->post('text_lastname'),
                        'std_email'             => $this->input->post('text_email'),
                        'std_tel'               => $this->input->post('text_tel'),
                        'std_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'std_lastedit_date'     => date('Y-m-d H:i:s'),
                    );

                    $this->student->updateStd($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'แก้ไขข้อมูลสำเร็จ',
                            'url' => site_url('profile/index/'.$Id)
                        );
                        echo json_encode($result);
                    }else{
                        $result = array(
                            'error' => true,
                            'title' => "ล้มเหลว",
                            'msg' => 'อัพเดตข้อมูลไม่สำเร็จ',
                        );
                        echo json_encode($result);
                    }
                    die;
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

}