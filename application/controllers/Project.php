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
    
    public function loadfile($file_id = "", $useid = ""){


        //เช็คว่าในตาราง tb_trace มี use_id นี้อยู่ไหม & file_id นี้อยู่ไหม
        $condition = array();
        $condition['fide'] = "tb_trace.use_id,tb_projectfile.file_id,tb_projectfile.file_name,tb_projectfile.project_id";
        $condition['where'] = array('tb_trace.use_id' => $useid,'tb_projectfile.file_id' => $file_id);
        $listproject = $this->projectfile->listjointrace($condition);

        //หากยังไม่มีการดาวน์โหลด ให้เพิ่มลงไป
        if(count($listproject) == 0){

            $data = array(
                'file_id'          => $file_id,
                'use_id'           => $useid,
                'trace_datetime'   => date('Y-m-d H:i:s'),
            );
            $this->projectfile->insertFiletrace($data);
        
        }else if($listproject[0]['use_id'] != $useid){
            //เช็คค่าซ้ำ หากไม่ซ้ำ use_id ให้เพิ่มลงไป
            $data = array(
                'file_id'          => $file_id,
                'use_id'           => $useid,
                'trace_datetime'   => date('Y-m-d H:i:s'),
            );
            $this->projectfile->insertFiletrace($data);

        }

        // select ชื่อไฟล์ และ โฟลเดอร์
        $condition = array();
        $condition['fide'] = "tb_projectfile.file_id,tb_projectfile.file_name,tb_projectfile.project_id";
        $condition['where'] = array('tb_projectfile.file_id' => $file_id);
        $listproject = $this->projectfile->listData($condition);

        // redirect('uploads/fileproject/Project_' . $listproject[0]['project_id'] . '/' . $listproject[0]['file_name']);

        echo json_encode($listproject);

    }
}
