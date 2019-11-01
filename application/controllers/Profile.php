<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profile extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("student_model", "student");
        $this->load->model("project_model", "project");
        $this->load->model("subject_model", "subject");
        $this->load->model("administrator_model", "administrator");
        $this->load->model("attached_model", "attached");
        $this->load->model("setting_model", "setting");
        $this->load->model("section_model", "section");
    }

    public function index($id = "")
    {

        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            if ($id == "") {
                show_404();
            } elseif (($poslogin == 'หัวหน้าสาขา' || $poslogin == 'อาจารย์ผู้สอน') && $idlogin == $id) {

                $data = array();
                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('use_id' => $id);
                $condition['orderby'] = "use_name ASC ";
                $data['listdata'] = $this->administrator->listjoinData($condition);

                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('tb_subject.use_id' => $id, 'tb_subject.sub_status' => 1);
                $data['listsubject'] = $this->subject->listjoinData($condition);

                if(count($data['listsubject']) != 0){

                    $condition = array();
                    $condition['fide'] = "*";
                    $condition['where'] = array('tb_subject.use_id' => $id, 'tb_subject.sub_status' => 1);
                    $data['listsubject'] = $this->subject->listjoinData($condition);

                   

                    $condition = array();
                    $condition['fide'] = "*";
                    $condition['where'] = array('sub_id' => $data['listsubject'][0]['sub_id']);
                    $condition['orderby'] = "att_id ASC ";
                    $data['listatt'] = $this->attached->listData($condition);

                }

                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('set_status' => 2);
                $listdata = $this->setting->listData($condition);

                if(count($listdata) != 0){
                    $data['set_id'] = $listdata[0]['set_id'];
                }else{
                    $data['set_id'] = "";
                }
                    
                $condition['fide'] = "*";
                $condition['where'] = array('set_id' => $data['set_id']);
                $condition['groupby'] = "sec_date";
                $data['listsec'] = $this->section->listData($condition);

                $data['formcrf'] = $this->tokens->token('formcrf');
                $this->template->backend('administrator/profile', $data);
            } else {
                $this->load->view('errors/html/error_403');
            }
        } else {
            //ไม่ login ให้ show 404
            show_404();
        }
    }

    public function checkemail()
    {
        // check email count 0 = true or than 0 = false
        $std_email = $this->input->post('std_email');
        if (!empty($std_email)) {
            $condition = array();
            $condition['fide'] = "std_email";
            $condition['where'] = array('std_email' => $std_email);
            $listemail = $this->student->listData($condition);
            if (count($listemail) == 0) {

                $condition = array();
                $condition['fide'] = "use_email";
                $condition['where'] = array('use_email' => $std_email);
                $listemails = $this->administrator->listData($condition);

                if (count($listemails) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            } else {
                echo "false";
            }
        }
    }
}
