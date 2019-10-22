<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Project extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("project_model", "project");
        $this->load->model("projectfile_model", "projectfile");
        $this->load->model("student_model", "student");
        $this->load->model("subject_model", "subject");
        $this->load->model("administrator_model", "administrator");
    }

    public function index()
    {
        $permission = array("ผู้ดูแลระบบ", "หัวหน้าสาขา", "อาจารย์ผู้สอน");
        if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
            $data = array();

            $condition = array();
            $condition['fide'] = "*";
            $condition['orderby'] = "tb_project.project_id ASC";
            $data['listdata'] = $this->project->listjoinData2($condition);

            $this->template->backend('project/main', $data);
        } else {
            $this->load->view('errors/html/error_403');
        }
    }

    public function detail($id = "")
    {
        if(!empty($id)){
            $permission = array("ผู้ดูแลระบบ", "หัวหน้าสาขา", "อาจารย์ผู้สอน");
            if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
                $data = array();
    
                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('tb_project.project_id' => $id);
                $data['listProject'] = $this->project->listjoinData2($condition);
                if(count($data['listProject']) != 0){
                    $condition = array();
                    $condition['fide'] = "*";
                    $condition['where'] = array('tb_projectperson.project_id' => $id);
                    $data['listPerson'] = $this->project->listperson($condition);

                    $condition = array();
                    $condition['fide'] = "*";
                    $condition['where'] = array('tb_projectfile.project_id' => $id);
                    $condition['orderby'] = "tb_projectfile.file_name ASC";
                    $data['listFile'] = $this->projectfile->listjoinData($condition);
                } else {
                    show_404();
                }
    
                $this->template->backend('project/detail', $data);
            } else {
                $this->load->view('errors/html/error_403');
            }
        } else {
            show_404();
        }
        
    }
}
