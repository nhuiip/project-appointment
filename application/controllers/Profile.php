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


            $data['loginid'] =   $loginid;
            $data['position'] =   $this->encryption->decrypt($this->input->cookie('sysp'));

            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('student/profile', $data);
        }

       

    }

    public function update()
    {
    

        $condition = array();
        $condition['fide'] = "*";
        // $condition['where'] = array('std_id' => );
        $checkinsert = $this->student->listData($condition);
        

        $this->template->backend('student/profile');

    }

}